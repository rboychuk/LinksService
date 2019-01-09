<?php

namespace App\Console;

use App\Console\Commands\MailReporter;
use App\Console\Commands\UpdateAhrefsAndMetrics;
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
        UpdateAhrefsAndMetrics::class
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
    }
}
