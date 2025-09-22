@extends('layouts.sidebar')

@section('title', 'Detail Motor')
@section('page-title', 'Detail Motor')

@section('content')ds('layouts.sidebar')

@section('title', 'Detail Motor')
@section('page-title', 'Detail Motor - Verifikasi')

@section('sidebar-menu')
<div class="space-y-1">
  <!-- Dashboard -->
  <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v8l4-4 4 4V5"></path>
    </svg>
    Dashboard
  </a>

  <!-- Users Management -->
  <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
    </svg>
    Kelola Pengguna
  </a>

  <!-- Motor Verification -->
  <a href="{{ route('admin.motors.index') }}" class="bg-primary-100 text-primary-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-primary-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Verifikasi Motor
  </a>

  <!-- Tarif Management -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
    </svg>
    Kelola Tarif
  </a>

  <!-- Transactions -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    Transaksi
  </a>

  <!-- Reports -->
  <div x-data="{ open: false }" class="space-y-1">
    <button @click="open = !open" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group w-full flex items-center pl-2 pr-1 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
      <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
      </svg>
      <span class="flex-1">Laporan</span>
      <svg :class="{'text-gray-400 rotate-90': open, 'text-gray-300': !open}" class="ml-3 flex-shrink-0 h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
      </svg>
    </button>
    <div x-show="open" class="space-y-1">
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Pendapatan
      </a>
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Analitik
      </a>
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Export Data
      </a>
    </div>
  </div>

  <!-- Settings -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
    Pengaturan
  </a>
