@extends('layouts.front')
@section('content')
    {!! Form::open($form) !!}
    @if (session()->has('success'))
        <span class="help-block">
            <strong>{{ session()->get('success') }}</strong>
        </span>
    @endif
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Nome</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Email</label>
        <div class="col-md-6">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Endereço</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
            @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Mensagem</label>
        <div class="col-md-6">
            <textarea type="text" class="form-control" name="body">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <span class="help-block">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </div>
    
    <div class="form-group{{ $errors->has('privacy') ? ' has-error' : '' }} form-check">
        @if ($errors->has('privacy'))
            <span class="help-block">
                    <strong>{{ $errors->first('privacy') }}</strong>
            </span>
        @endif
        <input type="checkbox" class="form-check-input" id="privacy" name="privacy" value="{{ old('privacy') }}">
        <label class="form-check-label" for="privacy">Eu li e concordo com o Política de Privacidade</label>
    </div>


    {!! NoCaptcha::displaySubmit('contact', 'Enviar', ['data-theme' => 'dark','class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
@push('js')
    {!! NoCaptcha::renderJs() !!}
@endpush
@push('css')
    <style>
        /*  .grecaptcha-badge {
              visibility: hidden;
          } */
    </style>
@endpush
