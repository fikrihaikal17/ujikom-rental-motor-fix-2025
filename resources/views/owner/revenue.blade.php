@extends('layouts.app')

@section('title', 'Laporan Pendapatan - RideNow')

@section('content')
<div class="min-h-screen bg-gray-50">
  <!-- Main Content -->
  <div class="flex">
    <!-- Sidebar -->
    @include('owner.components.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 ml-64 p-8">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Laporan Pendapatan</h1>
            <p class="text-gray-600 mt-2">Pantau pendapatan dan bagi hasil dari penyewaan motor Anda</p>
          </div>
          <div class="flex space-x-3">
            <a href="{{ route('owner.revenue.export') }}?{{ request()->getQueryString() }}"
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Export Excel
            </a>
          </div>
        </div>
      </div>

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Gross Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Gross Revenue</p>
              <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($summary['total_gross_revenue'], 0, ',', '.') }}</p>
            </div>
          </div>
        </div>

        <!-- Owner Share -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Bagian Pemilik ({{ $bagi_hasil_percentage }}%)</p>
              <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($summary['owner_share'], 0, ',', '.') }}</p>
            </div>
          </div>
        </div>

        <!-- Admin Commission -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m2-4h6m-6 0V9a2 2 0 012-2h4a2 2 0 012 2v6m-6 4h6v4H9v-4z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Komisi Admin ({{ 100 - $bagi_hasil_percentage }}%)</p>
              <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($summary['admin_commission'], 0, ',', '.') }}</p>
            </div>
          </div>
        </div>

        <!-- Pending Settlement -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Menunggu Pembayaran</p>
              <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($summary['pending_settlement'], 0, ',', '.') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
        <form method="GET" action="{{ route('owner.revenue') }}" class="flex flex-wrap gap-4">
          <div class="min-w-48">
            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
            <select name="month" id="month"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Semua Bulan</option>
              @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                </option>
                @endfor
            </select>
          </div>

          <div class="min-w-48">
            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
            <select name="year" id="year"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Semua Tahun</option>
              @for($y = date('Y'); $y >= 2020; $y--)
              <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
            </select>
          </div>

          <div class="min-w-48">
            <label for="motor_id" class="block text-sm font-medium text-gray-700 mb-1">Motor</label>
            <select name="motor_id" id="motor_id"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Semua Motor</option>
              @foreach($motors as $motor)
              <option value="{{ $motor->id }}" {{ request('motor_id') == $motor->id ? 'selected' : '' }}>
                {{ $motor->nama_motor }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="min-w-48">
            <label for="settlement_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
            <select name="settlement_status" id="settlement_status"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Semua Status</option>
              <option value="pending" {{ request('settlement_status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
              <option value="settled" {{ request('settlement_status') === 'settled' ? 'selected' : '' }}>Sudah Dibayar</option>
            </select>
          </div>

          <div class="flex items-end">
            <button type="submit"
              class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
              Filter
            </button>
            @if(request()->hasAny(['month', 'year', 'motor_id', 'settlement_status']))
            <a href="{{ route('owner.revenue') }}"
              class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200">
              Reset
            </a>
            @endif
          </div>
        </form>
      </div>

      <!-- Revenue Chart -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Grafik Pendapatan Bulanan</h2>
        <div class="h-80">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>

      <!-- Revenue Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Detail Bagi Hasil</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sewa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bagian Pemilik</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi Admin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($revenue_data as $data)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $data->penyewaan->motor->nama_motor }}</div>
                  <div class="text-sm text-gray-500">{{ $data->penyewaan->motor->plat_nomor }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $data->penyewaan->user->name }}</div>
                  <div class="text-sm text-gray-500">{{ $data->penyewaan->user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  Rp {{ number_format($data->penyewaan->jumlah_bayar, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                  Rp {{ number_format($data->bagi_hasil_pemilik, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  Rp {{ number_format($data->bagi_hasil_admin, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($data->settled_at)
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    Dibayar
                  </span>
                  <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($data->settled_at)->format('d M Y') }}</div>
                  @else
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Pending
                  </span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                  <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                  <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data</h3>
                  <p class="text-gray-600">
                    @if(request()->hasAny(['month', 'year', 'motor_id', 'settlement_status']))
                    Tidak ada data yang sesuai dengan filter yang dipilih.
                    @else
                    Belum ada data bagi hasil. Data akan muncul setelah ada transaksi penyewaan yang selesai.
                    @endif
                  </p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($revenue_data->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
          {{ $revenue_data->links() }}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($chart_data['labels']),
        datasets: [{
            label: 'Bagian Pemilik (Rp)',
            data: @json($chart_data['owner_data']),
            backgroundColor: 'rgba(34, 197, 94, 0.7)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1
          },
          {
            label: 'Komisi Admin (Rp)',
            data: @json($chart_data['admin_data']),
            backgroundColor: 'rgba(251, 191, 36, 0.7)',
            borderColor: 'rgb(251, 191, 36)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: false
          }
        },
        scales: {
          x: {
            stacked: true,
          },
          y: {
            stacked: true,
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  });
</script>
@endpush
@endsection