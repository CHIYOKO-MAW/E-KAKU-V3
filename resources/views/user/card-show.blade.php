@extends('layouts.app')

@section('content')
    <div class="page-wrap">
        <div class="mx-auto max-w-5xl">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-3xl font-bold text-gray-900">Preview Kartu Kuning</h1>
                <a href="{{ route('kartu.download.self') }}" class="btn-primary">
                    <i class="fas fa-file-pdf mr-2"></i> Download PDF
                </a>
            </div>

            {{-- Kartu Utama --}}
            <div class="rounded-2xl bg-gradient-to-br from-disnaker-600 to-blue-500 p-6 text-white shadow-xl">
                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                    <div class="flex-1">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-disnaker-600">
                                <i class="fas fa-id-card text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Dinas Tenaga Kerja Kabupaten Pandeglang</p>
                                <h2 class="text-xl font-bold">KARTU KUNING DIGITAL (AK-1)</h2>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 rounded-xl bg-white/10 p-4 text-sm sm:grid-cols-2">
                            <div>
                                <p class="opacity-80">Nama</p>
                                <p class="font-semibold">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="opacity-80">NIK</p>
                                <p class="font-semibold">{{ $user->biodata->nik ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="opacity-80">Nomor AK-1</p>
                                <p class="font-semibold">{{ $user->kartuKuning->nomor_ak1 ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="opacity-80">Tanggal Cetak</p>
                                <p class="font-semibold">
                                    {{ optional($user->kartuKuning->tanggal_cetak)->format('d/m/Y') ?? now()->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="opacity-80">Berlaku Hingga</p>
                                <p class="font-semibold">{{ $validUntil->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- QR Code --}}
                    <div class="w-full rounded-xl bg-white p-4 text-center md:w-48">
                        @if ($user->qr_code)
                            {!! QrCode::format('svg')->size(140)->generate($user->qr_code) !!}
                        @else
                            <div class="flex h-[140px] items-center justify-center text-gray-400">
                                <i class="fas fa-qrcode text-4xl"></i>
                            </div>
                        @endif
                        <p class="mt-2 text-xs font-medium text-gray-700">Scan untuk verifikasi</p>
                        @if ($user->qr_code)
                            <div class="mt-1 flex items-center justify-center gap-1">
                                <i class="fas fa-shield-halved text-xs text-green-600"></i>
                                <span class="text-xs text-green-700 font-semibold">Dilindungi HMAC</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Informasi Keahlian & Pendidikan --}}
            @if ($user->biodata)
                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- Pendidikan --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-bold text-gray-800">
                            <i class="fas fa-graduation-cap text-blue-500"></i>
                            Pendidikan
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-500">Pendidikan Terakhir</p>
                                <p class="font-semibold text-gray-900">{{ $user->biodata->pendidikan ?? '-' }}</p>
                            </div>
                            @if ($user->biodata->institusi_pendidikan)
                                <div>
                                    <p class="text-gray-500">Institusi</p>
                                    <p class="font-semibold text-gray-900">{{ $user->biodata->institusi_pendidikan }}</p>
                                </div>
                            @endif
                            @if ($user->biodata->jurusan)
                                <div>
                                    <p class="text-gray-500">Jurusan</p>
                                    <p class="font-semibold text-gray-900">{{ $user->biodata->jurusan }}</p>
                                </div>
                            @endif
                            @if ($user->biodata->tahun_lulus)
                                <div>
                                    <p class="text-gray-500">Tahun Lulus</p>
                                    <p class="font-semibold text-gray-900">{{ $user->biodata->tahun_lulus }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Keahlian --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-bold text-gray-800">
                            <i class="fas fa-star text-yellow-500"></i>
                            Keahlian & Tujuan
                        </h3>
                        @if ($user->biodata->keahlian)
                            <div class="mb-3">
                                <p class="mb-2 text-sm text-gray-500">Keahlian</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $user->biodata->keahlian) as $skill)
                                        <span
                                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($user->biodata->tujuan_lamaran)
                            <div class="text-sm">
                                <p class="text-gray-500">Tujuan Lamaran</p>
                                <p class="font-semibold text-gray-900">{{ $user->biodata->tujuan_lamaran }}</p>
                            </div>
                        @endif
                        @if (!$user->biodata->keahlian && !$user->biodata->tujuan_lamaran)
                            <p class="text-sm text-gray-400 italic">Belum ada data keahlian.</p>
                        @endif
                    </div>
                </div>

                {{-- Info Keamanan QR --}}
                <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-shield-halved mt-0.5 text-green-600"></i>
                        <div class="text-sm">
                            <p class="font-semibold text-green-800">QR Code Dilindungi HMAC-SHA256</p>
                            <p class="text-green-700 mt-1">
                                QR Code pada kartu ini mengandung token keamanan unik yang digenerate dari server.
                                Saat discan, sistem akan memverifikasi keaslian token secara realtime.
                                Kartu yang dipalsukan akan terdeteksi dan ditampilkan sebagai <strong>TIDAK VALID</strong>.
                            </p>
                            @if ($user->kartuKuning && $user->kartuKuning->qr_issued_at)
                                <p class="text-green-600 mt-2 text-xs">
                                    Token terakhir digenerate:
                                    {{ \Carbon\Carbon::parse($user->kartuKuning->qr_issued_at)->format('d/m/Y H:i') }}
                                    WIB
                                    &bull; Total scan: {{ $user->kartuKuning->scan_count ?? 0 }}x
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
