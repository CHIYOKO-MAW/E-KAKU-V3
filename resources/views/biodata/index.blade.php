@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-bold">Data Biodata</h1>

    <div class="mb-4">
        <a href="{{ route('biodata.create') }}" class="rounded-md bg-disnaker-500 px-4 py-2 text-white hover:bg-disnaker-600">Tambah Biodata</a>
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">NIK</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($datas as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->nik }}</td>
                        <td class="px-4 py-3">{{ $item->status_verifikasi }}</td>
                        <td class="px-4 py-3">
                            <a class="text-disnaker-600 hover:underline" href="{{ route('biodata.show', $item->id) }}">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-gray-500" colspan="4">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $datas->links() }}</div>
</div>
@endsection
