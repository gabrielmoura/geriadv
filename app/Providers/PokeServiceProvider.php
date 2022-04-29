<?php

namespace App\Providers;

use App\Http\Middleware\PokeMiddleware;
use App\View\Components\Poke;
use Illuminate\Support\ServiceProvider;


use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;


class PokeServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public const CONFIG = __DIR__ . '/../../config/poke.php';
    /**
     *
     */
    public const VIEWS = __DIR__ . '/../resources/views/layouts';


    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(static::CONFIG, 'poke');

        $this->app->singleton(
            PokeMiddleware::class,
            static function (Application $app): PokeMiddleware {
                return new PokeMiddleware($app->make('config')->get('poke.mode'));
            }
        );
    }


    /**
     * @param Router $router
     * @param Repository $config
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(Router $router, Repository $config): void
    {
        $this->loadViewsFrom(static::VIEWS, 'poke');
        $this->loadViewComponentsAs('poke', [Poke::class]);
//        $this->loadRoutesFrom(__DIR__.'/../routes/poke.php');

        $router->aliasMiddleware('poke', PokeMiddleware::class);

        // If Larapoke is set to auto, push it as global middleware.
        if ($config->get('poke.mode') === 'auto') {
            $this->app->make(Kernel::class)->appendMiddlewareToGroup('web', PokeMiddleware::class);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([static::CONFIG => $this->app->configPath('poke.php')], 'config');
            $this->publishes([static::VIEWS => $this->app->viewPath('poke')], 'views');
        }
    }
}
