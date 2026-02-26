<?php

namespace App\Http\Controllers;

use App\Http\Requests\BiodataRequest;
use App\Models\Biodata;
use Illuminate\Database\QueryException;

class BiodataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // list (admin/atasan see all, user see own)
    public function index()
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'atasan'], true)) {
            $datas = Biodata::with('user')->latest()->paginate(15);
            return view('biodata.index', compact('datas'));
        }

        return redirect()->to(route('profile.edit') . '#biodata');
    }

    public function create()
    {
        if (auth()->user()->role === 'user') {
            return redirect()->to(route('profile.edit') . '#biodata');
        }

        return view('biodata.create');
    }

    public function store(BiodataRequest $request)
    {
        $user = auth()->user();

        if ($user->biodata) {
            return redirect()->to(route('profile.edit') . '#biodata');
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['status_verifikasi'] = 'pending';

        try {
            $softDeletedOwnBiodata = Biodata::withTrashed()
                ->where('user_id', $user->id)
                ->whereNotNull('deleted_at')
                ->first();

            if ($softDeletedOwnBiodata) {
                $softDeletedOwnBiodata->restore();
                $softDeletedOwnBiodata->update($data);
            } else {
                Biodata::create($data);
            }
        } catch (QueryException $e) {
            if ((int) $e->getCode() === 23000) {
                return back()
                    ->withInput()
                    ->withErrors(['nik' => 'NIK sudah terdaftar di sistem. Gunakan NIK yang valid milik Anda atau hubungi admin.']);
            }
            throw $e;
        }

        return redirect()->to(route('profile.edit') . '#biodata')
            ->with('success', 'Biodata berhasil disimpan.');
    }

    public function edit()
    {
        $user = auth()->user();
        $biodata = $user->biodata;

        if (! $biodata) {
            return redirect()->to(route('profile.edit') . '#biodata')
                ->with('info', 'Silakan isi biodata terlebih dahulu.');
        }

        if ($user->role === 'user') {
            return redirect()->to(route('profile.edit') . '#biodata');
        }

        return view('biodata.edit', compact('biodata'));
    }

    public function update(BiodataRequest $request)
    {
        $user = auth()->user();
        $biodata = Biodata::withTrashed()->where('user_id', $user->id)->first();

        if (! $biodata) {
            return redirect()->to(route('profile.edit') . '#biodata');
        }

        if ($biodata->trashed()) {
            $biodata->restore();
        }

        $data = $request->validated();
        if ($biodata->status_verifikasi === 'rejected') {
            $data['status_verifikasi'] = 'pending';
        }
        try {
            $biodata->update($data);
        } catch (QueryException $e) {
            if ((int) $e->getCode() === 23000) {
                return back()
                    ->withInput()
                    ->withErrors(['nik' => 'NIK sudah terdaftar di sistem. Gunakan NIK yang valid milik Anda atau hubungi admin.']);
            }
            throw $e;
        }

        return redirect()->to(route('profile.edit') . '#biodata')
            ->with('success', 'Biodata berhasil diperbarui.');
    }

    public function submitForVerification()
    {
        $user = auth()->user();
        if ($user->role !== 'user') {
            abort(403);
        }

        $biodata = $user->biodata;
        if (! $biodata) {
            return redirect()->to(route('profile.edit') . '#biodata')
                ->with('error', 'Isi biodata terlebih dahulu.');
        }

        if ($biodata->status_verifikasi === 'verified') {
            return redirect()->to(route('profile.edit') . '#biodata')
                ->with('info', 'Biodata sudah terverifikasi.');
        }

        $biodata->update([
            'status_verifikasi' => 'pending',
            'tanggal_verifikasi' => null,
            'verifikator_id' => null,
        ]);

        return redirect()->to(route('profile.edit') . '#biodata')
            ->with('success', 'Pengajuan verifikasi berhasil dikirim. Menunggu validasi admin.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $b = Biodata::findOrFail($id);
        $b->delete();

        return redirect()->route('biodata.index')->with('success', 'Biodata dihapus.');
    }

    public function show($id = null)
    {
        $currentUser = auth()->user();
        if ($currentUser && $currentUser->role === 'user') {
            return redirect()->to(route('profile.edit') . '#biodata');
        }

        if ($id) {
            $biodata = Biodata::with('user', 'user.uploads')->findOrFail($id);
        } else {
            $biodata = $currentUser?->biodata;
        }

        return view('biodata.show', compact('biodata'));
    }
}
