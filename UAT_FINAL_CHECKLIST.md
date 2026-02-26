# UAT Final Checklist - e-Kaku V3

## A. Build & Runtime
- [x] `php artisan route:list` berjalan tanpa konflik route.
- [x] `php artisan test` lulus.
- [x] `npm run build` sukses.
- [x] `php artisan reminder:smart` sukses dijalankan manual.

## B. Public & Auth
- [x] Landing page di `/` tampil.
- [x] `/landing` redirect ke `welcome`.
- [x] Login/register tersedia dan tidak ada UI dobel layout.

## C. User Flow (Pencari Kerja)
- [x] User login diarahkan ke `dashboard.user`.
- [x] Profil menjadi pusat biodata (`/profile#biodata`).
- [x] Progress biodata (%) tampil dinamis.
- [x] Mini preview kartu digital tampil locked/unlocked berdasarkan verifikasi.
- [x] User dapat ajukan validasi admin.
- [x] User non-verified tidak bisa preview/cetak kartu.
- [x] User verified bisa preview/cetak kartu.

## D. Admin Flow
- [x] Admin login diarahkan ke `/admin/dashboard`.
- [x] Verifikasi pending tampil dan approve/reject berfungsi.
- [x] Notifikasi status verifikasi dikirim ke user.
- [x] Halaman laporan admin menampilkan filter:
  - [x] tanggal
  - [x] status pekerjaan
  - [x] kecamatan
  - [x] desa/kelurahan
- [x] Export laporan CSV aktif.
- [x] Export laporan PDF aktif.
- [x] Dashboard admin memiliki ringkasan wilayah:
  - [x] wilayah prioritas intervensi
  - [x] top rasio sudah bekerja

## E. Atasan Flow
- [x] Atasan login diarahkan ke `/atasan/dashboard`.
- [x] Atasan dapat akses `/atasan/rekap-admin`.
- [x] Endpoint operasional admin tidak masuk menu atasan.

## F. Data Demo & Production Safety
- [x] `DatabaseSeeder` hanya seed data inti.
- [x] Seed dummy massal dipisah ke `DemoDataSeeder`.
- [x] `SEED_DEMO_DATA` didukung untuk mode demo.
- [x] Master wilayah Pandeglang tersedia di `database/data/pandeglang_wilayah.json`.

## Catatan
- View legacy `resources/views/petugas/*` masih ada di codebase sebagai arsip, tetapi tidak lagi dipakai route canonical.
