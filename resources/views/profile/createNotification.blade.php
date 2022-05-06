@extends('layouts.default')
@section('title', 'Notificações')
@section('page-header','Notificações')
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::open($form) !!}
        <x-form-select name="to" title="Para" :selects="$to"></x-form-select>
        <x-form-input name='title' title="Titulo"></x-form-input>
        <x-form-tinymce name='body' title="Mensagem"></x-form-tinymce>
        <button type="submit" class="btn btn-primary">Enviar</button>
        {!! Form::close() !!}
    </div>
@endsection
