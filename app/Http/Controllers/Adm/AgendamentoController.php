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

    public function index()
    {
        // abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Model::withCount('events')
            ->get();

        return view('admin.calendar.index', compact('events'));
    }

    public function indexShow()
    {
        $events = [];

        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                //$crudFieldValue = $model->getOriginal($source['date_field']);
                $crudFieldValue = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->getOriginal($source['date_field']))->format('Y-m-d H:i:s');

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
        $data = \App\Models\Calendar::all();
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
        Model::create($request->all());

        return redirect()->route('admin.calendar.systemCalendar');
    }

    public function edit(Model $event)
    {
        // abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('event')
            ->loadCount('events');

        return view('admin.calendar.edit', compact('event'));
    }

    public function update(UpdateCalendarRequest $request, Event $event)
    {
        $event->update($request->all());

        return redirect()->route('admin.calendar.systemCalendar');
    }

    public function show(Model $event)
    {
        //       abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('event');

        return view('admin.calendar.show', compact('event'));
    }

    public function destroy(Model $event)
    {
        // abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyCalendarRequest $request)
    {
        Model::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
