@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center">
        <ul class="inline-flex flex-wrap items-center gap-1">
            @if ($paginator->onFirstPage())
                <li>
                    <span
                        class="inline-flex min-w-9 cursor-not-allowed justify-center rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-300"
                        aria-disabled="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"
                        class="inline-flex min-w-9 justify-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100">&lsaquo;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="inline-flex min-w-9 justify-center px-3 py-2 text-sm text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page"
                                    class="inline-flex min-w-9 justify-center rounded-md bg-gray-800 px-3 py-2 text-sm font-medium text-white">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" aria-label="Halaman {{ $page }}"
                                    class="inline-flex min-w-9 justify-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"
                        class="inline-flex min-w-9 justify-center rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100">&rsaquo;</a>
                </li>
            @else
                <li>
                    <span
                        class="inline-flex min-w-9 cursor-not-allowed justify-center rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-300"
                        aria-disabled="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif