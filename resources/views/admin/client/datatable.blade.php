@extends('layouts.default')
@section('page-header') Clientes @endsection
@section('content')
    <a class="btn btn-lg btn-success" href="{{route('admin.clients.create')}}">Registrar Cliente</a>
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
