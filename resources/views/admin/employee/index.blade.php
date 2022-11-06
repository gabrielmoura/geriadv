@extends('layouts.default')
@section('title', 'Funcionários')
@section('page-header') Funcionários @endsection
@section('content')
    <a href="{{signedRoute('admin.employee.create')}}" class="btn btn-success">Registrar Funcionário</a>
    {!! $dataTable->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
