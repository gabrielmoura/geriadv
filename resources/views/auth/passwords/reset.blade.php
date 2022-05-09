@extends('layouts.front')

@section('content')
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">{{__('Reset Password')}}</h2>
            </div>
            <div class="row">
                <form class="form-horizontal " method="POST" action="{{ route('password.update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ request('token')??'' }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="text-normal text-dark">{{__('E-Mail Address')}}</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ request('email') ?? old('email') }}"
                               required autofocus>

                        @if ($errors->has('email'))
                            <span class="form-text text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="text-normal text-dark">{{__('Password')}}</label>

                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="text-normal text-dark">{{__('Confirm Password')}}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{__('Reset Password')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
