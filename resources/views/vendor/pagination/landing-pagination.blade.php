@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4 py-3" role="navigation">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-100 rounded-xl cursor-default">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-100 rounded-xl cursor-default">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    {!! __('Showing') !!}
                    <span class="font-bold text-gray-900">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-bold text-gray-900">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-bold text-gray-900">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="cursor-default opacity-50" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="size-10 rounded-xl border border-gray-100 bg-white text-gray-400 flex items-center justify-center">
                                <i class="ki-filled ki-left text-lg"></i>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="size-10 rounded-xl border border-gray-100 bg-white text-gray-600 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm" aria-label="@lang('pagination.previous')">
                                <i class="ki-filled ki-left text-lg"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="size-10 flex items-center justify-center text-gray-400 font-bold" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li aria-current="page">
                                        <span class="size-10 rounded-xl bg-primary text-white flex items-center justify-center font-bold shadow-lg shadow-primary/20 transition-all border border-primary">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" class="size-10 rounded-xl border border-gray-100 bg-white text-gray-600 flex items-center justify-center font-bold hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="size-10 rounded-xl border border-gray-100 bg-white text-gray-600 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm" aria-label="@lang('pagination.next')">
                                <i class="ki-filled ki-right text-lg"></i>
                            </a>
                        </li>
                    @else
                        <li class="cursor-default opacity-50" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="size-10 rounded-xl border border-gray-100 bg-white text-gray-400 flex items-center justify-center">
                                <i class="ki-filled ki-right text-lg"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
