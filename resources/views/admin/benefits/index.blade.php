@extends('layouts.default')
@section('page-header') Beneficios @endsection
@section('content')
    <a class="btn btn-lg btn-success" href="{{route('admin.benefit.create')}}">Registrar Beneficios</a>
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
