@extends('layouts.sidebar')

@section('title', 'Kelola Pengguna')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Pengguna</h1>
      <p class="mt-2 text-sm text-gray-700">Daftar semua pengguna yang terdaftar di sistem RideNow.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3 flex">
      <a href="#" onclick="exportPDF()" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        Export PDF
      </a>
      <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Pengguna
      </a>
    </div>
  </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="mb-4 rounded-md bg-green-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
  </div>
</div>
@endif

@if(session('error'))
<div class="mb-4 rounded-md bg-red-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
    </div>
  </div>
</div>
@endif

<!-- Enhanced Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
  <div class="px-6 py-4 border-b border-gray-200">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-sm">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Filter & Pencarian</h3>
          <p class="text-sm text-gray-600">Cari dan filter pengguna berdasarkan kriteria tertentu</p>
        </div>
      </div>
      
      <!-- Active Filters Indicator -->
      @if(request('search') || request('role'))
      <div class="flex items-center space-x-2">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
          Filter Aktif
        </span>
        <span class="text-sm text-gray-500">
          {{ $users->total() }} hasil ditemukan
        </span>
      </div>
      @else
      <div class="text-sm text-gray-500">
        Total {{ $users->total() }} pengguna
      </div>
      @endif
    </div>
  </div>

  <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form" class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
      <!-- Search Input -->
      <div class="lg:col-span-2">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
          <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Pencarian Pengguna
        </label>
        <div class="relative">
          <input type="text" 
                 id="search"
                 name="search" 
                 value="{{ request('search') }}" 
                 placeholder="Cari berdasarkan nama, email, atau telepon..." 
                 class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 sm:text-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          @if(request('search'))
          <button type="button" 
                  onclick="document.getElementById('search').value=''; document.getElementById('filter-form').submit();"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <svg class="h-4 w-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
          @endif
        </div>
      </div>

      <!-- Role Filter -->
      <div>
        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
          <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          Filter Role
        </label>
        <select name="role" 
                id="role"
                class="block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 sm:text-sm">
          <option value="">Semua Role</option>
          <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
            🛡️ Administrator
          </option>
          <option value="pemilik" {{ request('role') == 'pemilik' ? 'selected' : '' }}>
            🏍️ Pemilik Kendaraan
          </option>
          <option value="penyewa" {{ request('role') == 'penyewa' ? 'selected' : '' }}>
            👤 Penyewa
          </option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-col">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
          </svg>
          Aksi
        </label>
        
        <div class="flex flex-col space-y-2">
          <button type="submit" 
                  class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-sm font-medium text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transform hover:scale-105 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Terapkan Filter
          </button>

          @if(request('search') || request('role'))
          <a href="{{ route('admin.users.index') }}" 
             class="inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset Filter
          </a>
          @endif
        </div>
      </div>
    </div>

    <!-- Advanced Filters (Optional - can be expanded) -->
    <div class="mt-4 pt-4 border-t border-gray-200" x-data="{ showAdvanced: false }">
      <button type="button" 
              @click="showAdvanced = !showAdvanced"
              class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
        <svg class="w-4 h-4 mr-1 transition-transform duration-200" 
             :class="{ 'rotate-180': showAdvanced }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
        Filter Lanjutan
      </button>
      
      <div x-show="showAdvanced" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 transform scale-100"
           x-transition:leave-end="opacity-0 transform scale-95"
           class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4"
           style="display: none;">
        
        <!-- Date Range -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Tanggal Bergabung
          </label>
          <select name="date_range" class="block w-full py-2 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="">Semua Waktu</option>
            <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
          </select>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Status Akun
          </label>
          <select name="status" class="block w-full py-2 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>

        <!-- Sort By -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
            </svg>
            Urutkan Berdasarkan
          </label>
          <select name="sort" class="block w-full py-2 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
            <option value="created_desc" {{ request('sort', 'created_desc') == 'created_desc' ? 'selected' : '' }}>Terbaru</option>
            <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>Terlama</option>
          </select>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Users Table -->
