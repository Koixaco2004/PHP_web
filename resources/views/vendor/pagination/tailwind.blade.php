@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between px-6 py-4 border-t border-secondary-200 dark:border-gray-700">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-secondary-500 dark:text-gray-500 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 cursor-default leading-5 rounded-md">
                    Trước
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 leading-5 rounded-md hover:text-secondary-500 dark:hover:text-gray-400 focus:outline-none focus:ring ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-300 dark:focus:border-primary-700 active:bg-secondary-100 dark:active:bg-gray-700 active:text-secondary-700 dark:active:text-gray-300 transition ease-in-out duration-150">
                    Trước
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 leading-5 rounded-md hover:text-secondary-500 dark:hover:text-gray-400 focus:outline-none focus:ring ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-300 dark:focus:border-primary-700 active:bg-secondary-100 dark:active:bg-gray-700 active:text-secondary-700 dark:active:text-gray-300 transition ease-in-out duration-150">
                    Tiếp
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-secondary-500 dark:text-gray-500 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 cursor-default leading-5 rounded-md">
                    Tiếp
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-secondary-700 dark:text-gray-300 leading-5">
                    Hiển thị
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        đến
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    trong
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    kết quả
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex items-center shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Trước">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-secondary-500 dark:text-gray-500 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 rounded-l-md leading-5 hover:bg-secondary-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-300 dark:focus:border-primary-700 active:bg-secondary-100 dark:active:bg-gray-700 active:text-secondary-700 dark:active:text-gray-300 transition ease-in-out duration-150" aria-label="Trước">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white dark:text-primary-900-dark bg-primary-600 dark:bg-primary-100-dark border border-primary-600 dark:border-primary-100-dark cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 leading-5 hover:bg-secondary-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-300 dark:focus:border-primary-700 active:bg-secondary-100 dark:active:bg-gray-700 active:text-secondary-700 dark:active:text-gray-300 transition ease-in-out duration-150" aria-label="Đến trang {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-secondary-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 rounded-r-md leading-5 hover:bg-secondary-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-300 dark:focus:border-primary-700 active:bg-secondary-100 dark:active:bg-gray-700 active:text-secondary-700 dark:active:text-gray-300 transition ease-in-out duration-150" aria-label="Tiếp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Tiếp">
                            <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-secondary-500 dark:text-gray-500 bg-white dark:bg-gray-800 border border-secondary-300 dark:border-gray-600 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
