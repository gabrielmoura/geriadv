<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials.head')

<body class="app">

@include('layouts.partials.spinner')

<div class="peers ai-s fxw-nw h-100vh">
    <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv "
         style='background-image: url("/images/bg.jpg");'>
        <div class="pos-a centerXY">
            <div class="bgc-white bdrs-50p pos-r " style='width: 120px; height: 120px;'>
                <img class="pos-a centerXY" src="/images/logo.png" alt="">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
        @yield('content')
    </div>
</div>

<!-- Global js content -->
<script src="{{mix('js/app.js')}}"></script>
<script src="{{mix('js/webPush.js')}}"></script>
<!-- End of global js content-->

<!-- Specific js content placeholder -->
@stack('js')
<!-- End of specific js content placeholder -->
{{--
<script>
    const public_channel = '{{config('app.name')}}.Public';

    Echo.channel(public_channel)
        .listen('OrderShipmentStatusUpdated', (data) => {
            console.log(data)
        });
</script>

@auth()
<script>
    const private_channel = '{{config('app.name')}}.{{auth()->id()}}';

    Echo.private(private_channel)
        .notification((notification) => {
            console.log(notification);
        });

</script>
@endauth --}}
</body>

</html>
