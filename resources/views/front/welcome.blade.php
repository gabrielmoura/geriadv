@extends('layouts.front')
@section('content')
    <!--== Start Hero Area Wrapper ==-->
    <section class="home-slider-area slider-default">
        <div class="home-slider-content slider-content-style3">
            <div class="swiper-container home-slider-container">
                <div class="swiper-wrapper">
                    @foreach($carousels as $carousel)
                        <div class="swiper-slide">
                            <!-- Start Slide Item -->
                            <div class="home-slider-item">
                                <div class="slider-content-area">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="content">
                                                    <div class="inner-content">
                                                        <div class="tittle-wrp">
                                                            <h1>{{$carousel->title}}</h1>
                                                        </div>
                                                        {!! $carousel->description !!}
                                                        @if(isset($carousel->button_title))
                                                            <a href="{{$carousel->button_link}}"
                                                               class="btn-theme btn-hover-style-bg">{{$carousel->button_title}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="slider-thumb">
                                                    <img src="{{$carousel->thumb}}" alt="{{$carousel->title}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Slide Item -->
                        </div>
                    @endforeach
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <!--== End Hero Area Wrapper ==-->

    <!--== Start Categories Area Wrapper ==-->
    <section class="categories-area categories-default-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 m-auto">
                    <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
                        <h2 class="title">Categorias</h2>
                    </div>
                </div>
            </div>
            <div class="row row-gutter-0 ml-0 mr-0" data-aos="fade-up" data-aos-duration="1100">
                <!-- Max 6 -->
                @foreach($categories->take(6) as $category)
                    <div class="col-lg-2 col-md-4 col-6">

                        <div class="categorie-content">
                            <h4 class="title"><a
                                    href="{{route('category.single',['slug'=>$category->slug])}}">{{$category->name}}</a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--== End Categories Area Wrapper ==-->

    <!--== Start Product Tab Area Wrapper ==-->
    <section class="product-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 m-auto">
                    <div class="section-title text-center mb-29" data-aos="fade-up" data-aos-duration="1000">
                        <h2 class="title">Produtos em Destaque</h2>
                    </div>
                </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-duration="1100">
                <div class="col-md-12">
                    <div class="product-tab-content">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="new-product-tab" data-bs-toggle="tab"
                                        data-bs-target="#new-product" type="button" role="tab"
                                        aria-controls="new-product" aria-selected="true">Lançamentos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="new-arrivals-tab" data-bs-toggle="tab"
                                        data-bs-target="#new-arrivals" type="button" role="tab"
                                        aria-controls="new-arrivals" aria-selected="false">Melhores Preços
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="popular-product-tab" data-bs-toggle="tab"
                                        data-bs-target="#popular-product" type="button" role="tab"
                                        aria-controls="popular-product" aria-selected="false">Popular Products
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="new-product" role="tabpanel"
                                 aria-labelledby="new-product-tab">
                                <div class="row">
                                    @foreach($products->sortDesc() as $product)
                                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                            <!-- Start Product Item -->
                                            <div class="product-item">
                                                <div class="product-thumb">
                                                    <a href="{{route('product.single',['slug'=>$product->slug])}}">
                                                        <img src="{{$product->thumb}}" alt="Olivine-Shop">
                                                    </a>
                                                    <div class="product-action">
                                                        <a class="action-cart" href="#/">
                                                            <i class="icofont-shopping-cart"></i>
                                                        </a>
                                                        <a class="action-quick-view" href="#/" title="Wishlist">
                                                            <i class="icon-zoom"></i>
                                                        </a>
                                                        <a class="action-compare" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-compare"></i>
                                                        </a>
                                                        <a class="action-wishlist" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-heart-empty"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h4 class="title"><a
                                                            href="{{route('product.single',['slug'=>$product->slug])}}">{{$product->name}}</a>
                                                    </h4>
                                                    <div class="prices">
                                                        <span class="price">{{$product->price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Product Item -->
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="tab-pane fade" id="new-arrivals" role="tabpanel"
                                 aria-labelledby="new-arrivals-tab">
                                <div class="row">
                                    @foreach($products->sortBy('price')->values() as $product)
                                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                            <!-- Start Product Item -->
                                            <div class="product-item">
                                                <div class="product-thumb">
                                                    <a href="{{route('product.single',['slug'=>$product->slug])}}">
                                                        <img src="{{$product->thumb}}" alt="{{$product->name}}">
                                                    </a>
                                                    <div class="ribbons">
                                                        <span class="ribbon ribbon-hot">Sale</span>
                                                        <span class="ribbon ribbon-onsale align-right">-10%</span>
                                                    </div>
                                                    <div class="product-action">
                                                        <a class="action-cart" href="#/">
                                                            <i class="icofont-shopping-cart"></i>
                                                        </a>
                                                        <a class="action-quick-view" href="#/" title="Wishlist">
                                                            <i class="icon-zoom"></i>
                                                        </a>
                                                        <a class="action-compare" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-compare"></i>
                                                        </a>
                                                        <a class="action-wishlist" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-heart-empty"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h4 class="title"><a
                                                            href="{{route('product.single',['slug'=>$product->slug])}}">{{$product->name}}</a>
                                                    </h4>
                                                    <div class="prices">
                                                        <span class="price">{{$product->price}}</span>
                                                        <span class="price-old">$21.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Product Item -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="popular-product" role="tabpanel"
                                 aria-labelledby="popular-product-tab">
                                <div class="row">
                                    @foreach($products->sortBy('price')->values() as $product)
                                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                            <!-- Start Product Item -->
                                            <div class="product-item">
                                                <div class="product-thumb">
                                                    <a href="shop-single-product.html">
                                                        <img src="images/shop/8.jpg" alt="Olivine-Shop">
                                                    </a>
                                                    <div class="product-action">
                                                        <a class="action-cart" href="#/">
                                                            <i class="icofont-shopping-cart"></i>
                                                        </a>
                                                        <a class="action-quick-view" href="#/" title="Wishlist">
                                                            <i class="icon-zoom"></i>
                                                        </a>
                                                        <a class="action-compare" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-compare"></i>
                                                        </a>
                                                        <a class="action-wishlist" href="javascript:void(0);"
                                                           title="Quick View">
                                                            <i class="icon-heart-empty"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h4 class="title"><a href="shop-single-product.html">Product dummy
                                                            title</a></h4>
                                                    <div class="prices">
                                                        <span class="price">$79.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Product Item -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Tab Area Wrapper ==-->

@endsection
