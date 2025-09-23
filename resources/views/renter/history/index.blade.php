@extends('layouts.renter')

@section('title', 'Riwayat Penyewaan')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Riwayat Penyewaan</h1>
      <p class="text-gray-600">Lihat semua riwayat penyewaan motor Anda</p>
    </div>
    <div class="flex space-x-3">
      <button onclick="exportHistory()"
        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export PDF
      </button>
      <a href="{{ route('renter.motors.index') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Booking Baru
      </a>
    </div>
  </div>

  <!-- Filters -->
  <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('renter.history') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <!-- Tahun -->
      <div>
        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
        <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Semua Tahun</option>
          @for($i = date('Y'); $i >= date('Y') - 5; $i--)
          <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
      </div>

      <!-- Bulan -->
      <div>
        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
        <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Semua Bulan</option>
          @php
          $months = [
          1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
          5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
          9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
          ];
          @endphp
          @foreach($months as $num => $name)
          <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Status -->
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
          <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Berlangsung</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
          <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
      </div>

      <!-- Submit Button -->
      <div class="flex items-end">
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Summary Statistics -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
      <div class="flex items-center">
        <div class="p-2 bg-blue-100 rounded-lg">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Total Booking</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $totalBookings }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
      <div class="flex items-center">
        <div class="p-2 bg-green-100 rounded-lg">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Selesai</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $completedBookings }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
      <div class="flex items-center">
        <div class="p-2 bg-red-100 rounded-lg">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Dibatalkan</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $cancelledBookings }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
      <div class="flex items-center">
        <div class="p-2 bg-yellow-100 rounded-lg">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
          <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>
      </div>
    </div>
  </div>

  @if($history->count() > 0)
  <!-- History List -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($history as $booking)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-gray-300 rounded-lg mr-4 flex-shrink-0">
                  @if($booking->motor->foto_motor)
                  <img src="{{ asset('storage/' . $booking->motor->foto_motor) }}"
                    alt="{{ $booking->motor->nama_motor }}"
                    class="w-full h-full object-cover rounded-lg">
                  @else
                  <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                    </svg>
                  </div>
                  @endif
                </div>
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ $booking->motor->nama_motor }}</div>
                  <div class="text-sm text-gray-500">{{ $booking->motor->merek }} - {{ $booking->motor->plat_nomor }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}
              </div>
              <div class="text-sm text-gray-500">
                s/d {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) }} hari
              </div>
              <div class="text-sm text-gray-500 capitalize">
                {{ $booking->tipe_durasi }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-semibold text-gray-900">
                Rp {{ number_format($booking->harga, 0, ',', '.') }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <svg class="h-4 w-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                <div>
                  <div class="text-sm text-gray-900">COD/Cash</div>
                  @if($booking->status->value == 'completed')
                  <div class="text-xs text-green-600">Lunas</div>
                  @elseif($booking->status->value == 'cancelled')
                  <div class="text-xs text-red-600">Dibatalkan</div>
                  @elseif($booking->status->value == 'confirmed' || $booking->status->value == 'active')
                  <div class="text-xs text-blue-600">Sedang Berlangsung</div>
                  @else
                  <div class="text-xs text-yellow-600">Pending</div>
                  @endif
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($booking->status->value == 'completed') bg-green-100 text-green-800
                                    @elseif($booking->status->value == 'cancelled') bg-red-100 text-red-800
                                    @elseif($booking->status->value == 'confirmed' || $booking->status->value == 'active') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                {{ $booking->status->getDisplayName() }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('renter.bookings.show', $booking) }}"
                class="text-blue-600 hover:text-blue-900">Detail</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $history->links() }}
  </div>
  @else
  <!-- Empty State -->
  <div class="bg-white rounded-lg shadow-sm p-8 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat</h3>
    <p class="text-gray-500 mb-4">
      @if(request()->has(['year', 'month', 'status']) && (request('year') || request('month') || request('status')))
      Tidak ada riwayat booking sesuai filter yang dipilih
      @else
      Anda belum memiliki riwayat penyewaan motor
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

<script>
  function exportHistory() {
    // Create form to submit to export endpoint
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("renter.history.export") }}';

    // Add current filter parameters
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = key;
      input.value = value;
      form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  }
</script>
@endsection