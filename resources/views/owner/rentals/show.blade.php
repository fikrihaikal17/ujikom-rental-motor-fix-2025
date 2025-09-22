@extends('layouts.owner')

@section('title', 'Detail Penyewaan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-4">
          <li>
            <a href="{{ route('owner.rentals') }}" class="text-gray-400 hover:text-gray-500">
              <span class="sr-only">Rentals</span>
              Kelola Penyewaan
            </a>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="ml-4 text-sm font-medium text-gray-500">Detail Penyewaan #{{ $penyewaan->id }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Content -->
  <div class="mt-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
      <!-- Main content -->
      <div class="lg:col-span-8">
        <!-- Rental Info Card -->
        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Penyewaan</h3>

            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
              <div>
                <dt class="text-sm font-medium text-gray-500">ID Penyewaan</dt>
                <dd class="mt-1 text-sm text-gray-900">#{{ $penyewaan->id }}</dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                  @php
                  $statusConfig = [
                  'pending' => ['bg-yellow-100', 'text-yellow-800', 'Menunggu'],
                  'confirmed' => ['bg-blue-100', 'text-blue-800', 'Dikonfirmasi'],
                  'active' => ['bg-green-100', 'text-green-800', 'Aktif'],
                  'ongoing' => ['bg-green-100', 'text-green-800', 'Berlangsung'],
                  'completed' => ['bg-gray-100', 'text-gray-800', 'Selesai'],
                  'cancelled' => ['bg-red-100', 'text-red-800', 'Dibatalkan']
                  ];
                  $config = $statusConfig[$penyewaan->status] ?? ['bg-gray-100', 'text-gray-800', ucfirst($penyewaan->status)];
                  @endphp
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $config[0] }} {{ $config[1] }}">
                    {{ $config[2] }}
                  </span>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d M Y') }}</dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($penyewaan->tanggal_selesai)->format('d M Y') }}</dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($penyewaan->tanggal_selesai)) + 1 }} hari</dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</dd>
              </div>
            </dl>
          </div>
        </div>

        <!-- Motor Info Card -->
        <div class="mt-6 bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Motor</h3>

            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                @if($penyewaan->motor->gambar)
                <img class="h-20 w-20 rounded-lg object-cover" src="{{ Storage::url($penyewaan->motor->gambar) }}" alt="{{ $penyewaan->motor->nama }}">
                @else
                <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                  <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
                @endif
              </div>
              <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900">{{ $penyewaan->motor->nama }}</h4>
                <p class="text-sm text-gray-500">{{ $penyewaan->motor->merk }} - {{ $penyewaan->motor->tahun }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $penyewaan->motor->warna }} | {{ $penyewaan->motor->nomor_plat }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Payments -->
        @if($penyewaan->payments && $penyewaan->payments->count() > 0)
        <div class="mt-6 bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Riwayat Pembayaran</h3>

            <div class="space-y-4">
              @foreach($penyewaan->payments as $payment)
              <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ $payment->payment_method }}</p>
                    <p class="text-sm text-gray-500">{{ $payment->created_at->format('d M Y H:i') }}</p>
                  </div>
                  <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                      {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                      {{ ucfirst($payment->status) }}
                    </span>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif
      </div>

      <!-- Sidebar -->
      <div class="mt-6 lg:col-span-4 lg:mt-0">
        <!-- Renter Info -->
        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Penyewa</h3>

            @if($penyewaan->renter)
            <div class="space-y-3">
              <div>
                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $penyewaan->renter->name }}</dd>
              </div>

              <div>
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $penyewaan->renter->email }}</dd>
              </div>

              @if($penyewaan->renter->phone)
              <div>
                <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $penyewaan->renter->phone }}</dd>
              </div>
              @endif
            </div>
            @else
            <p class="text-sm text-gray-500">Informasi penyewa tidak tersedia</p>
            @endif
          </div>
        </div>

        <!-- Revenue Share -->
        @if($penyewaan->bagiHasil)
        <div class="mt-6 bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Bagi Hasil</h3>

            <div class="space-y-3">
              <div class="flex justify-between">
                <span class="text-sm text-gray-500">Bagian Pemilik</span>
                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($penyewaan->bagiHasil->bagi_hasil_pemilik, 0, ',', '.') }}</span>
              </div>

              <div class="flex justify-between">
                <span class="text-sm text-gray-500">Bagian Platform</span>
                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($penyewaan->bagiHasil->bagi_hasil_platform, 0, ',', '.') }}</span>
              </div>

              <div class="border-t pt-3">
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-gray-900">Status</span>
                  <span class="text-sm {{ $penyewaan->bagiHasil->settled_at ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $penyewaan->bagiHasil->settled_at ? 'Sudah Dibayar' : 'Menunggu' }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection