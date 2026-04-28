@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Buku Editor"
            description="List buku editor"
            >
          </x-header-page>

          <div class="row mb-3">
              <div class="col-md-4 ms-auto">
                  <form action="{{ route('editor.book.index') }}" method="GET">
                      <div class="input-group">
                          <input type="text" name="search" class="form-control" placeholder="Cari judul buku..." value="{{ request('search') }}">
                          <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
                      </div>
                  </form>
              </div>
          </div>

          <ul class="nav nav-tabs p-3 mb-3 rounded align-items-center card flex-row" role="tablist">
            <li class="nav-item">
              <a class="nav-link d-flex active" data-bs-toggle="tab" href="#home2" role="tab">
                <span>
                  <i class="ti ti-book-download fs-6"></i>
                </span>
                <span class="d-none d-md-block ms-2">Buku Saya Klaim</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex" data-bs-toggle="tab" href="#ready2" role="tab">
                <span>
                  <i class="ti ti-book-check fs-6"></i>
                </span>
                <span class="d-none d-md-block ms-2">Buku Siap Diklaim <span class="badge bg-success ms-1">{{ $readyBooks->count() }}</span></span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex" data-bs-toggle="tab" href="#profile2" role="tab">
                <span>
                  <i class="ti ti-book-2 fs-6"></i>
                </span>
                <span class="d-none d-md-block ms-2">Buku Tersedia</span>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="home2" role="tabpanel">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Buku Proses Edit</h4>
                    <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </thead>
                        <tbody>
                            @forelse ($bookEditors as $bookEditor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $bookEditor->cover) }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                            <div>
                                                <h6 class="mb-1">{{ $bookEditor->title }}</h6>
                                                <p class="mb-1 text-muted fs-2">{{ $bookEditor->modules->count() }} Bab</p>
                                                <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $bookEditor->category?->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6><span class="text-muted">Harga E-Book:</span> Rp.{{ number_format($bookEditor->price_digital, 0, ',', '.') }}</h6>
                                        <h6><span class="text-muted">Harga Cetak:</span> Rp.{{ number_format($bookEditor->price_physical, 0, ',', '.') }}</h6>
                                    </td>
                                    <td>
                                        @php
                                            $editorClaim = $bookEditor->bookEditors;
                                        @endphp
                                        @if($editorClaim)
                                            <span class="mb-1 badge {{ \App\Helpers\StatusHelper::getBookEditorStatusBadge($editorClaim->status) }}">
                                                {{ \App\Helpers\StatusHelper::getStatusText($editorClaim->status) }}
                                            </span>
                                        @else
                                            <span class="mb-1 badge bg-secondary-subtle text-secondary">-</span>
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
                                                    <a class="dropdown-item" href="{{ route('editor.book.show', $bookEditor->id) }}">
                                                        <i class="ti ti-eye me-1 fs-4"></i>Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada buku dalam proses edit</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </tfoot>
                    </table>
                    </div>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $bookEditors->links() }}
                </div>
              </div>
                <!-- end Default Ordering -->
            </div>
            <div class="tab-pane p-3" id="ready2" role="tabpanel">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Buku Siap Diklaim (Semua Bab Sudah Terisi)</h4>
                    <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </thead>
                        <tbody>
                            @forelse ($readyBooks as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $book->cover) }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                            <div>
                                                <h6 class="mb-1">{{ $book->title }}</h6>
                                                <p class="mb-1 text-muted fs-2">{{ $book->modules->count() }} Bab (Semua sudah terisi)</p>
                                                <span class="mb-1 badge fs-2 bg-success-subtle text-success">{{ $book->category?->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6><span class="text-muted">Harga E-Book:</span> Rp.{{ number_format($book->price_digital, 0, ',', '.') }}</h6>
                                        <h6><span class="text-muted">Harga Cetak:</span> Rp.{{ number_format($book->price_physical, 0, ',', '.') }}</h6>
                                    </td>
                                    <td><span class="mb-1 badge bg-success-subtle text-success">{{ ucfirst($book->status) }}</span></td>
                                    <td>
                                        <form action="{{ route('editor.book.claim', $book->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button class="btn btn-success">
                                                <i class="ti ti-check"></i> Klaim Sekarang
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada buku yang siap di klaim</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </tfoot>
                    </table>
                    </div>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $readyBooks->links() }}
                </div>
              </div>
            </div>
            <div class="tab-pane p-3" id="profile2" role="tabpanel">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Buku Tersedia untuk Di Edit</h4>
                    <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $book->cover) }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                            <div>
                                                <h6 class="mb-1">{{ $book->title }}</h6>
                                                <p class="mb-1 text-muted fs-2">{{ $book->modules->count() }} Bab</p>
                                                <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $book->category?->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6><span class="text-muted">Harga E-Book:</span> Rp.{{ number_format($book->price_digital, 0, ',', '.') }}</h6>
                                        <h6><span class="text-muted">Harga Cetak:</span> Rp.{{ number_format($book->price_physical, 0, ',', '.') }}</h6>
                                    </td>
                                    <td><span class="mb-1 badge bg-success-subtle text-success">{{ ucfirst($book->status) }}</span></td>
                                    <td>
                                        <form action="{{ route('editor.book.claim', $book->id) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button class="btn btn-primary">Klaim</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada buku tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                        </tfoot>
                    </table>
                    </div>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $books->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
