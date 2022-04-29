<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials.head')

<body class="app">

@include('layouts.partials.spinner')

<div>
    <!-- #Left Sidebar ==================== -->
@include('layouts.partials.sidebar')

<!-- #Main ============================ -->
    <div class="page-container">
        <!-- ### $Topbar ### -->
    @include('layouts.partials.topbar',['user'=>auth()->user()])

    <!-- ### $App Screen Content ### -->
        <main class='main-content bgc-grey-100'>
            <div id='mainContent'>
                <div class="container-fluid">

                    <h4 class="c-grey-900 mT-10 mB-30">@yield('page-header')</h4>

                    @include('layouts.partials.messages')
                    @yield('content')

                </div>
            </div>
        </main>

        <!-- ### $App Screen Footer ### -->
        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                <span>&copy; {{now()->year}} Desenvolvido por SrMoura. Todos os direitos reservados.</span>
        </footer>
    </div>
</div>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>

@routes

<x-poke />
@stack('js')

@toastr_render
@if(config('webpush.enable'))
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
    @endauth
@endif
</body>

</html>
