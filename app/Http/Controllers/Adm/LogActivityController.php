<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index(Activity $activities, Request $request)
    {
        //$activity=Activity::all()->last();
        //$activity->all()->last();
        return view('admin.log.index', compact('activities', 'request'));
    }
}
