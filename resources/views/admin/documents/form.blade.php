@extends('layouts.default')
@section('page-header')Adicionar Termos @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}

                {!! Form::myInput('text','title','Titulo',[],$document['title']??null) !!}
                {!! Form::myTextArea('body','Conteúdo',[],$document['body']??null) !!}

                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
@push('js')

    <script>
        $('#price').maskMoney({prefix: '', allowNegative: false, thousands: '.', decimal: ','});
    </script>

@endpush
