@extends('layouts.owner')

@section('title', 'Riwayat Pendapatan')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Riwayat Pendapatan</h1>
      <p class="text-gray-600 mt-2">Lihat riwayat lengkap pendapatan dari penyewaan motor Anda</p>
    </div>

    <!-- Summary Card -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 mb-8">
      <div class="text-white">
        <h2 class="text-xl font-semibold mb-2">Total Pendapatan Tahun Ini</h2>
        <p class="text-3xl font-bold">Rp {{ number_format($totalRevenueThisYear, 0, ',', '.') }}</p>
      </div>
    </div>

    <!-- Revenue History Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Riwayat Bagi Hasil</h3>
      </div>

      @if($monthlyRevenue->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Motor
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Penyewa
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pendapatan Owner
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($monthlyRevenue as $revenue)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $revenue->created_at->format('d M Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ $revenue->penyewaan->motor->nama }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ $revenue->penyewaan->motor->nomor_plat }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $revenue->penyewaan->user->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-lg font-semibold text-green-600">
                  Rp {{ number_format($revenue->jumlah_owner, 0, ',', '.') }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  Dibayar
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $monthlyRevenue->links() }}
      </div>
      @else
      <div class="p-12 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Riwayat Pendapatan</h3>
        <p class="text-gray-500">Riwayat pendapatan akan muncul setelah ada transaksi penyewaan yang selesai</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection