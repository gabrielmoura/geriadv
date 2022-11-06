@extends('layouts.default')
@section('title', 'Clientes')
@section('page-header')
    Clientes
@endsection
@section('content')
    @hasrole('manager|employees')
    <a class="btn btn-lg btn-success" href="{{route('admin.clients.create')}}">Registrar Cliente</a>
    @endhasrole

    <div class="col-xl-12 ui-sortable">
        <div class=" " data-sortable-id="form-stuff-4">
            <div class="card-body">
                {!! Form::open(['route'=>['admin.clients.index'],'method'=>'GET']) !!}
                <div class="form-group row">
                    <div class="col-7">

                        <x-form.input name="name" value="{{$request->name??''}}" title="Nome"></x-form.input>
                    </div>
                    <div class="col-2">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" name="sex">
                            <option value="" selected="selected">Selecione</option>
                            <option value="m">Masculino</option>
                            <option value="f">Feminino</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <x-form.input name="recommendation" value="{{$request->recommendation??''}}"
                                      title="Recomendação"></x-form.input>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-4">
                        <label class="control-label select optional" for="status">
                            Status</label>
                        {!! Form::select('status',[
    null=>'Indefinido',
    'deferred'=>'Deferido',
    'rejected'=>'Indeferido',
    'analysis'=>'Analise',
    'called_off'=>'Cancelado',
    'deceased'=>'Falecido',
    'cancellation'=>'Solicitou Cancelamento',
    ],$request->status??null,['class'=>'form-control']) !!}
                    </div>
                    <div class="col-4">
                        <label for="cidade_id">Cidade</label>
                        <input class="form-control " id="cidade_id" data-tabela="bairros"
                               data-chave="cidade_id" data-campo-retorno="bairro_id" name="city"
                               value="{{$request->city??''}}"/>
                    </div>
                    <div class="col-4">
                        <label for="bairro_id">Bairro</label>
                        <input class="form-control" id="bairro_id" name="district" value="{{$request->district??''}}"/>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary float-right m-r-10">Buscar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! $dataTable->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
