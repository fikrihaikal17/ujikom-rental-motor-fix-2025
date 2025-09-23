@extends('layouts.sidebar')

@section('title', 'Grafik Penyewaan Per Periode')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Grafik Penyewaan Per Periode</h1>
      <p class="mt-2 text-sm text-gray-700">Analisis data penyewaan motor dalam bentuk grafik dan chart.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3 flex">
      <a href="{{ route('admin.analytics.export') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export PDF
      </a>
      <div class="relative">
        <select id="periodSelect" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
          <option value="week">7 Hari Terakhir</option>
          <option value="month" selected>30 Hari Terakhir</option>
          <option value="quarter">3 Bulan Terakhir</option>
          <option value="year">12 Bulan Terakhir</option>
          <option value="custom">Custom Period</option>
        </select>
      </div>
    </div>
  </div>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Booking</dt>
            <dd class="text-lg font-medium text-gray-900 flex items-center">
              <span>{{ $totalBookings }}</span>
              @if($totalBookings > 0)
              <span class="ml-2 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                Data Real
              </span>
              @endif
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
            <dd class="text-lg font-medium text-gray-900 flex items-center">
              <span>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
              @if($totalRevenue > 0)
              <span class="ml-2 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                Data Real
              </span>
              @endif
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Motor Aktif</dt>
            <dd class="text-lg font-medium text-gray-900 flex items-center">
              <span>{{ $totalMotors }}</span>
              @if($totalMotors > 0)
              <span class="ml-2 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                Data Real
              </span>
              @endif
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $totalUsers }} pengguna</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
  <!-- Booking Trend Chart -->
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Trend Penyewaan</h3>
      <div class="h-64">
        <canvas id="bookingTrendChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Revenue Chart -->
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Revenue Per Periode</h3>
      <div class="h-64">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- More Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
  <!-- Motor Type Distribution -->
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Distribusi Jenis Motor</h3>
      <div class="h-48">
        <canvas id="motorTypeChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Popular Hours -->
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Jam Populer Booking</h3>
      <div class="h-48">
        <canvas id="popularHoursChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Status Distribution -->
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Status Penyewaan</h3>
      <div class="h-48">
        <canvas id="statusChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Chart instances - store globally to manage destroy/recreate
  let bookingTrendChart, revenueChart, motorTypeChart, popularHoursChart, statusChart;

  // Real data from Laravel backend
  const monthlyBookingsData = @json($monthlyBookings);
  const monthlyRevenueData = @json($monthlyRevenue);
  const motorTypesData = @json($motorTypes);
  const popularTimesData = @json($popularTimes);
  const statusDistributionData = @json($statusDistribution);

  const chartData = {
    bookingTrend: {
      labels: monthlyBookingsData.map(item => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[item.month - 1];
      }),
      datasets: [{
        label: 'Jumlah Booking',
        data: monthlyBookingsData.map(item => item.count),
        borderColor: 'rgb(59, 130, 246)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        tension: 0.4
      }]
    },
    revenue: {
      labels: monthlyRevenueData.map(item => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[item.month - 1];
      }),
      datasets: [{
        label: 'Revenue (Juta Rp)',
        data: monthlyRevenueData.map(item => Math.round(item.total / 1000000 * 10) / 10),
        backgroundColor: 'rgba(16, 185, 129, 0.8)',
        borderColor: 'rgb(16, 185, 129)',
        borderWidth: 1
      }]
    },
    motorType: {
      labels: motorTypesData.map(item => item.merk),
      datasets: [{
        data: motorTypesData.map(item => item.count),
        backgroundColor: [
          'rgba(59, 130, 246, 0.8)',
          'rgba(16, 185, 129, 0.8)',
          'rgba(245, 158, 11, 0.8)',
          'rgba(239, 68, 68, 0.8)',
          'rgba(147, 51, 234, 0.8)',
          'rgba(236, 72, 153, 0.8)'
        ]
      }]
    },
    popularHours: {
      labels: popularTimesData.map(item => String(item.hour).padStart(2, '0') + ':00'),
      datasets: [{
        label: 'Jumlah Booking',
        data: popularTimesData.map(item => item.count),
        backgroundColor: 'rgba(147, 51, 234, 0.8)',
        borderColor: 'rgb(147, 51, 234)',
        borderWidth: 1
      }]
    },
    status: {
      labels: Object.keys(statusDistributionData),
      datasets: [{
        data: Object.values(statusDistributionData),
        backgroundColor: [
          'rgba(16, 185, 129, 0.8)',
          'rgba(59, 130, 246, 0.8)',
          'rgba(245, 158, 11, 0.8)',
          'rgba(239, 68, 68, 0.8)'
        ]
      }]
    }
  };

  // Function to destroy existing chart if it exists
  function destroyChart(chartInstance) {
    if (chartInstance && typeof chartInstance.destroy === 'function') {
      chartInstance.destroy();
    }
  }

  // Function to create all charts
  function createCharts() {
    // Destroy existing charts first to prevent memory leaks and duplicate data
    destroyChart(bookingTrendChart);
    destroyChart(revenueChart);
    destroyChart(motorTypeChart);
    destroyChart(popularHoursChart);
    destroyChart(statusChart);

    // Create Booking Trend Chart
    const bookingTrendCtx = document.getElementById('bookingTrendChart').getContext('2d');
    bookingTrendChart = new Chart(bookingTrendCtx, {
      type: 'line',
      data: chartData.bookingTrend,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          intersect: false,
          mode: 'index'
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Booking'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Bulan'
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Booking: ' + context.parsed.y + ' transaksi';
              }
            }
          }
        },
        animation: {
          duration: 2000,
          easing: 'easeInOutQuart'
        },
        elements: {
          point: {
            radius: 5,
            hoverRadius: 8
          }
        }
      }
    });

    // Create Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
      type: 'bar',
      data: chartData.revenue,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value + 'M';
              }
            },
            title: {
              display: true,
              text: 'Revenue (Juta Rupiah)'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Bulan'
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Revenue: Rp ' + context.parsed.y + ' Juta';
              }
            }
          }
        },
        animation: {
          duration: 2000,
          easing: 'easeInOutQuart'
        }
      }
    });

    // Create Motor Type Chart
    const motorTypeCtx = document.getElementById('motorTypeChart').getContext('2d');
    motorTypeChart = new Chart(motorTypeCtx, {
      type: 'doughnut',
      data: chartData.motorType,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // Create Popular Hours Chart
    const popularHoursCtx = document.getElementById('popularHoursChart').getContext('2d');
    popularHoursChart = new Chart(popularHoursCtx, {
      type: 'bar',
      data: chartData.popularHours,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    // Create Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    statusChart = new Chart(statusCtx, {
      type: 'pie',
      data: chartData.status,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  }

  // Initialize charts when DOM is loaded
  document.addEventListener('DOMContentLoaded', function() {
    createCharts();
  });

  // Period selector with proper chart refresh
  document.getElementById('periodSelect').addEventListener('change', function() {
    const period = this.value;

    if (period === 'custom') {
      // Show custom date picker modal
      alert('Custom date range picker would be implemented here');
      return;
    }

    // Show loading state
    const canvases = document.querySelectorAll('canvas');
    canvases.forEach(canvas => {
      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = '#f3f4f6';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = '#6b7280';
      ctx.font = '16px Arial';
      ctx.textAlign = 'center';
      ctx.fillText('Loading...', canvas.width / 2, canvas.height / 2);
    });

    // Simulate API call delay and recreate charts with fresh data
    setTimeout(() => {
      // In real app, you would fetch new data based on period here
      // For now, just recreate charts with same data
      createCharts();
      console.log('Charts refreshed for period:', period);
    }, 500);
  });

  // Cleanup function to prevent memory leaks
  function cleanupCharts() {
    destroyChart(bookingTrendChart);
    destroyChart(revenueChart);
    destroyChart(motorTypeChart);
    destroyChart(popularHoursChart);
    destroyChart(statusChart);
  }

  // Cleanup on page unload
  window.addEventListener('beforeunload', cleanupCharts);

  // Cleanup on page visibility change (when switching tabs)
  document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
      // Page is now hidden
      cleanupCharts();
    } else {
      // Page is now visible - recreate charts
      setTimeout(createCharts, 100);
    }
  });
</script>
@endsection