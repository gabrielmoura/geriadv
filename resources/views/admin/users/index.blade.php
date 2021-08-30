@extends('layouts.default')

@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a class="btn btn-lg btn-success" href="{{route('admin.users.create')}}">Registrar Usuários</a>
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Função</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Função</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td><img style="width: 50px"
                             src="{{(isset($usuario->avatar))?$usuario->avatar:$usuario->avatar()}}"></td>
                    <td>
                    @foreach($usuario->getRoleNames() as $role)
                        {{$role}}
                    @endforeach
                    <td>
                        <a href="{{route('admin.users.edit',['usuario'=>$usuario->id])}}">
                            <i class="fa fa-edit"></i></a>|
                        <a href="{{route('admin.users.show',['usuario'=>$usuario->id])}}">
                            <i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('page-header')Usuários @endsection
