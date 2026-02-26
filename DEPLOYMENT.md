# Deployment Checklist e-Kaku V3

## 1) Persiapan Environment
- PHP 8.2+ dengan extension: `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `fileinfo`, `gd`, `zip`.
- Node.js 20+.
- MySQL/MariaDB.
- Web server: Nginx/Apache.

## 2) Install Dependency
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

## 3) Konfigurasi `.env`
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Set `APP_URL` sesuai domain.
- Set koneksi DB (`DB_*`).
- Set `MAIL_*` untuk notifikasi email reminder.
- Gunakan driver queue non-sync (contoh: `QUEUE_CONNECTION=database`).

## 4) Setup Aplikasi
```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5) Worker Queue & Scheduler
- Jalankan worker queue sebagai service supervisor/systemd:
```bash
php artisan queue:work --tries=3 --timeout=120
```
- Tambahkan cron scheduler Laravel:
```cron
* * * * * cd /path/to/ekaku-v3 && php artisan schedule:run >> /dev/null 2>&1
```

`reminder:smart` sudah terjadwal harian pukul `08:00`.

## 6) Smoke Test Setelah Deploy
- Login `user/admin/atasan` berhasil.
- Dashboard admin memuat statistik dan tabel.
- Filter laporan (tanggal/status/kecamatan/kelurahan) berfungsi.
- Export laporan PDF/CSV berhasil diunduh.
- Alur verifikasi: user submit biodata -> admin verify -> user bisa cetak kartu.
- Jalankan:
```bash
php artisan test
```

## 7) Catatan Operasional
- Master wilayah Pandeglang ada di `database/data/pandeglang_wilayah.json`.
- `DatabaseSeeder` hanya seed akun inti (`user/admin/atasan`) + biodata dasar.
- Seed data demo massal terpisah di `DemoDataSeeder`:
```bash
php artisan db:seed --class=DemoDataSeeder
```
- Alternatif otomatis saat `db:seed`: set `.env` -> `SEED_DEMO_DATA=true`.
