<?php

namespace App\Console;

use App\HelperClasses\CheckPremiumExpireDate;
use App\HelperClasses\UpdateStatusFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            UpdateStatusFile::updateStatusCustomers();
            UpdateStatusFile::updateStatusLandowner();
            CheckPremiumExpireDate::checkExpireDate();
        })->dailyAt('7:00');

        $schedule->command('queue:work --stop-when-empty --tries=3')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
