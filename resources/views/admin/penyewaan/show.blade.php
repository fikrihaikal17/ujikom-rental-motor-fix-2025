@extends('layouts.admin')

@section('title', 'Detail Penyewaan')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Detail Penyewaan</h1>
        <p class="text-gray-600">{{ $penyewaan->booking_code }}</p>
      </div>
      <a href="{{ route('admin.penyewaan.index') }}" 
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>
        Kembali
      </a>
    </div>
  </div>

  <!-- Status Badge -->
  <div class="mb-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
      @if($penyewaan->status->value === 'pending') bg-yellow-100 text-yellow-800
      @elseif($penyewaan->status->value === 'confirmed') bg-blue-100 text-blue-800
      @elseif($penyewaan->status->value === 'active') bg-green-100 text-green-800
      @elseif($penyewaan->status->value === 'completed') bg-green-100 text-green-800
      @elseif($penyewaan->status->value === 'cancelled') bg-red-100 text-red-800
      @else bg-gray-100 text-gray-800
      @endif">
      {{ ucfirst($penyewaan->status->value) }}
    </span>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Informasi Penyewaan -->
    <div class="bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-semibold mb-4">Informasi Penyewaan</h2>
      
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Kode Booking</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->booking_code }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->tanggal_mulai->format('d/m/Y') }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->tanggal_selesai->format('d/m/Y') }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Durasi</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->duration_in_days }} hari ({{ ucfirst($penyewaan->tipe_durasi->value) }})</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Total Harga</label>
          <p class="mt-1 text-gray-900 font-semibold text-lg">{{ $penyewaan->formatted_price }}</p>
        </div>
        
        @if($penyewaan->catatan)
        <div>
          <label class="block text-sm font-medium text-gray-700">Catatan</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->catatan }}</p>
        </div>
        @endif
      </div>
    </div>

    <!-- Informasi Penyewa -->
    <div class="bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-semibold mb-4">Informasi Penyewa</h2>
      
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->penyewa->name }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->penyewa->email }}</p>
        </div>
        
        @if($penyewaan->penyewa->phone)
        <div>
          <label class="block text-sm font-medium text-gray-700">Telepon</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->penyewa->phone }}</p>
        </div>
        @endif
        
        @if($penyewaan->penyewa->address)
        <div>
          <label class="block text-sm font-medium text-gray-700">Alamat</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->penyewa->address }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Informasi Motor -->
  <div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Informasi Motor</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Motor</label>
          <p class="mt-1 text-gray-900 font-semibold">{{ $penyewaan->motor->nama_motor }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Merk</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->motor->merk }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Tipe CC</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->motor->tipe_cc?->value ?? '-' }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->motor->no_plat }}</p>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Tahun</label>
          <p class="mt-1 text-gray-900">{{ $penyewaan->motor->tahun }}</p>
        </div>
      </div>
      
      @if($penyewaan->motor->photo)
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Motor</label>
        <img src="{{ asset('storage/' . $penyewaan->motor->photo) }}" 
             alt="{{ $penyewaan->motor->nama_motor }}"
             class="w-full h-48 object-cover rounded-lg">
      </div>
      @endif
    </div>
  </div>

  <!-- Informasi Transaksi -->
  @if($penyewaan->transaksi)
  <div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Informasi Transaksi</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
        <p class="mt-1 text-gray-900 font-semibold">Rp {{ number_format($penyewaan->transaksi->total_pembayaran, 0, ',', '.') }}</p>
      </div>
      
      <div>
        <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
          @if($penyewaan->transaksi->status_pembayaran === 'paid') bg-green-100 text-green-800
          @elseif($penyewaan->transaksi->status_pembayaran === 'pending') bg-yellow-100 text-yellow-800
          @else bg-red-100 text-red-800
          @endif">
          {{ ucfirst($penyewaan->transaksi->status_pembayaran) }}
        </span>
      </div>
      
      <div>
        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
        <p class="mt-1 text-gray-900">{{ ucfirst($penyewaan->transaksi->metode_pembayaran) }}</p>
      </div>
    </div>
  </div>
  @endif

  <!-- Informasi Pembayaran -->
  @if($penyewaan->payments->count() > 0)
  <div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Riwayat Pembayaran</h2>
    
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($penyewaan->payments as $payment)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $payment->created_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
              {{ $payment->formatted_amount }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $payment->payment_method_display }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($payment->status === 'completed') bg-green-100 text-green-800
                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800
                @endif">
                {{ $payment->status_display['text'] ?? ucfirst($payment->status) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  <!-- Actions untuk Status Pending -->
  @if($penyewaan->status->value === 'pending')
  <div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Aksi Verifikasi</h2>
    
    <div class="flex space-x-4">
      <form action="{{ route('admin.penyewaan.update-status', $penyewaan) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="confirmed">
        <button type="submit" 
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition-colors"
                onclick="return confirm('Yakin ingin menyetujui penyewaan ini?')">
          <i class="fas fa-check mr-2"></i>
          Setujui Penyewaan
        </button>
      </form>
      
      <form action="{{ route('admin.penyewaan.update-status', $penyewaan) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="cancelled">
        <button type="submit" 
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors"
                onclick="return confirm('Yakin ingin menolak penyewaan ini?')">
          <i class="fas fa-times mr-2"></i>
          Tolak Penyewaan
        </button>
      </form>
    </div>
  </div>
  @endif

  <!-- Timestamps -->
  <div class="mt-6 bg-gray-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
      <div>
        <strong>Dibuat:</strong> {{ $penyewaan->created_at->format('d/m/Y H:i') }}
      </div>
      @if($penyewaan->confirmed_at)
      <div>
        <strong>Dikonfirmasi:</strong> {{ $penyewaan->confirmed_at->format('d/m/Y H:i') }}
      </div>
      @endif
      @if($penyewaan->updated_at != $penyewaan->created_at)
      <div>
        <strong>Diupdate:</strong> {{ $penyewaan->updated_at->format('d/m/Y H:i') }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection