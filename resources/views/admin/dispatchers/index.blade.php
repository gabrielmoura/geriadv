@extends('layouts.default')


@section('content')

    <a href="{{route('admin.dispatchers.create')}}" class="btn btn-lg btn-success">Criar Regra de Envio</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Titulo</th>
            <th>Tipo</th>
            <th>Formato</th>
            <th>Peso</th>
            <th>Comprimento</th>
            <th>Altura</th>
            <th>Largura</th>
            <th>Diametro</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dispatchers as $dispatcher)
            <tr>

                <td>{{$dispatcher->id}}</td>
                <td>{{$dispatcher->title}}</td>
                <td>{{$dispatcher->type}}</td>
                <td>{{$dispatcher->format}}</td>
                <td>{{$dispatcher->weight}} kg</td>
                <td>{{$dispatcher->length}} cm</td>
                <td>{{$dispatcher->height}} cm</td>
                <td>{{$dispatcher->width}} cm</td>
                <td>{{$dispatcher->diameter}} cm</td>
                <td width="15%">
                    <div class="btn-group">
                        <a href="{{route('admin.dispatchers.edit', ['dispatcher' => $dispatcher->slug])}}"
                           class="btn btn-sm btn-primary">EDITAR</a>

                        <form action="{{route('admin.dispatchers.destroy', ['dispatcher' => $dispatcher->slug])}}"
                              method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-danger">REMOVER</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
