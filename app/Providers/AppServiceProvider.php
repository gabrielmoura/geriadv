<?php

namespace App\Providers;

use App\Models\Clients;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use RichardStyles\EloquentEncryption\EloquentEncryption;
use RichardStyles\EloquentEncryption\Casts\Encrypted;
use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Clients::encryptUsing(new EloquentEncryption); //Não funciona com o PostgreSQL
        if ($this->app->environment('local')) {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(ClockworkServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        require_once base_path('resources/macros/form.php');

        Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    }
}
