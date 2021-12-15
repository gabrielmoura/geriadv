<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\CompanySessionTraits;

/**
 * Redireciona para o Painel correto
 * Class DashController
 * @package App\Http\Controllers\Auth
 */
class DashController extends Controller
{
    use CompanySessionTraits;
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function __invoke()
    {
        // TODO: Implement __invoke() method.

        $this->populateSession()

        if ($this->hasRole('admin')) {

            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.index');
        }
    }
}
