@echo off
setlocal

cd /d "%~dp0\..\.."

echo ===============================================
echo   e-Kaku V3 - Cek Cepat Presentasi
echo ===============================================

call php artisan route:list >nul
if errorlevel 1 goto :fail
echo [OK] route:list

call php artisan test >nul
if errorlevel 1 goto :fail
echo [OK] test

call npm run build >nul
if errorlevel 1 goto :fail
echo [OK] build

call php artisan reminder:smart >nul
if errorlevel 1 goto :fail
echo [OK] reminder:smart

echo.
echo Semua cek cepat lulus.
exit /b 0

:fail
echo.
echo Cek cepat gagal. Lihat error command terakhir.
exit /b 1
