<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Kuning AK/1 — {{ $user->name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
        }

        .page {
            padding: 20px;
            width: 100%;
        }

        /* Header instansi */
        .kop {
            text-align: center;
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .kop .instansi {
            font-size: 9px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop .title {
            font-size: 15px;
            font-weight: bold;
            color: #1d4ed8;
            margin: 4px 0 2px;
        }

        .kop .sub {
            font-size: 10px;
            color: #444;
        }

        /* Layout utama card */
        .card-outer {
            border: 2px solid #1d4ed8;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background: #1d4ed8;
            color: #fff;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header .ak1-title {
            font-size: 13px;
            font-weight: bold;
        }

        .card-header .nomor {
            font-size: 10px;
            opacity: 0.85;
        }

        .card-body {
            display: flex;
            padding: 14px;
            gap: 14px;
        }

        .card-left {
            flex: 1;
        }

        .card-right {
            width: 120px;
            text-align: center;
            flex-shrink: 0;
        }

        /* Row data */
        .row {
            margin-bottom: 7px;
        }

        .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .value {
            font-size: 11px;
            font-weight: bold;
            color: #111;
            margin-top: 1px;
        }

        .value.mono {
            font-family: monospace;
            letter-spacing: 1px;
        }

        /* Divider */
        .divider {
            border-top: 1px solid #e5e7eb;
            margin: 10px 0;
        }

        /* Badge valid */
        .badge-valid {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        /* Keahlian tags */
        .tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 3px;
        }

        .tag {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 3px;
            padding: 1px 6px;
            font-size: 9px;
            font-weight: bold;
        }

        /* QR area */
        .qr-box {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px;
            margin-bottom: 6px;
        }

        .qr-box svg {
            width: 100px;
            height: 100px;
        }

        .qr-caption {
            font-size: 8px;
            color: #6b7280;
            text-align: center;
            margin-top: 4px;
        }

        .validity-stamp {
            text-align: center;
            font-size: 8px;
            color: #555;
        }

        .validity-stamp strong {
            display: block;
            color: #dc2626;
            font-size: 9px;
        }

        /* Footer */
        .card-footer {
            background: #f1f5f9;
            border-top: 1px solid #e5e7eb;
            padding: 6px 14px;
            font-size: 8.5px;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .security-line {
            font-size: 7px;
            color: #9ca3af;
            text-align: center;
            margin-top: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="page">

        {{-- KOP SURAT --}}
        <div class="kop">
            <div class="instansi">Pemerintah Kabupaten Pandeglang</div>
            <div class="title">KARTU TANDA PENCARI KERJA (AK/1)</div>
            <div class="sub">Dinas Tenaga Kerja Kabupaten Pandeglang &bull; Kartu Kuning Digital</div>
        </div>

        {{-- CARD --}}
        <div class="card-outer">
            <div class="card-header">
                <span class="ak1-title">KARTU KUNING AK/1</span>
                <span class="nomor">No: {{ $user->kartuKuning->nomor_ak1 ?? '-' }}</span>
            </div>

            <div class="card-body">

                {{-- KIRI: Data diri --}}
                <div class="card-left">
                    <div class="badge-valid">✓ Telah Diverifikasi</div>

                    <div class="row">
                        <div class="label">Nama Lengkap</div>
                        <div class="value">{{ strtoupper($user->name) }}</div>
                    </div>

                    <div class="row">
                        <div class="label">NIK</div>
                        <div class="value mono">{{ substr($user->biodata->nik ?? '', 0, 6) }}**********</div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="row">
                            <div class="label">Tempat Lahir</div>
                            <div class="value">{{ $user->biodata->tempat_lahir ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="label">Jenis Kelamin</div>
                            <div class="value">{{ $user->biodata->jenis_kelamin ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label">Alamat</div>
                        <div class="value">{{ $user->biodata->alamat ?? '-' }}@if ($user->biodata->kecamatan ?? null)
                                , Kec. {{ $user->biodata->kecamatan }}
                            @endif
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- Pendidikan --}}
                    <div style="display: flex; gap: 20px;">
                        <div class="row">
                            <div class="label">Pendidikan Terakhir</div>
                            <div class="value">{{ $user->biodata->pendidikan ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="label">Tahun Lulus</div>
                            <div class="value">{{ $user->biodata->tahun_lulus ?? '-' }}</div>
                        </div>
                    </div>

                    @if ($user->biodata->institusi_pendidikan ?? null)
                        <div class="row">
                            <div class="label">Institusi</div>
                            <div class="value">{{ $user->biodata->institusi_pendidikan }}@if ($user->biodata->jurusan ?? null)
                                    — {{ $user->biodata->jurusan }}
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($user->biodata->keahlian ?? null)
                        <div class="row">
                            <div class="label">Keahlian</div>
                            <div class="tag-row">
                                @foreach (explode(',', $user->biodata->keahlian) as $skill)
                                    <span class="tag">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($user->biodata->tujuan_lamaran ?? null)
                        <div class="row" style="margin-top: 4px;">
                            <div class="label">Tujuan Lamaran</div>
                            <div class="value">{{ $user->biodata->tujuan_lamaran }}</div>
                        </div>
                    @endif
                </div>

                {{-- KANAN: QR + validitas --}}
                <div class="card-right">
                    <div class="qr-box">
                        {!! $qrSvg !!}
                    </div>
                    <div class="qr-caption">Scan untuk verifikasi keaslian kartu</div>
                    <div style="margin-top: 8px;">
                        <div class="validity-stamp">
                            Tanggal Cetak<br>
                            <strong>{{ optional($user->kartuKuning->tanggal_cetak)->format('d/m/Y') ?? now()->format('d/m/Y') }}</strong>
                        </div>
                        <div class="validity-stamp" style="margin-top: 6px;">
                            Berlaku Hingga<br>
                            <strong>{{ $validUntil->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

            </div>{{-- end card-body --}}

            <div class="card-footer">
                <span>Dinas Tenaga Kerja Kab. Pandeglang</span>
                <span>e-Kaku V3 &bull; Kartu Digital</span>
            </div>
        </div>{{-- end card-outer --}}

        <p class="security-line">
            Kartu ini dilindungi dengan token keamanan digital HMAC-SHA256.
            Scan QR Code untuk memverifikasi keaslian kartu secara realtime melalui sistem Disnaker Pandeglang.
        </p>

    </div>
</body>

</html>
