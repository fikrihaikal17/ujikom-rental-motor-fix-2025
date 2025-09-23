@extends('layouts.renter')

@section('title', 'Booking Saya')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Booking Saya</h1>
      <p class="text-gray-600">Kelola semua booking motor Anda</p>
    </div>
    <a href="{{ route('renter.motors.index') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
      </svg>
      Booking Baru
    </a>
  </div>

  <!-- Filter Tabs -->
  <div class="bg-white rounded-lg shadow-sm mb-6">
    <div class="border-b border-gray-200">
      <nav class="flex space-x-8 px-6" aria-label="Tabs">
        <a href="{{ route('renter.bookings.index') }}"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                          {{ request('status') == '' ? 'border-blue-500 text-blue-600' : '' }}">
          Semua
          <span class="bg-gray-100 text-gray-900 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
            {{ $bookings->total() }}
          </span>
        </a>
        <a href="{{ route('renter.bookings.index', ['status' => 'pending']) }}"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                          {{ request('status') == 'pending' ? 'border-blue-500 text-blue-600' : '' }}">
          Pending
          <span class="bg-yellow-100 text-yellow-800 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
            {{ $bookings->where('status', 'pending')->count() }}
          </span>
        </a>
        <a href="{{ route('renter.bookings.index', ['status' => 'confirmed']) }}"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                          {{ request('status') == 'confirmed' ? 'border-blue-500 text-blue-600' : '' }}">
          Dikonfirmasi
          <span class="bg-green-100 text-green-800 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
            {{ $bookings->where('status', 'confirmed')->count() }}
          </span>
        </a>
        <a href="{{ route('renter.bookings.index', ['status' => 'active']) }}"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                          {{ request('status') == 'active' ? 'border-blue-500 text-blue-600' : '' }}">
          Aktif
          <span class="bg-blue-100 text-blue-800 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
            {{ $bookings->where('status', 'active')->count() }}
          </span>
        </a>
        <a href="{{ route('renter.bookings.index', ['status' => 'completed']) }}"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                          {{ request('status') == 'completed' ? 'border-blue-500 text-blue-600' : '' }}">
          Selesai
          <span class="bg-gray-100 text-gray-900 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
            {{ $bookings->where('status', 'completed')->count() }}
          </span>
        </a>
      </nav>
    </div>
  </div>

  @if($bookings->count() > 0)
  <!-- Booking List -->
  <div class="space-y-4">
    @foreach($bookings as $booking)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div class="flex">
            <!-- Motor Image -->
            <div class="w-20 h-20 bg-gray-300 rounded-lg mr-4 flex-shrink-0">
              @if($booking->motor->photo)
              <img src="{{ asset('storage/' . $booking->motor->photo) }}"
                alt="{{ $booking->motor->nama_motor }}"
                class="w-full h-full object-cover rounded-lg">
              @else
              <div class="w-full h-full flex items-center justify-center text-gray-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                </svg>
              </div>
              @endif
            </div>

            <!-- Booking Info -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $booking->motor->nama_motor }}</h3>
              <p class="text-gray-600 text-sm mb-2">{{ $booking->motor->merek }} - {{ $booking->motor->plat_nomor }}</p>

              <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                  <span class="text-gray-500">Periode:</span>
                  <div class="font-medium">
                    {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                  </div>
                  <div class="text-gray-500">
                    ({{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) }} hari)
                  </div>
                </div>
                <div>
                  <span class="text-gray-500">Total Harga:</span>
                  <div class="font-semibold text-lg text-blue-600">
                    Rp {{ number_format($booking->harga, 0, ',', '.') }}
                  </div>
                  <div class="text-gray-500 capitalize">
                    {{ $booking->tipe_durasi }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Status & Actions -->
          <div class="text-right">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-3
                                @if($booking->status->value == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status->value == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status->value == 'active') bg-blue-100 text-blue-800
                                @elseif($booking->status->value == 'completed') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800 @endif">
              {{ ucfirst($booking->status->value) }}
            </span>

            <div class="space-y-2">
              <a href="{{ route('renter.bookings.show', $booking) }}"
                class="block w-full bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 text-center">
                Detail
              </a>

              @if($booking->status->value == 'pending')
              <form action="{{ route('renter.bookings.cancel', $booking) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                  onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                  class="w-full bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                  Batalkan
                </button>
              </form>
              @endif
            </div>
          </div>
        </div>

        @if($booking->catatan)
        <div class="mt-4 pt-4 border-t border-gray-200">
          <span class="text-gray-500 text-sm">Catatan:</span>
          <p class="text-gray-700 text-sm mt-1">{{ $booking->catatan }}</p>
        </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $bookings->links() }}
  </div>
  @else
  <!-- Empty State -->
  <div class="bg-white rounded-lg shadow-sm p-8 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Booking</h3>
    <p class="text-gray-500 mb-4">
      @if(request('status'))
      Tidak ada booking dengan status {{ request('status') }}
      @else
      Anda belum memiliki booking motor apapun
      @endif
    </p>
    <a href="{{ route('renter.motors.index') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
      </svg>
      Mulai Booking
    </a>
  </div>
  @endif
</div>
@endsection