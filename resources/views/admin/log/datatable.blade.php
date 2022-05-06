@extends('layouts.default')
@section('title', 'Registro')
@section('page-header') Registro @endsection
@section('content')
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
