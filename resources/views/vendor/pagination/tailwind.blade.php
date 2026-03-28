@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile Pagination --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-500 font-bold rounded-xl text-sm cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span>السابق</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span>السابق</span>
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] text-sm">
                    <span>التالي</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-500 font-bold rounded-xl text-sm cursor-not-allowed">
                    <span>التالي</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop Pagination --}}
        <div class="hidden sm:flex-1 sm:flex sm:gap-4 sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-brand-500 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div class="flex items-center gap-2"> {{-- Added gap-2 for spacing between buttons --}}

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-500 font-bold rounded-xl text-sm cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            <span>السابق</span>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] text-sm" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        <span>السابق</span>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="px-4 py-2 text-sm text-brand-500">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="px-4 py-2 text-sm font-semibold text-white bg-brand-600 rounded-xl">
                                        {{ $page }}
                                    </span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-xl transition-colors" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] text-sm" aria-label="{{ __('pagination.next') }}">
                        <span>التالي</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-500 font-bold rounded-xl text-sm cursor-not-allowed">
                            <span>التالي</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
