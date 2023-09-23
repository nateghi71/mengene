<?php

namespace App\Console;

use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
//    protected $commands = [
//        Commands\DemoCron::class,
//    ];

    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('demo:cron')->everyMinute();

        $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $customers = Customer::where('expiry_date', '<', Carbon::now())->get();
            foreach ($customers as $customer) {
                $customer->status = 0;
//                dd($pro);
                $customer->update();
            }
            $landowners = Landowner::where('expiry_date', '<', Carbon::now())->get();
            foreach ($landowners as $landowner) {
                $landowner->status = 0;
                $landowner->update();
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
