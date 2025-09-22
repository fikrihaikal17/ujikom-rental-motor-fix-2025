@extends('layouts.sidebar')

@section('title', 'Laporan Pembayaran')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Laporan Pembayaran</h1>
      <p class="mt-2 text-sm text-gray-700">Generate dan lihat laporan lengkap pembayaran dalam berbagai format.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3 flex">
      <a href="{{ route('admin.payments.report.export', ['format' => 'pdf']) }}"
        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
          </path>
        </svg>
        Export PDF
      </a>
      <a href="{{ route('admin.payments.report.export', ['format' => 'excel']) }}"
        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a4 4 0 01-4-4V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
          </path>
        </svg>
        Export Excel
      </a>
    </div>
  </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow rounded-lg mb-6">
  <div class="px-4 py-5 sm:p-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Filter Laporan</h3>
    <form method="GET" action="{{ route('admin.payments.report') }}" class="grid grid-cols-1 gap-6 sm:grid-cols-6">
      <div class="sm:col-span-2">
        <label for="date_from" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
        <input type="date" id="date_from" name="date_from"
          value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
      </div>
      <div class="sm:col-span-2">
        <label for="date_to" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
        <input type="date" id="date_to" name="date_to" value="{{ request('date_to', now()->format('Y-m-d')) }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
      </div>
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="status" name="status"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          <option value="">Semua Status</option>
          <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Berhasil</option>
          <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
          <option value="failed" {{ request('status')=='failed' ? 'selected' : '' }}>Gagal</option>
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit"
          class="w-full inline-flex justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          Generate
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Summary Statistics -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Transaksi</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $report['total_transactions'] ?? 0 }}</dd>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
            </path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Nilai</dt>
            <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($report['total_amount'] ?? 0, 0, ',', '.')
              }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Sukses</dt>
            <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($report['success_amount'] ?? 0, 0, ',',
              '.') }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
            <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($report['pending_amount'] ?? 0, 0, ',',
              '.') }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Methods Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Breakdown Metode Pembayaran</h3>
      <div class="space-y-4">
        @if(isset($report['payment_methods']))
        @foreach($report['payment_methods'] as $method => $data)
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            @switch($method)
            @case('transfer')
            <svg class="h-5 w-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z">
              </path>
            </svg>
            Transfer Bank
            @break
            @case('cash')
            <svg class="h-5 w-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
              </path>
            </svg>
            Cash
            @break
            @case('ewallet')
            <svg class="h-5 w-5 mr-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
              </path>
            </svg>
            E-Wallet
            @break
            @default
            <svg class="h-5 w-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"></path>
            </svg>
            {{ ucfirst(str_replace('_', ' ', $method)) }}
            @endswitch
          </div>
          <div class="text-right">
            <div class="text-sm font-medium text-gray-900">{{ $data['count'] }} transaksi</div>
            <div class="text-sm text-gray-500">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
          </div>
        </div>
        @endforeach
        @else
        <p class="text-gray-500 text-center py-4">Tidak ada data metode pembayaran</p>
        @endif
      </div>
    </div>
  </div>

  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Status Pembayaran</h3>
      <div class="space-y-4">
        @if(isset($report['status_breakdown']))
        @foreach($report['status_breakdown'] as $status => $data)
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            @switch($status)
            @case('completed')
            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
            Berhasil
            @break
            @case('pending')
            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
            Pending
            @break
            @case('failed')
            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
            Gagal
            @break
            @case('processing')
            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
            Diproses
            @break
            @default
            <div class="w-3 h-3 bg-gray-500 rounded-full mr-3"></div>
            {{ ucfirst($status) }}
            @endswitch
          </div>
          <div class="text-right">
            <div class="text-sm font-medium text-gray-900">{{ $data['count'] }} transaksi</div>
            <div class="text-sm text-gray-500">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
          </div>
        </div>
        @endforeach
        @else
        <p class="text-gray-500 text-center py-4">Tidak ada data status pembayaran</p>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Daily Transaction Chart -->
<div class="bg-white shadow rounded-lg mb-8">
  <div class="px-4 py-5 sm:p-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Trend Pembayaran Harian</h3>
    <div class="h-80">
      <canvas id="dailyTransactionChart"></canvas>
    </div>
  </div>
</div>

