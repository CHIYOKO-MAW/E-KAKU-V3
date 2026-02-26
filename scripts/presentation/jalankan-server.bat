@echo off
setlocal

cd /d "%~dp0\..\.."

echo Menjalankan server e-Kaku V3 di http://127.0.0.1:8000
echo Tekan CTRL+C untuk berhenti.
echo.
start "" http://127.0.0.1:8000
php artisan serve --host=127.0.0.1 --port=8000
