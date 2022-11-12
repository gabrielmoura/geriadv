@extends('layouts.default')
@section('title', 'Empresas')
@section('page-header') Empresas @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a class="btn btn-lg btn-success" href="{{signedRoute('admin.company.create')}}">Cadastrar Nova</a>
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">
            <thead>
            <tr>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Cep</th>
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Status</th>
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
                <th>Status</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{$company->name}}</td>
                    <td class="cnpj">{{$company->cnpj}}</td>
                    <td class="cep">{{$company->cep}}</td>
                    <td>{{$company->address}}</td>
                    <td>{{$company->email}}</td>
                    <td class="tel">{{$company->tel0}}</td>
                    <td>{!! ($company->banned)?'<span class="badge badge-secondary">Inativo</span>':'<span class="badge badge-success">Ativo</span>' !!}</td>
                    <td><a href="{{route('admin.company.show',['company'=>$company->id])}}">
                            <i class="fa fa-eye"></i>
                        </a>|<a href="{{route('admin.company.edit',['company'=>$company->id])}}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
