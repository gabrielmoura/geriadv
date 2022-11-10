<?php

namespace App\Providers;


use App\Actions\Payment\{Payment, PaymentFacade, PaymentInterface};
use Illuminate\Support\Facades\DB;
use App\Models\Calendar;
use App\Observers\CalendarRecurrenceObserver;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;

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
        if (config('panel.forceHttps')) {
            $this->app['request']->server->set('HTTPS', true);
        }

//        $this->app->bind(PaymentInterface::class, function ($app) {
//            return new Payment($app);
//        });
//        $this->app->alias('Payment', PaymentFacade::class);
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class,);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->forceHttps();
        //include_once base_path('resources/macros/form.php');

        Queue::failing(function (JobFailed $event) {
            Log::error('Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
        });
        Queue::before(function (JobProcessing $event) {
            Log::debug('Job ready: ' . $event->job->resolveName());
            Log::debug('Job startet: ' . $event->job->resolveName());
        });

        Queue::after(function (JobProcessed $event) {
            Log::debug('Job done: ' . $event->job->resolveName());
        });

        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });

//        Blade::component('form-input', \App\View\Components\Form\Input::class);
//        Blade::component('form-select', \App\View\Components\Form\Select::class);
////        Blade::component('form-textarea', \App\View\Components\Form\TextArea::class);
//        Blade::component('form-tinymce', \App\View\Components\Form\Tinymce::class);
////        Blade::component('form-file', \App\View\Components\Form\File::class);
//        Blade::component('form-date', \App\View\Components\Form\Date::class);
////        Blade::component('bootstrap-modal', \App\View\Components\Bootstrap\Modal::class);

        Calendar::observe(CalendarRecurrenceObserver::class);

    }

    private function forceHttps()
    {
        if (config('panel.forceHttps')) {

            if (parse_url(config('app.url'))['scheme'] == 'https') {
                \URL::forceScheme('https');
            }
        }
    }
}
