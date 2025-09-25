@extends('layouts.sidebar')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Manajemen Transaksi</h1>
      <p class="text-gray-600">Mengelola semua transaksi pembayaran</p>
    </div>
    <div class="flex space-x-3">
      <a href="{{ route('admin.transaksi.export', request()->query()) }}"
        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">
        <i class="fas fa-file-pdf mr-2"></i>Export PDF
      </a>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
          <i class="fas fa-receipt text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Total Transaksi</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_transaksi']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
          <i class="fas fa-clock text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Pending</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pending_transaksi']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
          <i class="fas fa-check-circle text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Berhasil</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['paid_transaksi']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
          <i class="fas fa-coins text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Total Revenue</p>
          <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Revenue Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100">Revenue Hari Ini</p>
          <p class="text-3xl font-bold">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="p-3 bg-blue-400 rounded-full">
          <i class="fas fa-calendar-day text-2xl"></i>
        </div>
      </div>
    </div>

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
  </div>

  <!-- Filters -->
  <div class="bg-white rounded-lg shadow p-4">
    <form method="GET" class="flex flex-wrap gap-4 items-center">
      <div class="flex-1 min-w-64">
        <input type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari kode transaksi atau nama penyewa..."
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div>
        <select name="status"
          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
          <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>
      <div>
        <input type="date"
          name="start_date"
          value="{{ request('start_date') }}"
          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div>
        <input type="date"
          name="end_date"
          value="{{ request('end_date') }}"
          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
        <i class="fas fa-search mr-2"></i>Filter
      </button>
      <a href="{{ route('admin.transaksi.index') }}"
        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
        Reset
      </a>
    </form>
  </div>

  <!-- Transactions Table -->
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($transaksis as $transaksi)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</div>
              @if($transaksi->booking_code)
              <div class="text-xs text-gray-500">{{ $transaksi->booking_code }}</div>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $transaksi->penyewa->name ?? '-' }}</div>
              <div class="text-sm text-gray-500">{{ $transaksi->penyewa->email ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ $transaksi->motor->merk ?? '-' }} {{ $transaksi->motor->nama_motor ?? '-' }}
              </div>
              <div class="text-sm text-gray-500">{{ $transaksi->motor->no_plat ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                COD/Cash
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @php
              $statusClasses = [
              'pending' => 'bg-yellow-100 text-yellow-800',
              'confirmed' => 'bg-blue-100 text-blue-800',
              'active' => 'bg-purple-100 text-purple-800',
              'completed' => 'bg-green-100 text-green-800',
              'cancelled' => 'bg-red-100 text-red-800'
              ];
              $statusValue = is_object($transaksi->status) ? $transaksi->status->value : $transaksi->status;
              @endphp
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$statusValue] ?? 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($statusValue) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $transaksi->created_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                class="text-blue-600 hover:text-blue-900">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
              Belum ada data transaksi
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Enhanced Pagination -->
    @if($transaksis->hasPages())
    <div class="px-6 py-4">
      {{ $transaksis->appends(request()->query())->links('custom.advanced-pagination') }}
    </div>
    @endif
  </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
  {{ session('success') }}
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto hide success alert
    const alert = document.getElementById('successAlert');
    if (alert) {
      setTimeout(() => {
        alert.style.display = 'none';
      }, 3000);
    }
  });
</script>
@endsection