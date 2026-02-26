@echo off
setlocal

cd /d "%~dp0\..\.."

echo.
echo ===============================================
echo   e-Kaku V3 - Setup Paket Presentasi Disnaker
echo ===============================================
echo.

where php >nul 2>nul
if errorlevel 1 (
  echo [ERROR] PHP tidak ditemukan di PATH.
  exit /b 1
)

where composer >nul 2>nul
if errorlevel 1 (
  echo [ERROR] Composer tidak ditemukan di PATH.
  exit /b 1
)

where npm >nul 2>nul
if errorlevel 1 (
  echo [ERROR] NPM tidak ditemukan di PATH.
  exit /b 1
)

echo [1/10] Composer install...
call composer install --no-interaction
if errorlevel 1 goto :fail

echo [2/10] NPM install...
call npm install
if errorlevel 1 goto :fail

echo [3/10] Generate app key jika belum ada...
call php artisan key:generate --force
if errorlevel 1 goto :fail

echo [4/10] Migrate fresh + seed inti...
call php artisan migrate:fresh --seed --force
if errorlevel 1 goto :fail

echo [5/10] Seed data demo massal...
call php artisan db:seed --class=DemoDataSeeder --force
if errorlevel 1 goto :fail

echo [6/10] Storage link...
call php artisan storage:link

echo [7/10] Build frontend asset...
call npm run build
if errorlevel 1 goto :fail

echo [8/10] Optimasi cache...
call php artisan optimize:clear
if errorlevel 1 goto :fail
call php artisan config:cache
if errorlevel 1 goto :fail
call php artisan route:cache
if errorlevel 1 goto :fail
call php artisan view:cache
if errorlevel 1 goto :fail

echo [9/10] Smoke test route...
call php artisan route:list >nul
if errorlevel 1 goto :fail

echo [10/10] Smoke test reminder...
call php artisan reminder:smart
if errorlevel 1 goto :fail

echo.
echo ===============================================
echo   SETUP PRESENTASI SELESAI
echo ===============================================
echo URL: http://127.0.0.1:8000
echo.
echo Akun Demo:
echo - User   : user@ekaku.test   / password
echo - Admin  : admin@ekaku.test  / password
echo - Atasan : atasan@ekaku.test / password
echo.
echo Jalankan server dengan:
echo   scripts\presentation\jalankan-server.bat
echo.
exit /b 0

:fail
echo.
echo [FAILED] Setup presentasi gagal. Cek log error di atas.
exit /b 1
