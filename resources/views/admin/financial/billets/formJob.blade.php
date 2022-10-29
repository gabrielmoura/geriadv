@extends('layouts.default')
@section('page-header')Cliente @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}


                <fieldset class="col-md-12">
                    <legend>Dados Principais</legend>
                    <div class="row">
                        <x-form.select name="client_id" title="Cliente" :selects="$clients" ></x-form.select>

                        <x-form.input type="number" name="parcel" title="Parcelas" class="col-md-2" required></x-form.input>

                        <x-form.input type="number" class="col-md-5" inputClass="price" name="price" title="Valor em centavos" :value="$billet->price??''"></x-form.input>
                        <x-form.input name="description" title="Descrição" class="col-md-2"></x-form.input>
                    </div>
                </fieldset>



                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection

