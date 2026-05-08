<div class="card shadow-none border">
    <div class="card-body row">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-3 p-0">Riwayat Withdrawl</h4>
            <button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#bs-modal-withdraw"><i class="ti ti-wallet"></i> Withdraw</button>
        </div>
        <div class="table-responsive">
            <table id="default_order" class="table table-bordered display text-nowrap">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>No</th>
                        <th>Rekening</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    @forelse ($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $withdrawals->perPage(), $withdrawals->currentPage()) }}</td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                        <h6 class="mb-1 fw-bolder">{{  $withdrawal->bank}}-{{ $withdrawal->account_number }}-</h6>
                                        <p class="mb-1 text-muted fs-2">Atas nama: {{ $withdrawal->account_name }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="">
                                <h6 class="fw-bolder">Rp. {{ number_format($withdrawal->net_amount ?? $withdrawal->amount, 0, ',', '.') }}</h6>
                                <p class="mb-1 text-muted fs-2">Potongan Saldo: Rp.{{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                                <p class="mb-1 text-muted fs-2">Biaya Admin: Rp.{{ number_format($withdrawal->admin_fee ?? 0, 0, ',', '.') }}</p>
                            </td>
                            <td>
                                <span class="mb-1 badge
                                    @if ($withdrawal->status == 'accepted')
                                        bg-success-subtle
                                        text-success
                                    @elseif ($withdrawal->status == 'rejected')
                                        bg-danger-subtle
                                        text-danger
                                    @else
                                        bg-warning-subtle
                                        text-warning
                                    @endif
                                ">{{
                                    $withdrawal->status
                                }}</span>
                                <p class="mb-1 text-muted fs-2">{{ $withdrawal->created_at->format('d F Y H:i:s') }}</p>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
                                        data-bs-reference="viewport"aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada riwayat withdrawl</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                <!-- start row -->
                <tr>
                    <th>No</th>
                    <th>Rekening</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <!-- end row -->
                </tfoot>
            </table>
        </div>
        <div class="mt-3">{{ $withdrawals->links() }}</div>
    </div>
</div>

<div id="bs-modal-withdraw" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-import" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tarik Saldo
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('withdraw.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="account_number">No Rekening / No HP (E-Wallet) <span class="text-danger">*</span></label>
                        <input id="account_number" name="account_number" type="text" class="form-control" aria-describedby="emailHelp" placeholder="XXXXXXXXXXXX" value="{{ old('account_number') }}">
                        <small class="form-text text-muted">Masukkan no rekening / no HP</small>
                        @error('account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="account_name">Nama Pemiliki Rekening / Pemilik E-Wallet <span class="text-danger">*</span></label>
                        <input id="account_name" name="account_name" type="text" class="form-control" aria-describedby="emailHelp" placeholder="XXXXXXXXXXXX" value="{{ old('account_name') }}">
                        <small class="form-text text-muted">Masukkan nama pemilik rekening / e-wallet</small>
                        @error('account_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank <span class="text-danger">*</span></label>
                        <input id="bank" name="bank" type="text" class="form-control" aria-describedby="emailHelp" placeholder="BRI/BCA/DANA/OVO" value="{{ old('bank') }}">
                        @error('bank')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="amount">Jumlah Tarik <span class="text-danger">*</span></label>
                        <input id="amount" name="amount" type="number" class="form-control" aria-describedby="emailHelp" placeholder="Rp.0" value="{{ old('amount') }}">
                        <small class="form-text text-muted">Masukkan jumlah tarik (Minimal: Rp {{ number_format(getMinWithdrawal(), 0, ',', '.') }})</small>
                        <div class="mt-2 p-2 bg-light rounded">
                            <small class="text-info">
                                <strong>Biaya Admin:</strong>Rp {{ getAdminFeeWithdrawal() }}<br>
                                <strong>Minimal Penarikan:</strong> Rp {{ number_format(getMinWithdrawal(), 0, ',', '.') }}
                            </small>
                        </div>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="progress hide" id="progress">
                        <div class="progress-bar progress-bar-striped text-bg-primary progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn bg-primary-subtle text-primary  waves-effect" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn bg-primary text-white waves-effect">
                        Submit
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
