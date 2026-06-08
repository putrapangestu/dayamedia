@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Member"
            description="List member yang terdaftar di Daya Media"
            >
            <x-slot:actions>
                <a href="{{ route('admin.member.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Member
                </a>

                <button
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#bs-modal-import"
                >
                    <i class="ti ti-file"></i> Impor Member Excel
                </button>

                <button
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#bs-modal-import-csv"
                >
                    <i class="ti ti-file"></i> Impor Member Csv
                </button>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="cari nama member.."
                                    value="{{ request('name') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tingkat Affiliate</label>
                                <select class="form-control" name="affiliate_level_id">
                                    <option value="">Semua Tingkat</option>
                                    @foreach($affiliateLevels as $level)
                                        <option value="{{ $level->id }}" {{ request('affiliate_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button class="btn btn-primary">
                                    Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                    Reset
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
                                <th>Nama Member</th>
                                <th>Nama Gelar</th>
                                <th>Email</th>
                                <th>Pekerjaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <!-- start row -->
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $users->perPage(), $users->currentPage()) }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->degree ?? "-" }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->job ?? "-" }}</td>
                                        <td>
                                            @if ($user->email_verified_at)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
              data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.member.show', $user->id) }}">
                                                            <i class="ti ti-eye me-1 fs-4"></i>Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.member.edit', $user->id) }}">
                                                            <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete" data-id="{{ $user->id }}" href="javascript:void(0)">
                                                        <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <!-- end row -->
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="ti ti-users fs-2 mb-2 d-block"></i>
                                            <h6 class="mb-1">Tidak ada member</h6>
                                            <small class="text-muted">Belum ada data member yang terdaftar</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Nama Gelar</th>
                                <th>Email</th>
                                <th>Pekerjaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    </div>
                    <!-- end Default Ordering -->
                    <div class="px-4 py-3 border-top">
                        {{ $users->appends(request()->only('name'))->links() }}
                    </div>
            </div>
          </div>
        </div>
      </div>

        {{-- Modal Import Excel --}}
        <div id="bs-modal-import" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-import" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Impor Member Excel
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">File</label>
                            <input id="file" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Budi Hartono">
                            <small class="form-text text-muted">Format file yang diizinkan: xls, xlsx</small>
                        </div>
                        <div class="progress hide" id="progress">
                            <div class="progress-bar progress-bar-striped text-bg-primary progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-success-subtle text-success waves-effect" id="import">
                            Impor
                        </button>
                        <button type="button" class="btn bg-default-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        {{-- modal import csv --}}
        <div id="bs-modal-import-csv" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-import" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Impor Member CSV
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fileCsv">File</label>
                            <input id="fileCsv" type="file" class="form-control" placeholder="Masukkan file">
                            <small class="form-text text-muted">Format file yang diizinkan: csv</small>
                        </div>
                        <div class="progress hide" id="progress">
                            <div class="progress-bar progress-bar-striped text-bg-primary progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-success-subtle text-success waves-effect" id="btn-import-csv">
                            Impor
                        </button>
                        <button type="button" class="btn bg-default-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <x-form-delete></x-form-delete>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#import').on('click', function() {
            console.log('click');
            $('#progress').removeClass('hide');
            $('#import').addClass('disabled');

            const formData = new FormData();
            formData.append('file', $('#file').prop('files')[0]);
            const xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = e.loaded / e.total;
                    $('#progress .progress-bar').css('width', percentComplete * 100 + '%');
                }
            });
            xhr.upload.addEventListener('load', function() {
                $('#progress').addClass('hide');
                $('#import').removeClass('disabled');
            });

            xhr.onload = function () {

                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('Success:', xhr.responseText);
                    window.location.reload();
                } else {
                    const res = JSON.parse(xhr.responseText);
                    alert(res.message || 'Import gagal');
                }
            };

            const token = $('meta[name="csrf-token"]').attr('content');
            xhr.open('POST', '{{ route("admin.member.import") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);
        });

        // Import Super Cepat
        document.getElementById('btn-import-csv').addEventListener('click', function() {
            const fileInput = document.getElementById('fileCsv');
            const file = fileInput.files[0];

            if (!file) {
                Swal.fire('Error!', 'Pilih file CSV dulu!', 'error');
                return;
            }

            if (!file.name.endsWith('.csv')) {
                Swal.fire('Error!', 'File harus berformat CSV!', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader"></i> Importing...';

            // Hitung waktu
            const startTime = Date.now();

            fetch('{{ route("admin.member.import.csv") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const endTime = Date.now();
                const duration = ((endTime - startTime) / 1000).toFixed(2);

                if (data.success) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: `${data.message} \n Waktu: ${duration} detik`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan: ' + error.message, 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Import Super Cepat';
            });
        });

        // modal delete
        $(".btn-delete").click(function () {
            const id = $(this).data('id');
            $('#form-delete').attr('action', '{{ route("admin.member.destroy", ":id") }}'.replace(':id', id));

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "ms-3 btn bg-primary-subtle text-primary",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus data ini?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#ffffff",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya, Hapus!",
            }).then((result) => {
                if (result.value) {
                    $('#form-delete').submit();
                }
            });
        });
    });
</script>
@endpush
