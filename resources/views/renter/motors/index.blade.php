@extends('layouts.renter')

@section('title', 'Cari Motor')
@section('subtitle', 'Temukan motor yang perfect untuk perjalanan Anda')

@section('content')
<div class="space-y-6">
  <!-- Search and Filter Section -->
  <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
    <form method="GET" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
          <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Motor</label>
          <div class="relative">
            <input type="text" name="search" id="search" value="{{ request('search') }}"
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Cari berdasarkan merk, model, atau plat nomor...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Engine Capacity Filter -->
        <div>
          <label for="tipe_cc" class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Mesin</label>
          <select name="tipe_cc" id="tipe_cc"
            class="block w-full py-3 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua CC</option>
            <option value="100" {{ request('tipe_cc') == '100' ? 'selected' : '' }}>100 CC</option>
            <option value="125" {{ request('tipe_cc') == '125' ? 'selected' : '' }}>125 CC</option>
            <option value="150" {{ request('tipe_cc') == '150' ? 'selected' : '' }}>150 CC</option>
          </select>
        </div>

        <!-- Brand Filter -->
        <div>
          <label for="merk" class="block text-sm font-medium text-gray-700 mb-2">Merk</label>
          <select name="merk" id="merk"
            class="block w-full py-3 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Merk</option>
            @foreach($brands as $brand)
            <option value="{{ $brand }}" {{ request('merk') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <!-- Sort Options -->
        <div class="flex items-center space-x-4">
          <label for="sort" class="text-sm font-medium text-gray-700">Urutkan:</label>
          <select name="sort" id="sort"
            class="py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Terbaru</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
          </select>
        </div>

        <!-- Search Button -->
        <div class="flex space-x-3">
          <a href="{{ route('renter.motors.index') }}"
            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
            Reset
          </a>
          <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Cari
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Results Header -->
  <div class="flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-gray-900">Motor Tersedia</h3>
      <p class="text-sm text-gray-600">Ditemukan {{ $motors->total() }} motor</p>
    </div>

    @if($motors->hasPages())
    <div class="text-sm text-gray-600">
      Menampilkan {{ $motors->firstItem() }}-{{ $motors->lastItem() }} dari {{ $motors->total() }} hasil
    </div>
    @endif
  </div>

  <!-- Motors Grid -->
  @if($motors->count() > 0)
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($motors as $motor)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
      <!-- Motor Image -->
      <div class="relative">
        @if($motor->photo)
        <img src="{{ asset($motor->photo) }}"
          alt="{{ $motor->merk }} {{ $motor->model }}"
          class="w-full h-48 object-cover">
        @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        @endif

        <!-- CC Badge -->
        <div class="absolute top-3 left-3">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            {{ $motor->tipe_cc }} CC
          </span>
        </div>

        <!-- Available Badge -->
        <div class="absolute top-3 right-3">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            Tersedia
          </span>
        </div>
      </div>

      <!-- Motor Info -->
      <div class="p-4">
        <div class="mb-2">
          <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $motor->merk }}</h4>
          <p class="text-gray-600 mb-1">{{ $motor->merk }} {{ $motor->model }}</p>
        </div>

        <div class="flex items-center justify-between mb-3">
          <p class="text-sm text-gray-500">{{ $motor->model }} • {{ $motor->tahun }}</p>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
            {{ $motor->no_plat }}
          </span>
        </div>

        <!-- Pricing -->
        @if($motor->tarifRental)
        <div class="space-y-1 mb-4">
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Harian:</span>
            <span class="font-semibold text-gray-900">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span>
          </div>
          @if($motor->tarifRental->tarif_mingguan)
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Mingguan:</span>
            <span class="font-semibold text-gray-900">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span>
          </div>
          @endif
        </div>
        @endif

        <!-- Owner Info -->
        <div class="flex items-center mb-4">
          <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-2">
            <span class="text-xs font-medium text-gray-600">
              {{ strtoupper(substr($motor->owner->nama, 0, 1)) }}
            </span>
          </div>
          <span class="text-sm text-gray-600">{{ $motor->owner->nama }}</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-2">
          <a href="{{ route('renter.motors.show', $motor) }}"
            class="flex-1 text-center px-3 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
            Lihat Detail
          </a>
          <a href="{{ route('renter.bookings.create', $motor) }}"
            class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
            Sewa Sekarang
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  @if($motors->hasPages())
  <div class="flex justify-center mt-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
      <nav class="flex items-center justify-between">
        <div class="flex items-center text-sm text-gray-700">
          <span>Menampilkan</span>
          <span class="font-medium mx-1">{{ $motors->firstItem() }}</span>
          <span>sampai</span>
          <span class="font-medium mx-1">{{ $motors->lastItem() }}</span>
          <span>dari</span>
          <span class="font-medium mx-1">{{ $motors->total() }}</span>
          <span>hasil</span>
        </div>
        
        <div class="flex items-center space-x-1">
          {{-- Previous Page Link --}}
          @if ($motors->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
              ←
            </span>
          @else
            <a href="{{ $motors->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-gray-800 transition-colors">
              ←
            </a>
          @endif

          {{-- Pagination Elements --}}
          @foreach ($motors->getUrlRange(1, $motors->lastPage()) as $page => $url)
            @if ($page == $motors->currentPage())
              <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md">
                {{ $page }}
              </span>
            @else
              <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-gray-800 transition-colors">
                {{ $page }}
              </a>
            @endif
          @endforeach

          {{-- Next Page Link --}}
          @if ($motors->hasMorePages())
            <a href="{{ $motors->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-gray-800 transition-colors">
              →
            </a>
          @else
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
              →
            </span>
          @endif
        </div>
      </nav>
    </div>
  </div>
  @endif

  @else
  <!-- Empty State -->
  <div class="bg-white rounded-xl p-12 text-center shadow-sm border border-gray-200">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada motor ditemukan</h3>
    <p class="text-gray-600 mb-6">Coba ubah filter pencarian atau kata kunci Anda</p>
    <a href="{{ route('renter.motors.index') }}"
      class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
      </svg>
      Reset Filter
    </a>
  </div>
  @endif
</div>



@push('scripts')
<script>
  // Auto-submit form when filter changes
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const filterSelects = document.querySelectorAll('select[name="tipe_cc"], select[name="merk"], select[name="sort"]');

    filterSelects.forEach(select => {
      select.addEventListener('change', function() {
        form.submit();
      });
    });
  });
</script>
@endpush
@endsection