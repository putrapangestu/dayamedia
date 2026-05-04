<div class="row">
    <div class="col-md-12 col-12">
        <div class="card shadow-none border">
            <div class="card-header">
                <h4 class="card-title mb-0">Target Afiliasi</h4>
            </div>
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="card shadow-none border">
            <div class="card-body row">
                <h4 class="mb-3">Riwayat Transaksi Affiliasi</h4>
                <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Affiliator</th>
                                <th>Komisi</th>
                                <th>Affiliator / Royalti</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            @forelse ($commissionHistories as $commissionHistory)
                                <tr>
                                    <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $commissionHistories->perPage(), $commissionHistories->currentPage()) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-1 fw-bolder">{{ $commissionHistory->transaction->transaction_code }}</h6>
                                                <p class="mb-1 text-muted fs-2">{{ $commissionHistory->transaction->user->full_name }}</p>
                                                <span class="mb-1 badge fs-2 bg-info-subtle text-info">{{ $commissionHistory->transaction->created_at->format('d F Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-1">{{ $commissionHistory->transaction->user->full_name }}</h6>
                                                <p class="mb-1 text-muted fs-2">Tingkat: {{ $commissionHistory->transaction->user->affiliateLevel?->name ?? 'Tidak Ada' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <h6 class="fw-bolder">Rp. {{ number_format($commissionHistory->amount, 0, ',', '.') }}</h6>
                                    </td>
                                    <td>
                                        @if ($commissionHistory->type == 'royalti')
                                            Royalti
                                        @else
                                            Affiliator
                                        @endif
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($commissionHistory->created_at)->format('d F Y H:i:s') }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                                data-bs-reference="viewport" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-4"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                <li>
                                                    <a class="dropdown-item btn-detail-commission" href="javascript:void(0)"
                                                        data-code="{{ $commissionHistory->transaction->transaction_code }}"
                                                        data-user="{{ $commissionHistory->transaction->user->full_name }}"
                                                        data-amount="Rp {{ number_format($commissionHistory->amount, 0, ',', '.') }}"
                                                        data-type="{{ $commissionHistory->type == 'royalti' ? 'Royalti' : 'Affiliator' }}"
                                                        data-date="{{ Carbon\Carbon::parse($commissionHistory->created_at)->format('d F Y H:i:s') }}"
                                                        data-items="{{ json_encode($commissionHistory->transaction->details->map(function($detail) {
                                                            return [
                                                                'name' => $detail->book->title ?? ($detail->module->title ?? 'Item'),
                                                                'price' => 'Rp ' . number_format($detail->price_book, 0, ',', '.')
                                                            ];
                                                        })) }}">
                                                        <i class="ti ti-eye me-1 fs-4"></i>Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada riwayat komisi affiliasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Affiliator</th>
                                <th>Komisi</th>
                                <th>Affiliator / Royalti</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
                <div class="mt-3">{{ $commissionHistories->links() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCommissionDetail" tabindex="-1" aria-labelledby="modalCommissionDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title text-white" id="modalCommissionDetailLabel">Detail Komisi & Royalti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-primary-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="ti ti-receipt fs-7 text-primary"></i>
                    </div>
                    <h4 class="fw-bolder mb-1" id="detail-amount"></h4>
                    <span class="badge bg-success-subtle text-success px-3 rounded-pill" id="detail-type"></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-borderless align-middle">
                        <tbody>
                            <tr>
                                <td class="text-muted py-2" style="width: 40%;">Kode Transaksi</td>
                                <td class="fw-bold py-2 text-dark" id="detail-code"></td>
                            </tr>
                            <tr>
                                <td class="text-muted py-2">Pembeli</td>
                                <td class="fw-bold py-2 text-dark" id="detail-user"></td>
                            </tr>
                            <tr>
                                <td class="text-muted py-2">Waktu</td>
                                <td class="fw-bold py-2 text-dark" id="detail-date"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr class="my-3 opacity-50">

                <h6 class="fw-bolder mb-3 text-dark">Item Terjual</h6>
                <div id="detail-items-list" class="d-flex flex-column gap-2">
                    <!-- Items will be injected here -->
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light-danger text-danger w-100 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('') }}assets/dashboard/libs/apexcharts/dist/apexcharts.min.js"></script>
<script>
    let affiliateLevels = @json($affiliateLevels);

    const goals = [];
    const colors = ['#EE128C', '#FFD700', '#E5E4E2'];
    for (let $index = 0; $index < affiliateLevels.length; $index++) {
        const affiliateLevel = affiliateLevels[$index];
        goals.push({
            name: 'Target ' + affiliateLevel.name,
            value: affiliateLevel.min_earning,
            strokeHeight: 100,
            strokeColor: colors[$index]
        });
    }

    $(document).ready(function() {
        var options = {
            series: [{
                name: 'Pendapatan Omset',
                data: [{
                    x: 'Total Omset',
                    y: {{ $commissionTotalMonth }},
                    goals: goals
                }]
            }],
            chart: {
                height: 180, // ✅ Dikurangi dari 350 jadi 180
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '60%', // ✅ Control tinggi bar (default 70%)
                    borderRadius: 8
                }
            },
            colors: ['#EE128C'],
            dataLabels: {
                enabled: true,
                formatter: function(val, opt) {
                    const goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex].goals;

                    if (goals && goals.length) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                },
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                }
            },
            xaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000000).toFixed(0) + 'jt';
                    },
                    style: {
                        fontSize: '11px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 600
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 0,
                    right: 10,
                    bottom: 0,
                    left: 10
                }
            },
            legend: {
                show: true,
                showForSingleSeries: true,
                customLegendItems: goals.map(goal => 'Target ' + goal.name + ' (Rp ' + new Intl.NumberFormat('id-ID').format(goal.value) + ')'),
                markers: {
                    fillColors: colors
                },
                fontSize: '12px',
                position: 'top',
                horizontalAlign: 'right'
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: function(val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                },
                style: {
                    fontSize: '12px'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        $('.btn-detail-commission').on('click', function() {
            const data = $(this).data();
            const items = data.items;

            $('#detail-code').text(data.code);
            $('#detail-user').text(data.user);
            $('#detail-amount').text(data.amount);
            $('#detail-type').text(data.type);
            $('#detail-date').text(data.date);

            let itemsHtml = '';
            items.forEach(item => {
                itemsHtml += `
                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded p-2 border">
                                <i class="ti ti-book text-primary fs-5"></i>
                            </div>
                            <span class="fw-bold text-dark fs-2 text-truncate" style="max-width: 200px;">${item.name}</span>
                        </div>
                        <span class="text-primary fw-bolder">${item.price}</span>
                    </div>
                `;
            });

            $('#detail-items-list').html(itemsHtml);
            $('#modalCommissionDetail').modal('show');
        });
    });
</script>
@endpush
