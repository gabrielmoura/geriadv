@extends('layouts.default')
@section('title', 'Advogados')
@section('page-header') Advogados @endsection
@section('content')
    <a href="{{signedRoute('admin.lawyer.create')}}" class="btn btn-success">Registrar Advogados</a>
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
