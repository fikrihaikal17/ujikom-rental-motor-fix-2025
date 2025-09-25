@if ($paginator->hasPages())
    {{-- Main Pagination Container --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        {{-- Header with Results Info --}}
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Data Pagination</p>
                    <p class="text-xs text-gray-500">
                        Menampilkan <span class="font-medium text-blue-600">{{ $paginator->firstItem() }}</span> 
                        hingga <span class="font-medium text-blue-600">{{ $paginator->lastItem() }}</span> 
                        dari <span class="font-medium text-blue-600">{{ $paginator->total() }}</span> total data
                    </p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-2">
                <span class="text-xs text-gray-500">Halaman</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>
            </div>
        </div>

        {{-- Pagination Controls --}}
        <div class="flex items-center justify-between px-4 py-4">
            {{-- Previous/First Controls --}}
            <div class="flex items-center space-x-1">
                {{-- First Page --}}
                @if ($paginator->currentPage() > 3)
                    <a href="{{ $paginator->url(1) }}" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400 transition-all duration-200" title="Halaman Pertama">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                    </a>
                @endif

                {{-- Previous Page --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </a>
                @endif
            </div>

            {{-- Page Numbers --}}
            <div class="hidden sm:flex items-center space-x-1">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-500 bg-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-600 rounded-md shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next/Last Controls --}}
            <div class="flex items-center space-x-1">
                {{-- Next Page --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif

                {{-- Last Page --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400 transition-all duration-200" title="Halaman Terakhir">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Mobile Pagination --}}
        <div class="sm:hidden border-t border-gray-200 px-4 py-3 bg-gray-50">
            <div class="flex items-center justify-between">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </a>
                @endif

                <div class="flex items-center space-x-2 text-sm text-gray-700">
                    <span>Hal.</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $paginator->currentPage() }}
                    </span>
                    <span>dari</span>
                    <span class="font-medium">{{ $paginator->lastPage() }}</span>
                </div>

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                        Selanjutnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- Footer with Additional Info --}}
        <div class="hidden lg:block px-4 py-2 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center space-x-4">
                    <span>Per halaman: {{ $paginator->perPage() }} data</span>
                    <span>•</span>
                    <span>Total halaman: {{ $paginator->lastPage() }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Gunakan tombol panah untuk navigasi cepat</span>
                </div>
            </div>
        </div>
    </div>
@endif