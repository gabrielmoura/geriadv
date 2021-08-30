<!--== Scroll Top Button ==-->
<div class="scroll-to-top"><span class="icofont-arrow-up"></span></div>

<!--== Start Quick View Menu ==-->
<aside class="product-quick-view-modal">
    <div class="product-quick-view-inner">
        <div class="product-quick-view-content">
            <button type="button" class="btn-close">
                <span class="close-icon"><i class="fa fa-times-circle"></i></span>
            </button>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="thumb">
                        <img src="{{asset('')}}/images/shop/quick-view1.webp" alt="Olivine-Shop">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="content">
                        <h4 class="title">Product dummy title</h4>
                        <div class="prices">
                            <del class="price-old">$167.540</del>
                            <span class="price">$141.76</span>
                        </div>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                            piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard
                            McClintock, a Latin professor at Hampden-Sydney College in Virginia,</p>
                        <div class="quick-view-select">
                            <div class="quick-view-select-item">
                                <label for="forSize" class="form-label">Size:</label>
                                <select class="form-select" id="forSize" required>
                                    <option selected value="">s</option>
                                    <option>m</option>
                                    <option>l</option>
                                    <option>xl</option>
                                </select>
                            </div>
                            <div class="quick-view-select-item">
                                <label for="forColor" class="form-label">Color:</label>
                                <select class="form-select" id="forColor" required>
                                    <option selected value="">red</option>
                                    <option>green</option>
                                    <option>blue</option>
                                    <option>yellow</option>
                                    <option>white</option>
                                </select>
                            </div>
                        </div>
                        <div class="action-top">
                            <div class="pro-qty">
                                <input type="text" id="quantity2" title="Quantity" value="1"/>
                            </div>
                            <button class="btn btn-black">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="canvas-overlay"></div>
</aside>
<!--== End Quick View Menu ==-->

<!--== Start Sidebar Cart Menu ==-->
<aside class="sidebar-cart-modal">
    <div class="sidebar-cart-inner">
        <div class="sidebar-cart-content">
            <a class="cart-close" href="javascript:void(0);"><i class="icofont-close-line"></i></a>
            <div class="sidebar-cart">
                <h4 class="sidebar-cart-title">Shopping Cart</h4>
                <div class="product-cart">
                    <div class="product-cart-item">
                        <div class="product-img">
                            <a href="shop.html"><img src="{{asset('')}}/images/shop/cart/1.webp" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="shop.html">Product title here</a></h4>
                            <span class="info">1 × $50.00</span>
                        </div>
                        <div class="product-delete"><a href="#/">×</a></div>
                    </div>
                    <div class="product-cart-item">
                        <div class="product-img">
                            <a href="shop.html"><img src="{{asset('')}}/images/shop/cart/2.webp" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="shop.html">Product dummy title - s</a></h4>
                            <span class="info">1 × $79.00</span>
                        </div>
                        <div class="product-delete"><a href="#/">×</a></div>
                    </div>
                </div>
                <div class="cart-total">
                    <h4>Total: <span class="money">$129.00</span></h4>
                </div>
                <div class="cart-checkout-btn">
                    <a class="btn-theme" href="shop-cart.html">View Cart</a>
                    <a class="btn-theme" href="shop-checkout.html">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</aside>
<!--== End Sidebar Cart Menu ==-->

<!--== Start Side Menu ==-->
<aside class="off-canvas-wrapper">
    <div class="off-canvas-inner">
        <div class="off-canvas-overlay d-none"></div>
        <!-- Start Off Canvas Content Wrapper -->
        <div class="off-canvas-content">
            <!-- Off Canvas Header -->
            <div class="off-canvas-header">
                <div class="close-action">
                    <button class="btn-close"><i class="icofont-close-line"></i></button>
                </div>
            </div>

            <div class="off-canvas-item">
                <!-- Start Mobile Menu Wrapper -->
                <div class="res-mobile-menu">
                    <!-- Note Content Auto Generate By Jquery From Main Menu -->
                </div>
                <!-- End Mobile Menu Wrapper -->
            </div>
            <!-- Off Canvas Footer -->
            <div class="off-canvas-footer"></div>
        </div>
        <!-- End Off Canvas Content Wrapper -->
    </div>
</aside>
<!--== End Side Menu ==-->
