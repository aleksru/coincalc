<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DownloadDataWhatToMine;
use App\Jobs\DownloadDataBittrex;
use App\Jobs\DownloadDataCriptopia;
use App\Jobs\DownloadDataHitbtc;
use App\Jobs\DownloadDataYobit;
use App\Jobs\DownloadPriceBtcUsd;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //>after(function () {
           // Задача завершена...
        // });
        //          ->hourly();
        $schedule->job(new DownloadDataWhatToMine)->dailyAt('13:40')->withoutOverlapping();
        $schedule->job(new DownloadDataBittrex)->hourlyAt(40)->withoutOverlapping();
        $schedule->job(new DownloadDataCriptopia)->hourlyAt(40)->withoutOverlapping();
        $schedule->job(new DownloadDataHitbtc)->hourlyAt(40)->withoutOverlapping();
        $schedule->job(new DownloadDataYobit)->hourlyAt(40)->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
