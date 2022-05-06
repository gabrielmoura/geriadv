@extends('layouts.default')
@section('title', 'Usuários')
@section('page-header')Usuários @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @hasrole('admin')
        <a class="btn btn-lg btn-success" href="{{route('admin.users.create')}}">Registrar Usuários</a>
    @endhasrole
    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
