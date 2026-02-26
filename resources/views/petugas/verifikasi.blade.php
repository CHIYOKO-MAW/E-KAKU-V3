@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8">
  <h1 class="mb-6 text-2xl font-bold text-gray-900">Verifikasi Biodata</h1>

  <div class="overflow-hidden rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">#</th>
          <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama</th>
          <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">NIK</th>
          <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
          <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        @forelse($datas as $data)
          <tr>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
            <td class="px-4 py-3 text-sm text-gray-900">{{ $data->user->name }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $data->nik }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($data->status_verifikasi) }}</td>
            <td class="px-4 py-3 text-sm">
              <div class="flex flex-wrap gap-2">
                <a href="{{ route('verifikasi.show', $data->id) }}" class="rounded-md bg-indigo-600 px-3 py-1 text-white hover:bg-indigo-700">Lihat</a>
                <form action="{{ route('verifikasi.updateStatus', $data->id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="status" value="verified">
                  <button class="rounded-md bg-green-600 px-3 py-1 text-white hover:bg-green-700">Setujui</button>
                </form>
                <form action="{{ route('verifikasi.updateStatus', $data->id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="status" value="rejected">
                  <button class="rounded-md bg-red-600 px-3 py-1 text-white hover:bg-red-700">Tolak</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada data verifikasi.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $datas->links() }}
  </div>
</div>
@endsection
