@extends('layouts.default')
@section('page-header')Usuário @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}
                <x-form-input  name="name" title="Username" :value="$user->name??''"></x-form-input>

                <x-form-input type="email" name="email" title="Email" :value="$user->email??''"></x-form-input>

                <x-form-input type="password" name="password" title="Password"></x-form-input>
                <x-form-input type="password" name="password_confirmation" title="Password again"></x-form-input>

                <x-form-select :selects="$company" name="company" title="Empresa"></x-form-select>

                <x-form-file name="avatar" title="Avatar"></x-form-file>


                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
