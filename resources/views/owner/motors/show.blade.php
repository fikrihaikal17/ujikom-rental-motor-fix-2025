@extends('layouts.app')

@section('title', 'Detail Motor - RideNow')

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
        <div class="flex items-center space-x-4">
          <a href="{{ route('owner.motors.index') }}"
            class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Motor
          </a>
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $motor->nama_motor }}</h1>
            <p class="text-gray-600 mt-2">{{ $motor->merk }} {{ $motor->model }} ({{ $motor->tahun }})</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Motor Details -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Motor Photo -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-96 bg-gray-200">
              @if($motor->foto_motor)
              <img src="{{ asset('storage/' . $motor->foto_motor) }}"
                alt="{{ $motor->nama_motor }}"
                class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center">
                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
              </div>
              @endif
            </div>
          </div>

          <!-- Motor Information -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Motor</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Motor</label>
                <p class="text-gray-900 font-medium">{{ $motor->nama_motor }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Merk</label>
                <p class="text-gray-900 font-medium">{{ $motor->merk }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Model</label>
                <p class="text-gray-900 font-medium">{{ $motor->model }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tahun</label>
                <p class="text-gray-900 font-medium">{{ $motor->tahun }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Plat Nomor</label>
                <p class="text-gray-900 font-medium">{{ $motor->plat_nomor }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Kapasitas Mesin</label>
                <p class="text-gray-900 font-medium">{{ $motor->kapasitas_mesin }} CC</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Harga Sewa per Hari</label>
                <p class="text-gray-900 font-medium">Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Daftar</label>
                <p class="text-gray-900 font-medium">{{ $motor->created_at->format('d M Y, H:i') }}</p>
              </div>
            </div>

            @if($motor->deskripsi)
            <div class="mt-6">
              <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi</label>
              <p class="text-gray-900 leading-relaxed">{{ $motor->deskripsi }}</p>
            </div>
            @endif
          </div>

          <!-- Rental History -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Riwayat Penyewaan</h2>

            @if($motor->penyewaans && $motor->penyewaans->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($motor->penyewaans->take(10) as $penyewaan)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">{{ $penyewaan->user->name }}</div>
                      <div class="text-sm text-gray-500">{{ $penyewaan->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d M Y') }} -
                      {{ \Carbon\Carbon::parse($penyewaan->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      Rp {{ number_format($penyewaan->jumlah_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      @php
                      $statusColors = [
                      'pending' => 'bg-yellow-100 text-yellow-800',
                      'confirmed' => 'bg-blue-100 text-blue-800',
                      'active' => 'bg-green-100 text-green-800',
                      'completed' => 'bg-gray-100 text-gray-800',
                      'cancelled' => 'bg-red-100 text-red-800'
                      ];
                      @endphp
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$penyewaan->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($penyewaan->status) }}
                      </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @else
            <div class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Penyewaan</h3>
              <p class="mt-1 text-sm text-gray-500">Motor ini belum pernah disewakan.</p>
            </div>
            @endif
          </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
          <!-- Status Card -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Motor</h3>

            @php
            $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'verified' => 'bg-green-100 text-green-800 border-green-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            'maintenance' => 'bg-gray-100 text-gray-800 border-gray-200'
            ];
            $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'maintenance' => 'Maintenance'
            ];
            $statusDescriptions = [
            'pending' => 'Motor sedang dalam proses verifikasi admin',
            'verified' => 'Motor telah diverifikasi dan dapat disewakan',
            'rejected' => 'Motor ditolak, mohon periksa catatan admin',
            'maintenance' => 'Motor sedang dalam perawatan'
            ];
            @endphp

            <div class="text-center">
              <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full border {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                {{ $statusLabels[$motor->status] ?? ucfirst($motor->status) }}
              </span>
              <p class="text-sm text-gray-600 mt-2">{{ $statusDescriptions[$motor->status] ?? '' }}</p>
            </div>

            @if($motor->status === 'rejected' && $motor->admin_notes)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
              <h4 class="text-sm font-medium text-red-800 mb-2">Catatan Admin:</h4>
              <p class="text-sm text-red-700">{{ $motor->admin_notes }}</p>
            </div>
            @endif

            @if($motor->status === 'verified' && $motor->admin_notes)
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
              <h4 class="text-sm font-medium text-green-800 mb-2">Catatan Admin:</h4>
              <p class="text-sm text-green-700">{{ $motor->admin_notes }}</p>
            </div>
            @endif
          </div>

          <!-- Statistics -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>

            <div class="space-y-3">
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Total Penyewaan:</span>
                <span class="text-sm font-medium text-gray-900">{{ $motor->penyewaans ? $motor->penyewaans->count() : 0 }}</span>
              </div>

              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Sedang Disewa:</span>
                <span class="text-sm font-medium text-gray-900">
                  {{ $motor->penyewaans ? $motor->penyewaans->whereIn('status', ['confirmed', 'active'])->count() : 0 }}
                </span>
              </div>

              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Total Pendapatan:</span>
                <span class="text-sm font-medium text-gray-900">
                  Rp {{ number_format($motor->penyewaans ? $motor->penyewaans->where('status', 'completed')->sum('jumlah_bayar') : 0, 0, ',', '.') }}
                </span>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>

            <div class="space-y-3">
              <a href="{{ route('owner.motors.edit', $motor) }}"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center block">
                Edit Motor
              </a>

              @if($motor->status === 'verified')
              <button class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                Set Maintenance
              </button>
              @endif

              @if($motor->status === 'maintenance')
              <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                Aktifkan Kembali
              </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection