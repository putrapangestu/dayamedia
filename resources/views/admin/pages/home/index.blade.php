@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
            <div class="card-body position-relative">
                <div class="row">
                <div class="col-sm-7">
                    <div class="d-flex align-items-center mb-7">
                    <div class="rounded-circle overflow-hidden me-6">
                        <img src="{{ asset('') }}assets/dashboard/images/profile/user-1.jpg" alt="modernize-img" width="40" height="40">
                    </div>
                    <h5 class="fw-semibold mb-0 fs-5">Selamat Datang, {{ auth()->user()->full_name }}!</h5>
                    </div>
                    <div class="d-flex align-items-center">
                    <div class="border-end pe-4 border-muted border-opacity-10">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                            {{ $userCount }}
                        </h3>
                        <p class="mb-0 text-dark">Pengguna Daya Media</p>
                    </div>
                    <div class="ps-4 pe-4 border-end border-muted border-opacity-10">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                            {{ $bookCount }}
                        </h3>
                        <p class="mb-0 text-dark">Buku Terpublish</p>
                    </div>
                    <div class="ps-4 pe-4 border-end border-muted border-opacity-10">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                            {{ $transactionCount }}
                        </h3>
                        <p class="mb-0 text-dark">Jumlah Transaksi Belum Dikonfirmasi</p>
                    </div>
                    <div class="ps-4">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                            {{ $withdrawCount }}
                        </h3>
                        <p class="mb-0 text-dark">Jumlah Permintaan Withdrawl</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="welcome-bg-img mb-n7 text-end">
                    <img src="{{ asset('') }}assets/dashboard/images/backgrounds/welcome-bg.svg" alt="modernize-img" class="img-fluid">
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
            <div class="card-body">
                <div>
                <h4 class="card-title fw-semibold">Pendapatan</h4>
                <p class="card-subtitle mb-3">Grafik Pendapatan</p>

                <form action="{{ route('admin.home') }}" method="GET" class="mb-4">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label for="filter_type" class="form-label small text-muted">Filter Berdasarkan</label>
                            <select name="filter_type" id="filter_type" class="form-select form-select-sm" onchange="toggleMonthSelect()">
                                <option value="yearly" {{ $filterType == 'yearly' ? 'selected' : '' }}>Per Tahun</option>
                                <option value="monthly" {{ $filterType == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label small text-muted">Tahun</label>
                            <select name="year" id="year" class="form-select form-select-sm">
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3" id="month_container" style="{{ $filterType == 'yearly' ? 'display:none;' : '' }}">
                            <label for="month" class="form-label small text-muted">Bulan</label>
                            <select name="month" id="month" class="form-select form-select-sm">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-4">
                                <i class="ti ti-filter me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>

                <div id="salary" class="mb-4 pb-4"></div>

                <div class="row">
                    <!-- Total Omset -->
                    <div class="col-sm-6 col-lg-4 col-xl mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-2 me-3 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-currency-dollar fs-6"></i>
                            </div>
                            <div>
                                <p class="fs-3 mb-0 fw-normal text-muted">Total Omset</p>
                                <h6 class="fw-bold text-dark fs-5 mb-0">Rp. {{ number_format($transactionSummary, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Buku Individu -->
                    <div class="col-sm-6 col-lg-4 col-xl mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success-subtle text-success rounded-2 me-3 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-user fs-6"></i>
                            </div>
                            <div>
                                <p class="fs-3 mb-0 fw-normal text-muted">Buku Individu</p>
                                <h6 class="fw-bold text-dark fs-5 mb-0">Rp. {{ number_format($revenueIndividualMonth ?? 0, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Buku Kolaborasi -->
                    <div class="col-sm-6 col-lg-4 col-xl mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning-subtle text-warning rounded-2 me-3 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-users fs-6"></i>
                            </div>
                            <div>
                                <p class="fs-3 mb-0 fw-normal text-muted">Buku Kolaborasi</p>
                                <h6 class="fw-bold text-dark fs-5 mb-0">Rp. {{ number_format($revenueCollaborationMonth ?? 0, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Penjualan Ebook -->
                    <div class="col-sm-6 col-lg-4 col-xl mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-info-subtle text-info rounded-2 me-3 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-device-tablet fs-6"></i>
                            </div>
                            <div>
                                <p class="fs-3 mb-0 fw-normal text-muted">Penjualan Ebook</p>
                                <h6 class="fw-bold text-dark fs-5 mb-0">Rp. {{ number_format($revenueEbookMonth ?? 0, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Penjualan Buku Cetak -->
                    <div class="col-sm-6 col-lg-4 col-xl mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger-subtle text-danger rounded-2 me-3 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-book fs-6"></i>
                            </div>
                            <div>
                                <p class="fs-3 mb-0 fw-normal text-muted">Buku Cetak</p>
                                <h6 class="fw-bold text-dark fs-5 mb-0">Rp. {{ number_format($revenuePhysicalMonth ?? 0, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                <div class="mb-3 mb-sm-0">
                    <h4 class="card-title fw-semibold">Buku Kolaborasi</h4>
                    <p class="card-subtitle">Buku kolaborasi tidak segera penuh</p>
                </div>
                </div>
                <div class="table-responsive">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                    <tr class="text-muted fw-semibold">
                        <th scope="col" class="ps-0">Buku</th>
                        <th scope="col">Kolaborator</th>
                        <th scope="col">Tanggal Dibuat</th>
                    </tr>
                    </thead>
                    <tbody class="border-top">
                        @forelse($books as $book)
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 pe-1">
                                            <img src="{{ asset('storage/' . $book->cover) }}" class="rounded-2" width="48" height="48" alt="modernize-img" />
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">{{ $book->title }}</h6>
                                            <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $book->category?->name ?? "-" }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 fs-3 text-dark">{{ $book->filled_authors_count }} / {{ $book->total_authors_count }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 fs-3 text-dark">{{ $book->created_at->format('d F Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <p class="mb-0 fs-4 text-dark">Tidak ada buku dalam kolaborasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('') }}assets/dashboard/libs/apexcharts/dist/apexcharts.min.js"></script>
    {{-- <script src="{{ asset('') }}assets/dashboard/js/dashboards/dashboard2.js"></script> --}}
    <script>
        function toggleMonthSelect() {
            var filterType = document.getElementById('filter_type').value;
            var monthContainer = document.getElementById('month_container');
            if (filterType === 'monthly') {
                monthContainer.style.display = 'block';
            } else {
                monthContainer.style.display = 'none';
            }
        }

        // =====================================
        // Salary 6 Month
        // =====================================
        var salaryData = @json($salaryData);
        var highlightIndex = {{ $currentHighlightIndex }};
        var colors = salaryData.map((_, index) => {
            return index === highlightIndex ? "var(--bs-primary)" : "var(--bs-primary-bg-subtle)";
        });

        var options = {
            series: [
                {
                    name: "Pendapatan",
                    data: salaryData,
                },
            ],

            chart: {
                toolbar: {
                    show: false,
                },
                height: 250,
                type: "bar",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
            },
            colors: colors,
            plotOptions: {
                bar: {
                    borderRadius: 5,
                    columnWidth: "45%",
                    distributed: true,
                    endingShape: "rounded",
                },
            },

            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            grid: {
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
            },
            xaxis: {
                categories: @json($salaryLabels),
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                labels: {
                    show: false,
                },
            },
            tooltip: {
                theme: "dark",
                y: {
                    formatter: function (value) {
                        return "Rp. " + value.toLocaleString('id-ID');
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#salary"), options);
        chart.render();
    </script>
@endpush
