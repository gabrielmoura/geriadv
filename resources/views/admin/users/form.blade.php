@extends('layouts.default')
@section('page-header')Usuário @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}

                {!! Form::myInput('text', 'name', 'Username',[],$user->name??'') !!}

                {!! Form::myInput('email', 'email', 'Email',[],$user->email??'') !!}

                {!! Form::myInput('password', 'password', 'Password') !!}

                {!! Form::myInput('password', 'password_confirmation', 'Password again') !!}
                {!! Form::mySelect('role','Função',$role,(isset($user))?$user->roles()->get():[],['multiple'=>'multiple']) !!}

                {!! Form::myFile('avatar', 'Avatar') !!}

                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
