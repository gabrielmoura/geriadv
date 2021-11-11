@extends('layouts.default')
@section('page-header') Funcionários @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a href="{{signedRoute('admin.employee.create')}}" class="btn btn-success">Registrar Funcionário</a>
        @section('content')
            <a class="btn btn-lg btn-success" href="{{route('admin.clients.create')}}">Registrar Cliente</a>
            {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
        @endsection
        @push('js')
            {!! $html->scripts() !!}
        @endpush
    </div>
@endsection
