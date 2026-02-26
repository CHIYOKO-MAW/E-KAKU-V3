<?php
namespace App\Http\Controllers;

use App\Models\NotificationE;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->boolean('mark_read')) {
            $user->notificationsE()->where('status_baca', false)->update(['status_baca' => true]);
        }

        $notes = $user->notificationsE()->latest()->paginate(10);
        $unreadCount = $user->notificationsE()->where('status_baca', false)->count();

        return view('user.notification', compact('notes', 'unreadCount'));
    }

    public function markRead(NotificationE $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['status_baca' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function sendManual(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengirim notifikasi manual.');
        }

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'user_ids' => 'nullable|string',
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string|max:2000',
        ]);

        $targetIds = collect();
        if ($request->filled('user_id')) {
            $targetIds->push((int) $request->user_id);
        }

        if ($request->filled('user_ids')) {
            $bulkIds = collect(explode(',', (string) $request->user_ids))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->values();
            $targetIds = $targetIds->merge($bulkIds);
        }

        if ($targetIds->isEmpty()) {
            return back()->with('error', 'Pilih minimal satu user tujuan notifikasi.');
        }

        $validUserIds = User::whereIn('id', $targetIds->unique()->all())->pluck('id');
        foreach ($validUserIds as $userId) {
            NotificationE::create([
                'user_id' => $userId,
                'judul' => (string) $request->judul,
                'pesan' => (string) $request->pesan,
                'tipe' => 'manual',
                'status_baca' => false,
            ]);
        }

        return back()->with('success', 'Notifikasi dikirim ke ' . $validUserIds->count() . ' pengguna.');
    }
}
