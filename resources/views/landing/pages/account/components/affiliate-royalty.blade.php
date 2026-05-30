<div class="space-y-8">
    
    <!-- 1. Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Komisi Bulan Ini -->
        <div class="bg-primary rounded-[2.5rem] p-8 text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 size-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80 mb-2">Komisi Bulan Ini</p>
                <h2 class="text-4xl font-black tracking-tighter mb-4">Rp{{ number_format($commissionTotalMonth, 0, ',', '.') }}</h2>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 bg-white/20 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $now->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Level Afiliasi -->
        <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Level Afiliasi</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-2xl font-black text-gray-900">{{ $user->affiliateLevel?->name ?? 'Standard' }}</h3>
                    <div class="size-8 rounded-lg bg-yellow-400 text-yellow-950 flex items-center justify-center shadow-lg shadow-yellow-400/20 animate-pulse">
                        <i class="ki-filled ki-crown text-base"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">Rate Komisi:</span>
                <span class="text-sm font-black text-primary">{{ $user->affiliateLevel?->commission_percentage ?? 5 }}%</span>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute bottom-0 right-0 size-24 bg-primary/20 rounded-full blur-3xl group-hover:scale-150 transition-all"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-4 italic">Info Penting</p>
                <p class="text-xs font-medium text-gray-400 leading-relaxed">Komisi otomatis masuk ke saldo Anda setiap kali ada transaksi berhasil dari referral atau modul Anda.</p>
            </div>
        </div>
    </div>

    <!-- 2. Target Afiliasi (Horizontal Chart) -->
    <div class="bg-white border border-gray-100 rounded-[3rem] shadow-sm overflow-hidden p-8 sm:p-10">
        <div class="flex items-center gap-4 mb-8">
            <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <i class="ki-filled ki-chart-line text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-gray-900 tracking-tight">Target Omset Bulanan</h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Pantau progres pencapaian level afiliasi Anda</p>
            </div>
        </div>

        <div id="affiliate-target-chart" class="w-full"></div>
    </div>

    <!-- 3. Riwayat Komisi -->
    <div class="bg-white border border-gray-100 rounded-[3rem] shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50 flex-wrap gap-4">
            <h3 class="text-lg font-black text-gray-900 tracking-tight">Riwayat Komisi & Royalti</h3>
            <span class="px-4 py-1.5 bg-primary text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20">
                Total: {{ $commissionHistories->total() }} Data
            </span>
        </div>

        @if($commissionHistories->count() > 0)
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse text-nowrap">
                    <thead>
                        <tr class="bg-gray-100/50">
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Detail Sumber</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Nominal Komisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($commissionHistories as $history)
                            <tr class="hover:bg-primary/[0.02] transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-primary group-hover:text-white transition-all">
                                            <i class="ki-filled ki-handcart text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $history->transaction?->transaction_code ?? 'TRX-UNKNOWN' }}</p>
                                            <p class="text-[10px] text-gray-500 font-medium mt-0.5">Pembeli: <span class="font-bold text-gray-700">{{ $history->transaction?->user?->full_name ?? 'User' }}</span></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-gray-600">{{ $history->created_at->format('d/m/Y') }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $history->created_at->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-lg font-black text-primary tracking-tight">+Rp{{ number_format($history->commission_amount, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-gray-50 flex justify-center">
                {{ $commissionHistories->links() }}
            </div>
        @else
            <div class="py-20 text-center">
                <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                    <i class="ki-filled ki-discount text-5xl"></i>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Komisi</h4>
                <p class="text-sm text-gray-500 font-medium max-w-xs mx-auto leading-relaxed">Bagikan kode referral Anda atau terbitkan modul kolaborasi untuk mulai menghasilkan royalti.</p>
            </div>
        @endif
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        let affiliateLevels = @json($affiliateLevels);
        const goals = [];
        const colors = ['#EE128C', '#FFD700', '#E5E4E2'];
        
        for (let i = 0; i < affiliateLevels.length; i++) {
            const level = affiliateLevels[i];
            goals.push({
                name: 'Target ' + level.name,
                value: level.min_earning,
                strokeHeight: 10,
                strokeColor: colors[i] || '#primary'
            });
        }

        var options = {
            series: [{
                name: 'Omset Saya',
                data: [{
                    x: 'Progres Omset',
                    y: {{ $commissionTotalMonth }},
                    goals: goals
                }]
            }],
            chart: {
                height: 250,
                type: 'bar',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '50%',
                    borderRadius: 12
                }
            },
            colors: ['#0F172A'], // Dark slate for the main bar
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                },
                style: {
                    fontSize: '12px',
                    fontWeight: '900',
                    colors: ['#fff']
                }
            },
            xaxis: {
                labels: {
                    show: true,
                    style: { colors: '#64748b', fontWeight: 'bold', fontSize: '10px' },
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                padding: { top: 0, right: 30, bottom: 0, left: 10 }
            },
            legend: {
                show: true,
                showForSingleSeries: true,
                customLegendItems: goals.map(goal => goal.name + ' (Rp ' + new Intl.NumberFormat('id-ID').format(goal.value) + ')'),
                markers: { fillColors: colors },
                fontSize: '11px',
                fontWeight: 'bold',
                position: 'top',
                horizontalAlign: 'right',
                itemMargin: { horizontal: 10, vertical: 5 }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#affiliate-target-chart"), options);
        chart.render();
    });
</script>
@endpush
