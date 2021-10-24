@extends('layouts.default')
@section('page-header') Empresas @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a href="{{signedRoute('admin.company.create')}}">Cadastrar Nova</a>
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0" >
            <thead>
            <tr>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Cep</th>
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Cep</th>
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{$company->name}}</td>
                    <td>{{$company->cnpj}}</td>
                    <td>{{$company->cep}}</td>
                    <td>{{$company->address}}</td>
                    <td>{{$company->email}}</td>
                    <td>{{$company->tel0}}</td>
                    <td><a href="{{route('admin.company.show',['company'=>$company->id])}}"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
