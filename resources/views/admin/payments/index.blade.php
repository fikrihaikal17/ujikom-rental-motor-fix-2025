@extends('layouts.sidebar')

@section('title', 'Kelola Pembayaran')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Pembayaran</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola semua data pembayaran dan transaksi dalam sistem.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
      <a href="{{ route('admin.payments.report.export.pdf') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export PDF
      </a>
    </div>
  </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="mb-4 rounded-md bg-green-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
  </div>
</div>
@endif

<!-- Statistics Cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Pembayaran</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] ?? 0 }}</dd>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Berhasil</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $stats['success'] ?? 0 }}</dd>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending'] ?? 0 }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Nilai</dt>
            <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($stats['total_amount'] ?? 0, 0, ',', '.') }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters -->
<div class="bg-white shadow rounded-lg mb-6">
  <div class="px-4 py-5 sm:p-6">
    <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 gap-6 sm:grid-cols-4">
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Berhasil</option>
          <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
          <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refund</option>
        </select>
      </div>
      <div>
        <label for="method" class="block text-sm font-medium text-gray-700">Metode Bayar</label>
        <select id="method" name="method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          <option value="">Semua Metode</option>
          <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash/COD</option>
        </select>
      </div>
      <div>
        <label for="date_from" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
      </div>
      <div class="flex items-end">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          Filter
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Payments Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
  <div class="px-4 py-5 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Pembayaran</h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">Data semua transaksi pembayaran dalam sistem.</p>
  </div>

  @if(isset($payments) && $payments->count() > 0)
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            ID Transaksi
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Penyewa
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Penyewaan
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Jumlah
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Metode
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Status
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Tanggal
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($payments as $payment)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ $payment->transaction_id }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex-shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                  <span class="text-sm font-medium text-gray-700">{{ substr($payment->penyewa->nama, 0, 1) }}</span>
                </div>
              </div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $payment->penyewa->nama }}</div>
                <div class="text-sm text-gray-500">{{ $payment->penyewa->email }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ $payment->booking_code }}</div>
            <div class="text-sm text-gray-500">{{ $payment->motor->merk }} {{ $payment->motor->nama_motor }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            Rp {{ number_format($payment->amount, 0, ',', '.') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <div class="flex items-center">
              <svg class="h-4 w-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
              </svg>
              COD/Cash
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            @php
            $statusClasses = [
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
            'completed' => 'Berhasil',
            'pending' => 'Pending',
            'failed' => 'Gagal'
            ];
            @endphp
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$payment->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
              {{ $statusLabels[$payment->payment_status] ?? ucfirst($payment->payment_status) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}
          </td>
        </tr>
        @endforeach
      </tbody>
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
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pembayaran</h3>
    <p class="mt-1 text-sm text-gray-500">Belum ada transaksi pembayaran dalam sistem.</p>
  </div>
  @endif
</div>
@endsection