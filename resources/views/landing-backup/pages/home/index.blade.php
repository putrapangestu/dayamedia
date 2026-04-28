@extends('landing.layouts.app')

@section('title', 'Beranda - Azzia')

@section('content')

<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active background_bg" data-img-src="assets/images/banner1.jpg">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                        <div class="row">
                            <div class="col-lg-7 col-9">
                                <div class="banner_content overflow-hidden">
                                	<h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Get up to 50% off Today Only!</h5>
                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Woman Fashion</h2>
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTAINER-->
                </div>
            </div>
            <div class="carousel-item background_bg" data-img-src="assets/images/banner2.jpg">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="banner_content overflow-hidden">
                                	<h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">50% off in all products</h5>
                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Man Fashion</h2>
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTAINER-->
                </div>
            </div>
            <div class="carousel-item background_bg" data-img-src="assets/images/banner3.jpg">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="banner_content overflow-hidden">
                                	<h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Taking your Viewing Experience to Next Level</h5>
                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Summer Sale</h2>
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTAINER-->
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev"><i class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next"><i class="ion-chevron-right"></i></a>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- END MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHIPPING INFO -->
<div class="">
    <div class="">
        <div class="row g-0">
            <div class="col-lg-3 col-sm-6">	
                <div class="icon_box icon_box_style3">
                    <div class="icon">
                        <i class="flaticon-shipped"></i>
                    </div>
                    <div class="icon_box_content">
                        <h6>Kolaborasi Penulis</h6>
                        <p>Menulis bersama</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">	
                <div class="icon_box icon_box_style3">
                    <div class="icon">
                        <i class="flaticon-money-back"></i>
                    </div>
                    <div class="icon_box_content">
                        <h6>Royalti Otomatis</h6>
                        <p>Penghasilan pasif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">	
                <div class="icon_box icon_box_style3">
                    <div class="icon">
                        <i class="flaticon-support"></i>
                    </div>
                    <div class="icon_box_content">
                        <h6>Program Afiliasi</h6>
                        <p>Mendapatkan komisi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">	
                <div class="icon_box icon_box_style3">
                    <div class="icon">
                        <i class="flaticon-lock"></i>
                    </div>
                    <div class="icon_box_content">
                        <h6>Dashboard Analytics</h6>
                        <p>Pantau pendapatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START SECTION SHIPPING INFO -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_20">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-6">
                <div class="heading_s3 text-center">
                    <h2>Buku Terbaru</h2>
                </div>
                <div class="small_divider clearfix"></div>
            </div>
		</div>
        <div class="row shop_container">
            @for ($i = 1; $i <= 8; $i++)
            <div class="col-lg-2 col-md-2 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="furniture_img1">
                        </a>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title m-0"><a href="shop-product-detail.html">Riset Indonesia</a></h6>
                        <small style="font-size: 0.7rem;" class="text-muted mb-3">Rikhard Titing Christopher Bolang,dkk</small>
                        <div class="product_price">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="price">Rp. 100.000</span><br>
                                    <small class="text-body-secondary">Harga Buku</small>
                                </div>
                                <div class="col-md-6">
                                    <span class="price">Rp. 50.000</span><br>
                                    <small class="text-body-secondary">Harga E-Book</small>
                                </div>
                            </div>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                        	<a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div> 
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_20">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-6">
                <div class="heading_s3 text-center">
                    <h2>Gabung Buku Kolaborasi</h2>
                </div>
                <div class="small_divider clearfix"></div>
            </div>
		</div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="product_slider carousel_slider owl-carousel owl-theme nav_style4" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "4"}, "1199":{"items": "6"}}'>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="furniture_img1">
                                </a>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">Teknologi Beton</a></h6>
                                <p>Penulis 10/14</p>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Gabung</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->
@endsection
