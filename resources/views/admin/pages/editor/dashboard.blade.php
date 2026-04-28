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
                                            {{ $claimedBooksCount }}
                                        </h3>
                                        <p class="mb-0 text-dark">Buku Diklaim</p>
                                    </div>
                                    <div class="ps-4 pe-4 border-end border-muted border-opacity-10">
                                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                            {{ $completedBooksCount }}
                                        </h3>
                                        <p class="mb-0 text-dark">Buku Selesai Diedit</p>
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

            <!-- Performance Chart -->
            <div class="col-md-6 col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title fw-semibold">Performa Edit (Tahun Ini)</h4>
                            <p class="card-subtitle">Jumlah buku yang diselesaikan per bulan</p>
                            <div id="performance-chart" class="mb-7 pb-8 mx-n4"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                            <div class="mb-3 mb-sm-0">
                                <h4 class="card-title fw-semibold">Proyek Aktif</h4>
                                <p class="card-subtitle">Buku yang sedang Anda kerjakan</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0">
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th scope="col" class="ps-0">Buku</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    @forelse($activeProjects as $project)
                                        <tr>
                                            <td class="ps-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 pe-1">
                                                        <img src="{{ asset('storage/' . $project->book->cover) }}" class="rounded-2" width="48" height="48" alt="cover" />
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">{{ $project->book->title }}</h6>
                                                        <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $project->book->category?->name ?? "-" }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ \App\Helpers\StatusHelper::getBookEditorStatusBadge($project->status) }}">
                                                    {{ \App\Helpers\StatusHelper::getStatusText($project->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <p class="mb-0 fs-4 text-dark">Tidak ada proyek aktif.</p>
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
<script>
    var options = {
        series: [
            {
                name: "Buku Selesai",
                data: @json($chartData),
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            height: 300,
            type: "bar",
            fontFamily: "inherit",
            foreColor: "#adb0bb",
        },
        colors: ["var(--bs-primary)"],
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
            categories: @json($chartLabels),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: true,
            },
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart = new ApexCharts(document.querySelector("#performance-chart"), options);
    chart.render();
</script>
@endpush
