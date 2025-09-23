@extends('layouts.owner')

@section('title', 'Pendapatan')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Pendapatan</h1>
      <p class="text-gray-600 mt-2">Pantau pendapatan dan bagi hasil dari penyewaan motor Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <!-- Total Revenue -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
          </div>
        </div>
      </div>

      <!-- This Month -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['this_month'] ?? 0, 0, ',', '.') }}</p>
          </div>
        </div>
      </div>

      <!-- Pending Settlements -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Menunggu Settlement</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_settlements'] ?? 0 }}</p>
          </div>
        </div>
      </div>

      <!-- Settled Count -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Telah Diselesaikan</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['settled_count'] ?? 0 }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('owner.revenue.history') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
          <div class="p-2 bg-blue-100 text-blue-600 rounded mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div>
            <p class="font-medium text-gray-900">Riwayat Pendapatan</p>
            <p class="text-sm text-gray-500">Lihat detail semua pendapatan</p>
          </div>
        </a>

        <a href="{{ route('owner.revenue.total') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
          <div class="p-2 bg-green-100 text-green-600 rounded mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
          <div>
            <p class="font-medium text-gray-900">Dashboard Pendapatan</p>
            <p class="text-sm text-gray-500">Analisis dan grafik performa</p>
          </div>
        </a>

        <a href="{{ route('owner.revenue.export') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
          <div class="p-2 bg-purple-100 text-purple-600 rounded mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div>
            <p class="font-medium text-gray-900">Export Data</p>
            <p class="text-sm text-gray-500">Download laporan pendapatan</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Motor Revenue Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-8">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Pendapatan per Motor</h3>
      </div>

      @if($motorRevenues->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Motor
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Pendapatan
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Transaksi Terakhir
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($motorRevenues as $motor)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $motor->nama }}</div>
                <div class="text-sm text-gray-500">{{ $motor->nomor_plat }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-lg font-semibold text-green-600">
                  Rp {{ number_format($motor->total_revenue ?? 0, 0, ',', '.') }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                @if($motor->bagiHasils->count() > 0)
                {{ $motor->bagiHasils->first()->created_at->format('d M Y') }}
                @else
                -
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $motor->status->value === 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                  {{ $motor->status->getDisplayName() }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="p-12 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data Pendapatan</h3>
        <p class="text-gray-500">Pendapatan akan muncul setelah ada transaksi penyewaan</p>
      </div>
      @endif
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Transaksi Terbaru</h3>
      </div>

      @if($recentTransactions->count() > 0)
      <div class="divide-y divide-gray-200">
        @foreach($recentTransactions as $transaction)
        <div class="p-6 hover:bg-gray-50">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-900">
                {{ $transaction->penyewaan->motor->nama }}
              </p>
              <p class="text-sm text-gray-500">
                Penyewa: {{ $transaction->penyewaan->penyewa->nama ?? 'N/A' }}
              </p>
              <p class="text-xs text-gray-400">
                {{ $transaction->created_at->format('d M Y, H:i') }}
              </p>
            </div>
            <div class="text-right">
              <p class="text-lg font-semibold text-green-600">
                Rp {{ number_format($transaction->bagi_hasil_pemilik ?? 0, 0, ',', '.') }}
              </p>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->settled_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $transaction->settled_at ? 'Settled' : 'Pending' }}
              </span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="p-12 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Transaksi</h3>
        <p class="text-gray-500">Transaksi akan muncul setelah ada penyewaan yang selesai</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection