@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
        <h1 class="text-2xl font-bold text-gray-900">Data Pengguna</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola user pencari kerja untuk kebutuhan operasional admin.</p>
    </div>

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-xl bg-white p-4 card-shadow md:grid-cols-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-input md:col-span-2" placeholder="Cari nama, email, atau NIK...">
        <select name="status" class="form-input">
            <option value="">Semua Status</option>
            <option value="belum_bekerja" @selected(request('status') === 'belum_bekerja')>Belum Bekerja</option>
            <option value="sudah_bekerja" @selected(request('status') === 'sudah_bekerja')>Sudah Bekerja</option>
            <option value="pelatihan" @selected(request('status') === 'pelatihan')>Sedang Pelatihan</option>
        </select>
        <button type="submit" class="btn-primary justify-center">Filter</button>
    </form>

    <div class="overflow-hidden rounded-xl bg-white card-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">NIK</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status Verifikasi</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status Pekerjaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $item)
                        @php($sv = $item->biodata->status_verifikasi ?? 'pending')
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $item->biodata->nik ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $item->email }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $sv === 'verified' ? 'bg-green-100 text-green-700' : ($sv === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ strtoupper($sv) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $item->statusPekerjaan?->status_pekerjaan ? str_replace('_', ' ', ucfirst($item->statusPekerjaan->status_pekerjaan)) : '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.pengguna.show', $item) }}" class="btn-secondary">Detail</a>
                                    <a href="{{ route('admin.pengguna.edit', $item) }}" class="btn-secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-4 py-3">{{ $users->links() }}</div>
    </div>
</div>
@endsection
