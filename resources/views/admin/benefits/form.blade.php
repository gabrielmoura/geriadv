@extends('layouts.default')
@section('title', 'Beneficios')
@section('page-header')Cadastrar Beneficio @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">

                @if($form['route'][0]=='admin.benefit.update'&& false)
                    <button onclick="document.getElementById('delete').submit()" class="btn btn-danger">Deletar
                    </button>
                @endif
                    {!! Form::open($form) !!}
                <fieldset class="col-md-12">
                    <legend>Dados Principais</legend>
                    <div class="row">

                        <x-form.input name="name" title="Nome" :value="$benefit['name']??''" required></x-form.input>
                        <x-form.input name="description" title="Descrição"
                                      :value="$benefit['description']??''"></x-form.input>

                    </div>
                </fieldset>


                <fieldset class="col-md-12">
                    <legend>Dados para Calculo</legend>
                    <p>
                        <span>Modos de uso:</span>
                    <ul>
                        <li>Definir apenas Remuneração</li>
                        <li>Definir Remuneração * Fator de Remuneração</li>
                        <li>Definir Apenas Fator de Remuneração irá multiplicar pelo salario minimo.</li>
                    </ul>
                    </p>
                    <!-- <legend>Endereço <a href="javascript:void(0)" class="fieldset-handler">mostrar</a></legend> -->
                    <div class="row">
                        <x-form.input type="number" name="wage" title="Remuneração" :value="$benefit['wage']??''"
                        ></x-form.input>
                        <x-form.input type="number" name="wage_factor" title="Fator de Remuneração"
                                      :value="$benefit['wage_factor']??''"
                                      step=".01"></x-form.input>

                    </div>
                </fieldset>


                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
    @if($form['route'][0]=='admin.benefit.update')
        {!! Form::open(['route' => ['admin.benefit.destroy', ['benefit' => $benefit]], 'method' => 'DELETE','id'=>'delete']) !!}
        {!! Form::close() !!}
    @endif
@endsection
