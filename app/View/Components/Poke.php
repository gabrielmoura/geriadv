<?php

namespace App\View\Components;

use Illuminate\View\Component;
use function config;
use Illuminate\Contracts\View\View;
use function url;
use function view;

class Poke extends Component
{
    /**
     * @param bool $force
     */
    public function __construct(protected bool $force = false)
    {
        //
    }

    /**
     * @return View|string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function render(): View|string
    {
        $config = config()->get([
            'session.lifetime',
            'poke.mode',
            'poke.poking.route',
            'poke.times',
        ]);

        if ($config['poke.mode'] !== 'blade' && !$this->force) {
            return '';
        }

        $session = $config['session.lifetime'] * 60 * 1000;

        return view('layouts.poke', [
            'route' => url($config['poke.poking.route']),
            'interval' => (int)($session / $config['poke.times']),
            'lifetime' => $session,
        ]);
    }
}
