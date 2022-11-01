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
        abort_if((bool)$this->hasBanned(), 403, __('error.Unauthorized'));
        return $next($request);
    }


}
