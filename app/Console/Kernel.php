<?php

namespace App\Console;

use App\Console\Commands\CheckExpensiveLinks;
use App\Console\Commands\MailReporter;
use App\Console\Commands\UpdateAhrefs;
use App\Console\Commands\UpdateMetrics;
use App\Console\Commands\UpdateDomains;
use App\Console\Commands\UpdateUniqueDomains;
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
        UpdateAhrefs::class,
        UpdateUniqueDomains::class,
        CheckExpensiveLinks::class
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

        $schedule->command('update:domains')
                 ->everyTenMinutes();

        $schedule->command('check:expensive_links')
                 ->everyTenMinutes();
    }
}
