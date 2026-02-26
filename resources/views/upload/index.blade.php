@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8">
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Dokumen Saya</h1>
    <a href="{{ route('upload.create') }}" class="rounded-md bg-disnaker-500 px-4 py-2 text-sm font-medium text-white hover:bg-disnaker-600">Upload Dokumen</a>
  </div>

  @if($uploads->count())
    <div class="overflow-hidden rounded-lg bg-white shadow">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">#</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Jenis</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">File</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">User</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            @foreach($uploads as $u)
              <tr>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($uploads->currentPage() - 1) * $uploads->perPage() }}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ strtoupper($u->jenis_dokumen) }}</td>
                <td class="px-4 py-3 text-sm">
                  <a href="{{ route('upload.preview', $u->id) }}" class="text-disnaker-600 hover:underline">{{ basename($u->file_path) }}</a>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $u->user->name ?? '-' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $u->created_at->format('Y-m-d') }}</td>
                <td class="px-4 py-3 text-sm">
                  <form action="{{ route('upload.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-md bg-red-600 px-3 py-1 text-white hover:bg-red-700">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="border-t border-gray-100 px-4 py-3">
        {{ $uploads->links() }}
      </div>
    </div>
  @else
    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-800">Belum ada dokumen.</div>
  @endif
</div>
@endsection
