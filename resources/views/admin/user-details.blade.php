@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pengguna</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $user->name }} - {{ $user->email }}</p>
            </div>
            <a href="{{ route('admin.pengguna.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl bg-white p-6 card-shadow lg:col-span-2">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Informasi Biodata</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
                <div><span class="font-semibold">NIK:</span> {{ $user->biodata->nik ?? '-' }}</div>
                <div><span class="font-semibold">Tempat Lahir:</span> {{ $user->biodata->tempat_lahir ?? '-' }}</div>
                <div><span class="font-semibold">Tanggal Lahir:</span> {{ optional($user->biodata?->tanggal_lahir)->format('d M Y') ?? '-' }}</div>
                <div><span class="font-semibold">Pendidikan:</span> {{ $user->biodata->pendidikan ?? '-' }}</div>
                <div class="sm:col-span-2"><span class="font-semibold">Alamat:</span> {{ $user->biodata->alamat ?? '-' }}</div>
                <div class="sm:col-span-2"><span class="font-semibold">Keahlian:</span> {{ $user->biodata->keahlian ?? '-' }}</div>
            </div>

            <h3 class="mb-3 mt-8 text-base font-semibold text-gray-900">Dokumen Upload</h3>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                @forelse($user->uploads as $upload)
                    <div class="rounded-lg border border-gray-200 p-3">
                        <p class="font-medium text-gray-900">{{ strtoupper($upload->jenis_dokumen) }}</p>
                        <a href="{{ route('upload.preview', $upload) }}" target="_blank" class="mt-1 inline-block text-sm text-disnaker-600 hover:text-disnaker-700">Lihat Dokumen</a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada dokumen.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Status</h3>
                <div class="mt-3 space-y-2 text-sm">
                    @php($sv = $user->biodata->status_verifikasi ?? 'pending')
                    <p><span class="font-semibold">Verifikasi:</span> <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $sv === 'verified' ? 'bg-green-100 text-green-700' : ($sv === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ strtoupper($sv) }}</span></p>
                    <p><span class="font-semibold">Status Pekerjaan:</span> {{ $user->statusPekerjaan?->status_pekerjaan ? str_replace('_', ' ', ucfirst($user->statusPekerjaan->status_pekerjaan)) : '-' }}</p>
                    <p><span class="font-semibold">Update Terakhir:</span> {{ optional($user->statusPekerjaan?->tanggal_update)->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Notifikasi Terbaru</h3>
                <div class="mt-3 space-y-2 text-sm">
                    @forelse($user->notificationsE as $note)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <p class="font-medium text-gray-900">{{ $note->judul }}</p>
                            <p class="text-gray-600">{{ $note->pesan }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada notifikasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
