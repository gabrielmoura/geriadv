<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link rel="manifest" href="{{url('manifest.json')}}">
    <!-- Styles -->


    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

{{-- <link href="{{ mix('/css/rtl.css') }}" rel="stylesheet"> --}}

<!-- Global css content -->

    <!-- End of global css content-->

    <!-- Specific css content placeholder -->
@stack('css')
<!-- End of specific css content placeholder -->
    @if(config('webpush.enable'))
        <script>
            window.Laravel = {!! json_encode([
          'user' => Auth::user(),
          'csrfToken' => csrf_token(),
          'vapidPublicKey' => config('webpush.vapid.public_key'),
          'pusher' => [
              'key' => config('broadcasting.connections.pusher.key'),
              'cluster' => config('broadcasting.connections.pusher.options.cluster'),
          ],
      ]) !!};
        </script>
    @endif
    @include('layouts.front.meta')
</head>

