<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\SmsContrller;

class Kernel extends ConsoleKernel
{
    /**
     * We need to replace the ConfigureLogging bootstrappers to use the custom
     * one. We’ll do this by overriding their respective constructors and
     * doing an array_walk to the bootstrappers property.
     *
     * @param Application $app
     * @param Router      $router
     */
    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);

        array_walk($this->bootstrappers, function (&$bootstrapper) {
            if ($bootstrapper === \Illuminate\Foundation\Bootstrap\ConfigureLogging::class) {
                $bootstrapper = \App\Bootstrap\ConfigureLogging::class;
            }
        });
    }

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

        $schedule->command('backup')->dailyAt('23:00');
        
        $schedule->command('ical:sync')->twiceDaily(0, 12);

        $schedule->command('storage:public_clear')->hourly();
        
        $schedule->call(function () {
            //$job = SmsContrller::getNow();
            //$job = SmsContrller::getTomorrow();
            //$job = SmsContrller::getSixMonth();
        })->everyMinute();

        $schedule->call(function () {
            
            $job[0] = SmsContrller::getTomorrow();
            $job[1] = SmsContrller::getSixMonth();

        })->dailyAt('9:00'); 
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
