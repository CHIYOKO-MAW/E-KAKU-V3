<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\KartuKuning;
use App\Models\NotificationE;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $datas = Biodata::with('user')->where('status_verifikasi', 'pending')->paginate(15);
        return view('admin.verifikasi', compact('datas'));
    }

    public function show(Biodata $biodata)
    {
        $biodata->load('user.uploads');
        return view('admin.verifikasi-detail', compact('biodata'));
    }

    public function update(Request $request, Biodata $biodata)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string|max:500',
        ]);

        $status = $request->input('status');
        $catatan = trim((string) $request->input('catatan'));

        $biodata->update([
            'status_verifikasi' => $status,
            'verifikator_id' => $request->user()->id,
            'tanggal_verifikasi' => now()->toDateString(),
        ]);

        NotificationE::create([
            'user_id' => $biodata->user_id,
            'judul' => 'Status Verifikasi Biodata',
            'pesan' => $status === 'verified'
                ? 'Biodata Anda telah diverifikasi admin. Anda sekarang dapat mencetak kartu kuning.'
                : 'Biodata Anda ditolak admin.' . ($catatan !== '' ? ' Catatan: ' . $catatan : ''),
            'status_baca' => false,
            'tipe' => 'status_update',
        ]);

        if ($status === 'verified') {
            KartuKuning::updateOrCreate(
                ['user_id' => $biodata->user_id],
                [
                    'nomor_ak1' => 'AK1-' . now()->format('Ymd') . '-' . str_pad((string) $biodata->user_id, 4, '0', STR_PAD_LEFT),
                    'status' => 'printed',
                    'tanggal_cetak' => now(),
                ]
            );
        }

        return back()->with('success', 'Status verifikasi diperbarui.');
    }

    public function updateStatus(Request $request, $biodataId)
    {
        $biodata = Biodata::findOrFail($biodataId);
        return $this->update($request, $biodata);
    }
}
