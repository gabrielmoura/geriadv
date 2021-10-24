@extends('layouts.default')
@section('page-header') Funcionários @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a href="{{signedRoute('admin.employee.create')}}" class="btn btn-success">Registrar Funcionário</a>
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
            @foreach($employees as $employee)
                <tr>
                    <td>{{$employee->name??$employee->user()->first()->name}}</td>
                    <td>{{$employee->sex}}</td>
                    <td>{{$employee->email??$employee->user()->first()->email}}</td>
                    <td>{{$employee->tel}}</td>
                    <td>{{$employee->address}}</td>
                    <td>{{$employee->birth_date}}</td>
                    <td>{{$employee->doc}}</td>
                    <td><a href="{{route('admin.employee.show',['employee'=>$employee->id])}}"><i
                                class="fa fa-eye"></i></a>|<a
                            href="{{route('admin.employee.edit',['employee'=>$employee->id])}}"><i
                                class="fa fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
