@extends('layouts.default')

@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Condominios</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Condominios</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($boletos as $boleto)
                <tr>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td><img style="width: 50px"
                             src="{{(isset($usuario->avatar))?$usuario->avatar:$usuario->avatar()}}"></td>
                    <td>
                        {{(isset($usuario->condominio()->get()->name))?$usuario->condominio()->get()->name:"Nenhum Condominio Associado"}}</td>
                    <td>
                        <a href="{{route('admin.usuario.edit',['usuario'=>$usuario->id])}}"><i
                                class="fa fa-edit"></i></a>|
                        <a href="{{route('admin.usuario.show',['usuario'=>$usuario->id])}}"><i
                                class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('page-header')Boletos @endsection
