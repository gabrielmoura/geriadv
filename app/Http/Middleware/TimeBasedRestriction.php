<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\CompanySessionTraits;

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
            return abort(403, __('view.hour.outside'));
        }
        return $next($request);
    }

}
