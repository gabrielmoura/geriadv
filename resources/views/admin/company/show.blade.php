@extends('layouts.default')
@section('page-header') Empresa @endsection
@section('content')
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
