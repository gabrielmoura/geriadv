<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TimeBasedRestriction
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->populateCache();
        if ($this->fimDeSemana() && $this->horaFuncionamento()) {
            return abort(403, __('view.hour.outside'));
        }
        return $next($request);
    }

    /**
     * Retorna True se estiver fora do horário de funcionamento
     * @return bool
     */
    private function horaFuncionamento()
    {
        return !now()->isBetween(Cache::get('core:Opening')[0], Cache::get('core:Opening')[1]);
    }

    /**
     * Retorna True se fim de semana não habilitado.
     * @return bool
     */
    private function fimDeSemana()
    {

        $weekend = now()->isWeekend();
        if (Cache::get('core:Weekend', false)) {
            return !$weekend;
        } else {
            return $weekend;
        }
    }

    /**
     * Atualiza valores em cache, caso não haja
     */
    private function populateCache()
    {
        if (!Cache::has('core:Weekend')) {
            Cache::rememberForever('core:Weekend', function () {
                return config('core.Weekend', false);
            });
        }
        if (!Cache::has('core:Opening')) {
            Cache::rememberForever('core:Opening', function () {
                return [config('core.Opening', '07:00:00'), config('core.Closing', '18:00:00')];
            });
        }
    }
}
