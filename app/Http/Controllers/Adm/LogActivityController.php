<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

//use Spatie\Activitylog\Contracts\Activity;

class LogActivityController extends Controller
{
    public function index(Activity $activities, Request $request)
    {
        //$activity=Activity::all()->last();
        //$activity->all()->last();
        //Cache::remember('activity',now()->addDay());
        return view('admin.log.index', compact('activities', 'request'));
    }
}
