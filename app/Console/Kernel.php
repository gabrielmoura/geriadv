<?php

namespace App\Console;

use App\Jobs\Client\BirthdayCustomerJob;
use App\Models\User;
use App\Notifications\User\PrivateMessageNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;

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
        //$schedule->command('queue:restart')->hourly();
        $schedule->command('queue:work --sleep=3 --timeout=900 --queue=high,default,low')->runInBackground()->withoutOverlapping()->everyMinute();


        $schedule->command('backup:run --only-db')->daily()->at('18:00')
            ->onFailure(function ($e) {
                Notification::sendNow(
                    User::find(1),
                    new PrivateMessageNotification('Backup Error', $e ?? null, '', ['name' => 'System DB'])
                );
            })
            ->onSuccess(function () {
                Notification::sendNow(
                    User::find(1),
                    new PrivateMessageNotification('Backup Success', $e ?? null, '', ['name' => 'System DB'])
                );
            });
        $schedule->job(new BirthdayCustomerJob())->dailyAt('19:00');

        $schedule->command('activitylog:clean')->sundays();

        // Executa ForgetSoftDeletes aos fins de semanas.
        //$schedule->command('x32:forgetDeletes')->weekends();

        // $schedule->command('inspire')->hourly();

        // Limpeda de SoftDeletes que usam o método prunable
        $schedule->command('db:prune')->daily();

        $schedule->command('queue:prune-batches')->daily();

        $schedule->command('horizon:snapshot')->everyMinute();
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
