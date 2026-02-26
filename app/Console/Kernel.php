<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jadwalkan perintah reminder:smart setiap hari jam 08:00
        $schedule->command('reminder:smart')->dailyAt('08:00');

        // contoh lain: jalankan queue:work saat dev (opsional)
        // $schedule->command('queue:work --stop-when-empty')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Auto-load semua command di app/Console/Commands
        $this->load(__DIR__.'/Commands');

        // Include routes/console.php jika ada
        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
