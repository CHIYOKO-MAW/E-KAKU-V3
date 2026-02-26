@extends('layouts.app')

@section('title', 'Verifikasi Admin')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
  <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
    <h1 class="text-2xl font-bold text-gray-900">Verifikasi Pengajuan</h1>
    <p class="mt-1 text-sm text-gray-600">Validasi biodata pengguna sebelum akses cetak kartu kuning.</p>
  </div>

  <div class="overflow-hidden rounded-xl bg-white card-shadow">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">NIK</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($datas as $data)
            <tr>
              <td class="px-4 py-3 text-gray-700">{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
              <td class="px-4 py-3 font-medium text-gray-900">{{ $data->user->name }}</td>
              <td class="px-4 py-3 text-gray-700">{{ $data->nik }}</td>
              <td class="px-4 py-3"><span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">{{ strtoupper($data->status_verifikasi) }}</span></td>
              <td class="px-4 py-3"><a href="{{ route('admin.verifikasi.show', $data) }}" class="btn-secondary">Detail</a></td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada data verifikasi pending.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="border-t border-gray-100 px-4 py-3">{{ $datas->links() }}</div>
  </div>
</div>
@endsection
