<?php

namespace App\Console;

use App\Jobs\ProcessSmsNotification;
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
        \App\Console\Commands\AutopublishBusinessVacancies::class,
        \App\Console\Commands\SendRootReport::class,
        \App\Console\Commands\SendBusinessReport::class,
        \App\Console\Commands\SyncICal::class,
        \App\Console\Commands\dbCheckPhonNum::class,
        \App\Console\Commands\Backup::class,
        \App\Console\Commands\storagePublicClear::class,
        \App\Console\Commands\SendSms::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('root:report')->dailyAt(config('root.report.time'));
        //$schedule->command('business:report')->dailyAt('21:00');
        //$schedule->command('business:vacancies')->weekly()->sundays()->at('00:00');
        // $schedule->command('ical:sync')->twiceDaily(0, 12);

        $schedule->command('backup')->dailyAt('23:00');
        $schedule->command('storage:public_clear')->hourly();
        $schedule->job(new ProcessSmsNotification())->dailyAt('9:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
