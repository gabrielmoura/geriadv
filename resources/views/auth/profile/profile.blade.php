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
    <!--
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enable Push Messages</div>
                    <div class="card-body">
                        <input type="checkbox" checked data-toggle="toggle" class="js-push-button" id="push-select">
                    </div>
                </div>
            </div>
        </div>
    </div>
            -->

@endsection
@push('css')
    <!-- <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
          integrity="sha512-hievggED+/IcfxhYRSr4Auo1jbiOczpqpLZwfTVL/6hFACdbI3WQ8S9NCX50gsM9QVE+zLk/8wb9TlgriFbX+Q=="
          crossorigin="anonymous"> -->
@endpush
@push('js')
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha512-eHWYortWe2NyxHIiY/wY82nK4RlPIDDDSD5ZvTHrTkiq9tAe++DBhq5rDcC02xqHxh0ctGGMbHKotqtYcYgXZA=="
            crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"
            integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w=="
            crossorigin="anonymous"></script>  -->
@endpush
