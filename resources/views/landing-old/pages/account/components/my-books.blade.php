<div class="card shadow-none border">
    <div class="card-body row">
        <h4 class="mb-3">Buku Saya</h4>
        <div class="table-responsive">
            <table id="default_order" class="table table-bordered display text-nowrap">
                <thead>
                <!-- start row -->
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                    @forelse($bookHistories as $bookHistory)
                        <tr>
                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $bookHistories->perPage(), $bookHistories->currentPage()) }}</td>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $bookHistory->book->cover ? asset('storage/' . $bookHistory->book->cover) : asset('assets/dashboard/images/products/product-1.jpg') }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                    <div>
                                        <h6 class="mb-1">{{ $bookHistory->book->title }}</h6>
                                        <p class="mb-1 text-muted fs-2">ISBN: {{ $bookHistory->book->code_isbn }}</p>
                                        <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $bookHistory->book->category->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($bookHistory->book->authors->count() > 0)
                                    {{ $bookHistory->book->count() > 1 ? $bookHistory->book->authors->take(1)->map(function ($author) {
                                        return $author->author ?? $author->user->full_name;
                                    })->implode(', ') . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('book.read', $bookHistory->book->slug) }}" class="btn btn-primary btn-sm">Baca Buku</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada buku yang di pinjam</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                <!-- start row -->
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
                <!-- end row -->
                </tfoot>
            </table>
        </div>
        <div class="mt-3">{{ $bookHistories->links() }}</div>
    </div>
</div>
