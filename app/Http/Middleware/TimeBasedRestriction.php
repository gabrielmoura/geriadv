<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Traits\CompanySessionTraits;
use App\Events\Employee\AccessWrongTimeEvent;

class TimeBasedRestriction
{
    use CompanySessionTraits;
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->blockFDS() && $this->blockTimeBased()) {
            // Dispara evento quando usuário acessar fora do horário permitido.
            AccessWrongTimeEvent::dispatch(collect([$request,$this->getCompanyId(),Auth::user()->id]));
            // Retorna Erro 403.
            return abort(403, __('view.hour.outside'));
        }
        return $next($request);
    }

}
