<div class="card shadow-none border">
    <div class="card-body row">
        <h4 class="mb-3">Dokumen</h4>
        <div class="table-responsive">
            <table id="default_order" class="table table-bordered display text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Dokumen</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $idx => $doc)
                        <tr>
                            <td>{{ ($documents->currentPage() - 1) * $documents->perPage() + $idx + 1 }}</td>
                            <td>
                                <h6 class="mb-1">{{ $doc->name }}</h6>
                            </td>
                            <td class="">
                                <a class="btn btn-primary btn-sm" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                    <i class="ti ti-download"></i> Unduh
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada dokumen</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Dokumen</th>
                        <th>File</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mt-3">{{ $documents->links() }}</div>
    </div>
</div>
