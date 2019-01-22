<?php

namespace App\Console;

use App\Console\Commands\MailReporter;
use App\Console\Commands\UpdateAhrefs;
use App\Console\Commands\UpdateMetrics;
use App\Console\Commands\UpdateDomains;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        UpdateDomains::class,
        MailReporter::class,
        UpdateMetrics::class,
        UpdateAhrefs::class
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('mail:report')
        //         ->dailyAt('23:55');

        $schedule->command('update:metrics')
                 ->everyThirtyMinutes();
        $schedule->command('update:ahrefs')
                 ->everyThirtyMinutes();
    }
}
