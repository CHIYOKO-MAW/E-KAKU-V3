<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Status Pengguna</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111827; }
        h1 { font-size: 16px; margin: 0 0 6px; }
        p { margin: 0 0 12px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; font-weight: 700; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <h1>Laporan Status Pengguna e-Kaku V3</h1>
    <p>Generated: {{ $generatedAt->format('d M Y H:i') }} WIB</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NIK</th>
                <th>Kecamatan</th>
                <th>Kelurahan/Desa</th>
                <th>Status Verifikasi</th>
                <th>Status Pekerjaan</th>
                <th>Tanggal Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                @php($area = $areaMap[$row->id] ?? ['kecamatan' => '-', 'kelurahan' => '-'])
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->biodata->nik ?? '-' }}</td>
                    <td>{{ $area['kecamatan'] }}</td>
                    <td>{{ $area['kelurahan'] }}</td>
                    <td>{{ strtoupper($row->biodata->status_verifikasi ?? 'pending') }}</td>
                    <td>{{ $row->statusPekerjaan?->status_pekerjaan ? str_replace('_', ' ', ucfirst($row->statusPekerjaan->status_pekerjaan)) : '-' }}</td>
                    <td>{{ optional($row->statusPekerjaan?->tanggal_update)->format('d M Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="muted">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
