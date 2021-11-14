@extends('layouts.default')
@section('page-header') Funcionários @endsection
@section('content')
    <a href="{{signedRoute('admin.employee.create')}}" class="btn btn-success">Registrar Funcionário</a>
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
