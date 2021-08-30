@extends('layouts.default')
@section('page-header')Produto @endsection
@section('content')
    {!! Form::open($form) !!}
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">


                {!! Form::myInput('text','name','Nome Produto',[],$product['name']??null) !!}

                {!! Form::myInput('text','description','Descrição',[],$product['description']??null) !!}

                {!! Form::myTextArea('body','Conteúdo',[],$product['body']??null) !!}

                {!! Form::myInput('text','price','Preço',['id'=>'price'],$product['price']??null) !!}

                {!! Form::mySelect('categories[]','Categorias',$dataCategories,(isset($product))?$product->categories()->get():[],['multiple']) !!}

                {!! Form::myFile('photos[]','Fotos do Produto',['multiple'=>'multiple']) !!}


            </div>
        </div>
        <div class="col-sm-4">
            <div class="sticky-top">
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="fa fa-save"></i> Salvar
                </button>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="published" id="" class="form-control form-select">
                        <option value="true">Publicado</option>
                        <option value="false">Pendente</option>
                    </select>
                </div>
            </div>
            <hr>
            <h5>Envio / Postagem</h5>
            {!! Form::mySelect('type','Tipo',['sedex'=>'sedex', 'sedex_a_cobrar'=>'sedex_a_cobrar', 'sedex_10'=>'sedex_10', 'sedex_hoje'=>'sedex_hoje', 'pac'=>'pac', 'pac_contrato'=>'pac_contrato', 'sedex_contrato'=>'sedex_contrato' , 'esedex'=>'esedex']) !!}

            {!! Form::mySelect('format','Formato',['caixa'=>'caixa', 'rolo'=>'rolo', 'envelope'=>'envelope']) !!}

            {!! Form::myInput('number','weight','Peso (kg)') !!}

            {!! Form::myInput('number','length','Comprimento (cm)') !!}

            {!! Form::myInput('number','height','Altura (cm)') !!}

            {!! Form::myInput('number','width','Largura (cm)') !!}

            {!! Form::myInput('number','diameter','Diâmetro (cm)') !!}

        </div>

    </div>
    {!! Form::close() !!}
@endsection
@push('js')

    <script>
        $('#price').maskMoney({prefix: '', allowNegative: false, thousands: '.', decimal: ','});
    </script>

@endpush
@push('css')

@endpush
