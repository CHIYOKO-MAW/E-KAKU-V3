@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8">
  <h1 class="mb-4 text-2xl font-bold text-gray-900">Manajemen Pengguna</h1>
  <div class="rounded-lg bg-white p-6 shadow">
    <p class="text-gray-600">Gunakan halaman data pengguna untuk edit role dan akun.</p>
    <a href="{{ route('admin.pengguna.index') }}" class="mt-3 inline-block text-disnaker-600 hover:underline">Buka daftar pengguna</a>
  </div>
</div>
@endsection
