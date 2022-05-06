@extends('layouts.default')
@section('title', 'Clientes')
@section('page-header') Clientes @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @hasrole('manager|employees')
        <a class="btn btn-lg btn-success" href="{{route('admin.clients.create')}}">Registrar Cliente</a>
        @endhasrole
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Data de Nascimento</th>
                <th>Documento</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Data de Nascimento</th>
                <th>Documento</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->fullname??$client->user()->name}}</td>
                    <td>{{$client->sex}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->tel}}</td>
                    <td>{{$client->address}}</td>
                    <td>{{$client->birth_date}}</td>
                    <td>{{$client->doc}}</td>
                    <td><a href="{{route('admin.clients.show',['client'=>$client->slug])}}"><i
                                class="fa fa-eye"></i></a>
@can('edit_client')
<a href="{{route('admin.clients.edit',['client'=>$client->slug])}}"><i
    class="fa fa-edit"></i></a>
@endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
