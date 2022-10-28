<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        abort_if(!Auth::user()->hasPermissionTo('use_dash'), 401,__('error.Unauthorized'));
        return view('layouts.app');
    }
}
