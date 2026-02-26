# Release Notes Candidate - e-Kaku V3

## Versi
Candidate deploy internal (siap ujicoba Disnaker)

## Highlight
- UI landing + halaman operasional diselaraskan ke tema base e-Kaku.
- Alur bisnis inti terkunci:
  - user isi biodata -> ajukan validasi -> admin verifikasi -> user cetak kartu.
- Role final dipakai: `user`, `admin`, `atasan`.
- Laporan admin kini mendukung analisis wilayah Pandeglang (kecamatan/desa-kelurahan).
- Export laporan PDF/CSV aktif.

## Perubahan Utama
- Rework dashboard/profile/biodata user dengan progress biodata + mini kartu digital.
- Rework dashboard/laporan/verifikasi/pengguna admin.
- Rework dashboard + rekap atasan.
- Integrasi master wilayah Pandeglang (`35 kecamatan`, `339 desa/kelurahan`) untuk filter laporan.
- Hardening smart reminder (anti-spam dedupe).
- Hardening notifikasi manual (admin-only).
- Pemisahan seeder:
  - `DatabaseSeeder` untuk data inti.
  - `DemoDataSeeder` untuk data dummy presentasi.

## Endpoint Baru/Disempurnakan
- `GET /admin/laporan/export/csv`
- `GET /admin/laporan/export/pdf`
- `GET /admin/wilayah/{districtCode}/villages`

## Breaking/Compatibility Notes
- Alias route legacy lama sudah dibersihkan:
  - `/dashboard/petugas`
  - `/dashboard/admin`
  - `/verifikasi/*` (legacy group)
  - `/admin/users/*` (legacy alias)
- Gunakan route canonical `admin.*`, `atasan.*`, `dashboard.user`.

## Verifikasi Teknis
- `php artisan route:list` OK
- `php artisan test` OK
- `npm run build` OK
- `php artisan reminder:smart` OK

## Deployment
- Lihat `DEPLOYMENT.md`.
- Untuk demo data:
  - `php artisan db:seed --class=DemoDataSeeder`
  - atau set `.env`: `SEED_DEMO_DATA=true`
