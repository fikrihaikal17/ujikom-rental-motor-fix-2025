@extends('layouts.sidebar')

@section('title', 'Detail Bagi Hasil')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-4">
          <li>
            <div>
              <a href="{{ route('admin.bagi-hasil.index') }}" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Bagi Hasil</span>
                History Bagi Hasil
              </a>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="ml-4 text-sm font-medium text-gray-500">Detail #{{ $bagiHasil->id }}</span>
            </div>
          </li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">Detail Bagi Hasil #{{ $bagiHasil->id }}</h1>
      <p class="mt-2 text-sm text-gray-700">Informasi lengkap tentang pembagian hasil revenue.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <a href="{{ route('admin.bagi-hasil.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
  
  <!-- Left Column - Main Info -->
  <div class="lg:col-span-2 space-y-6">
    
    <!-- Revenue Share Details -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Rincian Bagi Hasil</h3>
          <p class="mt-1 text-sm text-gray-500">Detail pembagian revenue antara admin dan owner</p>
        </div>
        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div class="bg-green-50 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-green-800">Total Pendapatan</p>
                <p class="text-lg font-semibold text-green-900">Rp {{ number_format($bagiHasil->total_pendapatan, 0, ',', '.') }}</p>
              </div>
            </div>
          </div>
          
          <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-blue-800">Bagian Admin</p>
                <p class="text-lg font-semibold text-blue-900">Rp {{ number_format($bagiHasil->bagi_hasil_admin, 0, ',', '.') }}</p>
                <p class="text-xs text-blue-600">
                  {{ number_format(($bagiHasil->bagi_hasil_admin / $bagiHasil->total_pendapatan) * 100, 1) }}%
                </p>
              </div>
            </div>
          </div>
          
          <div class="bg-purple-50 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-purple-800">Bagian Owner</p>
                <p class="text-lg font-semibold text-purple-900">Rp {{ number_format($bagiHasil->bagi_hasil_pemilik, 0, ',', '.') }}</p>
                <p class="text-xs text-purple-600">
                  {{ number_format(($bagiHasil->bagi_hasil_pemilik / $bagiHasil->total_pendapatan) * 100, 1) }}%
                </p>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-800">Tanggal Bagi Hasil</p>
                <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($bagiHasil->tanggal)->format('d M Y') }}</p>
              </div>
            </div>
          </div>
        </div>

        @if($bagiHasil->catatan)
        <div class="mt-6 pt-4 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-900 mb-2">Catatan</h4>
          <p class="text-sm text-gray-600 bg-gray-50 rounded-md p-3">{{ $bagiHasil->catatan }}</p>
        </div>
        @endif
      </div>
    </div>

    <!-- Rental Information -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Penyewaan</h3>
          <p class="mt-1 text-sm text-gray-500">Detail transaksi rental yang menjadi dasar bagi hasil</p>
        </div>
        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">ID Penyewaan</dt>
            <dd class="mt-1 text-sm text-gray-900">#{{ $bagiHasil->penyewaan->id }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($bagiHasil->penyewaan->tanggal_mulai)->format('d M Y') }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($bagiHasil->penyewaan->tanggal_selesai)->format('d M Y') }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Total Hari</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $bagiHasil->penyewaan->total_hari }} hari</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Status Penyewaan</dt>
            <dd class="mt-1">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                {{ $bagiHasil->penyewaan->status->getDisplayName() }}
              </span>
            </dd>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Information -->
    @if($bagiHasil->penyewaan->payments->count() > 0)
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Riwayat Pembayaran</h3>
          <p class="mt-1 text-sm text-gray-500">Detail pembayaran dari penyewa</p>
        </div>
        
        <div class="space-y-3">
          @foreach($bagiHasil->penyewaan->payments as $payment)
          <div class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
            <div>
              <p class="text-sm font-medium text-gray-900">{{ $payment->jenis_pembayaran }}</p>
              <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d M Y H:i') }}</p>
            </div>
            <div class="text-right">
              <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</p>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                Lunas
              </span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

  </div>

  <!-- Right Column - Side Info -->
  <div class="space-y-6">
    
    <!-- Owner Information -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Owner</h3>
        </div>
        
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
              <span class="text-lg font-medium text-gray-700">{{ substr($bagiHasil->penyewaan->motor->owner->nama, 0, 1) }}</span>
            </div>
          </div>
          <div class="ml-4">
            <div class="text-lg font-medium text-gray-900">{{ $bagiHasil->penyewaan->motor->owner->nama }}</div>
            <div class="text-sm text-gray-500">{{ $bagiHasil->penyewaan->motor->owner->email }}</div>
            <div class="text-sm text-gray-500">{{ $bagiHasil->penyewaan->motor->owner->no_hp }}</div>
          </div>
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-200">
          <div class="space-y-2">
            <div>
              <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Alamat</dt>
              <dd class="text-sm text-gray-900">{{ $bagiHasil->penyewaan->motor->owner->alamat ?? 'Tidak tersedia' }}</dd>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Motor Information -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Motor</h3>
        </div>
        
        <div class="space-y-3">
          <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Merk & Model</dt>
            <dd class="text-sm font-medium text-gray-900">{{ $bagiHasil->penyewaan->motor->merk }} {{ $bagiHasil->penyewaan->motor->model }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Plat</dt>
            <dd class="text-sm font-medium text-gray-900">{{ $bagiHasil->penyewaan->motor->no_plat }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tahun</dt>
            <dd class="text-sm text-gray-900">{{ $bagiHasil->penyewaan->motor->tahun }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tipe CC</dt>
            <dd class="text-sm text-gray-900">{{ $bagiHasil->penyewaan->motor->tipe_cc->getDisplayName() }}</dd>
          </div>
        </div>
      </div>
    </div>

    <!-- Renter Information -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Penyewa</h3>
        </div>
        
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="h-12 w-12 rounded-full bg-blue-300 flex items-center justify-center">
              <span class="text-lg font-medium text-blue-700">{{ substr($bagiHasil->penyewaan->penyewa->nama, 0, 1) }}</span>
            </div>
          </div>
          <div class="ml-4">
            <div class="text-lg font-medium text-gray-900">{{ $bagiHasil->penyewaan->penyewa->nama }}</div>
            <div class="text-sm text-gray-500">{{ $bagiHasil->penyewaan->penyewa->email }}</div>
            <div class="text-sm text-gray-500">{{ $bagiHasil->penyewaan->penyewa->no_hp }}</div>
          </div>
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-200">
          <div class="space-y-2">
            <div>
              <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Alamat</dt>
              <dd class="text-sm text-gray-900">{{ $bagiHasil->penyewaan->penyewa->alamat ?? 'Tidak tersedia' }}</dd>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Status & Actions -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Status & Aksi</h3>
        </div>
        
        <div class="space-y-4">
          <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status Settlement</dt>
            <dd class="mt-1">
              @if($bagiHasil->settled_at)
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  Diselesaikan
                </span>
                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($bagiHasil->settled_at)->format('d M Y H:i') }}</p>
              @else
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                  Menunggu
                </span>
              @endif
            </dd>
          </div>
          
          @if(!$bagiHasil->settled_at)
          <div class="pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('admin.bagi-hasil.process', $bagiHasil) }}">
              @csrf
              @method('PATCH')
              <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Proses Settlement
              </button>
            </form>
          </div>
          @endif
        </div>
      </div>
    </div>

  </div>
</div>
@endsection