@extends('layouts.front')


@section('content')

    <!--== Start Page Title Area ==-->
    <section class="page-title-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-content">
                        <h2 class="title">3. Variable product</h2>
                        <div class="bread-crumbs"><a href="{{url('')}}">Home<span
                                    class="breadcrumb-sep">></span></a><span class="active">3. Variable product</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Page Title Area ==-->

    <!--== Start Shop Area ==-->
    <section class="product-area shop-single-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="single-product-slider">
                        <div class="product-dec-slider-right">
                            <div class="single-product-thumb">
                                <div class="single-product-thumb-slider">
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/3.png">
                                                <img src="{{asset('')}}/assets/img/shop/details/3.png"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/4.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/4.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/1.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/1.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/5.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/5.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/6.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/6.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/7.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/7.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="zoom zoom-hover">
                                        <div class="thumb-item">
                                            <a class="lightbox-image" data-fancybox="gallery"
                                               href="{{asset('')}}/assets/img/shop/details/2.webp">
                                                <img src="{{asset('')}}/assets/img/shop/details/2.webp"
                                                     alt="Image-HasTech">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-dec-slider-left">
                            <div class="single-product-nav">
                                <div class="single-product-nav-slider">
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav3.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav4.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav1.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav5.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav6.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav7.webp" alt="Image-HasTech">
                                    </div>
                                    <div class="nav-item">
                                        <img src="{{asset('')}}/assets/img/shop/details/nav2.webp" alt="Image-HasTech">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-product-info">
                        <h4 class="title">{{$product->name}}</h4>
                        <div class="product-ratting">
                            @if (isset($product->sku))
                                <div class="product-sku">
                                    SKU: <span>{{$product->sku}}</span>
                                </div>
                            @endif
                            <div class="ratting-icons">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                        </div>
                        <div class="product-availability">
                            Availability: <span>11 left in stock</span>
                        </div>
                        <p class="product-desc">{!! $product->description !!}</p>
                        <div class="prices">
                            <span class="price">{{$product->price}}</span>
                            <span class="price-old">$85.00</span>
                        </div>
                        {{--<div class="product-action-size">
                            <span class="title">Size :</span>
                            <ul>
                                <li class="active">S</li>
                                <li>M</li>
                                <li>L</li>
                                <li>XL</li>
                            </ul>
                        </div>
                        <div class="product-action-color">
                            <span class="title">Color :</span>
                            <ul>
                                <li class="bg-color-purple active"></li>
                                <li class="bg-color-violet"></li>
                                <li class="bg-color-black"></li>
                                <li class="bg-color-pink"></li>
                                <li class="bg-color-orange"></li>
                            </ul>
                        </div>
                        <div class="product-action-material">
                            <span class="title">Material :</span>
                            <ul>
                                <li class="active">Metal</li>
                                <li>Resin</li>
                                <li>Leather</li>
                                <li>Slag</li>
                                <li>Fiber</li>
                            </ul>
                        </div> --}}
                        <div class="quick-product-action">
                            <div class="action-top">
                                <div class="pro-qty-area">
                                    <span class="qty-title">Quantity:</span>
                                    <div class="pro-qty">
                                        <input type="text" id="quantity" title="Quantity" value="1"/>
                                    </div>
                                </div>
                                <a class="btn-theme" href="shop-checkout.html">Buy it now</a>
                            </div>
                            <div class="action-bottom">
                                <button class="btn btn-black">Add to cart</button>
                                <a class="btn-wishlist" href="#"><i class="icon-heart-empty"></i></a>
                                <a class="btn-wishlist" href="#"><i class="icon-compare"></i></a>
                            </div>
                        </div>
                        <div class="product-social-info">
                            <span class="title-social">Share:</span>
                            <a href="#"><span class="shopify-social-icon-facebook-rounded color"></span></a>
                            <a href="#"><span class="shopify-social-icon-twitter-rounded color"></span></a>
                            <a href="#"><span class="shopify-social-icon-pinterest-rounded color"></span></a>
                        </div>
                        <div class="payment-support">
                            <h5>Guaranteed Checkout</h5>
                            <ul class="payment-items">
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/visa.svg" height="35"
                                         alt="visa">
                                </li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/master.svg"
                                         height="35"
                                         alt="master"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/paypal.svg"
                                         height="35"
                                         alt="paypal"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/discover.svg"
                                         height="35"
                                         alt="discover"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/american-express.svg"
                                         height="35"
                                         alt="american express"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/pay.svg" height="35"
                                         alt="shopify pay"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/bitcoin.svg"
                                         height="35"
                                         alt="bitcoin"></li>
                                <li class="payment-item">
                                    <img src="{{asset('')}}/assets/img/icons/google.svg"
                                         height="35"
                                         alt="google pay"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Shop Area ==-->

    <!--== Start Shop Tab Area ==-->
    <section class="product-area product-description-review-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description-review">
                        <ul class="nav nav-tabs product-description-tab-menu" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="product-desc-tab" data-bs-toggle="tab"
                                        data-bs-target="#productDesc" type="button" role="tab"
                                        aria-controls="productDesc" aria-selected="true">Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="product-review-tab" data-bs-toggle="tab"
                                        data-bs-target="#productReview" type="button" role="tab"
                                        aria-controls="productReview" aria-selected="false">Reviews
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="product-comment-tab" data-bs-toggle="tab"
                                        data-bs-target="#commentProduct" type="button" role="tab"
                                        aria-controls="commentProduct" aria-selected="false">Comments
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="product-custom-tab" data-bs-toggle="tab"
                                        data-bs-target="#productCustom" type="button" role="tab"
                                        aria-controls="productCustom" aria-selected="false">Shipping Policy
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="product-info-tab" data-bs-toggle="tab"
                                        data-bs-target="#productInfo" type="button" role="tab"
                                        aria-controls="productInfo" aria-selected="false">Size chart
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content product-description-tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="productDesc" role="tabpanel"
                                 aria-labelledby="product-desc-tab">
                                <div class="product-desc">
                                    {!! $product->body !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productReview" role="tabpanel"
                                 aria-labelledby="product-review-tab">
                                <div class="product-review">
                                    <div class="review-header">
                                        <h4 class="title">Customer Reviews</h4>
                                        <div class="review-info">
                                            <ul class="review-rating">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                            </ul>
                                            <span class="review-caption">Based on 1 review</span>
                                            <span class="review-write-btn">Write a review</span>
                                        </div>
                                    </div>
                                    <div class="product-review-form">
                                        <h4 class="title">Write a review</h4>
                                        <form action="#" method="post">
                                            <div class="review-form-content">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="reviewFormName">Name</label>
                                                            <input class="form-control" id="reviewFormName" type="text"
                                                                   placeholder="Enter your name" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="reviewFormEmail">Email</label>
                                                            <input class="form-control" id="reviewFormEmail"
                                                                   type="email" placeholder="john.smith@example.com"
                                                                   required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="rating">
                                                            <span class="rating-title">Rating</span>
                                                            <span>
                                  <a class="fa fa-star-o" href="#/"></a>
                                  <a class="fa fa-star-o" href="#/"></a>
                                  <a class="fa fa-star-o" href="#/"></a>
                                  <a class="fa fa-star-o" href="#/"></a>
                                  <a class="fa fa-star-o" href="#/"></a>
                                </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="reviewReviewTitle">Review Title</label>
                                                            <input class="form-control" id="reviewReviewTitle"
                                                                   type="text" placeholder="Give your review a title"
                                                                   required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="reviewFormTextarea">Body of Review
                                                                <span>(1500)</span></label>
                                                            <textarea class="form-control textarea"
                                                                      id="reviewFormTextarea" name="comment" rows="7"
                                                                      placeholder="Write your comments here"
                                                                      required=""></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group pull-right">
                                                            <button class="btn btn-theme" type="submit">Submit Review
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="review-content">
                                        <div class="review-item">
                                            <ul class="review-rating">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                            </ul>
                                            <h4 class="title">Cobus Bester</h4>
                                            <h5 class="review-date"><span>Cobus Bester</span> on
                                                <span>Mar 03, 2021</span></h5>
                                            <p>Can’t wait to start mixin’ with this one! Irba-irr-Up-up-up-up-date your
                                                theme!</p>
                                            <a class="review-report" href="#/">Report as Inappropriate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="commentProduct" role="tabpanel"
                                 aria-labelledby="product-comment-tab">
                                <div class="product-comment">
                                    <form action="#">
                                        <div class="product-comment-content">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/comment.png"
                                                 alt="Image-HasTech">
                                            <textarea name="con_message" placeholder="Start the discussion…"></textarea>
                                        </div>
                                        <button class="btn btn-theme" type="submit">Post as Product</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productCustom" role="tabpanel"
                                 aria-labelledby="product-custom-tab">
                                <div class="product-shipping-policy">
                                    <div class="section-title">
                                        <h2 class="title">Shipping policy for our store</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                            nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut
                                            wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                                            lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure
                                            dolor in hendrerit in vulputate</p>
                                    </div>
                                    <ul class="shipping-policy-list">
                                        <li>1-2 business days (Typically by end of day)</li>
                                        <li><a href="#">30 days money back guaranty</a></li>
                                        <li>24/7 live support</li>
                                        <li>odio dignissim qui blandit praesent</li>
                                        <li>luptatum zzril delenit augue duis dolore</li>
                                        <li>te feugait nulla facilisi.</li>
                                    </ul>
                                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming
                                        id quod mazim placerat facer possim assum. Typi non habent claritatem insitam;
                                        est usus legentis in iis qui facit eorum</p>
                                    <p>claritatem. Investigationes demonstraverunt lectores legere me lius quod ii
                                        legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem
                                        consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus
                                        parum claram, anteposuerit litterarum formas humanitatis per</p>
                                    <p>seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                        parum clari, fiant sollemnes in futurum.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productInfo" role="tabpanel"
                                 aria-labelledby="product-info-tab">
                                <div class="product-size-chart">
                                    <h4>Size Chart</h4>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="cun-name"><span>UK</span></td>
                                            <td>18</td>
                                            <td>20</td>
                                            <td>22</td>
                                            <td>24</td>
                                            <td>26</td>
                                        </tr>
                                        <tr>
                                            <td class="cun-name"><span>European</span></td>
                                            <td>46</td>
                                            <td>48</td>
                                            <td>50</td>
                                            <td>52</td>
                                            <td>54</td>
                                        </tr>
                                        <tr>
                                            <td class="cun-name"><span>usa</span></td>
                                            <td>14</td>
                                            <td>16</td>
                                            <td>18</td>
                                            <td>20</td>
                                            <td>22</td>
                                        </tr>
                                        <tr>
                                            <td class="cun-name"><span>Australia</span></td>
                                            <td>28</td>
                                            <td>10</td>
                                            <td>12</td>
                                            <td>14</td>
                                            <td>16</td>
                                        </tr>
                                        <tr>
                                            <td class="cun-name"><span>Canada</span></td>
                                            <td>24</td>
                                            <td>18</td>
                                            <td>14</td>
                                            <td>42</td>
                                            <td>36</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Shop Tab Area ==-->

    <!--== Start Popular Products Area Wrapper ==-->
    {{--<section class="product-area similar-product-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="section-title">
                        <h2 class="title title-style2">Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container product4-slider-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/9.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Demo product title</a></h4>
                                        <div class="prices">
                                            <span class="price">$29.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/14.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-hot">Sale</span>
                                            <span class="ribbon ribbon-onsale align-right">-27%</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy text for title</a>
                                        </h4>
                                        <div class="prices">
                                            <span class="price">$55.00</span>
                                            <span class="price-old">$75.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/15.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-hot">Sale</span>
                                            <span class="ribbon ribbon-onsale align-right">-18%</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy text for title</a>
                                        </h4>
                                        <div class="prices">
                                            <span class="price">$70.00</span>
                                            <span class="price-old">$85.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/6.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-onsale align-right">New</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy product name</a></h4>
                                        <div class="prices">
                                            <span class="price">$80.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--== End Popular Products Area Wrapper ==-->

    <!--== Start Popular Products Area Wrapper ==-->
    {{--<section class="product-area similar-product-area pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="section-title">
                        <h2 class="title title-style2">You May Like Also</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container product4-slider-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/9.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Demo product title</a></h4>
                                        <div class="prices">
                                            <span class="price">$29.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/14.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-hot">Sale</span>
                                            <span class="ribbon ribbon-onsale align-right">-27%</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy text for title</a>
                                        </h4>
                                        <div class="prices">
                                            <span class="price">$55.00</span>
                                            <span class="price-old">$75.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/15.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-hot">Sale</span>
                                            <span class="ribbon ribbon-onsale align-right">-18%</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy text for title</a>
                                        </h4>
                                        <div class="prices">
                                            <span class="price">$70.00</span>
                                            <span class="price-old">$85.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                            <div class="swiper-slide">
                                <!-- Start Product Item -->
                                <div class="product-item">
                                    <div class="product-thumb">
                                        <a href="shop-single-product.html">
                                            <img src="{{asset('')}}/{{asset('')}}/assets/img/shop/6.jpg"
                                                 alt="Olivine-Shop">
                                        </a>
                                        <div class="ribbons">
                                            <span class="ribbon ribbon-onsale align-right">New</span>
                                        </div>
                                        <div class="product-action">
                                            <a class="action-cart" href="#/">
                                                <i class="icofont-shopping-cart"></i>
                                            </a>
                                            <a class="action-quick-view" href="#/" title="Wishlist">
                                                <i class="icon-zoom"></i>
                                            </a>
                                            <a class="action-compare" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-compare"></i>
                                            </a>
                                            <a class="action-wishlist" href="javascript:void(0);" title="Quick View">
                                                <i class="icon-heart-empty"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="title"><a href="shop-single-product.html">Dummy product name</a></h4>
                                        <div class="prices">
                                            <span class="price">$80.00</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Item -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--== End Popular Products Area Wrapper ==-->

@endsection

@push('js')



    {{--<script>
        let thumb = document.querySelector('img.thumb');
        let imgSmall = document.querySelectorAll('img.img-small');

        imgSmall.forEach(function(el) {
             el.addEventListener('click', function() {
                thumb.src = el.src;
             });
        });
    </script> --}}
    <script>
        $('#img_01').ezPlus({
            gallery: 'gal1', cursor: 'pointer', galleryActiveClass: 'active',
            imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
        });

        //pass the images to Fancybox
        $('#img_01').bind('click', function (e) {
            var ez = $('#img_01').data('ezPlus');
            $.fancyboxPlus(ez.getGalleryList());
            return false;
        });
    </script>
@endpush
@push('css')
    <style>
        /*set a border on the images to prevent shifting*/
        #gallery_01 img {
            border: 2px solid white;
        }

        /*Change the colour*/
        .active img {
            border: 2px solid #333 !important;
        }
    </style>
@endpush
@push('metadata')
    <meta name="description" content="{{strip_tags($product->body,0)}}"/>
    <meta name="keywords" content="{{str_replace(' ',',',$product->description)}}"/>

    <meta property="og:locale" content="pt_BR">
    <meta property="og:image"
          content="{{asset('storage/' . $product->thumb)}}">
    <meta property="og:image:width" content="900">
    <meta property="og:image:height" content="900">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:title" content="{{$product->name}}">
    <meta property="og:site_name" content="{{config('metadata.name')}}">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{$product->description}}">
    <script type="application/ld+json">
        {!! collect([
      "@context"=> "https://schema.org/",
      "@type" =>"Product",
      "name"=> $product->name,
      "description"=> $product->description,
      "image"=> [
        asset('storage/' . $product->thumb),
       ],
      /*"brand"=> [
        "@type"=> "Brand",
        "name"=> "ACME"
      ],*/
      "offers"=> [
        "@type"=> "Offer",
        "url"=> url()->current(),
        "priceCurrency"=> "BRL",
        "price"=> $product->price,
        "priceValidUntil"=> $product->created_at,
        "itemCondition"=> "https://schema.org/UsedCondition",
        "availability"=> "https://schema.org/InStock"
      ]
    ])->toJson() !!}
    </script>
@endpush
