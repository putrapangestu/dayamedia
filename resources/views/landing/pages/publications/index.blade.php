@extends('landing.layouts.app')

@if((config('app.env') ?? config('app.env')) === 'production')
@push('meta')
    <meta name="robots" content="index, follow">
    @php
        $offset = method_exists($books, 'currentPage') ? (($books->currentPage() - 1) * $books->perPage()) : 0;
        $listElements = [];
        foreach ($books as $idx => $b) {
            $authors = [];
            foreach ($b->authors as $a) {
                $name = $a->author ?? ($a->user->full_name ?? null);
                if (!empty($name)) {
                    $authors[] = ['@type' => 'Person', 'name' => $name];
                }
            }
            $item = [
                '@type' => 'ListItem',
                'position' => $offset + $idx + 1,
                'url' => route('bookDetail', $b->slug),
                'item' => array_filter([
                    '@type' => 'Book',
                    'name' => $b->title,
                    'author' => $authors,
                    'image' => $b->cover ? asset('storage/' . $b->cover) : null,
                    'isbn' => $b->code_isbn ?: null,
                    'datePublished' => $b->year_published ?: null,
                    'publisher' => $b->publisher ?: config('app.name'),
                    'inLanguage' => $b->language ?: null,
                ], fn($v) => $v !== null),
            ];
            $listElements[] = $item;
        }
        $itemListSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Daftar Publikasi',
            'itemListOrder' => 'Ascending',
            'numberOfItems' => count($listElements),
            'itemListElement' => $listElements,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($itemListSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif

@section('content')
    <div class="main-wrapper overflow-hidden my-3">
        <div class="container">
            <h1 class="fs-5 mb-3">Daftar Publikasi</h1>
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($books as $b)
                            <li class="list-group-item">
                                <a href="{{ route('bookDetail', $b->slug) }}" class="fw-bold">
                                    {{ $b->title }}
                                </a>
                                <div class="text-muted">
                                    @if ($b->authors->count() > 0)
                                        {{ $b->authors->take(3)->map(function ($author) { return $author->author ?? $author->user->full_name; })->implode(', ') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">Belum ada publikasi.</li>
                        @endforelse
                    </ul>
                    <div class="mt-3">
                        {{ $books->links('vendor.pagination.landing-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
