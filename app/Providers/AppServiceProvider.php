<?php

namespace App\Providers;


use App\Models\Calendar;
use App\Observers\CalendarRecurrenceObserver;
use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
use RichardStyles\EloquentEncryption\Casts\Encrypted;
use RichardStyles\EloquentEncryption\EloquentEncryption;

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
        //require_once base_path('resources/macros/form.php');

        parent::register();


        /* Erro ao testar em produção
        if (!$this->app->environment('production')) {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(ClockworkServiceProvider::class);
        }*/


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //include_once base_path('resources/macros/form.php');


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

        Blade::component('form-input', \App\View\Components\Form\Input::class);
        Blade::component('form-select', \App\View\Components\Form\Select::class);
        Blade::component('form-textarea', \App\View\Components\Form\TextArea::class);
        Blade::component('form-tinymce', \App\View\Components\Form\Tinymce::class);
        Blade::component('form-file', \App\View\Components\Form\File::class);
        Blade::component('form-date', \App\View\Components\Form\Date::class);
        Blade::component('bootstrap-modal', \App\View\Components\Bootstrap\Modal::class);

        Calendar::observe(CalendarRecurrenceObserver::class);


    }
}
