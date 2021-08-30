@extends('layouts.default')

@section('content')

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
        @include('auth.profile.update-profile-information-form')
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        @include('auth.profile.update-password-form')
    @endif

    @hasanyrole('admin|editor|dispatcher')
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        @include('auth.profile.two-factor-authentication-form')
    @endif

    @if (config('fortify.features.logoutOtherBrowserSessions'))
        @include('auth.logout-other-session')
    @endif
    @endhasanyrole

@endsection
