<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Redireciona para o Painel correto
 * Class DashController
 * @package App\Http\Controllers\Auth
 */
class DashController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function __invoke()
    {
        // TODO: Implement __invoke() method.

        /*if (session()->has('cartID') && !\Cart::session(session()->get('cartID'))->isEmpty()) {
            return redirect()->route('checkout.index');
        }*/
        if (Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('employee.index');
        }
    }
}
