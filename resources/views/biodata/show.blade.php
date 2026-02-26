@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold">Detail Biodata</h1>

    @if (! $biodata)
        <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-yellow-800">
            Biodata belum tersedia.
        </div>
    @else
        <div class="grid gap-4 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
            <div><span class="font-semibold">NIK:</span> {{ $biodata->nik }}</div>
            <div><span class="font-semibold">Tempat Lahir:</span> {{ $biodata->tempat_lahir }}</div>
            <div><span class="font-semibold">Tanggal Lahir:</span> {{ $biodata->tanggal_lahir }}</div>
            <div><span class="font-semibold">Pendidikan:</span> {{ $biodata->pendidikan }}</div>
            <div class="sm:col-span-2"><span class="font-semibold">Alamat:</span> {{ $biodata->alamat }}</div>
            <div class="sm:col-span-2"><span class="font-semibold">Keahlian:</span> {{ $biodata->keahlian ?? '-' }}</div>
            <div>
                <span class="font-semibold">Status Verifikasi:</span>
                @if ($biodata->status_verifikasi === 'verified')
                    <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Terverifikasi</span>
                @elseif ($biodata->status_verifikasi === 'rejected')
                    <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Ditolak</span>
                @else
                    <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700">Menunggu Validasi Admin</span>
                @endif
            </div>
            @if ($biodata->tanggal_verifikasi)
                <div><span class="font-semibold">Tanggal Verifikasi:</span> {{ $biodata->tanggal_verifikasi }}</div>
            @endif
        </div>

        <div class="mt-4 rounded-lg bg-white p-6 shadow">
            <h2 class="mb-2 text-lg font-semibold text-gray-900">Pengajuan Validasi</h2>
            <p class="mb-4 text-sm text-gray-600">
                User hanya dapat preview/cetak kartu kuning setelah biodata diverifikasi admin Disnaker.
            </p>

            @if (auth()->user()->role === 'user')
                @if ($biodata->status_verifikasi === 'verified')
                    <a href="{{ route('kartu.show') }}" class="inline-flex rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        Lihat Kartu Kuning
                    </a>
                @else
                    <form method="POST" action="{{ route('biodata.submit') }}">
                        @csrf
                        <button type="submit" class="inline-flex rounded-md bg-disnaker-500 px-4 py-2 text-white hover:bg-disnaker-600">
                            Ajukan Validasi ke Admin
                        </button>
                    </form>
                @endif
            @endif
        </div>
    @endif
</div>
@endsection
