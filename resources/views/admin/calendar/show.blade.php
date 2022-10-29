@extends('layouts.default')
@section('title', 'Agendamento')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ __('global.show') }} {{ __('cruds.event.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.id') }}
                        </th>
                        <td>
                            {{ $event->pid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.name') }}
                        </th>
                        <td>
                            {{ $event->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.start_time') }}
                        </th>
                        <td>
                            {{ $event->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.end_time') }}
                        </th>
                        <td>
                            {{ $event->end_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.recurrence') }}
                        </th>
                        <td>
                            {{ \App\Models\Calendar::RECURRENCE_RADIO[$event->recurrence] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.event') }}
                        </th>
                        <td>
                            {{ $event->event->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ __('cruds.event.fields.address') }}
                        </th>
                        <td>
                            {{ $event->address ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.lawyer') }}
                        </th>
                        <td>
                            {{ $event->lawyer()->first()->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('cruds.event.fields.description') }}
                        </th>
                        <td>
                            {!! $event->description ?? '' !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ __('global.back_to_list') }}
                </a>
            </div>

            <nav class="mb-3">
                <div class="nav nav-tabs">

                </div>
            </nav>
            <div class="tab-content">

            </div>
        </div>
    </div>
@endsection
