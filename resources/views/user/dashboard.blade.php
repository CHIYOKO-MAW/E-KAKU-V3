@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="page-wrap">
    <div class="rounded-xl bg-white p-6 card-shadow">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ $user->name }}!</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola biodata, status pekerjaan, dan kartu kuning digital Anda.</p>
            </div>
            <div class="hidden h-16 w-16 items-center justify-center rounded-full bg-disnaker-100 sm:flex">
                <i class="fas fa-user text-2xl text-disnaker-600"></i>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl bg-white p-6 card-shadow">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Status Profil dan Verifikasi</h2>
                @if ($biodata?->status_verifikasi === 'verified')
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terverifikasi</span>
                @elseif ($biodata?->status_verifikasi === 'rejected')
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                @elseif ($biodata)
                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu Validasi</span>
                @else
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Belum Isi Biodata</span>
                @endif
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">NIK</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ $biodata?->nik ?? '-' }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Pendidikan</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ $biodata?->pendidikan ?? '-' }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 p-4 sm:col-span-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Status Pekerjaan</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $status?->status_pekerjaan ? str_replace('_', ' ', ucfirst($status->status_pekerjaan)) : 'Belum ada update' }}
                    </p>
                    @if ($status?->nama_perusahaan)
                        <p class="mt-1 text-sm text-gray-600">Perusahaan: {{ $status->nama_perusahaan }}</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('profile.edit') }}" class="btn-primary"><i class="fas fa-user mr-2"></i>Kelola Profil</a>
                <a href="{{ $biodata ? route('biodata.edit') : route('biodata.create') }}" class="btn-secondary"><i class="fas fa-address-card mr-2"></i>{{ $biodata ? 'Edit Biodata' : 'Isi Biodata' }}</a>
                <a href="{{ route('status.index') }}" class="btn-secondary"><i class="fas fa-sync-alt mr-2"></i>Update Status</a>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl bg-white p-5 card-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Notifikasi Baru</p>
                    <i class="fas fa-bell text-disnaker-600"></i>
                </div>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $unreadCount }}</p>
                <a href="{{ route('notifikasi.index') }}" class="mt-3 inline-block text-sm font-medium text-disnaker-600 hover:text-disnaker-700">Lihat notifikasi</a>
            </div>

            <div class="rounded-xl bg-white p-5 card-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Kartu Kuning</p>
                    <i class="fas fa-id-card text-disnaker-600"></i>
                </div>
                <p class="mt-2 text-sm text-gray-700">
                    {{ $biodata?->status_verifikasi === 'verified' ? 'Siap dipreview dan dicetak.' : 'Aktif setelah biodata diverifikasi admin.' }}
                </p>
                <a href="{{ route('kartu.show') }}" class="mt-3 inline-block text-sm font-medium text-disnaker-600 hover:text-disnaker-700">Buka kartu digital</a>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-xl bg-white p-6 card-shadow">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Notifikasi Terbaru</h2>
            <a href="{{ route('notifikasi.index') }}" class="text-sm font-medium text-disnaker-600 hover:text-disnaker-700">Semua notifikasi</a>
        </div>
        <div class="space-y-3">
            @forelse ($notifications as $note)
                <div class="rounded-lg border px-4 py-3 {{ $note->status_baca ? 'border-gray-200 bg-white' : 'border-blue-200 bg-blue-50' }}">
                    <p class="font-medium text-gray-900">{{ $note->judul }}</p>
                    <p class="mt-1 text-sm text-gray-600">{{ $note->pesan }}</p>
                    <p class="mt-1 text-xs text-gray-500">{{ $note->created_at?->diffForHumans() }}</p>
                </div>
            @empty
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">
                    Belum ada notifikasi.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
