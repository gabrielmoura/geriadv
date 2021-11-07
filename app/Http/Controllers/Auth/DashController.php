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


        $userAuth = Auth::user();
        //Caso não hája company_id na sessão escreva (opcional)
        if (!session()->has('company_id') && !$userAuth->hasRole('admin')) session(['company_id' => $userAuth->employee()->first()->company()->first()->id]);

        if ($userAuth->hasRole(['admin'])) {

            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.index');
        }
    }
}
