@extends('layouts.app')

@section('title', 'Kartu Kuning')

@section('content')
<div class="page-wrap">
    <div class="rounded-xl bg-white p-6 card-shadow">
        <h1 class="text-2xl font-bold text-gray-900">Kartu Kuning Digital (AK-1)</h1>
        <p class="mt-2 text-sm text-gray-600">
            Kartu kuning bisa dipreview dan diunduh setelah biodata Anda diverifikasi admin.
        </p>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('kartu.show') }}" class="rounded-lg border border-gray-200 p-4 transition hover:border-disnaker-300 hover:bg-disnaker-50">
                <div class="flex items-center">
                    <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                        <i class="fas fa-eye text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Preview Kartu</p>
                        <p class="text-sm text-gray-600">Lihat kartu digital Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kartu.download.self') }}" class="rounded-lg border border-gray-200 p-4 transition hover:border-disnaker-300 hover:bg-disnaker-50">
                <div class="flex items-center">
                    <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                        <i class="fas fa-file-pdf text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Download PDF</p>
                        <p class="text-sm text-gray-600">Unduh kartu untuk dicetak</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
