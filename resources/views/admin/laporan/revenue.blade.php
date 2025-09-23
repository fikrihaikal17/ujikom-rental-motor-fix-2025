@extends('layouts.sidebar')

@section('title', 'Laporan Revenue')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Laporan Revenue</h1>
      <p class="text-gray-600">Analisis pendapatan dan revenue sistem</p>
    </div>
    <div class="flex space-x-3">
      <a href="{{ route('admin.laporan.index') }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Laporan
      </a>
      <button onclick="window.print()"
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
        <i class="fas fa-print mr-2"></i>Print Laporan
      </button>
    </div>
  </div>

  <!-- Date Filter -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Periode</h3>
    <form method="GET" action="{{ route('admin.laporan.revenue') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
        <input type="date" name="start_date" id="start_date"
          value="{{ $startDate->format('Y-m-d') }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
      </div>
      <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
        <input type="date" name="end_date" id="end_date"
          value="{{ $endDate->format('Y-m-d') }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
      </div>
      <div>
        <label for="group_by" class="block text-sm font-medium text-gray-700">Group By</label>
        <select name="group_by" id="group_by"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Per Hari</option>
          <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Per Bulan</option>
          <option value="year" {{ $groupBy == 'year' ? 'selected' : '' }}>Per Tahun</option>
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit"
          class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
          <i class="fas fa-filter mr-2"></i>Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Revenue Summary -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100">Total Revenue</p>
          <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-400 bg-opacity-20 rounded-full p-3">
          <i class="fas fa-chart-line text-2xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100">Total Transaksi</p>
          <p class="text-3xl font-bold">{{ number_format($totalTransactions, 0, ',', '.') }}</p>
        </div>
        <div class="bg-blue-400 bg-opacity-20 rounded-full p-3">
          <i class="fas fa-receipt text-2xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-purple-100">Rata-rata per Transaksi</p>
          <p class="text-3xl font-bold">Rp {{ number_format($averagePerTransaction, 0, ',', '.') }}</p>
        </div>
        <div class="bg-purple-400 bg-opacity-20 rounded-full p-3">
          <i class="fas fa-calculator text-2xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Revenue Chart -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Grafik Revenue</h3>
    <div class="h-96">
      <canvas id="revenueChart"></canvas>
    </div>
  </div>

  <!-- Revenue Data Table -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-lg font-semibold text-gray-900">Data Revenue Detail</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($data as $item)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              {{ $item->period }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <span class="font-semibold text-green-600">
                Rp {{ number_format($item->revenue, 0, ',', '.') }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ number_format($item->transaction_count, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              Rp {{ number_format($item->transaction_count > 0 ? $item->revenue / $item->transaction_count : 0, 0, ',', '.') }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
              <div class="flex flex-col items-center">
                <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                <p class="text-lg font-medium">Tidak ada data revenue</p>
                <p class="text-sm">Coba ubah filter periode untuk melihat data</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const data = @json($data);

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.map(item => item.period),
        datasets: [{
          label: 'Revenue',
          data: data.map(item => item.revenue),
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          borderColor: 'rgb(59, 130, 246)',
          borderWidth: 3,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value, index, values) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
              }
            }
          }
        },
        elements: {
          point: {
            radius: 6,
            hoverRadius: 8
          }
        }
      }
    });
  });
</script>
@endpush
@endsection