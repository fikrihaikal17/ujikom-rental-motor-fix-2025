@extends('layouts.owner')

@section('title', 'Kelola Penyewaan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Penyewaan</h1>
      <p class="mt-2 text-sm text-gray-700">Daftar semua penyewaan motor yang Anda miliki.</p>
    </div>
  </div>

  <!-- Rentals Table -->
  <div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($rentals as $rental)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  #{{ $rental->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      @if($rental->motor->gambar)
                      <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($rental->motor->gambar) }}" alt="{{ $rental->motor->nama }}">
                      @else
                      <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                      </div>
                      @endif
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ $rental->motor->nama }}</div>
                      <div class="text-sm text-gray-500">{{ $rental->motor->merk }} - {{ $rental->motor->tahun }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $rental->renter->name ?? 'N/A' }}</div>
                  <div class="text-sm text-gray-500">{{ $rental->renter->email ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div>{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}</div>
                  <div class="text-gray-500">s.d {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                  $statusConfig = [
                  'pending' => ['bg-yellow-100', 'text-yellow-800', 'Menunggu'],
                  'confirmed' => ['bg-blue-100', 'text-blue-800', 'Dikonfirmasi'],
                  'active' => ['bg-green-100', 'text-green-800', 'Aktif'],
                  'ongoing' => ['bg-green-100', 'text-green-800', 'Berlangsung'],
                  'completed' => ['bg-gray-100', 'text-gray-800', 'Selesai'],
                  'cancelled' => ['bg-red-100', 'text-red-800', 'Dibatalkan']
                  ];
                  $config = $statusConfig[$rental->status] ?? ['bg-gray-100', 'text-gray-800', ucfirst($rental->status)];
                  @endphp
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $config[0] }} {{ $config[1] }}">
                    {{ $config[2] }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="{{ route('owner.rentals.show', $rental) }}" class="text-primary-600 hover:text-primary-900">
                    Detail
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                  <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada penyewaan</h3>
                    <p class="mt-1 text-sm text-gray-500">Motor Anda belum ada yang disewa.</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  @if($rentals->hasPages())
  <div class="mt-6">
    {{ $rentals->links('custom.advanced-pagination') }}
  </div>
  @endif
</div>
@endsection