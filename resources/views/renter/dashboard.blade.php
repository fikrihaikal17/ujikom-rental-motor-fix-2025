@extends('layouts.renter')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang di dashboard penyewa motor')

@section('content')
<div class="space-y-6">
  <!-- Welcome Section -->
  <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->email ?? 'Pengguna' }}! 👋</h1>
        <p class="text-blue-100 mt-1">Temukan motor terbaik untuk perjalanan Anda</p>
      </div>
      <div class="hidden md:block">
        <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Bookings -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Total Penyewaan</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_bookings'] }}</p>
        </div>
      </div>
    </div>

    <!-- Active Bookings -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Sedang Aktif</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_bookings'] }}</p>
        </div>
      </div>
    </div>

    <!-- Completed Bookings -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Selesai</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed_bookings'] }}</p>
        </div>
      </div>
    </div>

    <!-- Total Spent -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Total Biaya</p>
          <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="{{ route('renter.motors.index') }}"
        class="group p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200">
        <div class="text-center">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <h4 class="font-medium text-gray-900 mb-1">Cari Motor</h4>
          <p class="text-sm text-gray-600">Temukan motor sesuai kebutuhan Anda</p>
        </div>
      </a>

      <a href="{{ route('renter.bookings.index') }}"
        class="group p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-200">
        <div class="text-center">
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>
          <h4 class="font-medium text-gray-900 mb-1">Kelola Penyewaan</h4>
          <p class="text-sm text-gray-600">Lihat dan kelola penyewaan Anda</p>
        </div>
      </a>

      <a href="{{ route('renter.history') }}"
        class="group p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-200">
        <div class="text-center">
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h4 class="font-medium text-gray-900 mb-1">Riwayat</h4>
          <p class="text-sm text-gray-600">Lihat riwayat penyewaan Anda</p>
        </div>
      </a>
    </div>
  </div>

  <!-- Active Bookings & Recent Activity -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Active Bookings -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Penyewaan Aktif</h3>
        <a href="{{ route('renter.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
          Lihat Semua
        </a>
      </div>

      @if($activeBookings->count() > 0)
      <div class="space-y-4">
        @foreach($activeBookings->take(3) as $booking)
        <div class="border border-gray-200 rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="font-medium text-gray-900">{{ $booking->motor->merk }} {{ $booking->motor->nama_motor }}</h4>
              <p class="text-sm text-gray-600">{{ $booking->motor->no_plat }}</p>
              <div class="flex items-center space-x-4 mt-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $booking->status->getBadgeColor() }}">
                  {{ $booking->status->getDisplayName() }}
                </span>
                <span class="text-sm text-gray-600">
                  {{ $booking->tanggal_mulai->format('d M') }} - {{ $booking->tanggal_selesai->format('d M Y') }}
                </span>
              </div>
            </div>
            <div class="text-right">
              <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($booking->harga, 0, ',', '.') }}</p>
              <a href="{{ route('renter.bookings.show', $booking) }}"
                class="text-sm text-blue-600 hover:text-blue-800">Detail</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="text-center py-8">
        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <p class="text-gray-600 mb-4">Belum ada penyewaan aktif</p>
        <a href="{{ route('renter.motors.index') }}"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Cari Motor Sekarang
        </a>
      </div>
      @endif
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
        <a href="{{ route('renter.history') }}" class="text-sm text-blue-600 hover:text-blue-800">
          Lihat Semua
        </a>
      </div>

      @if($recentBookings->count() > 0)
      <div class="space-y-4">
        @foreach($recentBookings->take(4) as $booking)
        <div class="flex items-center space-x-3">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
              <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">
              {{ $booking->motor->merk }} {{ $booking->motor->nama_motor }}
            </p>
            <p class="text-sm text-gray-600">
              {{ $booking->created_at->diffForHumans() }}
            </p>
          </div>
          <div class="flex-shrink-0">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                {{ $booking->status->getBadgeColor() }}">
              {{ $booking->status->getDisplayName() }}
            </span>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="text-center py-8">
        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-gray-600">Belum ada aktivitas</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection