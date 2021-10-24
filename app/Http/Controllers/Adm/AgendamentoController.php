<?php

namespace App\Http\Controllers\Adm;

//use Acaronlex\LaravelCalendar\Calendar;
use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\MassDestroyCalendarRequest;
use App\Http\Requests\Calendar\StoreCalendarRequest;
use App\Http\Requests\Calendar\UpdateCalendarRequest;
use App\Models\Calendar as Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgendamentoController extends Controller
{
    public $sources = [
        [
            'model' => '\\App\\Models\\Calendar',
            'date_field' => 'start_time',
            'end_field' => 'end_time',
            'field' => 'name',
            'prefix' => '',
            'suffix' => '',
            'route' => 'admin.calendar.edit',
        ],
    ];

    public function index(Request $request)
    {
        // abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Model::withCount('calendars')->where('company_id', '=', session()->get('company_id'));

        if ($request->has('month')) {
            //Busca agendamentos por data
            $events->whereMonth('created_at', '=', $request->month);
        }
        $events->get();

        return view('admin.calendar.index', compact('events'));
    }

    public function indexShow()
    {
        $events = [];

        foreach ($this->sources as $source) {
            foreach ($source['model']::where('company_id', '=', session()->get('company_id')) as $model) {
                //$crudFieldValue = $model->getOriginal($source['date_field']);
                $crudFieldValue = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->getOriginal($source['date_field']))->format('Y-m-d H:i:s');
                //$crudFieldValue=Carbon::parse($model->getOriginal($source['date_field']))->toDateTimeString();

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    //'end' => $model->{$source['end_field']},
                    'end' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->{$source['end_field']})->format('Y-m-d H:i:s'),
                    'description' => $model->description ?? '',
                    'url' => route($source['route'], $model->id),
                ];
            }
        }

        return view('admin.calendar.index-show', compact('events'));
    }

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

        return view('admin.calendar.create');
    }

    public function store(StoreCalendarRequest $request)
    {
        $format = (string)config('panel.date_format') . ' ' . config('panel.time_format');
        $data = $request->all();
        $data['start_time'] = Carbon::createFromFormat($format, $request->start_time);
        $data['end_time'] = Carbon::createFromFormat($format, $request->end_time);
        $data['company_id'] = session()->get('company_id');
        Model::create($data);

        return redirect()->route('admin.calendar.systemCalendar');
    }

    public function edit(Model $schedule)
    {
        // abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event = $schedule;
        $event->load('calendar')->loadCount('calendars');


        return view('admin.calendar.edit', compact('event'));
    }

    public function update(UpdateCalendarRequest $request, Model $event)
    {
        $format = (string)config('panel.date_format') . ' ' . config('panel.time_format');
        $data = $request->all();
        $data['start_time'] = Carbon::createFromFormat($format, $request->start_time);
        $data['end_time'] = Carbon::createFromFormat($format, $request->end_time);
        $data['company_id'] = session()->get('company_id');
        $event->update($data);

        return redirect()->route('admin.calendar.systemCalendar');
    }

    public function show(Model $schedule)
    {
        //       abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = $schedule;
        $event->load('calendar')->loadCount('calendars');


        return view('admin.calendar.show', compact('event'));
    }

    public function destroy(Model $schedule)
    {
        // abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = $schedule;
        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyCalendarRequest $request)
    {
        Model::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
