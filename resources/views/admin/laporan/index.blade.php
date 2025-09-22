@extends('layouts.sidebar')

@section('title', 'Laporan & Analitik')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Laporan & Analitik</h1>
      <p class="text-gray-600">Dashboard analitik dan laporan sistem</p>
    </div>
    <div class="flex space-x-3">
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
          class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
          <i class="fas fa-download mr-2"></i>Export Laporan
          <i class="fas fa-chevron-down ml-2"></i>
        </button>
        <div x-show="open" @click.away="open = false" x-transition
          class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
          <div class="py-1">
            <a href="{{ route('admin.laporan.export', ['type' => 'revenue']) }}"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <i class="fas fa-chart-line mr-2"></i>Laporan Revenue
            </a>
            <a href="{{ route('admin.laporan.export', ['type' => 'motors']) }}"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <i class="fas fa-motorcycle mr-2"></i>Laporan Motor
            </a>
            <a href="{{ route('admin.laporan.export', ['type' => 'users']) }}"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <i class="fas fa-users mr-2"></i>Laporan User
            </a>
            <a href="{{ route('admin.laporan.export', ['type' => 'transactions']) }}"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <i class="fas fa-receipt mr-2"></i>Laporan Transaksi
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Statistics -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Daily Revenue -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100">Revenue Hari Ini</p>
          <p class="text-3xl font-bold">Rp {{ number_format($stats['daily_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="p-3 bg-blue-400 rounded-full">
          <i class="fas fa-calendar-day text-2xl"></i>
        </div>
      </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100">Revenue Bulan Ini</p>
          <p class="text-3xl font-bold">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="p-3 bg-green-400 rounded-full">
          <i class="fas fa-calendar-alt text-2xl"></i>
        </div>
      </div>
    </div>

    <!-- Yearly Revenue -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-purple-100">Revenue Tahun Ini</p>
          <p class="text-3xl font-bold">Rp {{ number_format($stats['yearly_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="p-3 bg-purple-400 rounded-full">
          <i class="fas fa-calendar text-2xl"></i>
        </div>
      </div>
    </div>

    <!-- Active Rentals -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-orange-100">Penyewaan Aktif</p>
          <p class="text-3xl font-bold">{{ number_format($stats['active_rentals']) }}</p>
        </div>
        <div class="p-3 bg-orange-400 rounded-full">
          <i class="fas fa-clock text-2xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Secondary Statistics -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
          <i class="fas fa-receipt text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Total Penyewaan</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_rentals']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
          <i class="fas fa-motorcycle text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Motor Tersedia</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['available_motors']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
          <i class="fas fa-key text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Motor Disewa</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['rented_motors']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
          <i class="fas fa-users text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Total User</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Revenue Trend Chart -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Tren Revenue (12 Bulan Terakhir)</h3>
        <a href="{{ route('admin.laporan.revenue') }}" class="text-blue-600 hover:text-blue-800 text-sm">
          Lihat Detail →
        </a>
      </div>
      <canvas id="revenueChart" height="300"></canvas>
    </div>

    <!-- Payment Methods Distribution -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Metode Pembayaran</h3>
      </div>
      <canvas id="paymentChart" height="300"></canvas>
    </div>
  </div>

  <!-- Quick Navigation -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('admin.laporan.revenue') }}"
      class="bg-white rounded-lg shadow p-6 hover:shadow-md transition duration-200">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
          <i class="fas fa-chart-line text-xl"></i>
        </div>
        <div class="ml-4">
          <h4 class="text-lg font-medium text-gray-900">Laporan Revenue</h4>
          <p class="text-sm text-gray-600">Analisis pendapatan detail</p>
        </div>
      </div>
    </a>

    <a href="{{ route('admin.laporan.motors') }}"
      class="bg-white rounded-lg shadow p-6 hover:shadow-md transition duration-200">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
          <i class="fas fa-motorcycle text-xl"></i>
        </div>
        <div class="ml-4">
          <h4 class="text-lg font-medium text-gray-900">Laporan Motor</h4>
          <p class="text-sm text-gray-600">Performa dan statistik motor</p>
        </div>
      </div>
    </a>

    <a href="{{ route('admin.laporan.users') }}"
      class="bg-white rounded-lg shadow p-6 hover:shadow-md transition duration-200">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
          <i class="fas fa-users text-xl"></i>
        </div>
        <div class="ml-4">
          <h4 class="text-lg font-medium text-gray-900">Laporan User</h4>
          <p class="text-sm text-gray-600">Analisis pengguna dan registrasi</p>
        </div>
      </div>
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    // eslint-disable-next-line
    const revenueData = @json($revenueTrend);

    new Chart(revenueCtx, {
      type: 'line',
      data: {
        labels: revenueData.map(item => item.month),
        datasets: [{
          label: 'Revenue',
          data: revenueData.map(item => item.revenue),
          borderColor: 'rgb(59, 130, 246)',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function (value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                return 'Revenue: Rp ' + context.parsed.y.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    // eslint-disable-next-line
    const paymentData = @json($paymentMethods);

    new Chart(paymentCtx, {
      type: 'doughnut',
      data: {
        labels: paymentData.map(item => item.metode_pembayaran.charAt(0).toUpperCase() + item.metode_pembayaran.slice(1)),
        datasets: [{
          data: paymentData.map(item => item.total_amount),
          backgroundColor: [
            'rgb(59, 130, 246)',
            'rgb(16, 185, 129)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
            'rgb(139, 92, 246)'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((context.parsed / total) * 100).toFixed(1);
                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
              }
            }
          }
        }
      }
    });
  });
</script>
@endsection