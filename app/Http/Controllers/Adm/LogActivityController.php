<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;


class LogActivityController extends Controller
{
    use CompanySessionTraits;

    /**
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * LogActivityController constructor.
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request)
    {
        //$activity=Activity::all()->last();
        //$activity->all()->last();
        //Cache::remember('activity',now()->addDay());
        $month = Carbon::now()->month;
        $activity = Activity::whereMonth('created_at', '=', $month);

        if (session()->has('company.name')) {
            $activity = Activity::whereMonth('created_at', '=', $month)
                ->where('log_name', $this->getCompanyName());
        }

        if ($request->ajax()) {
            return Datatables::of($activity)
                ->addColumn('employee', function (Activity $activity) {
                    return \App\Models\User::find($activity->causer_id)->name ?? null;
                })
                ->addColumn('type', function (Activity $activity) {
                    return __('view.' . explode("\\", $activity->subject_type)[2]) . '::' . __('view.' . $activity->description);
                })
                ->addColumn('altered', function (Activity $activity) {
                    $a = $b = $c = $d = $e = $f = $g = '';
                    $a = ($activity->properties->has('old')) ? json_encode(collect($activity->properties['attributes'])->diffAssoc($activity->properties['old'])) : '';
                    if ($activity->properties->has('old')) {
                        $b = '<ul><span> Antigo</span>';
                        $c = '';
                        foreach ($activity->properties['old'] as $attribute => $value) {
                            $c .= (string)'<li>' . $attribute . ':' . $value . '</li>';
                        }

                        $d = '</ul>';
                    }
                    if ($activity->properties->has('attributes')) {
                        $e = '<ul><span>Novo</span >';
                        $f = '';
                        foreach ($activity->properties['attributes'] as $attribute => $value) {
                            $f .= (string)'<li>' . $attribute . ':' . $value . '</li >';
                        }
                        $g = '</ul >';
                    }
                    return $a . $b . $c . $d . $e . $f . $g;
                })
                ->rawColumns(['employee', 'type', 'altered'])
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Data'])
            ->addColumn(['data' => 'employee', 'name' => 'employee', 'title' => 'Funcionário'])
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => 'Tipo'])
            ->addColumn(['data' => 'altered', 'name' => 'altered', 'title' => 'Dados Alterados'])
            ->responsive(true)
            ->serverSide(true)
            ->minifiedAjax();


        return view('admin.log.datatable', compact('html', 'request'));
    }
}
