@extends('layouts.front')

@section('content')
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">{{__('Verify Code')}}</h2>
            </div>
            <div class="row">

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success" role="alert">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}

                <form class="form-horizontal" method="POST" action="{{ url('two-factor-challenge') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                        <div class="col-md-6">
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                                   name="code" value="{{ old('code') }}" autocomplete="code" autofocus>
                            <span
                                class="text-muted">{{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}</span>
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="recovery_code"
                               class="col-md-4 col-form-label text-md-right">{{ __('Recovery Code') }}</label>

                        <div class="col-md-6">
                            <input id="recovery_code" type="text"
                                   class="form-control @error('recovery_code') is-invalid @enderror"
                                   name="recovery_code" value="{{ old('recovery_code') }}"
                                   autocomplete="recovery_code" autofocus>
                            @error('recovery_code')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
