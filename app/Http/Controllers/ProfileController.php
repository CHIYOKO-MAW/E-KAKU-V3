<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $authUser = $request->user()->load(['biodata', 'kartuKuning', 'statusPekerjaan']);

        return view('user.profile', [
            'user' => $authUser,
            'biodata' => $authUser->biodata,
            'status' => $authUser->statusPekerjaan,
            'unreadCount' => $authUser->notificationsE()->where('status_baca', false)->count(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        unset($validated['profile_photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store("profile-photos/{$user->id}", 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function photo(User $user)
    {
        $currentUser = Auth::user();
        if (! $currentUser) {
            abort(403);
        }

        if ((int) $currentUser->id !== (int) $user->id && ! in_array($currentUser->role, ['admin', 'atasan'], true)) {
            abort(403, 'This action is unauthorized.');
        }

        if (! $user->profile_photo_path) {
            abort(404, 'Foto profil tidak tersedia.');
        }

        $path = storage_path('app/public/' . ltrim($user->profile_photo_path, '/'));
        if (! is_file($path)) {
            abort(404, 'Foto profil tidak ditemukan.');
        }

        return response()->file($path);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Use force delete so Breeze default tests and account removal semantics match.
        $user->forceDelete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
