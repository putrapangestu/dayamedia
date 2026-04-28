<div class="card shadow-none border">
    <div class="card-body row">
        <h4 class="mb-3">Riwayat Kolaborasi</h4>
        <div class="table-responsive">
            <table id="default_order" class="table table-bordered display text-nowrap">
                <thead>
                <!-- start row -->
                <tr>
                    <th>No</th>
                    <th>Buku / Modul</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Turnitin</th>
                    <th>Aksi</th>
                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                    @forelse ($bookColaborators as $collaborator)
                        @if($collaborator->book)
                            <tr>
                                <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $bookColaborators->perPage(), $bookColaborators->currentPage()) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <img src="{{ asset('') }}assets/dashboard/images/products/product-1.jpg" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                        <div>
                                            <h6 class="mb-1">{{ $collaborator->book->title }}</h6>
                                            <p class="mb-1 text-muted fs-2">BAB {{ $collaborator->chapter }} | {{ $collaborator->title }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $collaborator->deadline ? \Carbon\Carbon::parse($collaborator->deadline)->format('d-m-Y') : 'Belum dimulai' }}</td>
                                <td><span class="mb-1 badge
                                @if(
                                    (($collaborator->file_path || $collaborator->file_path_turnitin) && $collaborator->deadline != null && $collaborator->deadline < $now)
                                    || $collaborator?->book?->status == "published"
                                )
                                    bg-success-subtle text-success
                                @elseif ((!$collaborator->file_path && !$collaborator->file_path_turnitin) && $collaborator->deadline != null && $collaborator->deadline < $now)
                                    bg-danger-subtle text-danger
                                @else
                                    bg-warning-subtle text-warning
                                @endif">
                                    @if(
                                        (($collaborator->file_path || $collaborator->file_path_turnitin) && $collaborator->deadline != null && $collaborator->deadline < $now)
                                        || $collaborator?->book?->status == "published"
                                    )
                                        Selesai
                                    @elseif ((
                                        (!$collaborator->file_path && !$collaborator->file_path_turnitin) && $collaborator->deadline != null && $collaborator->deadline < $now)
                                    )
                                        Tidak Selesai
                                    @else
                                        Proses
                                    @endif
                                </span></td>
                                <td>
                                    @if ($collaborator->file_path)
                                        <a href="{{ asset('storage/' . $collaborator->file_path) }}" target="_blank" class="btn btn-success"><i class="ti ti-upload"></i> Lihat Naskah</a>
                                    @else
                                        <span class="text-muted">Belum Upload Naskah</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($collaborator->file_path_turnitin)
                                        <a href="{{ asset('storage/' . $collaborator->file_path_turnitin) }}" target="_blank" class="btn btn-success"><i class="ti ti-upload"></i> Lihat Turnitin</a>
                                    @else
                                        <span class="text-muted">Belum Upload Turnitin</span>
                                    @endif
                                </td>
                                <td>
                                    @if (($collaborator->deadline == null || $collaborator->deadline > $now) && $collaborator?->book?->status != "published")
                                        <button class="btn btn-primary btn-upload" data-id="{{ $collaborator->id }}" data-bs-toggle="modal" data-bs-target="#modal-upload-collaboration-{{ $loop->iteration }}"><i class="ti ti-upload"></i> Upload Naskah</button>
                                    @else
                                        <button class="btn btn-success"><i class="ti ti-upload"></i> Upload Selesai</button>
                                    @endif
                                </td>
                            </tr>
                        @endif

                        {{-- Modal Upload Naskah --}}
                        <div id="modal-upload-collaboration-{{ $loop->iteration }}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-md">
                                <form method="post" action="{{ route('account.collaboration.upload', $collaborator->id) }}" id="form-upload" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myModalLabel">
                                            Upload File Kolaborasi
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($collaborator->file_path)
                                            <div class="mb-3">
                                                <a href="{{ asset('storage/' . $collaborator->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <x-dropzone
                                                name="file"
                                                label="File Naskah"
                                                accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                :maxSize="10"
                                                :required="true"
                                                helperText="Upload file naskah (DOC, DOCX - Max: 10MB)"
                                            />
                                        </div>
                                        @if($collaborator->file_path_turnitin)
                                            <div class="mb-3">
                                                <a href="{{ asset('storage/' . $collaborator->file_path_turnitin) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <x-dropzone
                                                name="turnitin_file"
                                                label="File Turnitin (Opsional)"
                                                accept="application/pdf"
                                                :maxSize="5"
                                                :required="false"
                                                helperText="Upload file turnitin (PDF - Max: 5MB)"
                                            />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-primary-subtle text-primary  waves-effect" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                                </form>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada riwayat kolaborasi.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                <!-- start row -->
                <tr>
                    <th>No</th>
                    <th>Buku / Modul</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <!-- end row -->
                </tfoot>
            </table>
        </div>
        <div class="mt-3">{{ $bookColaborators->links() }}</div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('.btn-upload').click(function() {
                let id = $(this).data('id')
                let url = `{{ url('account/collaboration/upload/${id}') }}`

                $('#form-upload').attr('action', url)
            })
        })
    </script>
@endpush
