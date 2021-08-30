<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Olivine - Responsive Beard Oil Bootstrap 5 HTML Template</title>
@include('layouts.front.meta')
@stack('metadata')
<!--== Favicon ==-->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon"/>

    <!--== Google Fonts ==-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700" rel="stylesheet">

    <!--== Bootstrap CSS ==-->
    <link href="{{mix('css/app.css')}}" rel="stylesheet"/>
    <!--== Font-awesome Icons CSS ==-->
    <link href="{{asset('')}}/assets/css/font-awesome.min.css" rel="stylesheet"/>
    <!--== Icofont Min Icons CSS ==-->
    <link href="{{asset('')}}/assets/css/icofont.min.css" rel="stylesheet"/>
    <!--== Fontello CSS ==-->
    <link href="{{asset('')}}/assets/css/fontello.css" rel="stylesheet"/>
    <!--== Shopify Social CSS ==-->
    <link href="{{asset('')}}/assets/css/shopify-social.css" rel="stylesheet"/>
    <!--== Vandella CSS ==-->
    <link href="{{asset('')}}/assets/css/font-vandella.css" rel="stylesheet"/>
    <!--== Animate CSS ==-->
    <link href="{{asset('')}}/assets/css/animate.css" rel="stylesheet"/>
    <!--== Aos CSS ==-->
    <link href="{{asset('')}}/assets/css/aos.css" rel="stylesheet"/>
    <!--== FancyBox CSS ==-->
    <link href="{{asset('')}}/assets/css/jquery.fancybox.min.css" rel="stylesheet"/>
    <!--== Slicknav CSS ==-->
    <link href="{{asset('')}}/assets/css/slicknav.css" rel="stylesheet"/>
    <!--== Swiper CSS ==-->
    <link href="{{asset('')}}/assets/css/swiper.min.css" rel="stylesheet"/>
    <!--== Slick CSS ==-->
    <link href="{{asset('')}}/assets/css/slick.css" rel="stylesheet"/>
    <!--== Main Style CSS ==-->
    <link href="{{asset('')}}/assets/css/style.css" rel="stylesheet"/>


</head>

<body>

<!--wrapper start-->
<div class="wrapper home-default-wrapper">

    <!--== Start Preloader Content ==-->
    @if(env('APP_ENV')!='local')
        <div class="preloader-wrap">
            <div class="preloader">
                <span class="dot"></span>
                <div class="dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    @endif

