@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden">
    <!-- Hero Section -->
    <section class="bg-primary-subtle py-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bolder text-dark mb-3">Tentang Kami</h1>
                    <p class="fs-4 text-muted mb-4">Menjadi jembatan ilmu melalui publikasi berkualitas dan kolaborasi penulis yang inovatif.</p>
                    <div class="d-flex gap-3">
                        <div class="bg-white p-3 rounded-4 shadow-sm border d-flex align-items-center gap-3">
                            <div class="bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="ti ti-certificate text-white fs-6"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block uppercase fw-bold fs-1">Terdaftar IKAPI</small>
                                <span class="fw-bold text-dark">051/SBA/2024</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('assets/dashboard/images/backgrounds/welcome-bg.svg') }}" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="mb-5">
                        <h2 class="fw-bolder text-dark mb-4">Visi & Misi</h2>
                        <p class="text-muted lh-lg">
                            Azzia hadir sebagai platform penerbitan modern yang berkomitmen untuk mendukung ekosistem literasi di Indonesia. Kami percaya bahwa setiap ide layak untuk diterbitkan dan setiap penulis memiliki potensi untuk menginspirasi dunia.
                        </p>
                        <p class="text-muted lh-lg">
                            Sebagai anggota resmi <strong>IKAPI (Ikatan Penerbit Indonesia)</strong> dengan nomor <strong>051/SBA/2024</strong>, kami menjamin standar profesionalisme dan legalitas dalam setiap karya yang kami terbitkan. Kami fokus pada kemudahan proses publikasi, transparansi royalti, dan inovasi kolaborasi antar penulis.
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                                <div class="card-body">
                                    <div class="bg-primary-subtle rounded-3 p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                        <i class="ti ti-rocket fs-7 text-primary"></i>
                                    </div>
                                    <h5 class="fw-bolder">Inovasi</h5>
                                    <p class="text-muted fs-2 mb-0">Mengembangkan sistem kolaborasi bab buku yang memudahkan penulis untuk berkarya bersama.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                                <div class="card-body">
                                    <div class="bg-success-subtle rounded-3 p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                        <i class="ti ti-shield-check fs-7 text-success"></i>
                                    </div>
                                    <h5 class="fw-bolder">Kualitas</h5>
                                    <p class="text-muted fs-2 mb-0">Menjamin proses editing dan layouting profesional untuk setiap naskah yang masuk.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-xl-5">
                            <h3 class="fw-bolder text-dark mb-4">Hubungi Kami</h3>

                            <div class="d-flex flex-column gap-4">
                                <div class="d-flex gap-3">
                                    <div class="bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="min-width: 55px; height: 55px;">
                                        <i class="ti ti-map-pin fs-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Alamat Kantor</h6>
                                        <p class="text-muted fs-2 mb-0">Perumahan Griya Anak Air Permai Blok B19, Batipuh Panjang, Koto Tangah, Kota Padang, Sumatera Barat</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <div class="bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="min-width: 55px; height: 55px;">
                                        <i class="ti ti-phone fs-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Layanan Admin</h6>
                                        <p class="text-muted fs-2 mb-1"> <a href="https://wa.me/6281166012020" target="_blank">+62 823-3339-0205</a></p>
                                        <p class="text-muted fs-2 mb-0"> <a href="https://wa.me/6282333390206" target="_blank">+62 823-3339-0206</a></p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <div class="bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="min-width: 55px; height: 55px;">
                                        <i class="ti ti-mail fs-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email Dukungan</h6>
                                        <p class="text-muted fs-2 mb-0">support@azzia.id</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 opacity-50">

                            <div class="bg-primary rounded-4 p-4 text-white">
                                <h6 class="text-white fw-bold mb-2">Jam Operasional</h6>
                                <div class="d-flex justify-content-between fs-2 mb-1">
                                    <span>Senin - Jumat</span>
                                    <span>08:00 - 17:00 WIB</span>
                                </div>
                                <div class="d-flex justify-content-between fs-2">
                                    <span>Sabtu</span>
                                    <span>08:00 - 13:00 WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
