<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Upload;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $uploads = Auth::user()->uploads()->with('user')->latest()->paginate(10);

        return view('upload.index', compact('uploads'));
    }

    public function create()
    {
        return view('upload.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => ['required', Rule::in(['ktp', 'ijazah', 'foto'])],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $user = Auth::user();

        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $file = $request->file('file');

        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $extension = $file->getClientOriginalExtension();

        $filename = Str::slug($originalName)
            . '-' . time()
            . '.' . $extension;

        $path = $file->storeAs(
            "uploads/{$user->id}",
            $filename,
            'public'
        );

        Upload::create([
            'user_id' => $user->id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file_path' => $path,
        ]);

        return redirect()
            ->route('upload.index')
            ->with('success', 'File berhasil diupload.');
    }

    public function preview(Upload $upload)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'Unauthorized');
        }
        if (! in_array($user->role, ['admin', 'atasan'], true) && (int) $upload->user_id !== (int) $user->id) {
            abort(403, 'This action is unauthorized.');
        }

        $candidatePaths = [
            storage_path('app/' . ltrim($upload->file_path, '/')),
            storage_path('app/public/' . ltrim($upload->file_path, '/')),
            storage_path('app/public/' . ltrim(str_replace('public/', '', $upload->file_path), '/')),
        ];

        $fullPath = null;
        foreach ($candidatePaths as $candidatePath) {
            if (is_file($candidatePath)) {
                $fullPath = $candidatePath;
                break;
            }
        }

        if (! $fullPath) {
            return redirect()->route('upload.index')->with('error', 'File tidak ditemukan di server. Upload ulang dokumen Anda.');
        }

        return response()->file($fullPath);
    }

    public function destroy(Upload $upload)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'Unauthorized');
        }
        if (! in_array($user->role, ['admin', 'atasan'], true) && (int) $upload->user_id !== (int) $user->id) {
            abort(403, 'This action is unauthorized.');
        }

        if (Storage::disk('public')->exists($upload->file_path)) {
            Storage::disk('public')->delete($upload->file_path);
        } elseif (Storage::exists($upload->file_path)) {
            Storage::delete($upload->file_path);
        } elseif (Storage::disk('public')->exists(str_replace('public/', '', $upload->file_path))) {
            Storage::disk('public')->delete(str_replace('public/', '', $upload->file_path));
        }

        $upload->delete();

        return redirect()
            ->route('upload.index')
            ->with('success', 'File berhasil dihapus.');
    }
}
