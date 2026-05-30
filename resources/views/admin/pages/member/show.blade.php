@extends('admin.layouts.app')

@section('title', 'Detail Member')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Detail Member"
            description="Ringkasan aktivitas dan kepemilikan {{ $member->full_name }}"
        >
            <x-slot:actions>
                <a href="{{ route('admin.member.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.member.edit', $member->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit"></i> Edit Member
                </a>
            </x-slot:actions>
        </x-header-page>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $member->full_name }}</h4>
                                <p class="mb-1 text-muted">{{ $member->email }}</p>
                                <span class="badge {{ $member->email_verified_at ? 'bg-success' : 'bg-danger' }}">
                                    {{ $member->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="text-end">
                                <div class="mb-2">
                                    <p class="mb-0 text-muted fs-2">Kode Referal</p>
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <h5 class="mb-0">{{ $member->referral_code ?? '-' }}</h5>
                                        @if($member->referral_code)
                                            <button class="btn btn-sm btn-outline-primary link-referral" data-referral="{{ $member->referral_code }}" title="Salin Kode Referal">
                                                <i class="ti ti-copy"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0">Saldo:</p>
                                    <h6 class="fw-bolder">Rp {{ number_format($member->balance, 0, ',', '.') }}</h6>
                                </div>
                                <div>
                                    <p class="mb-0">Tingkat Affiliate:</p>
                                    <h6 class="fw-bolder">{{ $member->affiliateLevel?->name ?? '-' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Target Afiliasi (Bulan Ini)</h4>
                        <span class="badge bg-info-subtle text-info">Omset: Rp {{ number_format($commissionTotalMonth, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h4 class="mb-3">Riwayat Transaksi</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penjualan</th>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $transactions->perPage(), $transactions->currentPage()) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h6 class="mb-1 fw-bolder">{{ $transaction->transaction_code }}</h6>
                                                        <span class="mb-1 badge fs-2 bg-info-subtle text-info">{{ $transaction->created_at->format('d F Y') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach ($transaction->details as $detail)
                                                        <li>
                                                            {{ $detail->book->title ?? ('BAB '.$detail->module->chapter.': '.$detail->module->title) }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge {{ $transaction->status == 'paid' ? 'bg-success' : ($transaction->status == 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transaction->created_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada riwayat transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">{{ $transactions->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h4 class="mb-3">Kepemilikan Buku</h4>
                        <div class="row">
                            @forelse ($ownedBooks as $book)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm h-100 mb-0">
                                        <div class="position-relative">
                                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('assets/daya-media-logo.png') }}" class="card-img-top" alt="Book Cover" style="height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="card-body p-2 d-flex flex-column">
                                            <h6 class="fw-bolder mb-1" style="color: #2a3547; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">{{ $book->title }}</h6>
                                            <span class="badge bg-primary-subtle text-primary">{{ $book->category?->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12"><p class="text-muted">Belum ada kepemilikan buku.</p></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h4 class="mb-3">Ikut Kolaborasi BAB</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Buku</th>
                                        <th>Bab</th>
                                        <th>Judul Bab</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collaborationModules as $module)
                                        <tr>
                                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $collaborationModules->perPage(), $collaborationModules->currentPage()) }}</td>
                                            <td>{{ $module->book?->title ?? '-' }}</td>
                                            <td>BAB {{ $module->chapter ?? '-' }}</td>
                                            <td>{{ $module->title ?? '-' }}</td>
                                            <td>{{ $module->updated_at->format('d F Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada kolaborasi BAB.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">{{ $collaborationModules->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h4 class="mb-3">Riwayat Komisi Afiliasi/Royalti</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tipe</th>
                                        <th>Komisi</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commissionHistories as $history)
                                        <tr>
                                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $commissionHistories->perPage(), $commissionHistories->currentPage()) }}</td>
                                            <td>{{ $history->transaction->transaction_code }}</td>
                                            <td>{{ $history->type == 'royalti' ? 'Royalti' : 'Affiliator' }}</td>
                                            <td>Rp {{ number_format($history->amount, 0, ',', '.') }}</td>
                                            <td>{{ $history->created_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada riwayat komisi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">{{ $commissionHistories->appends(request()->except('commission_page'))->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h4 class="mb-3">Daftar Member Referal</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Member</th>
                                        <th>Tingkat Affiliasi</th>
                                        <th>Tanggal Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($referralUsers as $referral)
                                        <tr>
                                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $referralUsers->perPage(), $referralUsers->currentPage()) }}</td>
                                            <td>
                                                <h6 class="mb-1">{{ $referral->full_name }}</h6>
                                                <p class="mb-0 text-muted fs-2">{{ $referral->email }}</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    {{ $referral->affiliateLevel?->name ?? 'Member' }}
                                                </span>
                                            </td>
                                            <td>{{ $referral->created_at->format('d F Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada member referal</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">{{ $referralUsers->appends(request()->except('referral_page'))->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        $('.link-referral').click(function() {
            const referral = $(this).data('referral');
            const link = '{{ route('register', ['ref' => '']) }}' + referral;
            navigator.clipboard.writeText(link).then(() => {
                alert('Link referal berhasil disalin!');
            }).catch(err => {
                console.error('Gagal menyalin text: ', err);
            });
        });
    });
</script>
@endpush

@push('js')
<script src="{{ asset('') }}assets/dashboard/libs/apexcharts/dist/apexcharts.min.js"></script>
<script>
    const affiliateLevels = @json($affiliateLevels);
    const goals = [];
    const colors = ['#845EF7','#22D3EE','#34D399','#F59E0B','#EF4444','#EE128C'];
    for (let i = 0; i < affiliateLevels.length; i++) {
        const level = affiliateLevels[i];
        goals.push({
            name: level.name,
            value: level.min_earning,
            strokeHeight: 100,
            strokeColor: colors[i % colors.length]
        });
    }
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
            height: 180,
            type: 'bar',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '60%',
                borderRadius: 8
            }
        },
        colors: ['#EE128C'],
        dataLabels: {
            enabled: true,
            formatter: function(val, opt) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            }
        },
        xaxis: {
            labels: {
                formatter: function(val) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                }
            }
        },
        legend: {
            show: true,
            customLegendItems: goals.map(goal => 'Target ' + goal.name + ' (Rp ' + new Intl.NumberFormat('id-ID').format(goal.value) + ')'),
            markers: { fillColors: colors },
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
            style: { fontSize: '12px' }
        }
    };
    new ApexCharts(document.querySelector("#chart"), options).render();
</script>
@endpush
