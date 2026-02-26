@extends('layouts.app')

@section('title', 'Rekap Admin')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
  <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
    <h1 class="text-2xl font-bold text-gray-900">Rekap Kinerja Admin</h1>
    <p class="mt-1 text-sm text-gray-600">Ringkasan aktivitas verifikasi masing-masing admin.</p>
  </div>

  <div class="overflow-hidden rounded-xl bg-white card-shadow">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Admin</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Total Verifikasi</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Verified</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Rejected</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($admins as $admin)
            <tr>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $admin->name }}</td>
              <td class="px-4 py-3 text-gray-700">{{ $admin->email }}</td>
              <td class="px-4 py-3 text-gray-700">{{ $verifikasiPerAdmin[$admin->id] ?? 0 }}</td>
              <td class="px-4 py-3 text-green-700">{{ $verifiedPerAdmin[$admin->id] ?? 0 }}</td>
              <td class="px-4 py-3 text-red-700">{{ $rejectedPerAdmin[$admin->id] ?? 0 }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada admin terdaftar.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
