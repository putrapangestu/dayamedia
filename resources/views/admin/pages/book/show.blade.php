@extends('admin.layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Detail Buku"
            description="Halaman detail buku yang dipilih"
            >
        </x-header-page>

        <div class="card">
            <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3 active" id="pills-information-tab" data-bs-toggle="pill" data-bs-target="#pills-information" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-info-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Informasi Buku</span>
                </button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-bab-tab" data-bs-toggle="pill" data-bs-target="#pills-bab" type="button" role="tab" aria-controls="pills-notifications" aria-selected="false" tabindex="-1">
                    <i class="ti ti-stack-2 me-2 fs-6"></i>
                    <span class="d-none d-md-block">Bab</span>
                </button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-collaborator-tab" data-bs-toggle="pill" data-bs-target="#pills-collaborator" type="button" role="tab" aria-controls="pills-bills" aria-selected="false" tabindex="-1">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Kolaborator</span>
                </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="pills-information" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-4 d-flex align-items-stretch">
                            <img class="img-fluid rounded-xl" src="{{ asset('storage/' . $book->cover) }}" alt="furniture_img1" style="max-height: 500px; object-fit: cover;">
                        </div>
                        <div class="col-lg-8 d-flex flex-column align-items-stretch">
                            <h3 class="fw-bolder">{{ $book->title }}</h3>
                            <p class="text-muted">Kategori: {{ $book->category?->name }}</p>
                            <div class="d-flex">
                                <h5 class="fw-bolder">Penulis</h5>
                                <a href="" class="ms-auto" data-bs-toggle="modal" data-bs-target="#bs-modal-author">Selengkapnya</a>
                            </div>
                            <div class="row">
                                @forelse ($authors->take(3) as $author)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body p-4 d-flex align-items-center gap-6">
                                            <img src="{{ asset('') }}assets/dashboard/images/profile/user-1.jpg" alt="modernize-img" class="rounded-circle" width="40" height="40">
                                            <div class="overflow-hidden" style="min-width: 0;">
                                                <h6 class="fw-semibold mb-0" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $author['name'] }}</h6>
                                                <span class="fs-2 d-flex align-items-center">
                                                <i class="ti ti-map-pin text-dark fs-3 me-1"></i>{{ $author['phone_number'] ?? $author['email'] ?? "-" }}
                                                </span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="p-0 m-0">Belum ada penulis</p>
                                @endforelse
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p class="p-0 m-0">Harga Cetak</p>
                                    <h3 class="text-primary fw-bolder">Rp.{{ number_format($book->price_physical, 0, ',', '.') }}</h3>
                                </div>
                                <div class="col-6">
                                    <p class="p-0 m-0">Harga E-Book</p>
                                    <h3 class="text-primary fw-bolder">Rp.{{ number_format($book->price_digital, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                            <hr>
                            <h5 class="fw-bolder">Detail</h5>
                            <div class="row mb-2">
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Bahasa</p>
                                    <h6 class="fw-bolder">{{ $book->language }}</h6>
                                </div>
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">ISBN</p>
                                    <h6 class="fw-bolder">{{ $book->code_isbn }}</h6>
                                </div>
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Berat Buku</p>
                                    <h6 class="fw-bolder">{{ number_format($book->weight, 0, ',', '.') }} Gram</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Tahun Terbit</p>
                                    <h6 class="fw-bolder">{{ $book->year_published }}</h6>
                                </div>
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Halaman</p>
                                    <h6 class="fw-bolder">{{ number_format($book->pages, 0, ',', '.') }}</h6>
                                </div>
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Penerbit</p>
                                    <h6 class="fw-bolder">{{ $book->publisher }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <p class="p-0 mb-1">Editor</p>
                                    <h6 class="fw-bolder">{{ $book->editor && $book->editor !== '-' ? $book->editor : ($book->bookEditors?->user?->full_name ?? '-') }}</h6>
                                </div>
                            </div>
                            <hr>
                            <h5 class="fw-bolder">Deskripsi</h5>
                            <p>{!! $book->description !!}</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-bab" role="tabpanel" aria-labelledby="pills-notifications-tab" tabindex="0">
                    <div class="d-flex">
                        @if(!$book->is_individual)
                            <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#bs-modal-create-bab"><i class="ti ti-plus"></i> Tambah Bab</button>
                        @endif
                    </div>
                    <div class="table-responsive mt-3">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Bab</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>File Bab</th>
                                <th>File Turnitin</th>
                                @if(!$book->is_individual)
                                <th>Aksi</th>
                                @endif
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse ($modules as $item)
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $modules->perPage(), $modules->currentPage()) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <h5 class="mb-1 fw-bolder">{{ $book->is_individual ? 'Buku Individu' : "Bab " . $item->chapter }}</h5>
                                                    <p class="mb-1 text-muted fs-2">
                                                        @if ($item->deadline)
                                                            {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y H:i') }}
                                                        @elseif($book->is_individual)
                                                            Proses Upload
                                                        @else
                                                            {{ $item->days }} Hari - Belum Mulai
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item?->user?->full_name ?? '-' }}</td>
                                        <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                                            {{ $item->description }}
                                        </td>
                                        <td class="fs-bolder">Rp.{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->file_path)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                                    </a>
                                                </div>
                                            @else
                                                <button class="btn btn-outline-danger btn-sm">Belum Upload</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->file_path_turnitin)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $item->file_path_turnitin) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="ti ti-file-text"></i> Lihat File Turnitin Saat Ini
                                                    </a>
                                                </div>
                                            @else
                                                <button class="btn btn-outline-danger btn-sm">Belum Upload</button>
                                            @endif
                                        </td>
                                        @if(!$book->is_individual)
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
                                                    data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.module.edit', $item->id) }}">
                                                            <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete-module" data-id="{{ $item->id }}" href="javascript:void(0)">
                                                            <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Bab</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                @if(!$book->is_individual)
                                <th>Aksi</th>
                                @endif
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $modules->links() }}
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-collaborator" role="tabpanel" aria-labelledby="pills-bills-tab" tabindex="0">
                    <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Tanggal Bergabung</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                {{-- @forelse ($book->authors as $item) --}}
                                @forelse ($authors as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <img src="{{ asset('') }}assets/dashboard/images/products/product-1.jpg" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                                <div>
                                                    {{-- <h6 class="mb-1">{{ $item->author ?? $item->user?->full_name }}</h6> --}}
                                                    <h6 class="mb-1">{{ $item['name'] ?? "-" }}</h6>
                                                    @if ($item['chapter'])
                                                        <p class="mb-1 text-muted fs-2">BAB {{ $item['chapter'] }}  | {{ $item['title'] ?? "-" }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td><span class="mb-1 badge bg-success-subtle text-success">{{ $item->created_at->format('d-m-Y') }}</span></td> --}}
                                        <td><span class="mb-1 badge bg-success-subtle text-success">{{ $item['created_at']->format('d-m-Y') ?? "-" }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data penulis</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Tanggal Bergabung</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bs-modal-author" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-author" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Penulis
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="default_order" class="table table-bordered display text-nowrap">
                    <thead>
                            <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                        </tr>
                        <!-- end row -->
                        </thead>
                        <tbody>
                            @forelse ($authors as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['email'] }}</td>
                                    <td>{{ $item['phone_number'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data penulis</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                        </tr>
                        <!-- end row -->
                        </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-primary-subtle text-primary  waves-effect" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="bs-modal-create-bab" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-create-bab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Bab
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-create-bab" method="POST" action="{{ route('admin.module.store') }}">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="modal-body row">
                    <div class="col-md-9 mb-1">
                        <div class="form-group">
                            <label for="title">Judul <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Peran Pendidik dan Tenaga Kependidikan PAUD" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group">
                            <label for="chapter">Bab <span class="text-danger">*</span></label>
                            <input id="chapter" type="number" name="chapter" class="form-control" aria-describedby="emailHelp" placeholder="1" value="{{ old('chapter') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group">
                            <label for="price">Harga <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" aria-describedby="emailHelp" placeholder="200000" value="{{ old('price') }}">
                        </div>
                    </div>
                    {{-- <div class="col-md-6 mb-1">
                        <div class="form-group">
                            <label for="deadline_type">Tipe Tenggat <span class="text-danger">*</span></label>
                            <select id="deadline_type_create" name="deadline_type" class="form-control" required>
                                <option value="days">Hari</option>
                                <option value="date">Tanggal</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-6 mb-1" id="days_container_create">
                        <div class="form-group">
                            <label for="days">Jumlah Hari <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" id="days_create" name="days" class="form-control" placeholder="100" value="{{ old('days') }}">
                                <span class="input-group-text">Hari</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1" id="date_container_create" style="display: none;">
                        <div class="form-group">
                            <label for="deadline_date_create">Tanggal Tenggat <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="deadline_date_create" name="deadline_date" class="form-control" value="{{ old('deadline_date') }}">
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <textarea name="description" rows="3" placeholder="Deskripsi bab..." id="" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-primary-subtle text-primary waves-effect" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn bg-primary waves-effect text-white" id="import">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<form id="form-delete-module" method="post" action="">
    @method('DELETE')
    @csrf
</form>
@endsection

@push('js')
<script src="{{ asset('') }}assets/dashboard/libs/tinymce/tinymce.min.js"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: "textarea#mymce",
        });

        // Deadline type toggle for create modal
        $('#deadline_type_create').change(function() {
            if ($(this).val() === 'days') {
                $('#days_container_create').show();
                $('#date_container_create').hide();
                $('#days_create').attr('required', 'required');
                $('#deadline_date_create').removeAttr('required');
            } else {
                $('#days_container_create').hide();
                $('#date_container_create').show();
                $('#deadline_date_create').attr('required', 'required');
                $('#days_create').removeAttr('required');
            }
        });
    });

    $(".btn-delete-module").click(function () {
        const id = $(this).data('id');
        $('#form-delete-module').attr('action', '{{ route("admin.module.destroy", ":id") }}'.replace(':id', id));

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
                $('#form-delete-module').submit();
            }
        });
    });
</script>
@endpush
