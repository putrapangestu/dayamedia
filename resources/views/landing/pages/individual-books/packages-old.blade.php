@extends('landing.layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark mb-3">Pilih Paket Buku Individu</h1>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Wujudkan karya impian Anda dengan paket penerbitan profesional kami. Pilih paket yang sesuai dengan kebutuhan Anda.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($packages as $package)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden transition-hover">
                        <div class="card-body p-4 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h3 class="h4 fw-bold text-dark mb-1">{{ $package->name }}</h3>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                        {{ $package->max_authors_default }} Penulis
                                    </span>
                                </div>
                                @if($loop->iteration == 2)
                                    <span class="badge bg-primary text-uppercase tracking-wider shadow-sm" style="font-size: 10px;">Populer</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <span class="h1 fw-black text-dark">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-4">
                                <p class="small fw-bold text-uppercase text-muted tracking-wide mb-3">Apa yang Anda dapatkan:</p>
                                <ul class="list-unstyled">
                                    @foreach($package->benefits as $benefit)
                                        <li class="d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-2">
                                                <iconify-icon icon="solar:check-circle-bold" class="text-success fs-5"></iconify-icon>
                                            </div>
                                            <div>
                                                <span class="d-block fw-medium text-dark">{{ $benefit->benefit_name }}</span>
                                                @if($benefit->benefit_value)
                                                    <small class="text-muted d-block">{{ $benefit->benefit_value }}</small>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="p-4 bg-light border-top border-light">
                            <a href="{{ route('individual-books.purchase', $package) }}"
                               class="btn btn-lg d-grid gap-2 rounded-3 fw-bold {{ $loop->iteration == 2 ? 'btn-primary shadow-sm' : 'btn-outline-primary border-2' }}">
                                Pilih Paket Ini
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <iconify-icon icon="solar:box-minimalistic-broken" class="display-1 text-muted opacity-25 mb-3"></iconify-icon>
                    <p class="h4 text-muted">Belum ada paket tersedia saat ini</p>
                    <p class="text-secondary">Silakan kembali lagi nanti atau hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 bg-white rounded-5 p-4 p-md-5 shadow-sm border">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="fw-bold text-dark mb-4">Mengapa Menerbitkan di Azzia?</h2>
                    <div class="vstack gap-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <iconify-icon icon="solar:verified-check-bold" class="text-primary fs-3"></iconify-icon>
                            </div>
                            <div class="ms-3">
                                <h4 class="h5 fw-bold mb-1">Proses Cepat & Profesional</h4>
                                <p class="text-muted mb-0">Tim editorial kami akan membantu proses penerbitan buku Anda dari awal hingga selesai dengan standar tinggi.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <iconify-icon icon="solar:document-text-bold" class="text-success fs-3"></iconify-icon>
                            </div>
                            <div class="ms-3">
                                <h4 class="h5 fw-bold mb-1">ISBN & Barcode</h4>
                                <p class="text-muted mb-0">Setiap buku yang diterbitkan akan mendapatkan nomor ISBN resmi dan barcode untuk kemudahan distribusi.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <iconify-icon icon="solar:globus-bold" class="text-info fs-3"></iconify-icon>
                            </div>
                            <div class="ms-3">
                                <h4 class="h5 fw-bold mb-1">Jangkauan Luas</h4>
                                <p class="text-muted mb-0">Buku Anda akan dipasarkan melalui berbagai platform digital dan fisik untuk menjangkau lebih banyak pembaca.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 position-relative mt-5 mt-md-0">
                    <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800"
                         alt="Publishing Process" class="img-fluid rounded-4 shadow-lg">
                    <div class="position-absolute bottom-0 start-0 translate-middle-x ms-md-n4 mb-n4 bg-white p-4 rounded-4 shadow border d-none d-md-block" style="max-width: 250px;">
                        <p class="text-primary fw-bold h3 mb-0">1000+</p>
                        <p class="text-muted small mb-0">Buku telah berhasil diterbitkan melalui platform kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .fw-black { font-weight: 900; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
