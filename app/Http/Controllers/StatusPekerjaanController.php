<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusPekerjaan;
use Carbon\Carbon;

class StatusPekerjaanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:user']);
    }

    // tampil halaman status user (card di dashboard bisa include partial)
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $user->statusPekerjaan()->first();
        return view('status.index', compact('status'));
    }

    // menyimpan/men-update
    public function store(Request $request)
    {
        $request->validate([
            'status_pekerjaan' => 'required|in:belum_bekerja,sudah_bekerja',
            'nama_perusahaan' => 'nullable|string|max:255',
            'tanggal_update' => 'nullable|date',
        ]);

        $user = $request->user();

        $data = [
            'status_pekerjaan' => $request->status_pekerjaan,
            'nama_perusahaan' => $request->status_pekerjaan === 'sudah_bekerja' ? $request->nama_perusahaan : null,
            'tanggal_update' => $request->tanggal_update ? Carbon::parse($request->tanggal_update)->format('Y-m-d') : now()->toDateString(),
        ];

        $status = StatusPekerjaan::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success','Status pekerjaan berhasil disimpan.');
    }
}
