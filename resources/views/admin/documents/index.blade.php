@extends('layouts.default')


@section('content')
    <div class="content">
    <a href="{{route('admin.document.create')}}" class="btn btn-lg btn-success">Criar Documeto</a>
    <table id="dataTable" class="table table-striped display  " >
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Mensagem</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documents as $p)
            <tr>
                <td>{{$p->title}}</td>
                <td  id="body">{!! resumo($p->body,100) !!}</td>
                <td><a href="{{route('admin.document.edit',['term'=>$p->id])}}"><i class="fa fa-edit fa-lg"></i></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection
@push('js')
@endpush
