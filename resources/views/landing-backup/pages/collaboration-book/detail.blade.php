@extends('landing.layouts.app')

@push('styles')
<style>
    .timeline-container {
            padding: 40px 20px;
        }
        .timeline-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }
        .timeline-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .timeline-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 40px;
            left: 50%;
            width: 100%;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 1;
        }
        .timeline-content {
            margin-top: 20px;
            text-align: center;
        }
        .timeline-title {
            font-size: 16px;
            font-weight: 600;
            color: #5f6368;
            margin-bottom: 5px;
        }
        .timeline-subtitle {
            font-size: 14px;
            color: #9e9e9e;
            margin: 0;
        }
        @media (max-width: 768px) {
            .timeline-wrapper {
                flex-direction: column;
                align-items: center;
            }
            .timeline-item {
                margin-bottom: 40px;
                width: 100%;
            }
            .timeline-item:not(:last-child)::after {
                top: 80px;
                left: 40px;
                width: 2px;
                height: 60px;
            }
        }
</style>
@endpush

@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Riset Indonesia</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Katalog</a></li>
                    <li class="breadcrumb-item active">Riset Indonesia</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-md-12">
                <div class="timeline-container">
                    <div class="timeline-wrapper">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Kolaborasi</div>
                                <div class="timeline-subtitle">16 / 14</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Upload Naskah</div>
                                <div class="timeline-subtitle">0/14</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Editing Naskah</div>
                                <div class="timeline-subtitle">Oleh Editor</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Input ISBN</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Buku Publish</div>
                                <div class="timeline-subtitle">created</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 class="product_title"><a href="#">Buku Riset Indonesia</a></h4>
                        <div class="product_price d-flex flex-column">
                            <small>Politik</small>
                        </div>
                        <div class="pr_desc">
                            <hr>
                            <div class="row shop_container grid">
                                @for ($i = 1; $i <= 12; $i++)
                                <div class="col-lg-3 col-md-3 col-6">
                                    <div class="product_box text-center">
                                        <div class="product_img">
                                            <a href="shop-product-detail.html">
                                                <img src="https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="furniture_img1">
                                            </a>
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title"><a href="shop-product-detail.html">BAB <?= $i ?></a></h6>
                                            <p>Klasifikasi Beton</p>
                                            <div class="product_price">
                                                <span class="price">Rp. 100.000</span>
                                            </div>
                                            <div class="add-to-cart">
                                                <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Gabung</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor
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