<?php

namespace App\Http\Controllers;

use App\Models\KartuKuning;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KartuKuningController extends Controller
{
    public function show()
    {
        return $this->preview((int) Auth::id());
    }

    public function download()
    {
        return $this->generatePdf((int) Auth::id());
    }

    public function preview(int $id)
    {
        $currentUser = Auth::user();

        if (! $currentUser) {
            abort(403);
        }

        if (! in_array($currentUser->role, ['admin', 'atasan'], true) && $currentUser->id !== $id) {
            abort(403);
        }

        $user = User::with(['biodata', 'kartuKuning'])->findOrFail($id);

        if (
            $currentUser->id === $user->id &&
            (! $user->biodata || $user->biodata->status_verifikasi !== 'verified')
        ) {
            return redirect()->route($user->biodata ? 'biodata.show' : 'biodata.create', $user->biodata ? [$user->biodata->id] : [])
                ->with('error', 'Biodata Anda belum diverifikasi admin. Kartu kuning belum bisa dipreview.');
        }

        $this->ensureKartuKuningReady($user);

        return view('user.card-show', [
            'user'       => $user,
            'validUntil' => now()->addYears(2),
        ]);
    }

    public function generatePdf(int $id)
    {
        $currentUser = Auth::user();

        if (! $currentUser) {
            abort(403);
        }

        if (! in_array($currentUser->role, ['admin', 'atasan'], true) && $currentUser->id !== $id) {
            abort(403);
        }

        $user = User::with(['biodata', 'kartuKuning'])->findOrFail($id);

        if (
            $currentUser->id === $user->id &&
            (! $user->biodata || $user->biodata->status_verifikasi !== 'verified')
        ) {
            return redirect()->route($user->biodata ? 'biodata.show' : 'biodata.create', $user->biodata ? [$user->biodata->id] : [])
                ->with('error', 'Biodata Anda belum diverifikasi admin. Kartu kuning belum bisa dicetak.');
        }

        $this->ensureKartuKuningReady($user);

        $user->kartuKuning()->updateOrCreate(
            ['user_id' => $user->id],
            ['tanggal_cetak' => now()]
        );

        // Selalu regenerasi QR saat download PDF agar token terbaru
        $user->generateQrCode();
        $user->refresh(['biodata', 'kartuKuning']);

        $qrSvg = QrCode::format('svg')
            ->size(200)
            ->generate($user->qr_code);

        $pdf = Pdf::loadView('kartu.cetak', [
            'user'       => $user->fresh(['biodata', 'kartuKuning']),
            'qrSvg'      => $qrSvg,
            'validUntil' => now()->addYears(2),
        ]);

        return $pdf->download('kartu-kuning-' . $user->id . '.pdf');
    }

    /**
     * Endpoint verifikasi publik — diakses saat QR discan.
     * TIDAK memerlukan login.
     */
    public function verify(Request $request, string $nomor_ak1)
    {
        $token = $request->query('token', '');

        // Cari kartu berdasarkan nomor_ak1
        $kartu = KartuKuning::where('nomor_ak1', $nomor_ak1)->first();

        // Tentukan status validitas
        $isValid = false;
        $errorMessage = null;

        if (! $kartu) {
            $errorMessage = 'Kartu dengan nomor ini tidak ditemukan dalam sistem.';
        } elseif (! $token || $kartu->qr_token !== $token) {
            $errorMessage = 'Token keamanan tidak valid. Kartu ini kemungkinan dipalsukan.';
        } elseif ($kartu->status === 'expired') {
            $errorMessage = 'Kartu ini sudah kadaluarsa.';
        } else {
            $user = User::with(['biodata', 'kartuKuning'])->find($kartu->user_id);
            if (! $user || ! $user->biodata || $user->biodata->status_verifikasi !== 'verified') {
                $errorMessage = 'Biodata pemilik kartu belum atau tidak lagi diverifikasi.';
            } else {
                $isValid = true;
            }
        }

        // Increment scan count jika kartu ditemukan
        if ($kartu) {
            $kartu->increment('scan_count');
        }

        // Jika tidak valid, tampilkan halaman error
        if (! $isValid) {
            return view('kartu.verify', [
                'valid'        => false,
                'errorMessage' => $errorMessage,
                'nomor_ak1'    => $nomor_ak1,
            ]);
        }

        // Load user dengan relasi lengkap
        $user = User::with(['biodata', 'kartuKuning'])->find($kartu->user_id);

        return view('kartu.verify', [
            'valid'      => true,
            'user'       => $user,
            'kartu'      => $kartu->fresh(),
            'validUntil' => $kartu->tanggal_cetak
                ? \Carbon\Carbon::parse($kartu->tanggal_cetak)->addYears(2)
                : now()->addYears(2),
            'scannedAt'  => now(),
        ]);
    }

    /**
     * API endpoint untuk data scan (backward compat + extended info).
     */
    public function scanData(int $id): JsonResponse
    {
        $user = User::with(['biodata', 'kartuKuning'])->findOrFail($id);

        return response()->json([
            'valid'    => (bool) $user->kartuKuning && optional($user->biodata)->status_verifikasi === 'verified',
            'user'     => [
                'id'   => $user->id,
                'name' => $user->name,
            ],
            'biodata'  => [
                'nik'                => optional($user->biodata)->nik
                    ? substr(optional($user->biodata)->nik, 0, 6) . '**********'
                    : null,
                'tempat_lahir'       => optional($user->biodata)->tempat_lahir,
                'jenis_kelamin'      => optional($user->biodata)->jenis_kelamin,
                'pendidikan'         => optional($user->biodata)->pendidikan,
                'institusi'          => optional($user->biodata)->institusi_pendidikan,
                'jurusan'            => optional($user->biodata)->jurusan,
                'tahun_lulus'        => optional($user->biodata)->tahun_lulus,
                'keahlian'           => optional($user->biodata)->keahlian,
                'tujuan_lamaran'     => optional($user->biodata)->tujuan_lamaran,
                'status_verifikasi'  => optional($user->biodata)->status_verifikasi,
            ],
            'kartu'    => [
                'nomor_ak1'     => optional($user->kartuKuning)->nomor_ak1,
                'tanggal_cetak' => optional($user->kartuKuning)->tanggal_cetak,
                'status'        => optional($user->kartuKuning)->status,
                'scan_count'    => optional($user->kartuKuning)->scan_count,
            ],
        ]);
    }

    private function ensureKartuKuningReady(User $user): void
    {
        if (! $user->hasCompletedProfile()) {
            abort(422, 'Lengkapi profil terlebih dahulu.');
        }

        if (! $user->biodata || $user->biodata->status_verifikasi !== 'verified') {
            abort(403, 'Biodata belum diverifikasi admin. Kartu kuning belum bisa dicetak.');
        }

        if (! $user->kartuKuning) {
            KartuKuning::create([
                'user_id'    => $user->id,
                'nomor_ak1'  => 'AK1-' . now()->format('Ymd') . '-' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                'tanggal_cetak' => now(),
                'status'     => 'printed',
            ]);

            $user->refresh();
        }

        if (! $user->qr_code) {
            $user->generateQrCode();
            $user->refresh();
        }
    }
}
