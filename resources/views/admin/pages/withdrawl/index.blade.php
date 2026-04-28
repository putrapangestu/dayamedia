@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Riwayat Penarikan Komisi"
            description="List riwayat penarikan komisi di Azzia"
            >
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Cari</label>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="cari nama, email, bank, atau rekening..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control"
                                    value="{{ request('start_date') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input
                                    type="date"
                                    name="end_date"
                                    class="form-control"
                                    value="{{ request('end_date') }}"
                                >
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button class="btn btn-primary">
                                    <i class="ti ti-search"></i> Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-refresh"></i> Reset
                                </a>
                            </div>
                        </form>
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Affiliator</th>
                                <th>Rekening</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse ($withdrawls as $withdrawl)
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $withdrawls->perPage(), $withdrawls->currentPage()) }}</td>
                                        <td>
                                            <div class="d-flex"><div>
                                                    <h6 class="mb-1">{{ $withdrawl->user->name }}</h6>
                                                    <p class="mb-1 text-muted fs-2">Sisa Saldo: Rp. {{ number_format($withdrawl->user->balance, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <h6 class="mb-1 fw-bolder">{{  $withdrawl->bank}} - {{ $withdrawl->account_number }}</h6>
                                                    <p class="mb-1 text-muted fs-2">Atas nama: {{ $withdrawl->account_name }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="">
                                            <h6 class="fw-bolder">Rp. {{ number_format($withdrawl->net_amount, 0, ',', '.') }}</h6>
                                            <p class="mb-1 text-muted fs-2">Pengajuan: Rp.{{ number_format($withdrawl->amount, 0, ',', '.') }}</p>
                                            <p class="mb-1 text-muted fs-2">Biaya Admin: Rp.{{ number_format($withdrawl->admin_fee, 0, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <span class="mb-1 badge
                                                @if ($withdrawl->status == 'accepted')
                                                    bg-success-subtle
                                                    text-success
                                                @elseif ($withdrawl->status == 'rejected')
                                                    bg-danger-subtle
                                                    text-danger
                                                @else
                                                    bg-warning-subtle
                                                    text-warning
                                                @endif
                                            ">{{
                                                $withdrawl->status
                                            }}</span>
                                            <p class="mb-1 text-muted fs-2">{{ $withdrawl->created_at->format('d F Y H:i:s') }}</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
                                                    data-bs-reference="viewport"aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                @if ($withdrawl->status == 'pending')
                                                    <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bs-modal-confirmation-{{ $withdrawl->id }}">
                                                                <i class="ti ti-edit me-1 fs-4"></i>Tanggapi
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal Confirmation --}}
                                    <div id="bs-modal-confirmation-{{ $withdrawl->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Tanggapi Penarikan Dana
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.withdrawl.update', $withdrawl->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="form-select status-select" name="status">
                                                                <option value="" selected>-- Pilih Status --</option>
                                                                <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3 upload-container">
                                                            <x-dropzone
                                                                name="proof"
                                                                label="Upload Bukti Transfer"
                                                                accept="image/*"
                                                                :maxSize="5"
                                                                :required="false"
                                                                helperText="Upload lengkap bukti transfer"
                                                            />
                                                        </div>
                                                        <div class="form-group mt-3 hide reason-container">
                                                            <label>Alasan Penolakan</label>
                                                            <textarea class="form-control" rows="3" placeholder="Masukkan alasan penolakan" name="note">{{ old('note') }}</textarea>
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
                                <th>Affiliator</th>
                                <th>Rekening</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $withdrawls->links() }}
                    </div>
                    </div>
                    <!-- end Default Ordering -->
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.status-select').on('change', function() {
                var modal = $(this).closest('.modal-content');
                if ($(this).val() == 'rejected') {
                    modal.find('.reason-container').removeClass('hide');
                    modal.find('.upload-container').addClass('hide');
                } else {
                    modal.find('.reason-container').addClass('hide');
                    modal.find('.upload-container').removeClass('hide');
                }
            });
        });
    </script>
@endpush
