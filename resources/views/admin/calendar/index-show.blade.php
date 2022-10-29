@extends('layouts.default')
@section('title', 'Agendamento')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.calendar.create") }}">
                {{ __('global.add') }} {{ __('cruds.event.title_singular') }}
            </a>
        </div>
    </div>

    <h3 class="page-title">{{ __('global.systemCalendar') }}</h3>
    <div class="card">
        <div class="card-header">
            {{ __('global.systemCalendar') }}
        </div>

        <div class="card-body">
            <link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.css' rel='stylesheet'/>
            <link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.print.css' rel='stylesheet'
                  media='print'/>

            <div id='calendar'></div>
        </div>
    </div>
@endsection
@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/moment@2/min/moment.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale-all.min.js'></script>



    {{--    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>--}}
    <script>
        $(document).ready(function () {

            // page is now ready, initialize the calendar...
            events = {!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events: events,
                eventRender: function (eventObj, $el) {

                    $el.popover({
                        title: eventObj.title,
                        content: eventObj.description,
                        trigger: 'hover',
                        placement: 'top',
                        html: true,
                        container: 'body'
                    });
                },
                timeZone: 'UTC',
                header: {
                    left: 'prev,next today ',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                locale: 'pt-br',
                businessHours: {
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    dow: [1, 2, 3, 4, 5], // Monday - Thursday

                    start: '{{config('core.Opening')}}', // a start time (10am in this example)
                    end: '{{config('core.Closing')}}', // an end time (6pm in this example)
                }
            });
        });
    </script>
@endpush
