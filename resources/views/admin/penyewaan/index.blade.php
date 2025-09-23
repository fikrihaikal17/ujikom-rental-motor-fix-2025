@extends('layouts.sidebar')

@section('title', 'Verifikasi Penyewaan')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Verifikasi Penyewaan</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola dan verifikasi permintaan penyewaan motor dari penyewa.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex sm:space-x-3">
      <!-- PDF Export Button -->
      <a href="{{ route('admin.penyewaan.export.pdf', request()->query()) }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Penyewaan</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $totalPenyewaan }}</dd>
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
            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Verifikasi</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $pendingPenyewaan }}</dd>
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
            <dt class="text-sm font-medium text-gray-500 truncate">Aktif</dt>
            <dd class="text-lg font-medium text-green-600">{{ $activePenyewaan }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $completedPenyewaan }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters -->
<div class="bg-white shadow rounded-lg mb-6">
  <div class="px-4 py-5 sm:p-6">
    <form method="GET" action="{{ route('admin.penyewaan.index') }}" class="grid grid-cols-1 gap-6 sm:grid-cols-4">
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
          <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
          <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
      </div>
      <div>
        <label for="motor" class="block text-sm font-medium text-gray-700">Motor</label>
        <input type="text" id="motor" name="motor" value="{{ request('motor') }}" placeholder="Cari motor..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
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

<!-- Penyewaan Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
  <div class="px-4 py-5 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Penyewaan</h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">Data semua penyewaan motor yang terdaftar.</p>
  </div>

  @if(isset($penyewaans) && $penyewaans->count() > 0)
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Kode Booking
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Penyewa
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Motor
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Periode Sewa
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Total Biaya
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Status
          </th>
          <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($penyewaans as $penyewaan)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ $penyewaan->booking_code }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex-shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                  <span class="text-sm font-medium text-gray-700">{{ substr($penyewaan->penyewa->name, 0, 1) }}</span>
                </div>
              </div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $penyewaan->penyewa->name }}</div>
                <div class="text-sm text-gray-500">{{ $penyewaan->penyewa->email }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ $penyewaan->motor->merk }} {{ $penyewaan->motor->model }}</div>
            <div class="text-sm text-gray-500">{{ $penyewaan->motor->no_plat }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <div>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d/m/Y') }}</div>
            <div class="text-gray-500">s/d {{ \Carbon\Carbon::parse($penyewaan->tanggal_selesai)->format('d/m/Y') }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            Rp {{ number_format($penyewaan->harga, 0, ',', '.') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            @php
            $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'ongoing' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Berjalan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
            ];
            @endphp
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$penyewaan->status->value] ?? 'bg-gray-100 text-gray-800' }}">
              {{ $statusLabels[$penyewaan->status->value] ?? ucfirst($penyewaan->status->value) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex items-center justify-end space-x-2">
              <a href="{{ route('admin.penyewaan.show', $penyewaan) }}" class="text-primary-600 hover:text-primary-900">
                Detail
              </a>

              @if($penyewaan->status->value === 'pending')
              <!-- Tombol Terima untuk status pending -->
              <form method="POST" action="{{ route('admin.penyewaan.update-status', $penyewaan) }}" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="return confirm('Terima penyewaan ini?')">
                  <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  Terima
                </button>
              </form>

              <!-- Tombol Tolak untuk status pending -->
              <form method="POST" action="{{ route('admin.penyewaan.update-status', $penyewaan) }}" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Tolak penyewaan ini?')">
                  <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                  Tolak
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(method_exists($penyewaans, 'hasPages') && $penyewaans->hasPages())
  <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    {{ $penyewaans->appends(request()->query())->links() }}
  </div>
  @endif

  @else
  <div class="px-4 py-12 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada penyewaan</h3>
    <p class="mt-1 text-sm text-gray-500">Belum ada permintaan penyewaan yang perlu diverifikasi.</p>
  </div>
  @endif
</div>
@endsection