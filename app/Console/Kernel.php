<?php

namespace App\Console;

use App\Jobs\Client\BirthdayCustomerJob;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('queue:restart')->hourly();
        //       $schedule->command('queue:work --sleep=3 --timeout=900 --queue=high,default,low')->runInBackground()->withoutOverlapping()->everyMinute();


        $schedule->command('backup:run --only-db')->daily()->at('18:00')
            ->onFailure(function () {

            })
            ->onSuccess(function () {
            });
        $schedule->job(new BirthdayCustomerJob())->dailyAt('19:00');

        $schedule->command('activitylog:clean')->sundays();

        // $schedule->command('inspire')->hourly();
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