<!--== Start Header Wrapper ==-->
    <header class="header-area header-default style-2 sticky-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-5 col-sm-3 col-md-3 col-lg-2">
                    <div class="header-logo-area">
                        <a href="{{url('')}}">
                            <img class="logo-main" src="{{asset('/images/valquirias.png')}}" alt="Logo"/>
                            <img class="logo-light" src="{{asset('/images/valquirias.png')}}" alt="Logo"/>
                        </a>
                    </div>
                </div>
                <div class="col-7 col-sm-9 col-md-9 col-lg-10">
                    <div class="header-align">
                        <div class="header-navigation-area d-none">
                            <ul class="main-menu nav justify-content-center">
                                <li class="has-submenu active"><a href="index.html">Home</a>
                                    <ul class="submenu-nav">
                                        <li><a href="index.html">Home 1</a></li>
                                        <li><a href="index-2.html">Home 2</a></li>
                                        <li><a href="index-3.html">Home 3</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu full-width"><a href="index.html">Shop</a>
                                    <ul class="submenu-nav submenu-nav-mega">
                                        <li class="mega-menu-item"><a class="srmenu-title" href="#">Collection 01</a>
                                            <ul>
                                                <li><a href="shop-single-product-title1.html">Mostarizing Oil</a></li>
                                                <li><a href="shop-single-product-title1.html">Katopeno Altuni</a></li>
                                                <li><a href="shop-single-product-title1.html">Buffekete Chai</a></li>
                                                <li><a href="shop-single-product-title1.html">Simple product</a></li>
                                                <li><a href="shop-single-product-title1.html">Vortahole Valohoi</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a class="srmenu-title" href="#">Collection 02</a>
                                            <ul>
                                                <li><a href="shop-single-product-title1.html">Murikhete Paris</a></li>
                                                <li><a href="shop-single-product-title1.html">Origeno Veledita</a></li>
                                                <li><a href="shop-single-product-title1.html">Simple product</a></li>
                                                <li><a href="shop-single-product-title1.html">Vortahole Valohoi</a></li>
                                                <li><a href="shop-single-product-title1.html">Baizidale Momone</a></li>
                                                <li><a href="shop-single-product-title1.html">Soldout product</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a class="srmenu-title" href="#">Collection 03</a>
                                            <ul>
                                                <li><a href="shop-single-product-title1.html">New Badge Product</a></li>
                                                <li><a href="shop-single-product-title1.html">Origeno Veledita</a></li>
                                                <li><a href="shop-single-product-title1.html">Baizidale Momone</a></li>
                                                <li><a href="shop-single-product-title1.html">Origeno Veledita</a></li>
                                                <li><a href="shop-single-product-title1.html">Countdown product</a></li>
                                                <li><a href="shop-single-product-title1.html">Murikhete Paris</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item banner-menu-content-wrap">
                                            <ul>
                                                <li>
                                                    <a href="shop-single-product-title1.html">
                                                        <img src="{{asset('/images/photos/menu1.jpg')}}"
                                                             alt="Olivine-Shop">
                                                    </a>
                                                    <div class="banner-menu-content">
                                                        <h2>New <br>Collections</h2>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-submenu full-width colunm-two position-static"><a href="index.html">Product</a>
                                    <ul class="submenu-nav submenu-nav-mega">
                                        <li class="mega-menu-item"><a class="srmenu-title" href="#">Shop Pages
                                                Layout</a>
                                            <ul>
                                                <li><a href="shop-3-grid.html">Shop 3 Column</a></li>
                                                <li><a href="shop-4-grid.html">Shop 4 Column</a></li>
                                                <li><a href="shop.html">Shop Left Sidebar</a></li>
                                                <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                                <li><a href="shop-list.html">Shop Listing View</a></li>
                                                <li><a href="shop-list-left-sidebar.html">Shop List left Sidebar</a>
                                                </li>
                                                <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a class="srmenu-title" href="#">Single Products</a>
                                            <ul>
                                                <li><a href="shop-single-product.html">Simple Product</a></li>
                                                <li><a href="shop-single-product-affiliate.html">Affiliate Product</a>
                                                </li>
                                                <li><a href="shop-single-product-variable.html">Variable Product</a>
                                                </li>
                                                <li><a href="shop-single-product-soldout.html">Soldout Product</a></li>
                                                <li><a href="shop-single-product-countdown.html">Countdown Product</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-submenu"><a href="blog.html">Blog</a>
                                    <ul class="submenu-nav">
                                        <li><a href="blog.html">Blog Grid Left Sidebar</a></li>
                                        <li><a href="blog-grid-right-sidebar.html">Blog Grid Right Sidebar</a></li>
                                        <li><a href="blog-grid-no-sidebar.html">Blog Grid No Sidebar</a></li>
                                        <li><a href="blog-details-left-sidebar.html">Blog Single Left Sidebar</a></li>
                                        <li><a href="blog-details-right-sidebar.html">Blog Single Right Sidebar</a></li>
                                        <li><a href="blog-details-no-sidebar.html">Blog Single No Sidebar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                        <div class="header-action-area">
                            <div class="header-action-search search-toggle-style">
                                <button class="btn-search show">
                                    <span class="search-icon icofont-close-line"></span>
                                    <span class="search-icon-close icofont-search-1"></span>
                                </button>
                                <div class="btn-search-toggle">
                                    <form action="#search" method="GET">
                                        <div class="form-input-item">
                                            <label for="search" class="sr-only">Search our store</label>
                                            <input type="text" id="search" name="search" placeholder="Search our store">
                                            <button type="submit" class="btn-src">
                                                <i class="icofont-search-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="header-action-cart">
                                <a class="cart-icon" href="javascript:void(0);">
                                    <i class="icofont-shopping-cart"></i>
                                </a>
                            </div>
                            <div class="header-action-usermenu">
                                <a href="{{route('login')}}" class="icon-usermenu"><i
                                        class="icofont-user-alt-3"></i></a>
                            </div>
                            <button class="btn-menu">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--== End Header Wrapper ==-->
    <main class="main-content site-wrapper-reveal">
        @yield('content')
    </main>
    @include('layouts.front.footer')
    @include('layouts.front.modal')
</div>
<!--=======================Javascript============================-->

<!--=== Modernizr Min Js ===-->

<!--=== Modernizr Min Js ===-->
<script src="{{asset('')}}/assets/js/modernizr.js"></script>
<!--=== jQuery Min Js ===-->
<script src="{{asset('')}}/assets/js/jquery-3.6.0.min.js"></script>
<!--=== jQuery Migration Min Js ===-->
<script src="{{asset('')}}/assets/js/jquery-migrate.js"></script>
<!--=== Popper Min Js ===-->
<script src="{{asset('')}}/assets/js/popper.min.js"></script>
<!--=== Bootstrap Min Js ===-->
<script src="{{asset('')}}/assets/js/bootstrap.min.js"></script>
<!--=== jquery Appear Js ===-->
<script src="{{asset('')}}/assets/js/jquery.appear.js"></script>
<!--=== jquery Swiper Min Js ===-->
<script src="{{asset('')}}/assets/js/swiper.min.js"></script>
<!--=== jQuery Slick Min Js ===-->
<script src="{{asset('')}}/assets/js/slick.min.js"></script>
<!--=== jquery Fancybox Min Js ===-->
<script src="{{asset('')}}/assets/js/fancybox.min.js"></script>
<!--=== jquery Aos Min Js ===-->
<script src="{{asset('')}}/assets/js/aos.min.js"></script>
<!--=== jquery Slicknav Js ===-->
<script src="{{asset('')}}/assets/js/jquery.slicknav.js"></script>
<!--=== jquery Countdown Js ===-->
<script src="{{asset('')}}/assets/js/jquery.countdown.min.js"></script>
<!--=== jquery Wow Min Js ===-->
<script src="{{asset('')}}/assets/js/wow.min.js"></script>
<!--=== jQuery Zoom Min Js ===-->
<script src="{{asset('')}}/assets/js/jquery-zoom.min.js"></script>

<!--=== Custom Js ===-->
<script src="{{asset('')}}/assets/js/custom.js"></script>
</body>

</html>
