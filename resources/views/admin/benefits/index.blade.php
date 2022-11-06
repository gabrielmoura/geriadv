@extends('layouts.default')
@section('title', 'Beneficios')
@section('page-header') Beneficios @endsection
@section('content')
    <a class="btn btn-lg btn-success" href="{{route('admin.benefit.create')}}">Registrar Beneficios</a>
    {!! $dataTable->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
