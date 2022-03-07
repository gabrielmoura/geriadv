@extends('layouts.default')
@section('page-header') Boletos @endsection
@section('content')
    <a href="{{route('admin.billets.create')}}" class="btn btn-success">Registrar novo Boleto</a>
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
