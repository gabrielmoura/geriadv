@extends('layouts.default')
@section('page-header') Registro @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0">
            <thead>
            <tr>
                <th>Data</th>
                <th>Funcionário</th>
                <th>Tipo</th>
                <th>Dados Alterados</th>

            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Data</th>
                <th>Funcionário</th>
                <th>Tipo</th>
                <th>Dados Alterados</th>

            </tr>
            </tfoot>
            <tbody>
            @foreach($activities->all() as $activity)
                <tr>
                    <td>{{$activity->created_at}}</td>
                    <td>{{\App\Models\User::find($activity->causer_id)->name}}</td>
                    <td>{{$activity->description}} </td>
                    <td>{{($activity->properties->has('old')) ?json_encode( collect($activity->properties['attributes'])->diffAssoc($activity->properties['old'])):''}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
