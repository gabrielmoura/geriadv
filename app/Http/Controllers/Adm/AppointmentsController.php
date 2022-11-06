<?php

namespace App\Http\Controllers\Adm;

use App\DataTables\AppointmentDataTable;
use Dhonions\LaravelCalendar\Facades\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\MassDestroyCalendarRequest;
use App\Http\Requests\Calendar\StoreCalendarRequest;
use App\Http\Requests\Calendar\UpdateCalendarRequest;
use App\Models\Calendar as Model;
use App\Models\Lawyer;
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
class AppointmentsController extends Controller
{
    use CompanySessionTraits;


    /**
     * @var string
     */
    public $formatDate = 'd/m/Y';
    /**
     * @var string
     */
    public $formatDateTime = 'd/m/Y H:i:s';
    public $cFormatDateTime = 'Y-m-d H:i:s';
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
     * @param AppointmentDataTable $dataTable
     * @param Request $request
     * @return mixed
     */
    public function index(AppointmentDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.calendar.datatable', compact('request'));
    }

    /**
     * Exibe Calendário
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
                $src = $source['model']::with('lawyer')->whereCompanyId($this->getCompanyId())->get();
            }
            foreach ($src as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                //$crudFieldValue = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->getOriginal($source['date_field']))->format('Y-m-d H:i:s');
                //$crudFieldValue=Carbon::parse($model->getOriginal($source['date_field']))->toDateTimeString();

                if (!$crudFieldValue) {
                    continue;
                }
                $lawyer = 'Advogado: <b>' . $model->lawyer->name . '</b><br/><br/>' ?? '';
                $description = $model->description ?? '';
                $end_time = ($model->{$source['end_field']} !== null) ? $model->{$source['end_field']}->format('c') : null;
                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue->format('c'),
                    //'end' => $model->{$source['end_field']},
                    'end' => $end_time,
                    'description' => $lawyer . $description ?? '',
                    'url' => route($source['route'], $model->pid) ?? '',
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


    public function create()
    {
        //abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $lawyer = [];
        $lawyer[] = ['value' => null, 'name' => 'Nenhum'];
        foreach (Lawyer::whereCompanyId($this->getCompanyId())->get() as $l) {
            $lawyer[] = ['value' => $l->id, 'name' => $l->name];
        }

        return view('admin.calendar.create', compact('lawyer'));
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
        $data['start_time'] = Carbon::createFromFormat($this->formatDateTime, $request->start_time);
        $data['end_time'] = ($request->end_time !== null) ? Carbon::createFromFormat($this->formatDateTime, $request->end_time) : null;
        $data['company_id'] = $this->getCompanyId();
        $data['lawyer_id'] = numberClear($request->lawyer_id);

        if (Model::create($data)) {
            toastr()->success('Salvo com sucesso.');
        }

        return redirect()->route('admin.calendar.systemCalendar');
    }

    /**
     * @param Model $schedule
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($schedule)
    {
        // abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $lawyer = [];
        $event = Model::wherePid($schedule)
            ->first()
            ->load('calendar')
            ->loadCount('calendars')
            ->first();


        return view('admin.calendar.edit', compact('event', 'lawyer'));
    }

    public function update(UpdateCalendarRequest $request, $event)
    {
        $data = $request->all();
        $data['start_time'] = Carbon::createFromFormat($this->formatDateTime, $request->start_time);;
        $data['end_time'] = ($request->end_time !== null) ? Carbon::createFromFormat($this->formatDateTime, $request->end_time) : null;
        $data['company_id'] = $this->getCompanyId();
        $data['lawyer_id'] = numberClear($request->lawyer_id);

        $event = Model::wherePid($event)
            ->first();
        if ($event->update($data)) {
            toastr()->success('Salvo com sucesso.');
        }

        return redirect()->route('admin.calendar.systemCalendar');
    }


    public function show($schedule)
    {
        //       abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Model::wherePid($schedule)
            ->first()
            ->load('calendar')
            ->loadCount('calendars')
            ->first();

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
