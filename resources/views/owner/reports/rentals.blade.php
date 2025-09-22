@extends('layouts.owner')

@section('title', 'Laporan Penyewaan')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Laporan Penyewaan</h1>
      <p class="text-gray-600 mt-2">Analisis data penyewaan motor Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Total Rentals -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Total Penyewaan</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalRentals }}</p>
          </div>
        </div>
      </div>

      <!-- Active Rentals -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Sedang Aktif</p>
            <p class="text-2xl font-bold text-gray-900">{{ $activeRentals }}</p>
          </div>
        </div>
      </div>

      <!-- Completed Rentals -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Selesai</p>
            <p class="text-2xl font-bold text-gray-900">{{ $completedRentals }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Monthly Rental Chart -->
    <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Penyewaan per Bulan {{ now()->year }}</h3>

      <div class="h-64 flex items-end justify-center space-x-2">
        @if($monthlyRentals->count() > 0)
        @for($i = 1; $i <= 12; $i++)
          @php
          $monthData=$monthlyRentals->where('month', $i)->first();
          $count = $monthData ? $monthData->total : 0;
          $maxCount = $monthlyRentals->max('total') ?: 1;
          $height = $count > 0 ? max(($count / $maxCount) * 200, 4) : 4;
          @endphp
          <div class="flex flex-col items-center">
            <div class="bg-indigo-500 rounded-t hover:bg-indigo-600 transition-colors relative group cursor-pointer"
              style="height: {{ $height }}px; width: 40px;">
              <!-- Tooltip -->
              <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ $count }} penyewaan
              </div>
            </div>
            <span class="text-xs text-gray-600 mt-2">
              {{ \Carbon\Carbon::create()->month($i)->format('M') }}
            </span>
          </div>
          @endfor
          @else
          <div class="text-center text-gray-500">
            <p>Belum ada data penyewaan untuk tahun ini</p>
          </div>
          @endif
      </div>
    </div>

    <!-- Recent Rentals Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Penyewaan Terbaru</h3>
      </div>

      @if($recentRentals->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Motor
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Penyewa
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Mulai
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Selesai
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($recentRentals as $rental)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $rental->motor->nama }}</div>
                <div class="text-sm text-gray-500">{{ $rental->motor->nomor_plat }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $rental->user->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $rental->tanggal_mulai->format('d M Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $rental->tanggal_selesai->format('d M Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $rental->status->value === 'active' ? 'bg-green-100 text-green-800' : 
                                               ($rental->status->value === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                               ($rental->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-gray-100 text-gray-800')) }}">
                  {{ $rental->status->getDisplayName() }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $recentRentals->links() }}
      </div>
      @else
      <div class="p-12 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Penyewaan</h3>
        <p class="text-gray-500">Data penyewaan akan muncul setelah ada transaksi</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection