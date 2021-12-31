<?php

namespace App\Http\Middleware;

use App\Traits\CompanySessionTraits;
use Closure;
use Illuminate\Http\Request;

class VerifyBanned
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
        if ((bool)$this->hasBanned()) return abort(403, 'Banido');
        return $next($request);
    }


}
