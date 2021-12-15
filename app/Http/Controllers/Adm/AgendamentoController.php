<?php

namespace App\Http\Controllers\Adm;

//use Acaronlex\LaravelCalendar\Calendar;
use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\MassDestroyCalendarRequest;
use App\Http\Requests\Calendar\StoreCalendarRequest;
use App\Http\Requests\Calendar\UpdateCalendarRequest;
use App\Models\Calendar as Model;
use App\Traits\CompanySessionTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

/**
 * Class AgendamentoController
 * @package App\Http\Controllers\Adm
 */
class AgendamentoController extends Controller
{
    use CompanySessionTraits;

    /**
     * @var \string[][]
     */
    public $sources = [
        [
            'model' => '\\App\\Models\\Calendar',
            'date_field' => 'start_time',
            'end_field' => 'end_time',
            'field' => 'name',
            'prefix' => '',
            'suffix' => '',
            'route' => 'admin.calendar.show',
        ],
    ];
    /**
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * AgendamentoController constructor.
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
        // abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($this->hasRole('admin')) {
            $events = Model::withCount('calendars');
        } else {
            $events = Model::withCount('calendars')->whereCompanyId($this->getCompanyId());
        }


        if ($request->has('month')) {
            //Busca agendamentos por data
            $events->whereMonth('created_at', '=', $request->month);
        }


        if (config('panel.datatable')) {
            return $this->datatable($request, $events);
        } else {
            $events = $events->get();
            return view('admin.calendar.index', compact('events'));
        }
    }

    /**
     * @param $request
     * @param $events
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function datatable($request, $events)
    {
        if ($request->ajax()) {
            return Datatables::of($events)
                ->addColumn('action', function (Model $events) {
                    return '<div class="table-data-feature"><a href="' . route('admin.calendar.show', $events->id) . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Ver"><i class="fa fa-eye"></i></a>|<a href="' . route('admin.calendar.edit', $events->id) . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a></div>';
                })
                ->addColumn('recurrence', function (Model $events) {
                    return \App\Models\Calendar::RECURRENCE_RADIO[$events->recurrence] ?? '';
                })
                ->addColumn('start_time', function (Model $events) {
                    return Carbon::parse($events->start_time)->format('Y-m-d H:i:s');
                })
                ->addColumn('end_time', function (Model $events) {
                    return Carbon::parse($events->end_time)->format('Y-m-d H:i:s');
                })
                ->addColumn('lawyer', function (Model $events) {
                    return $events->lawyer()->first()->name ?? '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $html = $this->htmlBuilder
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'ID'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Nome'])
            ->addColumn(['data' => 'start_time', 'name' => 'start_time', 'title' => 'Hora de início'])
            ->addColumn(['data' => 'end_time', 'name' => 'end_time', 'title' => 'Hora de Fim'])
            ->addColumn(['data' => 'recurrence', 'name' => 'recurrence', 'title' => 'Recorrência'])
            ->addColumn(['data' => 'lawyer', 'name' => 'lawyer', 'title' => 'Advogado'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true)
            ->serverSide(true)
            ->minifiedAjax();
        return view('admin.calendar.datatable', compact('html'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function indexShow()
    {
        $events = [];

        foreach ($this->sources as $source) {
            if ($this->hasRole('admin')) {
                $src = $source['model']::all();
            } else {
                $src = $source['model']::where('company_id', '=', $this->getCompanyId());
            }
            foreach ($src as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                //$crudFieldValue = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->getOriginal($source['date_field']))->format('Y-m-d H:i:s');
                //$crudFieldValue=Carbon::parse($model->getOriginal($source['date_field']))->toDateTimeString();

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue->format('Y-m-d H:i:s'),
                    //'end' => $model->{$source['end_field']},
                    'end' => $model->{$source['end_field']}->format('Y-m-d H:i:s'),
                    'description' => $model->description ?? '',
                    'url' => route($source['route'], $model->id),
                ];
            }
        }


        return view('admin.calendar.index-show', compact('events'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function indexSimple()
    {


        $events = [];
        $data = Model::all();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date . ' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'url' => 'pass here url and any route',
                        'description' => $value->description,
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events)
            ->setOptions([
                'locale' => 'pt',
                'firstDay' => 0,
                'displayEventTime' => true,
                'selectable' => true,
                'initialView' => 'timeGridWeek',
                'headerToolbar' => [
                    'end' => 'today prev,next dayGridMonth timeGridWeek timeGridDay'
                ]
            ]);
        $calendar->setCallbacks([
            'select' => 'function(selectionInfo){}',
            'eventClick' => 'function(event){}'
        ]);

        return view('admin.calendar.index-simple', compact('calendar'));

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        //abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.calendar.create');
    }

    /**
     * @param StoreCalendarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function store(StoreCalendarRequest $request)
    {

        $data = $request->all();
        $data['start_time'] = Carbon::parse($request->start_time);
        $data['end_time'] = Carbon::parse($request->end_time);
        $data['company_id'] = $this->getCompanyId();

        if (Model::create($data)) {
            toastr()->success('Salvo com sucesso.');
        }

        return redirect()->route('admin.calendar.systemCalendar');
    }

    /**
     * @param Model $schedule
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Model $schedule)
    {
        // abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event = $schedule;
        $event->load('calendar')->loadCount('calendars');


        return view('admin.calendar.edit', compact('event'));
    }

    /**
     * @param UpdateCalendarRequest $request
     * @param Model $event
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(UpdateCalendarRequest $request, Model $event)
    {
        $data = $request->all();
        $data['start_time'] = Carbon::parse($request->start_time);
        $data['end_time'] = Carbon::parse($request->end_time);
        $data['company_id'] = $this->getCompanyId();
        if ($event->update($data)) {
            toastr()->success('Salvo com sucesso.');
        }

        return redirect()->route('admin.calendar.systemCalendar');
    }

    /**
     * @param Model $schedule
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Model $schedule)
    {
        //       abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = $schedule;
        $event->load('calendar')->loadCount('calendars');


        return view('admin.calendar.show', compact('event'));
    }

    /**
     * @param Model $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Model $schedule)
    {
        // abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = $schedule;
        if ($event->delete()) {
            toastr()->success('Removido com sucesso.');
        }

        return back();
    }

    /**
     * @param MassDestroyCalendarRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyCalendarRequest $request)
    {
        if (Model::whereIn('id', request('ids'))->delete()) {
            toastr()->success('Removido com sucesso.');
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
