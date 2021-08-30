@extends('layouts.front')

@section('content')
    <!--== Start Page Title Area ==-->
    <section class="page-title-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-content ">
                        <h2 class="title">Products</h2>
                        <div class="bread-crumbs"><a href="{{url('')}}">Home<span
                                    class="breadcrumb-sep">></span></a><span class="active">Products</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Page Title Area ==-->

    <!--== Start Shop Area Wrapper ==-->
    <div class="product-area product-grid-area">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-topbar-wrapper">
                                <div class="collection-shorting">
                                    <div class="shop-topbar-left">
                                        <div class="view-mode">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link" id="nav-grid-tab" data-bs-toggle="tab"
                                                            data-bs-target="#nav-grid" type="button" role="tab"
                                                            aria-controls="nav-grid" aria-selected="false"><i
                                                            class="fa fa-th"></i></button>
                                                    <button class="nav-link active" id="nav-list-tab"
                                                            data-bs-toggle="tab" data-bs-target="#nav-list"
                                                            type="button" role="tab" aria-controls="nav-list"
                                                            aria-selected="true"><i class="fa fa-list"></i></button>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="product-show-content"><p>Showing 1 - 21
                                            of {{$products->count()}}
                                            result</p></div>
                                    <div class="product-short-list">
                                        <div class="product-show">
                                            <label for="SortBy">Sort by</label>
                                            <select class="form-select" id="SortBy" aria-label="Default select example">
                                                <option value="manual">Featured</option>
                                                <option value="best-selling">Best Selling</option>
                                                <option value="title-ascending" selected>Alphabetically, A-Z</option>
                                                <option value="title-descending">Alphabetically, Z-A</option>
                                                <option value="price-ascending">Price, low to high</option>
                                                <option value="price-descending">Price, high to low</option>
                                                <option value="created-descending">Date, new to old</option>
                                                <option value="created-ascending">Date, old to new</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                            <div class="row">
                                @forelse($products as $key => $product)
                                    <div class="col-xl-4 col-md-6">
                                        <!-- Start Product Item -->
                                        <div class="product-item">
                                            <div class="product-thumb">
                                                <a href="{{route('product.single',['slug'=>$product->slug])}}">
                                                    <img src="{{$product->thumb}}" alt="{{$product->slug}}">
                                                </a>
                                                <div class="ribbons">
                                                    <span class="ribbon ribbon-hot">Sale</span>
                                                    <span class="ribbon ribbon-onsale align-right">-15%</span>
                                                    <span class="ribbon ribbon-new align-right-top">New</span>
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
                                                    <span class="price-old">$130.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Item -->
                                    </div>
                                @empty
                                    <div class="col-xl-4 col-md-6">
                                        <h3 class="alert alert-warning">Nenhum produto encontrado!</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="nav-list" role="tabpanel"
                             aria-labelledby="nav-list-tab">
                            <div class="row">
                                @foreach($products as $key => $product)
                                    <div class="col-12">
                                        <!-- Start Product Item -->
                                        <div class="product-item product-item-list">
                                            <div class="product-thumb">
                                                <a href="{{route('product.single',['slug'=>$product->slug])}}"><img
                                                        src="{{$product->thumb}}"
                                                        alt="{{$product->slug}}"></a>
                                                <div class="product-action-quick-view">
                                                    <a class="action-quick-view"
                                                       href="{{route('product.single',['slug'=>$product->slug])}}"
                                                       title="Show">
                                                        <i class="icon-zoom"></i>
                                                    </a>
                                                </div>
                                                <div class="ribbons">
                                                    <span class="ribbon ribbon-hot">Sale</span>
                                                    <span class="ribbon ribbon-onsale align-right">-15%</span>
                                                    <span class="ribbon ribbon-new align-right-top">New</span>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h4 class="title"><a
                                                        href="{{route('product.single',['slug'=>$product->slug])}}">{{$product->name}}</a>
                                                </h4>
                                                <div class="prices">
                                                    <span class="price">{{$product->price}}</span>
                                                    <del class="price-old">$130.00</del>
                                                </div>
                                                {!! $product->body !!}
                                                <div class="product-action-btn">
                                                    <a class="btn-compare" href="javascript:void(0);">
                                                        <i class="fa icon-compare"></i>
                                                    </a>
                                                    <a class="btn-add-cart" href="shop-cart.html">Add to cart</a>
                                                    <a class="btn-wishlist" href="shop-wishlist.html">
                                                        <i class="icon-heart-empty"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Item -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{$products->links('front.pagination')}}
                </div>
            </div>
        </div>
    </div>
@endsection

