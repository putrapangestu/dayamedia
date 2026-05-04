<div class="card shadow-none border">
    <div class="card-body row">
        <h4 class="mb-3">Member Referal</h4>
        <div class="table-responsive">
            <table id="default_order" class="table table-bordered display text-nowrap">
                <thead>
                <!-- start row -->
                    <tr>
                        <th>No</th>
                        <th>Affiliasi</th>
                        <th>Bergabung</th>
                    </tr>
                <!-- end row -->
                </thead>
                <tbody>
                    @forelse ($referrals as $referral)
                        <tr>
                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $referrals->perPage(), $referrals->currentPage()) }}</td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                        <h6 class="mb-1">{{ $referral->full_name }}</h6>
                                        <p class="mb-1 text-muted fs-2">Tingkat: {{ $referral->affiliateLevel?->name ?? 'Tidak ada' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="">
                                <h6 class="">{{ $referral->created_at->format('d F Y') }}</h6>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada member referal.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                <!-- start row -->
                    <tr>
                        <th>No</th>
                        <th>Affiliasi</th>
                        <th>Bergabung</th>
                    </tr>
                <!-- end row -->
                </tfoot>
            </table>
        </div>
        <div class="mt-3">{{ $referrals->links() }}</div>
    </div>
</div>
