@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6 px-4 py-8">
    <div class="rounded-xl bg-white p-6 card-shadow">
        <h2 class="mb-4 text-lg font-semibold">Informasi Profil</h2>
        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="form-label" for="name">Nama</label>
                <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary">Simpan</button>
        </form>
    </div>

    <div class="rounded-xl border border-red-200 bg-white p-6 card-shadow">
        <h2 class="mb-4 text-lg font-semibold text-red-700">Hapus Akun</h2>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('delete')
            <div>
                <label class="form-label" for="password">Password</label>
                <input id="password" name="password" type="password" class="form-input" required>
                @error('password', 'userDeletion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-danger">Hapus Akun</button>
        </form>
    </div>
</div>
@endsection