<!-- Detailed Payment Report -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
  <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Laporan Pembayaran</h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">
      Periode: {{ request('date_from', now()->startOfMonth()->format('d/m/Y')) }} - {{ request('date_to',
      now()->format('d/m/Y')) }}
    </p>
  </div>

  @if(isset($payments) && $payments->count() > 0)
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Tanggal
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            ID Transaksi
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Penyewa
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Motor
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Metode
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Jumlah
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Status
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($payments as $payment)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
            {{ $payment->transaction_id }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $payment->penyewaan->user->nama }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $payment->penyewaan->motor->merk }} {{ $payment->penyewaan->motor->model }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            Rp {{ number_format($payment->amount, 0, ',', '.') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            @php
            $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
            'pending' => 'Pending',
            'processing' => 'Diproses',
            'completed' => 'Berhasil',
            'failed' => 'Gagal'
            ];
            @endphp
            <span
              class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
              {{ $statusLabels[$payment->status] ?? ucfirst($payment->status) }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-gray-50">
        <tr>
          <td colspan="5" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
            Total:
          </td>
          <td class="px-6 py-4 text-sm font-bold text-gray-900">
            Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}
          </td>
          <td class="px-6 py-4"></td>
        </tr>
      </tfoot>
    </table>
  </div>

  @if(method_exists($payments, 'hasPages') && $payments->hasPages())
  <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    {{ $payments->appends(request()->query())->links() }}
  </div>
  @endif

  @else
  <div class="px-4 py-12 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a4 4 0 01-4-4V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
      </path>
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data pembayaran</h3>
    <p class="mt-1 text-sm text-gray-500">Sesuaikan filter tanggal atau status untuk melihat data.</p>
  </div>
  @endif
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Chart instance - store globally to manage destroy/recreate
  let dailyTransactionChart;

  // Sample daily transaction data
  const dailyData = {
    // eslint-disable-next-line
    labels: @json($report['daily_labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']),
    datasets: [{
      label: 'Jumlah Transaksi',
      // eslint-disable-next-line
      data: @json($report['daily_counts'] ?? [12, 18, 22, 28, 32, 35, 38]),
      backgroundColor: 'rgba(59, 130, 246, 0.1)',
      borderColor: 'rgb(59, 130, 246)',
      borderWidth: 2,
      tension: 0.4
    }, {
      label: 'Total Nilai (Juta Rp)',
      // eslint-disable-next-line
      data: @json($report['daily_amounts'] ?? [15, 22, 28, 35, 42, 48, 55]),
      backgroundColor: 'rgba(16, 185, 129, 0.1)',
      borderColor: 'rgb(16, 185, 129)',
      borderWidth: 2,
      tension: 0.4,
      yAxisID: 'y1'
    }]
  };

  // Function to destroy existing chart if it exists
  function destroyDailyChart() {
    if (dailyTransactionChart && typeof dailyTransactionChart.destroy === 'function') {
      dailyTransactionChart.destroy();
    }
  }

  // Function to create daily transaction chart
  function createDailyChart() {
    // Destroy existing chart first
    destroyDailyChart();

    const ctx = document.getElementById('dailyTransactionChart').getContext('2d');
    dailyTransactionChart = new Chart(ctx, {
      type: 'line',
      data: dailyData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Tanggal'
            }
          },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            title: {
              display: true,
              text: 'Jumlah Transaksi'
            }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            title: {
              display: true,
              text: 'Total Nilai (Juta Rp)'
            },
            grid: {
              drawOnChartArea: false,
            },
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    });
  }

  // Initialize chart when DOM is loaded
  document.addEventListener('DOMContentLoaded', function () {
    createDailyChart();
  });

  // Function to refresh chart data (for future AJAX implementation)
  function refreshChartData() {
    // Show loading state
    const canvas = document.getElementById('dailyTransactionChart');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#f3f4f6';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#6b7280';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Loading...', canvas.width / 2, canvas.height / 2);

    // In real implementation, fetch new data via AJAX
    setTimeout(() => {
      createDailyChart();
      console.log('Payment report chart refreshed');
    }, 500);
  }

  // Auto-refresh data every 5 minutes (disabled for demo)
  // setInterval(refreshChartData, 300000);

  // Cleanup function
  function cleanupPaymentChart() {
    destroyDailyChart();
  }

  // Cleanup on page unload
  window.addEventListener('beforeunload', cleanupPaymentChart);

  // Cleanup on page visibility change
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      cleanupPaymentChart();
    } else {
      setTimeout(createDailyChart, 100);
    }
  });
</script>
@endsection