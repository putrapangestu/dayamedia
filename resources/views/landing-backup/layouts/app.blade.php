<!DOCTYPE html>
<html lang="en">

<!-- Mirrored by HTTrack Website Copier/3.x [XR/YP'2000] -->
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
<meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

<!-- SITE TITLE -->
<title>@yield('title')</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}assets/landing/images/favicon.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/animate.css">	
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet"> 
<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/all.min.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/themify-icons.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/linearicons.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/flaticon.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/simple-line-icons.css">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/owlcarousel/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/magnific-popup.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/slick.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/style.css">
<link rel="stylesheet" href="{{ asset('') }}assets/landing/css/responsive.css">

@stack('styles')
</head>

<body>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END LOADER -->

<!-- Home Popup Section -->
<!-- <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s3 text-center">
                                    <h4>Subscribe and Get 25% Discount!</h4>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post" class="rounded_input">
                            	<div class="form-group mb-3">
                                	<input name="email" required type="email" class="form-control" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group mb-3">
                                	<button class="btn btn-fill-line btn-block text-uppercase btn-radius" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div> -->
<!-- End Screen Load Popup Section --> 

<!-- START HEADER -->
@include('landing.partials.header')
<!-- END HEADER -->

<!-- content  -->
@yield('content')
<!-- end content  -->

<!-- START FOOTER -->
@include('landing.partials.footer')
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 

<!-- Latest jQuery --> 
<script src="{{ asset('') }}assets/landing/js/jquery-3.7.0.min.js"></script> 
<!-- popper min js -->
<script src="{{ asset('') }}assets/landing/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap --> 
<script src="{{ asset('') }}assets/landing/bootstrap/js/bootstrap.min.js"></script> 
<!-- owl-carousel min js  --> 
<script src="{{ asset('') }}assets/landing/owlcarousel/js/owl.carousel.min.js"></script> 
<!-- magnific-popup min js  --> 
<script src="{{ asset('') }}assets/landing/js/magnific-popup.min.js"></script> 
<!-- waypoints min js  --> 
<script src="{{ asset('') }}assets/landing/js/waypoints.min.js"></script> 
<!-- parallax js  --> 
<script src="{{ asset('') }}assets/landing/js/parallax.js"></script> 
<!-- countdown js  --> 
<script src="{{ asset('') }}assets/landing/js/jquery.countdown.min.js"></script> 
<!-- imagesloaded js --> 
<script src="{{ asset('') }}assets/landing/js/imagesloaded.pkgd.min.js"></script>
<!-- isotope min js --> 
<script src="{{ asset('') }}assets/landing/js/isotope.min.js"></script>
<!-- jquery.dd.min js -->
<script src="{{ asset('') }}assets/landing/js/jquery.dd.min.js"></script>
<!-- slick js -->
<script src="{{ asset('') }}assets/landing/js/slick.min.js"></script>
<!-- elevatezoom js -->
<script src="{{ asset('') }}assets/landing/js/jquery.elevatezoom.js"></script>
<!-- scripts js --> 
<script src="{{ asset('') }}assets/landing/js/scripts.js"></script>

</body>

<!-- Mirrored by HTTrack Website Copier/3.x [XR/YP'2000] -->
</html>