<div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
  <div class="px-6 py-4 border-b border-gray-200">
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h3>
      <div class="flex items-center space-x-2 text-sm text-gray-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
        </svg>
        <span>{{ $users->count() }} dari {{ $users->total() }} pengguna</span>
      </div>
    </div>
  </div>

    @if($users->count() > 0)
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Pengguna
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Role
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Kontak
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Bergabung
            </th>
            <th scope="col" class="relative px-6 py-3">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($users as $user)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                  <div class="text-sm text-gray-500">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role->value === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role->value === 'pemilik' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                {{ $user->role->getDisplayName() }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <div>{{ $user->no_tlpn }}</div>
              <div class="text-gray-500 text-xs">{{ Str::limit($user->alamat, 30) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <time datetime="{{ $user->created_at->toISOString() }}" data-format="date">{{ $user->created_at->format('d M Y') }}</time>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-2">
                <a href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:text-primary-900">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
      {{ $users->links('custom.advanced-pagination') }}
    </div>
    @else
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengguna</h3>
      <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pengguna baru.</p>
      <div class="mt-6">
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Tambah Pengguna
        </a>
      </div>
    </div>
    @endif
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on role change
    document.getElementById('role').addEventListener('change', function() {
      document.getElementById('filter-form').submit();
    });

    // Real-time search with debounce
    let searchTimeout;
    const searchInput = document.getElementById('search');
    
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        // Only auto-submit if user has typed something or cleared the field
        if (this.value.length >= 3 || this.value.length === 0) {
          document.getElementById('filter-form').submit();
        }
      }, 500); // Wait 500ms after user stops typing
    });

    // Enhanced filter feedback
    const form = document.getElementById('filter-form');
    form.addEventListener('submit', function() {
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.innerHTML = `
        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Memfilter...
      `;
      submitBtn.disabled = true;
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      // Ctrl/Cmd + K to focus search
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
      }
      
      // Escape to clear search
      if (e.key === 'Escape' && document.activeElement === searchInput) {
        searchInput.value = '';
        document.getElementById('filter-form').submit();
      }
    });

    // Add search hints
    searchInput.setAttribute('title', 'Gunakan Ctrl+K untuk fokus cepat, Escape untuk clear');
  });

  // Export PDF function that includes current filters
  function exportPDF() {
    const form = document.getElementById('filter-form');
    const formData = new FormData(form);

    // Build URL with current filters
    let exportUrl = '{{ route("admin.users.export") }}';

    const params = new URLSearchParams();
    for (let [key, value] of formData.entries()) {
      if (value) {
        params.append(key, value);
      }
    }

    if (params.toString()) {
      exportUrl += '?' + params.toString();
    }

    // Navigate to export URL
    window.location.href = exportUrl;
  }

  // Filter statistics update
  function updateFilterStats() {
    const totalUsers = {{ $users->total() }};
    const currentResults = {{ $users->count() }};
    
    if (totalUsers !== currentResults) {
      const statsElement = document.querySelector('.filter-stats');
      if (statsElement) {
        statsElement.innerHTML = `
          <div class="flex items-center space-x-2 text-sm">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
            </svg>
            <span class="text-blue-600 font-medium">${currentResults} dari ${totalUsers} pengguna</span>
          </div>
        `;
      }
    }
  }
</script>

@push('styles')
<style>
  /* Custom styles for enhanced filter */
  .filter-input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
  }
  
  .filter-select:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
  }
  
  /* Smooth transitions for advanced filters */
  [x-cloak] { display: none !important; }
  
  /* Loading state styles */
  .btn-loading {
    pointer-events: none;
    opacity: 0.7;
  }
  
  /* Search input enhancements */
  #search::placeholder {
    color: #9ca3af;
    font-style: italic;
  }
  
  /* Active filter indicators */
  .active-filter {
    position: relative;
  }
  
  .active-filter::after {
    content: '';
    position: absolute;
    top: -2px;
    right: -2px;
    width: 8px;
    height: 8px;
    background: #3b82f6;
    border-radius: 50%;
    border: 2px solid white;
  }
</style>
@endpush
@endsection