<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ActivityControlController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        if ($request->has('weekend')) {
            if ($request->weekend == config('core.Weekend')) {
                Cache::rememberForever('core.Weekend', function () use ($request) {
                    return $request->weekend;
                });
            } else {
                Cache::rememberForever('core.Weekend', function () use ($request) {
                    return $request->weekend;
                });
            }
            toastr()->success('Dado atualizado com sucesso');
        }
        /*
         *  Afere se dados foram enviados.
         *  Se diferem ou são iguais ao padrão.
         */
        if ($request->has('opening') && $request->has('closing')) {
            if ($request->opening == config('core.opening') || $request->closing == config('core.closing')) {
                Cache::rememberForever('core.Opening', function () use ($request) {
                    return [$request->opening, $request->closing];
                });
            } else {
                Cache::rememberForever('core.Opening', function () use ($request) {
                    return [$request->opening, $request->closing];
                });
            }
            toastr()->success('Dado atualizado com sucesso');
        }
        return redirect()->route('admin.ActivityControl');
    }
}
