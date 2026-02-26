# Demo Script Presentasi Disnaker - e-Kaku V3

## Persiapan 5 Menit Sebelum Demo
1. Jalankan:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan db:seed --class=DemoDataSeeder
npm run build
```
2. Pastikan akun:
- User: `user@ekaku.test` / `password`
- Admin: `admin@ekaku.test` / `password`
- Atasan: `atasan@ekaku.test` / `password`

## Alur Demo (Rekomendasi 15-20 Menit)

### 1) Pembukaan (Landing)
1. Buka `/`.
2. Jelaskan ini sistem digital AK-1 untuk Pandeglang.
3. Tunjukkan tombol daftar/masuk.

### 2) Skenario User (Pencari Kerja)
1. Login sebagai user.
2. Buka `Profil`.
3. Tunjukkan:
- form biodata inline,
- progress biodata,
- mini kartu digital (locked jika belum verified).
4. Isi/ubah biodata lalu klik `Ajukan Validasi Admin`.
5. Tunjukkan user belum bisa cetak kartu jika status belum verified.

### 3) Skenario Admin (Validator)
1. Logout, login sebagai admin.
2. Buka `Verifikasi`.
3. Buka detail user pending, lakukan `Approve`.
4. Jelaskan notifikasi status otomatis ke user.
5. Buka `Dashboard Admin`:
- statistik operasional,
- wilayah prioritas intervensi,
- top rasio sudah bekerja.
6. Buka `Laporan`:
- filter tanggal/status/kecamatan/desa-kelurahan,
- export CSV dan PDF.

### 4) Kembali ke User (Cetak Kartu)
1. Logout admin, login user yang tadi diverifikasi.
2. Buka `Kartu Digital`.
3. Tunjukkan preview dan download PDF berhasil.

### 5) Skenario Atasan (Monitoring)
1. Logout user, login atasan.
2. Buka `Dashboard Atasan` dan `Rekap Admin`.
3. Jelaskan atasan fokus monitoring/evaluasi, bukan validasi operasional.

## Poin Teknis yang Perlu Disampaikan
- Reminder pintar berjalan via scheduler harian.
- Data wilayah Pandeglang sudah disiapkan untuk analitik per daerah.
- Alur verifikasi menutup celah cetak kartu sebelum validasi.

## Cadangan Saat Tanya Jawab
- Jika ditanya data besar: tunjukkan halaman admin pengguna/laporan dengan data hasil `DemoDataSeeder`.
- Jika ditanya ekspor: langsung unduh CSV/PDF dari halaman laporan.
