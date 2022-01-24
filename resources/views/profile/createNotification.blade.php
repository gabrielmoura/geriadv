@extends('layouts.default')
@section('page-header') Notificações @endsection
@section('content')
<div class="bgc-white bd bdrs-3 p-20 mB-20">
   {!! Form::open($form) !!}
   <x-form-input name='title'></x-form-input>
    <x-form-tinymce name='body'></x-form-tinymce>
   {!! Form::close() !!}
</div>
@endsection
