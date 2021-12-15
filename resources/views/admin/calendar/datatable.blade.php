@extends('layouts.default')
@section('page-header') Eventos @endsection
@section('content')
    @hasrole('manager|employees')
    <a class="btn btn-success" href="{{ route("admin.calendar.create") }}">
        {{ __('global.add') }} {{ __('cruds.event.title_singular') }}
    </a>
    @endhasrole
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
