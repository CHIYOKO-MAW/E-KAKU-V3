<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where('role', 'user')
            ->with(['biodata', 'statusPekerjaan']);

        if (request('search')) {
            $term = trim((string) request('search'));
            $users->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhereHas('biodata', fn ($qb) => $qb->where('nik', 'like', '%' . $term . '%'));
            });
        }

        if (request('status')) {
            $users->whereHas('statusPekerjaan', fn ($q) => $q->where('status_pekerjaan', request('status')));
        }

        $users = $users->latest()->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['biodata', 'statusPekerjaan', 'uploads', 'notificationsE' => fn ($q) => $q->latest()->take(10)]);

        return view('admin.user-details', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'atasan', 'user'])],
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.pengguna.index')->with('success', 'User diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }

    public function attention()
    {
        $needsAttention = User::where('role', 'user')
            ->where(function ($q) {
                $q->doesntHave('biodata')
                    ->orWhereHas('biodata', function ($qb) {
                        $qb->where('status_verifikasi', '!=', 'verified');
                    })
                    ->orWhereHas('statusPekerjaan', function ($qb) {
                        $qb->whereDate('tanggal_update', '<', now()->subDays(90)->toDateString());
                    });
            })
            ->with(['biodata', 'statusPekerjaan'])
            ->latest()
            ->paginate(20);

        return view('admin.perhatian', compact('needsAttention'));
    }
}