</div>
@endsection

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <a href="{{ route('admin.motors.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Detail Motor</h1>
        <p class="mt-2 text-sm text-gray-700">{{ $motor->merk }} {{ $motor->model }} - {{ $motor->no_plat }}</p>
      </div>
    </div>
    <div class="flex items-center space-x-3">
      <!-- Status Badge -->
      <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                {{ $motor->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($motor->status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
        {{ ucfirst($motor->status) }}
      </span>
    </div>
  </div>
</div>

<!-- Motor Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
  <!-- Motor Information -->
  <div class="lg:col-span-2">
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Motor</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Merk & Model</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->merk }} {{ $motor->model }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Tahun</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->tahun }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">No. Plat</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->no_plat }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Warna</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->warna ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Ketersediaan</dt>
            <dd class="mt-1 text-sm text-gray-900">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $motor->ketersediaan === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($motor->ketersediaan) }}
              </span>
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Tanggal Daftar</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->created_at->format('d M Y H:i') }}</dd>
          </div>
          @if($motor->deskripsi)
          <div class="sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $motor->deskripsi }}</dd>
          </div>
          @endif
        </dl>
      </div>
    </div>

    <!-- Pricing Information -->
    @if($motor->tarifRental)
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Tarif</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Harga per Hari</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">
              Rp {{ number_format($motor->tarifRental->harga_per_hari, 0, ',', '.') }}
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Jenis Tarif</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($motor->tarifRental->jenis_tarif) }}</dd>
          </div>
          @if($motor->tarifRental->denda_keterlambatan)
          <div>
            <dt class="text-sm font-medium text-gray-500">Denda Keterlambatan</dt>
            <dd class="mt-1 text-sm text-gray-900">
              Rp {{ number_format($motor->tarifRental->denda_keterlambatan, 0, ',', '.') }}
            </dd>
          </div>
          @endif
        </dl>
      </div>
    </div>
    @endif

    <!-- Rental History -->
    @if($motor->penyewaans->count() > 0)
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Riwayat Rental</h3>
        <div class="flow-root">
          <ul class="-mb-8">
            @foreach($motor->penyewaans->take(5) as $rental)
            <li>
              <div class="relative pb-8">
                @if(!$loop->last)
                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                @endif
                <div class="relative flex space-x-3">
                  <div>
                    <span class="h-8 w-8 rounded-full 
                                            {{ $rental->status_penyewaan === 'selesai' ? 'bg-green-500' : 
                                               ($rental->status_penyewaan === 'berlangsung' ? 'bg-blue-500' : 'bg-gray-400') }} 
                                            flex items-center justify-center ring-8 ring-white">
                      <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                      </svg>
                    </span>
                  </div>
                  <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                    <div>
                      <p class="text-sm text-gray-500">
                        Disewa oleh <a href="#" class="font-medium text-gray-900">{{ $rental->renter->nama }}</a>
                      </p>
                      <p class="text-xs text-gray-400">
                        {{ $rental->tanggal_mulai->format('d M Y') }} - {{ $rental->tanggal_selesai->format('d M Y') }}
                      </p>
                    </div>
                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $rental->status_penyewaan === 'selesai' ? 'bg-green-100 text-green-800' : 
                                                   ($rental->status_penyewaan === 'berlangsung' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($rental->status_penyewaan) }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    @endif
  </div>

  <!-- Owner Information & Actions -->
  <div class="space-y-6">
    <!-- Owner Info -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Owner</h3>
        <div class="flex items-center">
          <div class="flex-shrink-0 h-12 w-12">
            <div class="h-12 w-12 rounded-full bg-primary-500 flex items-center justify-center">
              <span class="text-sm font-medium text-white">{{ strtoupper(substr($motor->owner->nama, 0, 1)) }}</span>
            </div>
          </div>
          <div class="ml-4">
            <div class="text-sm font-medium text-gray-900">{{ $motor->owner->nama }}</div>
            <div class="text-sm text-gray-500">{{ $motor->owner->email }}</div>
            <div class="text-sm text-gray-500">{{ $motor->owner->no_telp }}</div>
          </div>
        </div>
        <div class="mt-4">
          <dt class="text-sm font-medium text-gray-500">Alamat</dt>
          <dd class="mt-1 text-sm text-gray-900">{{ $motor->owner->alamat }}</dd>
        </div>
      </div>
    </div>

    <!-- Admin Notes -->
    @if($motor->admin_notes)
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Catatan Admin</h3>
        <p class="text-sm text-gray-700">{{ $motor->admin_notes }}</p>
        @if($motor->verified_at)
        <p class="mt-2 text-xs text-gray-500">
          Diverifikasi pada {{ $motor->verified_at->format('d M Y H:i') }}
        </p>
        @endif
      </div>
    </div>
    @endif

    <!-- Verification Actions -->
    @if($motor->status === 'pending')
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Verifikasi</h3>

        <!-- Verify Form -->
        <form action="{{ route('admin.motors.verify', $motor) }}" method="POST" class="mb-4">
          @csrf
          @method('PATCH')
          <div class="mb-3">
            <label for="verify_notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="notes" id="verify_notes" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
              placeholder="Tambahkan catatan verifikasi..."></textarea>
          </div>
          <button type="submit"
            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Verifikasi Motor
          </button>
        </form>

        <!-- Reject Form -->
        <form action="{{ route('admin.motors.reject', $motor) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="mb-3">
            <label for="reject_notes" class="block text-sm font-medium text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
            <textarea name="notes" id="reject_notes" rows="3" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
              placeholder="Jelaskan alasan penolakan..."></textarea>
          </div>
          <button type="submit"
            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            onclick="return confirm('Apakah Anda yakin ingin menolak motor ini?')">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Tolak Motor
          </button>
        </form>
      </div>
    </div>
    @endif

    <!-- Statistics -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Statistik</h3>
        <dl class="space-y-4">
          <div>
            <dt class="text-sm font-medium text-gray-500">Total Rental</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $motor->penyewaans->count() }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Rental Aktif</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">
              {{ $motor->penyewaans->where('status_penyewaan', 'berlangsung')->count() }}
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Rating Rata-rata</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">
              <span class="text-yellow-400">★★★★☆</span> 4.5
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection