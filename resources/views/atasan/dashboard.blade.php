@extends('layouts.app')

@section('title', 'Dashboard Atasan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
  <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Atasan</h1>
    <p class="mt-1 text-sm text-gray-600">Monitoring performa operasional admin dan progress verifikasi layanan AK-1.</p>
  </div>

  <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-5">
    <div class="rounded-xl bg-white p-5 card-shadow"><p class="text-sm text-gray-500">Total Admin</p><p class="text-3xl font-bold text-gray-900">{{ $totalAdmin ?? 0 }}</p></div>
    <div class="rounded-xl bg-white p-5 card-shadow"><p class="text-sm text-gray-500">Total User</p><p class="text-3xl font-bold text-blue-600">{{ $totalUser ?? 0 }}</p></div>
    <div class="rounded-xl bg-white p-5 card-shadow"><p class="text-sm text-gray-500">Pending</p><p class="text-3xl font-bold text-yellow-700">{{ $pending ?? 0 }}</p></div>
    <div class="rounded-xl bg-white p-5 card-shadow"><p class="text-sm text-gray-500">Verified</p><p class="text-3xl font-bold text-green-700">{{ $verified ?? 0 }}</p></div>
    <div class="rounded-xl bg-white p-5 card-shadow"><p class="text-sm text-gray-500">Rejected</p><p class="text-3xl font-bold text-red-700">{{ $rejected ?? 0 }}</p></div>
  </div>

  <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="rounded-xl bg-white p-6 card-shadow lg:col-span-2">
      <h2 class="text-lg font-semibold text-gray-900">Distribusi Status Pekerjaan</h2>
      <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3 text-sm">
        <div class="rounded-lg border border-gray-200 px-3 py-2"><p class="text-gray-600">Belum Bekerja</p><p class="font-semibold text-yellow-700">{{ $statusDistribution['belum_bekerja'] ?? 0 }}</p></div>
        <div class="rounded-lg border border-gray-200 px-3 py-2"><p class="text-gray-600">Sudah Bekerja</p><p class="font-semibold text-green-700">{{ $statusDistribution['sudah_bekerja'] ?? 0 }}</p></div>
        <div class="rounded-lg border border-gray-200 px-3 py-2"><p class="text-gray-600">Pelatihan</p><p class="font-semibold text-blue-700">{{ $statusDistribution['pelatihan'] ?? 0 }}</p></div>
      </div>
    </div>
    <div class="rounded-xl bg-white p-6 card-shadow">
      <h2 class="text-lg font-semibold text-gray-900">Akses Cepat</h2>
      <a href="{{ route('atasan.rekap-admin') }}" class="mt-3 inline-flex text-sm font-semibold text-disnaker-600 hover:underline">Buka Rekap Admin</a>
    </div>
  </div>
</div>
@endsection
