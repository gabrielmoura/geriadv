@extends('layouts.default')
@section('page-header') Clientes @endsection
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

                        <x-form-input name="name" value="{{$request->name??''}}" title="Nome"></x-form-input>
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
                        <x-form-input name="recommendation" value="{{$request->recommendation??''}}"
                                      title="Recomendação"></x-form-input>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-4">
                        <label for="estado_id">Estado</label>
                        <select class="form-control selectLoad" data-tabela="cidades" data-chave="estado_id"
                                data-campo-retorno="cidade_id" name="state">
                            <option value="" selected="selected">Selecione</option>
                            <option value="12">Acre</option>
                            <option value="27">Alagoas</option>
                            <option value="16">Amapá</option>
                            <option value="13">Amazonas</option>
                            <option value="29">Bahia</option>
                            <option value="23">Ceará</option>
                            <option value="53">Distrito Federal</option>
                            <option value="32">Espírito Santo</option>
                            <option value="52">Goiás</option>
                            <option value="21">Maranhão</option>
                            <option value="51">Mato Grosso</option>
                            <option value="50">Mato Grosso do Sul</option>
                            <option value="31">Minas Gerais</option>
                            <option value="15">Pará</option>
                            <option value="25">Paraíba</option>
                            <option value="41">Paraná</option>
                            <option value="26">Pernambuco</option>
                            <option value="22">Piauí</option>
                            <option value="33">Rio de Janeiro</option>
                            <option value="24">Rio Grande do Norte</option>
                            <option value="43">Rio Grande do Sul</option>
                            <option value="11">Rondônia</option>
                            <option value="14">Roraima</option>
                            <option value="42">Santa Catarina</option>
                            <option value="35">São Paulo</option>
                            <option value="28">Sergipe</option>
                            <option value="17">Tocantins</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="cidade_id">Cidade</label>
                        <select class="form-control selectLoad" id="cidade_id" data-tabela="bairros"
                                data-chave="cidade_id" data-campo-retorno="bairro_id" name="city"></select>
                    </div>
                    <div class="col-4">
                        <label for="bairro_id">Bairro</label>
                        <select class="form-control" id="bairro_id" name="district">
                            <option value="" selected="selected">Selecione</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary float-right m-r-10">Buscar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {!! $html->scripts() !!}
@endpush
