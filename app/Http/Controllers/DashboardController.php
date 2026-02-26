<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\StatusPekerjaan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'atasan' => redirect()->route('atasan.dashboard'),
            default => redirect()->route('dashboard.user'),
        };
    }

    public function user()
    {
        $user = Auth::user();
        $biodata = $user->biodata;
        $status = $user->statusPekerjaan;
        $notifications = $user->notificationsE()->latest()->take(5)->get();
        $unreadCount = $user->notificationsE()->where('status_baca', false)->count();

        return view('user.dashboard', compact('user', 'biodata', 'status', 'notifications', 'unreadCount'));
    }

    public function admin()
    {
        $districts = $this->getPandeglangWilayahData()['districts'];
        $totalUsers = User::where('role', 'user')->count();
        $totalActiveUsers = StatusPekerjaan::distinct('user_id')->count('user_id');
        $usersNeedAttention = User::where('role', 'user')
            ->where(function ($q) {
                $q->doesntHave('biodata')
                    ->orWhereHas('biodata', fn ($qb) => $qb->where('status_verifikasi', '!=', 'verified'));
            })->count();

        $pending = Biodata::where('status_verifikasi', 'pending')->count();
        $verified = Biodata::where('status_verifikasi', 'verified')->count();
        $rejected = Biodata::where('status_verifikasi', 'rejected')->count();

        $statusDistribution = StatusPekerjaan::selectRaw('status_pekerjaan, count(*) as total')
            ->groupBy('status_pekerjaan')
            ->pluck('total', 'status_pekerjaan');

        $recentActivities = User::where('role', 'user')
            ->with(['biodata', 'statusPekerjaan'])
            ->whereHas('biodata')
            ->latest()
            ->take(8)
            ->get();

        $regionalSummary = $this->buildRegionalSummary($districts);
        $topAttentionDistricts = $regionalSummary['topAttentionDistricts'];
        $topWorkingDistricts = $regionalSummary['topWorkingDistricts'];

        return view('admin.dashboard', compact(
            'pending',
            'verified',
            'rejected',
            'totalUsers',
            'totalActiveUsers',
            'usersNeedAttention',
            'statusDistribution',
            'recentActivities',
            'topAttentionDistricts',
            'topWorkingDistricts'
        ));
    }

    public function laporanAdmin()
    {
        $wilayahData = $this->getPandeglangWilayahData();
        $districts = $wilayahData['districts'];
        $selectedDistrictCode = (string) request('kecamatan_code', '');
        $selectedVillageName = (string) request('kelurahan_name', '');
        $villagesForSelectedDistrict = $this->villagesForDistrict($districts, $selectedDistrictCode);

        $totalUser = User::where('role', 'user')->count();
        $query = $this->buildLaporanQuery(request(), $districts);
        $rows = $query->latest()->paginate(15)->withQueryString();

        $areaMap = $this->buildAreaMap(
            $rows->items(),
            $districts,
            $selectedDistrictCode,
            $selectedVillageName
        );

        $statusStats = (clone $query)
            ->reorder()
            ->join('status_pekerjaan', 'users.id', '=', 'status_pekerjaan.user_id')
            ->selectRaw('status_pekerjaan.status_pekerjaan, count(*) as total')
            ->groupBy('status_pekerjaan.status_pekerjaan')
            ->pluck('total', 'status_pekerjaan.status_pekerjaan');
        $pendingVerifikasi = Biodata::where('status_verifikasi', 'pending')->count();

        return view('admin.laporan', compact(
            'totalUser',
            'statusStats',
            'rows',
            'pendingVerifikasi',
            'districts',
            'villagesForSelectedDistrict',
            'selectedDistrictCode',
            'selectedVillageName',
            'areaMap'
        ));
    }

    public function exportLaporanCsv(Request $request): StreamedResponse
    {
        $districts = $this->getPandeglangWilayahData()['districts'];
        $selectedDistrictCode = (string) $request->query('kecamatan_code', '');
        $selectedVillageName = (string) $request->query('kelurahan_name', '');
        $rows = $this->buildLaporanQuery($request, $districts)->latest()->get();
        $areaMap = $this->buildAreaMap($rows, $districts, $selectedDistrictCode, $selectedVillageName);

        $filename = 'laporan-status-pandeglang-' . now()->format('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($rows, $areaMap): void {
            $handle = fopen('php://output', 'wb');
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['Nama', 'Email', 'NIK', 'Kecamatan', 'Kelurahan/Desa', 'Status Verifikasi', 'Status Pekerjaan', 'Tanggal Update']);

            foreach ($rows as $row) {
                $area = $areaMap[$row->id] ?? ['kecamatan' => '-', 'kelurahan' => '-'];
                fputcsv($handle, [
                    $row->name,
                    $row->email,
                    optional($row->biodata)->nik ?? '-',
                    $area['kecamatan'],
                    $area['kelurahan'],
                    optional($row->biodata)->status_verifikasi ?? 'pending',
                    optional($row->statusPekerjaan)->status_pekerjaan ?? '-',
                    $row->statusPekerjaan?->tanggal_update?->format('Y-m-d') ?? '-',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportLaporanPdf(Request $request)
    {
        $districts = $this->getPandeglangWilayahData()['districts'];
        $selectedDistrictCode = (string) $request->query('kecamatan_code', '');
        $selectedVillageName = (string) $request->query('kelurahan_name', '');
        $rows = $this->buildLaporanQuery($request, $districts)->latest()->get();
        $areaMap = $this->buildAreaMap($rows, $districts, $selectedDistrictCode, $selectedVillageName);

        $pdf = Pdf::loadView('admin.laporan-export-pdf', [
            'rows' => $rows,
            'areaMap' => $areaMap,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-status-pandeglang-' . now()->format('Ymd-His') . '.pdf');
    }

    public function villagesByDistrict(string $districtCode): JsonResponse
    {
        $districts = $this->getPandeglangWilayahData()['districts'];
        $villages = $this->villagesForDistrict($districts, $districtCode);

        return response()->json([
            'district_code' => $districtCode,
            'villages' => collect($villages)->map(fn ($v) => [
                'code' => $v['code'] ?? null,
                'name' => $v['name'] ?? null,
            ])->values(),
        ]);
    }

    public function atasan()
    {
        $totalAdmin = User::where('role', 'admin')->count();
        $totalUser = User::where('role', 'user')->count();
        $pending = Biodata::where('status_verifikasi', 'pending')->count();
        $verified = Biodata::where('status_verifikasi', 'verified')->count();
        $rejected = Biodata::where('status_verifikasi', 'rejected')->count();
        $statusDistribution = StatusPekerjaan::selectRaw('status_pekerjaan, count(*) as total')
            ->groupBy('status_pekerjaan')
            ->pluck('total', 'status_pekerjaan');

        return view('atasan.dashboard', compact('totalAdmin', 'totalUser', 'pending', 'verified', 'rejected', 'statusDistribution'));
    }

    public function rekapAdmin()
    {
        $admins = User::where('role', 'admin')->latest()->get();

        $verifikasiPerAdmin = Biodata::selectRaw('verifikator_id, count(*) as total')
            ->whereNotNull('verifikator_id')
            ->groupBy('verifikator_id')
            ->pluck('total', 'verifikator_id');

        $verifiedPerAdmin = Biodata::selectRaw('verifikator_id, count(*) as total')
            ->where('status_verifikasi', 'verified')
            ->whereNotNull('verifikator_id')
            ->groupBy('verifikator_id')
            ->pluck('total', 'verifikator_id');

        $rejectedPerAdmin = Biodata::selectRaw('verifikator_id, count(*) as total')
            ->where('status_verifikasi', 'rejected')
            ->whereNotNull('verifikator_id')
            ->groupBy('verifikator_id')
            ->pluck('total', 'verifikator_id');

        return view('atasan.rekap-admin', compact('admins', 'verifikasiPerAdmin', 'verifiedPerAdmin', 'rejectedPerAdmin'));
    }

    private function buildLaporanQuery(Request $request, array $districts)
    {
        $query = User::query()
            ->where('role', 'user')
            ->with(['biodata', 'statusPekerjaan']);

        $status = (string) $request->query('status', '');
        if ($status !== '') {
            $query->whereHas('statusPekerjaan', fn ($q) => $q->where('status_pekerjaan', $status));
        }

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        if ($startDate || $endDate) {
            $query->whereHas('statusPekerjaan', function ($q) use ($startDate, $endDate) {
                if ($startDate) {
                    $q->whereDate('tanggal_update', '>=', $startDate);
                }
                if ($endDate) {
                    $q->whereDate('tanggal_update', '<=', $endDate);
                }
            });
        }

        $districtCode = (string) $request->query('kecamatan_code', '');
        $district = collect($districts)->firstWhere('code', $districtCode);
        if ($district) {
            $districtName = Str::lower((string) $district['name']);
            $query->whereHas('biodata', function ($q) use ($districtName) {
                $q->whereRaw('LOWER(COALESCE(kecamatan, "")) LIKE ?', ['%' . $districtName . '%'])
                    ->orWhereRaw('LOWER(alamat) LIKE ?', ['%' . $districtName . '%']);
            });
        }

        $villageName = trim((string) $request->query('kelurahan_name', ''));
        if ($villageName !== '') {
            $villageNameLower = Str::lower($villageName);
            $query->whereHas('biodata', function ($q) use ($villageNameLower) {
                $q->whereRaw('LOWER(COALESCE(desa_kelurahan, "")) LIKE ?', ['%' . $villageNameLower . '%'])
                    ->orWhereRaw('LOWER(alamat) LIKE ?', ['%' . $villageNameLower . '%']);
            });
        }

        return $query;
    }

    private function getPandeglangWilayahData(): array
    {
        $localPath = database_path('data/pandeglang_wilayah.json');
        if (is_file($localPath)) {
            $parsed = json_decode((string) file_get_contents($localPath), true);
            if (is_array($parsed) && isset($parsed['districts']) && is_array($parsed['districts'])) {
                return $parsed;
            }
        }

        return ['districts' => []];
    }

    private function villagesForDistrict(array $districts, string $districtCode): array
    {
        if ($districtCode === '') {
            return [];
        }

        $district = collect($districts)->firstWhere('code', $districtCode);
        if (! $district || ! isset($district['villages']) || ! is_array($district['villages'])) {
            return [];
        }

        return $district['villages'];
    }

    private function buildAreaMap(iterable $rows, array $districts, string $selectedDistrictCode, string $selectedVillageName): array
    {
        $areaMap = [];
        $districtNames = collect($districts)->pluck('name', 'code')->toArray();
        $selectedDistrictName = $districtNames[$selectedDistrictCode] ?? null;
        $selectedDistrictVillages = $this->villagesForDistrict($districts, $selectedDistrictCode);

        foreach ($rows as $row) {
            $address = (string) optional($row->biodata)->alamat;
            $districtName = $selectedDistrictName
                ?: (optional($row->biodata)->kecamatan ?: $this->findNameInAddress($address, array_values($districtNames)));

            $villageName = $selectedVillageName ?: (optional($row->biodata)->desa_kelurahan ?? '');
            if ($villageName === '' && $selectedDistrictCode !== '') {
                $villageName = $this->findNameInAddress($address, collect($selectedDistrictVillages)->pluck('name')->all());
            }

            $areaMap[$row->id] = [
                'kecamatan' => $districtName ?: '-',
                'kelurahan' => $villageName ?: '-',
            ];
        }

        return $areaMap;
    }

    private function findNameInAddress(string $address, array $names): ?string
    {
        $addressNormalized = Str::lower($address);
        $sortedNames = collect($names)->filter()->sortByDesc(fn ($name) => strlen((string) $name));

        foreach ($sortedNames as $name) {
            $needle = Str::lower((string) $name);
            if ($needle !== '' && str_contains($addressNormalized, $needle)) {
                return (string) $name;
            }
        }

        return null;
    }

    private function buildRegionalSummary(array $districts): array
    {
        if (empty($districts)) {
            return [
                'topAttentionDistricts' => collect(),
                'topWorkingDistricts' => collect(),
            ];
        }

        $districtNames = collect($districts)->pluck('name')->all();
        $users = User::where('role', 'user')->with(['biodata', 'statusPekerjaan'])->get();
        $bucket = [];

        foreach ($users as $user) {
            $address = (string) optional($user->biodata)->alamat;
            $district = $this->findNameInAddress($address, $districtNames) ?: 'Tidak Terpetakan';
            if (! isset($bucket[$district])) {
                $bucket[$district] = [
                    'kecamatan' => $district,
                    'total' => 0,
                    'belum_bekerja' => 0,
                    'sudah_bekerja' => 0,
                    'pending_verifikasi' => 0,
                ];
            }

            $bucket[$district]['total']++;
            $statusPekerjaan = optional($user->statusPekerjaan)->status_pekerjaan;
            if ($statusPekerjaan === 'belum_bekerja') {
                $bucket[$district]['belum_bekerja']++;
            } elseif ($statusPekerjaan === 'sudah_bekerja') {
                $bucket[$district]['sudah_bekerja']++;
            }

            if (optional($user->biodata)->status_verifikasi !== 'verified') {
                $bucket[$district]['pending_verifikasi']++;
            }
        }

        $topAttentionDistricts = collect($bucket)
            ->sortByDesc(fn ($item) => ($item['belum_bekerja'] * 2) + $item['pending_verifikasi'])
            ->take(5)
            ->values();

        $topWorkingDistricts = collect($bucket)
            ->filter(fn ($item) => $item['total'] > 0)
            ->sortByDesc(fn ($item) => $item['sudah_bekerja'] / max(1, $item['total']))
            ->take(5)
            ->map(function ($item) {
                $item['rasio_bekerja'] = round(($item['sudah_bekerja'] / max(1, $item['total'])) * 100, 1);
                return $item;
            })
            ->values();

        return compact('topAttentionDistricts', 'topWorkingDistricts');
    }
}
