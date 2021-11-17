@extends('layouts.default')
@section('page-header') Empresa @endsection
@section('content')

    {!! Form::open(['route'=>['admin.company.destroy','company'=>$company->id],'method'=>'DELETE','id'=>'delete']) !!}
    <a class="btn btn-danger" onclick="document.getElementById('delete').submit();">Deletar Empresa</a>
    {!! Form::close() !!}

    <div>
        {{$company->name}}
        {{$company->cnpj}}
        {{$company->cep}}
        {{$company->address}}
        {{$company->email}}
        {{$company->tel0}}
    </div>
    <div>
        <iframe src="{{route('admin.company.iframe',['id'=>$id])}}" title='Funcionários' width="100%"></iframe>
    </div>
@endsection
