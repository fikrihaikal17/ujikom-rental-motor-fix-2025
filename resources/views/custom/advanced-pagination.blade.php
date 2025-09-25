@if ($paginator->hasPages())
    {{-- Advanced Pagination Container --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Header Section with Enhanced Stats --}}
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Left: Results Information --}}
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-gray-900">Data Pagination</h4>
                        <p class="text-sm text-gray-600">
                            Menampilkan 
                            <span class="font-semibold text-blue-600">{{ number_format($paginator->firstItem()) }}</span> - 
                            <span class="font-semibold text-blue-600">{{ number_format($paginator->lastItem()) }}</span> 
                            dari 
                            <span class="font-semibold text-blue-600">{{ number_format($paginator->total()) }}</span> total data
                        </p>
                    </div>
                </div>

                {{-- Right: Page Info & Quick Stats --}}
                <div class="flex items-center space-x-4">
                    {{-- Current Page Indicator --}}
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Halaman</span>
                        <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300">
                            {{ $paginator->currentPage() }} / {{ number_format($paginator->lastPage()) }}
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="hidden lg:flex items-center space-x-2">
                        <span class="text-xs text-gray-500">Progress:</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ ($paginator->currentPage() / $paginator->lastPage()) * 100 }}%">
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">{{ round(($paginator->currentPage() / $paginator->lastPage()) * 100) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Pagination Controls --}}
        <div class="px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Navigation Controls Left --}}
                <div class="flex items-center space-x-2">
                    {{-- First Page Button --}}
                    @if ($paginator->currentPage() > 3)
                        <a href="{{ $paginator->url(1) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200 shadow-sm"
                           title="Ke Halaman Pertama">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                            <span class="ml-1 hidden sm:inline">First</span>
                        </a>
                    @endif

                    {{-- Previous Button --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                    @endif
                </div>

                {{-- Page Numbers (Desktop) --}}
                <div class="hidden md:flex items-center space-x-1">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                </svg>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-600 rounded-lg shadow-md transform scale-105">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:shadow-md transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Navigation Controls Right --}}
                <div class="flex items-center space-x-2">
                    {{-- Next Button --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200 shadow-sm">
                            Next
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                            Next
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif

                    {{-- Last Page Button --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        <a href="{{ $paginator->url($paginator->lastPage()) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200 shadow-sm"
                           title="Ke Halaman Terakhir">
                            <span class="mr-1 hidden sm:inline">Last</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Mobile Pagination --}}
        <div class="md:hidden border-t border-gray-200 px-6 py-4 bg-gray-50">
            <div class="flex items-center justify-between">
                {{-- Mobile Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </a>
                @endif

                {{-- Mobile Page Info --}}
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Page</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $paginator->currentPage() }}
                    </span>
                    <span class="text-sm text-gray-600">of</span>
                    <span class="text-sm font-medium text-gray-900">{{ $paginator->lastPage() }}</span>
                </div>

                {{-- Mobile Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Next
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                        Next
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- Enhanced Footer with Statistics --}}
        <div class="hidden lg:block px-6 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
            <div class="flex items-center justify-between">
                {{-- Left: Pagination Details --}}
                <div class="flex items-center space-x-6 text-sm text-gray-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Per halaman: <span class="font-medium text-gray-900">{{ $paginator->perPage() }}</span> data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                        <span>Total halaman: <span class="font-medium text-gray-900">{{ number_format($paginator->lastPage()) }}</span></span>
                    </div>
                </div>

                {{-- Right: Navigation Tips --}}
                <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Gunakan tombol First/Last untuk navigasi cepat</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination Enhancement Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.target.tagName.toLowerCase() === 'input') return; // Don't interfere with form inputs
                
                if (e.key === 'ArrowLeft' && e.ctrlKey) {
                    // Ctrl + Left Arrow = Previous page
                    @if (!$paginator->onFirstPage())
                        window.location.href = '{{ $paginator->previousPageUrl() }}';
                    @endif
                } else if (e.key === 'ArrowRight' && e.ctrlKey) {
                    // Ctrl + Right Arrow = Next page
                    @if ($paginator->hasMorePages())
                        window.location.href = '{{ $paginator->nextPageUrl() }}';
                    @endif
                }
            });

            // Add loading state to pagination links
            const paginationLinks = document.querySelectorAll('a[href*="page="]');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';
                    
                    // Add loading spinner
                    const originalContent = this.innerHTML;
                    const spinner = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                    
                    if (this.querySelector('svg')) {
                        // Replace existing icon with spinner
                        const svg = this.querySelector('svg');
                        svg.outerHTML = spinner;
                    }
                });
            });
        });
    </script>
@endif