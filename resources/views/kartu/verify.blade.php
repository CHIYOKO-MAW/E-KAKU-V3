<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kartu Kuning — Disnaker Pandeglang</title>
    <meta name="description" content="Halaman verifikasi keaslian Kartu Kuning (AK/1) Dinas Tenaga Kerja Kabupaten Pandeglang">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #16a34a;
            --green-light: #dcfce7;
            --green-border: #bbf7d0;
            --red: #dc2626;
            --red-light: #fee2e2;
            --red-border: #fecaca;
            --yellow: #d97706;
            --yellow-light: #fef3c7;
            --blue: #2563eb;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .wrapper {
            width: 100%;
            max-width: 560px;
        }

        /* ======= HEADER ======= */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 8px 18px;
            margin-bottom: 12px;
            backdrop-filter: blur(10px);
        }
        .header-logo i { color: #fbbf24; font-size: 16px; }
        .header-logo span { color: #fff; font-size: 13px; font-weight: 600; letter-spacing: 0.3px; }
        .header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p { color: rgba(255,255,255,0.6); font-size: 13px; margin-top: 4px; }

        /* ======= CARD ======= */
        .card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }

        /* ======= STATUS BANNER ======= */
        .status-banner {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .status-banner.valid {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }
        .status-banner.invalid {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }
        .status-icon {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .status-icon i { font-size: 22px; color: #fff; }
        .status-text h2 { color: #fff; font-size: 18px; font-weight: 800; }
        .status-text p  { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 2px; }

        /* ======= ALERT MESSAGE ======= */
        .alert-box {
            margin: 20px;
            padding: 16px 20px;
            border-radius: 12px;
            background: var(--red-light);
            border: 1px solid var(--red-border);
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .alert-box i { color: var(--red); margin-top: 2px; flex-shrink: 0; }
        .alert-box p { color: #7f1d1d; font-size: 14px; line-height: 1.5; }

        /* ======= PROFILE SECTION ======= */
        .profile-section {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid var(--gray-100);
        }
        .avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .avatar i { font-size: 26px; color: #fff; }
        .profile-info h3 { font-size: 18px; font-weight: 700; color: var(--gray-900); }
        .profile-info .nik {
            font-size: 12px; color: var(--gray-500); margin-top: 3px;
            font-family: monospace; letter-spacing: 1px;
        }
        .verified-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--green-light); border: 1px solid var(--green-border);
            border-radius: 20px; padding: 3px 10px;
            margin-top: 6px;
        }
        .verified-badge i { font-size: 11px; color: var(--green); }
        .verified-badge span { font-size: 11px; font-weight: 600; color: var(--green); }

        /* ======= INFO GRID ======= */
        .info-section { padding: 20px 24px; }
        .section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--gray-500);
            margin-bottom: 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title::after {
            content: ''; flex: 1; height: 1px; background: var(--gray-200);
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .info-item { }
        .info-item.full { grid-column: 1 / -1; }
        .info-label { font-size: 11px; color: var(--gray-500); font-weight: 500; margin-bottom: 2px; }
        .info-value { font-size: 14px; color: var(--gray-900); font-weight: 600; }
        .info-value.large { font-size: 15px; font-family: monospace; letter-spacing: 0.5px; }

        /* ======= KARTU STATUS ======= */
        .kartu-section {
            padding: 20px 24px;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-100);
        }
        .kartu-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 12px; margin-top: 0;
        }
        .kartu-chip {
            background: #fff; border: 1px solid var(--gray-200);
            border-radius: 10px; padding: 12px;
            display: flex; align-items: center; gap: 10px;
        }
        .kartu-chip-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .kartu-chip-icon.green  { background: var(--green-light);  }
        .kartu-chip-icon.blue   { background: #dbeafe; }
        .kartu-chip-icon.yellow { background: var(--yellow-light); }
        .kartu-chip-icon.purple { background: #ede9fe; }
        .kartu-chip-icon.green  i { color: var(--green); }
        .kartu-chip-icon.blue   i { color: var(--blue); }
        .kartu-chip-icon.yellow i { color: var(--yellow); }
        .kartu-chip-icon.purple i { color: #7c3aed; }
        .kartu-chip-icon i { font-size: 15px; }
        .kartu-chip-text .chip-label { font-size: 10px; color: var(--gray-500); font-weight: 500; }
        .kartu-chip-text .chip-value { font-size: 13px; font-weight: 700; color: var(--gray-900); margin-top: 1px; }

        /* tags */
        .tag-list { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
        .tag {
            display: inline-block; background: #dbeafe;
            color: var(--blue); font-size: 12px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px; border: 1px solid #bfdbfe;
        }

        /* ======= FOOTER ======= */
        .card-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 8px;
        }
        .footer-brand { display: flex; align-items: center; gap: 8px; }
        .footer-brand i { color: #fbbf24; font-size: 14px; }
        .footer-brand span { font-size: 12px; color: var(--gray-500); font-weight: 500; }
        .footer-meta { font-size: 11px; color: var(--gray-500); }

        /* ======= INVALID FOOTER ======= */
        .invalid-help {
            padding: 16px 24px;
            text-align: center;
            border-top: 1px solid var(--gray-100);
        }
        .invalid-help p { font-size: 13px; color: var(--gray-500); }
        .invalid-help a { color: var(--blue); font-weight: 600; text-decoration: none; }

        /* ======= SCAN REF ======= */
        .scan-ref {
            margin-top: 14px;
            text-align: center;
        }
        .scan-ref span {
            font-size: 11px; color: rgba(255,255,255,0.4);
        }

        @media (max-width: 480px) {
            .info-grid, .kartu-grid { grid-template-columns: 1fr; }
            .info-item.full { grid-column: 1; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    {{-- HEADER --}}
    <div class="header">
        <div class="header-logo">
            <i class="fas fa-shield-halved"></i>
            <span>DISNAKER PANDEGLANG — SISTEM VERIFIKASI</span>
        </div>
        <h1>Verifikasi Kartu Kuning</h1>
        <p>Kartu AK-1 Digital &bull; Dinas Tenaga Kerja Kabupaten Pandeglang</p>
    </div>

    <div class="card">

        {{-- ====== VALID ====== --}}
        @if($valid)

        <div class="status-banner valid">
            <div class="status-icon">
                <i class="fas fa-circle-check"></i>
            </div>
            <div class="status-text">
                <h2>✅ KARTU VALID & ASLI</h2>
                <p>Kartu ini terdaftar resmi di sistem Disnaker Pandeglang</p>
            </div>
        </div>

        {{-- Profile --}}
        <div class="profile-section">
            <div class="avatar">
                @if($user->profile_photo_path)
                    <img src="{{ route('profile.photo', $user) }}" alt="{{ $user->name }}">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <div class="profile-info">
                <h3>{{ $user->name }}</h3>
                <div class="nik">NIK: {{ substr($user->biodata->nik ?? '', 0, 6) }}**********</div>
                <div class="verified-badge">
                    <i class="fas fa-circle-check"></i>
                    <span>Terverifikasi Disnaker</span>
                </div>
            </div>
        </div>

        {{-- Data Kartu --}}
        <div class="kartu-section">
            <div class="section-title">Data Kartu</div>
            <div class="kartu-grid">
                <div class="kartu-chip">
                    <div class="kartu-chip-icon blue"><i class="fas fa-id-card"></i></div>
                    <div class="kartu-chip-text">
                        <div class="chip-label">Nomor AK-1</div>
                        <div class="chip-value">{{ $kartu->nomor_ak1 }}</div>
                    </div>
                </div>
                <div class="kartu-chip">
                    <div class="kartu-chip-icon green"><i class="fas fa-calendar-check"></i></div>
                    <div class="kartu-chip-text">
                        <div class="chip-label">Berlaku Hingga</div>
                        <div class="chip-value">{{ $validUntil->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="kartu-chip">
                    <div class="kartu-chip-icon yellow"><i class="fas fa-print"></i></div>
                    <div class="kartu-chip-text">
                        <div class="chip-label">Tanggal Cetak</div>
                        <div class="chip-value">
                            {{ optional($kartu->tanggal_cetak)->format('d/m/Y') ?? '-' }}
                        </div>
                    </div>
                </div>
                <div class="kartu-chip">
                    <div class="kartu-chip-icon purple"><i class="fas fa-qrcode"></i></div>
                    <div class="kartu-chip-text">
                        <div class="chip-label">Total Dipindai</div>
                        <div class="chip-value">{{ $kartu->scan_count }}x</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Pribadi --}}
        <div class="info-section">
            <div class="section-title">Data Pribadi</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Tempat Lahir</div>
                    <div class="info-value">{{ $user->biodata->tempat_lahir ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">{{ $user->biodata->jenis_kelamin ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status Perkawinan</div>
                    <div class="info-value">{{ $user->biodata->status_perkawinan ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kecamatan</div>
                    <div class="info-value">{{ $user->biodata->kecamatan ?? '-' }}</div>
                </div>
                <div class="info-item full">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $user->biodata->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Pendidikan & Keahlian --}}
        <div class="info-section" style="border-top: 1px solid var(--gray-100); padding-top: 16px;">
            <div class="section-title">Pendidikan & Keahlian</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Pendidikan Terakhir</div>
                    <div class="info-value">{{ $user->biodata->pendidikan ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tahun Lulus</div>
                    <div class="info-value">{{ $user->biodata->tahun_lulus ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Institusi</div>
                    <div class="info-value">{{ $user->biodata->institusi_pendidikan ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jurusan</div>
                    <div class="info-value">{{ $user->biodata->jurusan ?? '-' }}</div>
                </div>
                @if($user->biodata->keahlian ?? null)
                <div class="info-item full">
                    <div class="info-label">Keahlian</div>
                    <div class="tag-list">
                        @foreach(explode(',', $user->biodata->keahlian) as $skill)
                            <span class="tag">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($user->biodata->tujuan_lamaran ?? null)
                <div class="info-item full">
                    <div class="info-label">Tujuan Lamaran</div>
                    <div class="info-value">{{ $user->biodata->tujuan_lamaran }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer">
            <div class="footer-brand">
                <i class="fas fa-building-columns"></i>
                <span>Dinas Tenaga Kerja Kab. Pandeglang</span>
            </div>
            <div class="footer-meta">
                Dipindai: {{ $scannedAt->format('d/m/Y H:i') }} WIB
            </div>
        </div>

        {{-- ====== INVALID ====== --}}
        @else

        <div class="status-banner invalid">
            <div class="status-icon">
                <i class="fas fa-circle-xmark"></i>
            </div>
            <div class="status-text">
                <h2>❌ KARTU TIDAK VALID</h2>
                <p>Kartu ini tidak dapat diverifikasi oleh sistem</p>
            </div>
        </div>

        <div class="alert-box">
            <i class="fas fa-triangle-exclamation"></i>
            <p>{{ $errorMessage ?? 'Kartu ini tidak dapat diverifikasi. Kemungkinan kartu telah dipalsukan, kadaluarsa, atau tidak terdaftar di sistem.' }}</p>
        </div>

        <div class="info-section">
            <div class="section-title">Referensi</div>
            <div class="info-grid">
                <div class="info-item full">
                    <div class="info-label">Nomor AK-1 yang dicoba</div>
                    <div class="info-value large">{{ $nomor_ak1 ?? '-' }}</div>
                </div>
                <div class="info-item full">
                    <div class="info-label">Waktu Pemeriksaan</div>
                    <div class="info-value">{{ now()->format('d/m/Y H:i:s') }} WIB</div>
                </div>
            </div>
        </div>

        <div class="invalid-help">
            <p>Jika Anda yakin kartu ini asli, hubungi <a href="#">Disnaker Pandeglang</a> untuk klarifikasi.</p>
        </div>

        @endif

    </div>{{-- end .card --}}

    <div class="scan-ref">
        <span>e-Kaku &bull; Verifikasi Digital &bull; Disnaker Pandeglang &copy; {{ date('Y') }}</span>
    </div>
</div>

</body>
</html>
