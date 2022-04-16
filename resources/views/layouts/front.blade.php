<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{--
   @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
 --}}


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    <meta name="theme-color" content="rgb(9,162,255)">
    <meta name="twitter:description" content="Gerente Virtual para seu escritório.">
    <meta name="twitter:image" content="images/geriadv.png">
    <meta name="description" content="Gerente Virtual para seu escritório.">
    <meta property="og:image" content="images/geriadv.png">
    <meta name="twitter:title" content="GeriADV">
    <link rel="icon" type="image/png" sizes="500x500" href="images/geriadv.png">
    <link rel="stylesheet" href="{{url('css/front/bootstrap.min.css')}}">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{url('css/front/Whatsapp_Button.css')}}">
    <link rel="stylesheet" href="{{url('css/front/Navigation-with-Button.css')}}">
    <link rel="stylesheet" href="{{url('css/front/vanilla-zoom.min.css')}}">
    @include('layouts.front.meta')
</head>

<body>
<main class="page landing-page">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="{{url('/')}}">GeriADV</a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">First Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Second Item</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false"
                                                     data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="#">First Item</a><a
                                class="dropdown-item" href="#">Second Item</a><a class="dropdown-item" href="#">Third
                                Item</a></div>
                    </li>
                </ul>
                <span class="navbar-text actions">
                     @if (Route::has('login'))

                            <a class="btn btn-light action-button" role="button" href="{{ url('/login') }}"
                               style="background: rgba(9,162,255,0.85);">{{__('view.login')}}</a>

                    @endif
                </span>
            </div>
        </div>
    </nav>
    @yield('content')
</main>
<footer class="page-footer dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5>Get started</h5>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ route('login') }}">{{__('view.login')}}</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>About us</h5>
                <ul>
                    <li><a href="#">Company Information</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Reviews</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>Support</h5>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Help desk</a></li>
                    <li><a href="#">Forums</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>Legal</h5>
                <ul>
                    <li><a href="#">Termos de Serviço</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#">Politica de Privacidade</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>&copy; {{now()->year}} Desenvolvido por SrMoura. Todos os direitos reservados.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{url('js/front/bs-init.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
<script src="{{url('js/front/vanilla-zoom.js')}}"></script>
<script src="{{url('js/front/theme.js')}}"></script>
</body>

</html>
