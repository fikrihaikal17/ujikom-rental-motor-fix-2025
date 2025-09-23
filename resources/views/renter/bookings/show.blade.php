@extends('layouts.renter')

@section('title', 'Detail Booking')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Breadcrumb -->
  <nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
      <li><a href="{{ route('renter.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
      <li>/</li>
      <li><a href="{{ route('renter.bookings.index') }}" class="hover:text-blue-600">Booking</a></li>
      <li>/</li>
      <li class="text-gray-900">Detail Booking</li>
    </ol>
  </nav>

  <!-- Status Banner -->
  <div class="mb-6 p-4 rounded-lg border-l-4
        @if($booking->status === \App\Enums\BookingStatus::PENDING) bg-yellow-50 border-yellow-400
        @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED) bg-green-50 border-green-400
        @elseif($booking->status === \App\Enums\BookingStatus::ACTIVE) bg-blue-50 border-blue-400
        @elseif($booking->status === \App\Enums\BookingStatus::COMPLETED) bg-gray-50 border-gray-400
        @else bg-red-50 border-red-400 @endif">
    <div class="flex items-center">
      <div class="flex-1">
        <h3 class="text-lg font-medium
                    @if($booking->status === \App\Enums\BookingStatus::PENDING) text-yellow-800
                    @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED) text-green-800
                    @elseif($booking->status === \App\Enums\BookingStatus::ACTIVE) text-blue-800
                    @elseif($booking->status === \App\Enums\BookingStatus::COMPLETED) text-gray-800
                    @else text-red-800 @endif">
          Status: {{ $booking->status->getDisplayName() }}
        </h3>
        <p class="text-sm
                    @if($booking->status === \App\Enums\BookingStatus::PENDING) text-yellow-700
                    @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED) text-green-700
                    @elseif($booking->status === \App\Enums\BookingStatus::ACTIVE) text-blue-700
                    @elseif($booking->status === \App\Enums\BookingStatus::COMPLETED) text-gray-700
                    @else text-red-700 @endif">
          @if($booking->status === \App\Enums\BookingStatus::PENDING)
          Booking Anda sedang menunggu konfirmasi dari admin
          @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED)
          Booking telah dikonfirmasi, silakan ambil motor sesuai jadwal
          @elseif($booking->status === \App\Enums\BookingStatus::ACTIVE)
          Motor sedang dalam masa rental. Jangan lupa konfirmasi pengembalian melalui tombol di bawah setelah mengembalikan motor.
          @elseif($booking->status === \App\Enums\BookingStatus::COMPLETED)
          Rental telah selesai. Terima kasih telah menggunakan layanan kami!
          @else
          Booking telah dibatalkan
          @endif
        </p>
      </div>
      @if($booking->status === \App\Enums\BookingStatus::PENDING)
      <form action="{{ route('renter.bookings.cancel', $booking) }}" method="POST" class="ml-4">
        @csrf
        @method('PATCH')
        <button type="submit"
          onclick="return confirm('Yakin ingin membatalkan booking ini?')"
          class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm">
          Batalkan Booking
        </button>
      </form>
      @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED)
      <div class="ml-4 text-sm text-green-700">
        <div class="flex items-center">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Booking dikonfirmasi! Silakan hubungi admin untuk mengambil motor.
        </div>
      </div>
      @elseif($booking->status === \App\Enums\BookingStatus::ACTIVE)
      <form action="{{ route('renter.bookings.confirm-return', $booking) }}" method="POST" class="ml-4">
        @csrf
        @method('PATCH')
        <button type="submit"
          onclick="return confirm('Apakah Anda yakin sudah mengembalikan motor dengan kondisi baik?')"
          class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 text-sm">
          <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Konfirmasi Pengembalian
        </button>
      </form>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Motor Information -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Motor</h2>

          <div class="flex">
            <!-- Motor Image -->
            <div class="w-32 h-32 bg-gray-300 rounded-lg mr-6 flex-shrink-0">
              @if($booking->motor->photo)
              <img src="{{ asset('storage/' . $booking->motor->photo) }}"
                alt="{{ $booking->motor->nama_motor }}"
                class="w-full h-full object-cover rounded-lg">
              @else
              <div class="w-full h-full flex items-center justify-center text-gray-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                </svg>
              </div>
              @endif
            </div>

            <!-- Motor Details -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $booking->motor->nama_motor }}</h3>

              <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                  <span class="text-gray-500">Merek:</span>
                  <div class="font-medium">{{ $booking->motor->merk }}</div>
                </div>
                <div>
                  <span class="text-gray-500">Tahun:</span>
                  <div class="font-medium">{{ $booking->motor->tahun }}</div>
                </div>
                <div>
                  <span class="text-gray-500">Plat Nomor:</span>
                  <div class="font-medium">{{ $booking->motor->no_plat }}</div>
                </div>
                <div>
                  <span class="text-gray-500">Warna:</span>
                  <div class="font-medium">{{ $booking->motor->warna }}</div>
                </div>
                <div>
                  <span class="text-gray-500">Jenis:</span>
                  <div class="font-medium">{{ $booking->motor->tipe_cc?->getDisplayName() ?? 'N/A' }}</div>
                </div>
                <div>
                  <span class="text-gray-500">Status Motor:</span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->motor->status?->value == 'verified') bg-green-100 text-green-800
                                        @elseif($booking->motor->status?->value == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($booking->motor->status?->value ?? 'N/A') }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Booking Details -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Booking</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
              <div>
                <span class="text-gray-500 text-sm">Tanggal Mulai</span>
                <div class="font-medium text-lg">
                  {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}
                </div>
                <div class="text-gray-500 text-sm">
                  {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('l') }}
                </div>
              </div>

              <div>
                <span class="text-gray-500 text-sm">Tanggal Selesai</span>
                <div class="font-medium text-lg">
                  {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                </div>
                <div class="text-gray-500 text-sm">
                  {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('l') }}
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <div>
                <span class="text-gray-500 text-sm">Durasi</span>
                <div class="font-medium text-lg">
                  {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) }} Hari
                </div>
                <div class="text-gray-500 text-sm capitalize">
                  Sistem {{ $booking->tipe_durasi }}
                </div>
              </div>

              <div>
                <span class="text-gray-500 text-sm">Tanggal Booking</span>
                <div class="font-medium">
                  {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}
                </div>
              </div>
            </div>
          </div>

          @if($booking->catatan)
          <div class="mt-6 pt-6 border-t border-gray-200">
            <span class="text-gray-500 text-sm">Catatan</span>
            <div class="mt-2 p-3 bg-gray-50 rounded-lg">
              <p class="text-gray-700">{{ $booking->catatan }}</p>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
      <!-- Pricing Summary -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Harga</h3>

          @if($booking->motor->tarifRental)
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600">Tarif per {{ $booking->tipe_durasi }}:</span>
              <span class="font-medium">
                @if($booking->tipe_durasi == 'harian')
                Rp {{ number_format($booking->motor->tarifRental->tarif_harian, 0, ',', '.') }}
                @elseif($booking->tipe_durasi == 'mingguan')
                Rp {{ number_format($booking->motor->tarifRental->tarif_mingguan, 0, ',', '.') }}
                @else
                Rp {{ number_format($booking->motor->tarifRental->tarif_bulanan, 0, ',', '.') }}
                @endif
              </span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-600">Durasi:</span>
              <span class="font-medium">
                @if($booking->tipe_durasi == 'harian')
                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) }} hari
                @elseif($booking->tipe_durasi == 'mingguan')
                {{ ceil(\Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) / 7) }} minggu
                @else
                {{ ceil(\Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) / 30) }} bulan
                @endif
              </span>
            </div>

            <hr class="my-3">

            <div class="flex justify-between text-lg font-semibold">
              <span>Total Harga:</span>
              <span class="text-blue-600">Rp {{ number_format($booking->harga, 0, ',', '.') }}</span>
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>

          <div class="space-y-3">
            <a href="{{ route('renter.bookings.index') }}"
              class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 text-center block">
              Kembali ke Daftar Booking
            </a>

            @if($booking->status === \App\Enums\BookingStatus::ACTIVE)
            <form action="{{ route('renter.bookings.confirm-return', $booking) }}" method="POST" class="w-full">
              @csrf
              @method('PATCH')
              <button type="submit"
                onclick="return confirm('Apakah Anda yakin sudah mengembalikan motor dengan kondisi baik? Motor akan ditandai sebagai selesai disewa.')"
                class="w-full bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 text-center">
                <div class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Konfirmasi Pengembalian Motor
                </div>
              </button>
            </form>
            @endif

            <a href="{{ route('renter.motors.show', $booking->motor) }}"
              class="w-full bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 text-center block">
              Lihat Detail Motor
            </a>

            @if($booking->status === \App\Enums\BookingStatus::COMPLETED)
            <a href="{{ route('renter.motors.index') }}"
              class="w-full bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 text-center block">
              Booking Motor Lagi
            </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Timeline -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>

          <div class="space-y-4">
            <div class="flex items-start">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">Booking Dibuat</div>
                <div class="text-xs text-gray-500">
                  {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}
                </div>
              </div>
            </div>

            @if($booking->status->value != 'pending')
            <div class="flex items-start">
              <div class="flex-shrink-0 w-2 h-2 bg-green-600 rounded-full mt-2"></div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">Status Diperbarui</div>
                <div class="text-xs text-gray-500">
                  {{ \Carbon\Carbon::parse($booking->updated_at)->format('d M Y H:i') }}
                </div>
              </div>
            </div>
            @endif

            @if($booking->status->value == 'active' || $booking->status->value == 'completed')
            <div class="flex items-start">
              <div class="flex-shrink-0 w-2 h-2 
                                @if($booking->status->value == 'completed') bg-gray-600 @else bg-yellow-600 @endif 
                                rounded-full mt-2"></div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                  @if($booking->status->value == 'completed') Rental Selesai @else Rental Dimulai @endif
                </div>
                <div class="text-xs text-gray-500">
                  @if($booking->status->value == 'completed' && $booking->completed_at)
                  {{ \Carbon\Carbon::parse($booking->completed_at)->format('d M Y H:i') }}
                  @else
                  {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}
                  @endif
                </div>
              </div>
            </div>
            @endif

            @if($booking->status->value == 'active')
            <div class="flex items-start">
              <div class="flex-shrink-0 w-2 h-2 bg-orange-600 rounded-full mt-2"></div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">Periode Berakhir</div>
                <div class="text-xs text-gray-500">
                  {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                </div>
                <div class="text-xs text-orange-600 mt-1">
                  <strong>Catatan:</strong> Silakan konfirmasi pengembalian motor melalui tombol di atas
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection