@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
    <a href="{{ route('admin.pengguna.index') }}" class="btn-secondary">Kembali</a>
  </div>

  <div class="rounded-xl bg-white p-6 card-shadow">
    <form method="POST" action="{{ route('admin.pengguna.update', $user) }}" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="form-label" for="name">Nama</label>
        <input id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="form-label" for="email">Email</label>
        <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="form-label" for="role">Role</label>
        <select id="role" name="role" class="form-input" required>
          @foreach(['admin' => 'Admin', 'atasan' => 'Atasan', 'user' => 'User'] as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
          @endforeach
        </select>
        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="form-label" for="password">Password Baru (opsional)</label>
        <input id="password" name="password" type="password" class="form-input">
      </div>

      <div>
        <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
      </div>

      <button type="submit" class="btn-primary">Simpan Perubahan</button>
    </form>
  </div>
</div>
@endsection
