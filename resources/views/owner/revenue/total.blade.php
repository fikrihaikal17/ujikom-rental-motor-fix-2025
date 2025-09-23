@extends('layouts.owner')

@section('title', 'Dashboard Pendapatan')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-start">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Pendapatan</h1>
        <p class="text-gray-600 mt-2">Analisis lengkap pendapatan dan performa motor Anda</p>
      </div>

      <!-- Export Button -->
      <div>
        <a href="{{ route('owner.revenue.export.pdf') }}"
          class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Ekspor PDF
        </a>
      </div>
    </div>

    <!-- Summary Stats -->
    @if(isset($totalYearRevenue))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan {{ now()->year }}</dt>
                <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($totalYearRevenue, 0, ',', '.') }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Monthly Revenue Chart -->
    <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Pendapatan Bulanan {{ now()->year }}</h3>

      <div class="h-64 flex items-end justify-center space-x-2">
        @if($monthlyData->count() > 0)
        @for($i = 1; $i <= 12; $i++)
          @php
          $monthData=$monthlyData->where('month', $i)->first();
          $amount = $monthData ? $monthData->total : 0;
          $maxAmount = $monthlyData->max('total') ?: 1;
          $height = $amount > 0 ? max(($amount / $maxAmount) * 200, 4) : 4;
          @endphp
          <div class="flex flex-col items-center">
            <div class="bg-blue-500 rounded-t hover:bg-blue-600 transition-colors relative group cursor-pointer"
              style="height: {{ $height }}px; width: 40px; min-height: 4px;">
              <!-- Tooltip -->
              <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Rp {{ number_format($amount, 0, ',', '.') }}
              </div>
            </div>
            <span class="text-xs text-gray-600 mt-2">
              {{ \Carbon\Carbon::create()->month($i)->format('M') }}
            </span>
          </div>
          @endfor
          @else
          <div class="text-center text-gray-500">
            <p>Belum ada data pendapatan untuk tahun ini</p>
          </div>
          @endif
      </div>
    </div>

    <!-- Top Performing Motors -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Motor Terbaik {{ now()->year }}</h3>
        <p class="text-sm text-gray-600">Motor dengan pendapatan tertinggi</p>
      </div>

      @if($topMotors->count() > 0)
      <div class="divide-y divide-gray-200">
        @foreach($topMotors as $index => $motor)
        <div class="p-6 hover:bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- Ranking Badge -->
              <div class="flex-shrink-0 mr-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : ($index === 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800')) }}">
                  <span class="font-bold text-sm">{{ $index + 1 }}</span>
                </div>
              </div>

              <!-- Motor Info -->
              <div>
                <h4 class="text-lg font-medium text-gray-900">{{ $motor->merk }}</h4>
                <p class="text-sm text-gray-600">{{ $motor->no_plat }} • {{ $motor->tipe_cc ? $motor->tipe_cc->getDisplayName() : 'Tidak diketahui' }}</p>
              </div>
            </div>

            <!-- Revenue -->
            <div class="text-right">
              <p class="text-xl font-bold text-green-600">
                Rp {{ number_format($motor->total_revenue ?? 0, 0, ',', '.') }}
              </p>
              <p class="text-sm text-gray-500">Total pendapatan</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="p-12 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data Motor</h3>
        <p class="text-gray-500">Data performa motor akan muncul setelah ada transaksi penyewaan</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection