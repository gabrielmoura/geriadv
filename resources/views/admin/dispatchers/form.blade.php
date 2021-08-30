@extends('layouts.default')
@section('page-header')Regra de Envio @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}

                {!! Form::myInput('text','title','Nome',[],$dispatcher['title']??null) !!}

                {!! Form::mySelect('type','Tipo',['sedex'=>'sedex', 'sedex_a_cobrar'=>'sedex_a_cobrar', 'sedex_10'=>'sedex_10', 'sedex_hoje'=>'sedex_hoje', 'pac'=>'pac', 'pac_contrato'=>'pac_contrato', 'sedex_contrato'=>'sedex_contrato' , 'esedex'=>'esedex'],$dispatcher['title']??null) !!}

                {!! Form::mySelect('format','Formato',['caixa'=>'caixa', 'rolo'=>'rolo', 'envelope'=>'envelope'],$dispatcher['title']??null) !!}

                {!! Form::myInput('number','weight','Peso (kg)',[],$dispatcher['weight']??null) !!}

                {!! Form::myInput('number','length','Comprimento (cm)',[],$dispatcher['length']??null) !!}

                {!! Form::myInput('number','height','Altura (cm)',[],$dispatcher['height']??null) !!}

                {!! Form::myInput('number','width','Largura (cm)',[],$dispatcher['width']??null) !!}

                {!! Form::myInput('number','diameter','Diâmetro (cm)',[],$dispatcher['diameter']??null) !!}


                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
