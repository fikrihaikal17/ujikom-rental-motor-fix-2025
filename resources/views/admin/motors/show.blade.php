@extends('layouts.sidebar')

@section('title', 'Detail Motor')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('admin.motors.index') }}" class="mr-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </a>
        <div class="flex-1">
          <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-semibold leading-6 text-gray-900">Detail Motor</h1>
              <p class="mt-1 text-sm text-gray-600">Kelola informasi lengkap motor <span class="font-medium text-green-600">{{ $motor->merek }} {{ $motor->model }}</span></p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Action Buttons -->
      <div class="flex items-center space-x-4">
        @if(!$motor->verified_at)
        <form action="{{ route('admin.motors.verify', $motor) }}" method="POST" class="inline">
          @csrf
          <button type="submit"
            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm"
            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Verifikasi Motor
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>

  <!-- Motor Profile Card -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden mb-8">
    <!-- Profile Header -->
    <div class="px-6 py-6 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="h-20 w-20 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center shadow-lg">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <h2 class="text-2xl font-bold text-gray-900">{{ $motor->merek }} {{ $motor->model }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ $motor->plat_nomor }}</p>
          <div class="mt-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            @if($motor->verified_at)
              bg-green-100 text-green-800
            @else
              bg-yellow-100 text-yellow-800
            @endif">
              @if($motor->verified_at)
                ✅ Terverifikasi
              @else
                ⏳ Menunggu Verifikasi
              @endif
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Motor Details -->
    <div class="px-6 py-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Motor Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Informasi Motor
          </h3>
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-1.414.586H7a4 4 0 01-4-4V7a4 4 0 014-4z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Merek & Model</p>
                <p class="text-gray-900">{{ $motor->merek }} {{ $motor->model }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Plat Nomor</p>
                <p class="text-gray-900 font-mono">{{ $motor->plat_nomor }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Tipe Motor</p>
                <p class="text-gray-900">{{ $motor->type?->getDisplayName() ?? 'Tidak ada' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Owner Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Pemilik
          </h3>
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-lg">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Nama Pemilik</p>
                <p class="text-gray-900">{{ $motor->owner->nama }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Email</p>
                <p class="text-gray-900">{{ $motor->owner->email }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">No. Telepon</p>
                <p class="text-gray-900">{{ $motor->owner->no_tlpn ?? 'Tidak ada' }}</p>
              </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="flex items-center space-x-2 mb-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Bergabung Sejak</span>
              </div>
              <p class="text-gray-900">{{ $motor->owner->created_at->format('d F Y') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Additional Information Cards -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Technical Specifications -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
          <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
          </svg>
          Spesifikasi Teknis
        </h3>
      </div>
      <div class="px-6 py-4">
        <div class="space-y-4">
          <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-600">Tahun</span>
            <span class="text-sm font-semibold text-gray-900">{{ $motor->tahun ?? 'Tidak ada' }}</span>
          </div>
          <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-600">Warna</span>
            <span class="text-sm font-semibold text-gray-900">{{ $motor->warna ?? 'Tidak ada' }}</span>
          </div>
          <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-600">CC Motor</span>
            <span class="text-sm font-semibold text-gray-900">{{ $motor->cc ?? 'Tidak ada' }} CC</span>
          </div>
          <div class="flex justify-between items-center py-2">
            <span class="text-sm font-medium text-gray-600">Status</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
            @if($motor->status?->value === 'available')
              bg-green-100 text-green-800
            @elseif($motor->status?->value === 'rented')
              bg-yellow-100 text-yellow-800
            @else
              bg-gray-100 text-gray-800
            @endif">
              {{ $motor->status?->getDisplayName() ?? 'Tidak ada' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Verification Details -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
          <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Detail Verifikasi
        </h3>
      </div>
      <div class="px-6 py-4">
        <div class="space-y-4">
          <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span class="text-sm font-medium text-gray-700">Status Verifikasi</span>
            </div>
            @if($motor->verified_at)
              <p class="text-green-700 font-medium">✅ Terverifikasi</p>
              <p class="text-sm text-gray-600">{{ $motor->verified_at->format('d F Y, H:i') }} WIB</p>
            @else
              <p class="text-yellow-700 font-medium">⏳ Menunggu Verifikasi</p>
              <p class="text-sm text-gray-600">Motor belum diverifikasi oleh admin</p>
            @endif
          </div>

          @if($motor->verified_by)
          <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-600">Diverifikasi oleh</span>
            <span class="text-sm font-semibold text-gray-900">{{ $motor->verifiedBy->nama ?? 'Admin' }}</span>
          </div>
          @endif

          <div class="flex justify-between items-center py-2">
            <span class="text-sm font-medium text-gray-600">Tanggal Pendaftaran</span>
            <span class="text-sm font-semibold text-gray-900">{{ $motor->created_at->format('d F Y') }}</span>
          </div>
        </div>

        @if($motor->deskripsi)
        <div class="mt-4 pt-4 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-700 mb-2">Deskripsi Motor</h4>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $motor->deskripsi }}</p>
        </div>
        @endif

        @if($motor->admin_notes)
        <div class="mt-4 pt-4 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Admin</h4>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $motor->admin_notes }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
  <div class="mb-6 rounded-md bg-green-50 p-4">
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
  <div class="mb-6 rounded-md bg-red-50 p-4">
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

  <!-- Statistics Card -->
  @if($motor->verified_at)
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
      <h3 class="text-lg font-semibold text-gray-900 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Statistik & Kinerja Motor
      </h3>
    </div>
    <div class="px-6 py-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center">
          <div class="bg-green-100 rounded-full p-3 w-12 h-12 mx-auto mb-3 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-gray-900">{{ $motor->penyewaans->count() }}</p>
          <p class="text-sm text-gray-600">Total Penyewaan</p>
        </div>
        <div class="text-center">
          <div class="bg-blue-100 rounded-full p-3 w-12 h-12 mx-auto mb-3 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($motor->penyewaans->sum('total_harga'), 0, ',', '.') }}</p>
          <p class="text-sm text-gray-600">Total Pendapatan</p>
        </div>
        <div class="text-center">
          <div class="bg-yellow-100 rounded-full p-3 w-12 h-12 mx-auto mb-3 flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-gray-900">-</p>
          <p class="text-sm text-gray-600">Rating Rata-rata</p>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection