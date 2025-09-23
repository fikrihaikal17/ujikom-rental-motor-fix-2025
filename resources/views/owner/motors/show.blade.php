@extends('layouts.owner')

@section('title', 'Detail Motor - RideNow')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
  <div class="flex items-center">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    {{ session('success') }}
  </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
  <div class="flex items-center">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
    </svg>
    {{ session('error') }}
  </div>
</div>
@endif

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
      <h1 class="text-3xl font-bold text-gray-900">{{ $motor->merk }} {{ $motor->model }}</h1>
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
        @if($motor->photo)
        <img src="{{ asset('storage/' . $motor->photo) }}"
          alt="{{ $motor->merk }} {{ $motor->model }}"
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
          <p class="text-gray-900 font-medium">{{ $motor->merk }} {{ $motor->model }}</p>
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
          <p class="text-gray-900 font-medium">{{ $motor->no_plat }}</p>
        </div>

        @if($motor->warna)
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Warna</label>
          <p class="text-gray-900 font-medium">{{ $motor->warna }}</p>
        </div>
        @endif

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Kapasitas Mesin</label>
          <p class="text-gray-900 font-medium">{{ $motor->tipe_cc }} CC</p>
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

    <!-- Dokumen Kepemilikan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Dokumen Kepemilikan</h2>

      @if($motor->dokumen_kepemilikan)
      <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
          <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <div>
            <p class="text-sm font-medium text-green-800">Dokumen Kepemilikan Tersedia</p>
            <p class="text-xs text-green-600">File sudah diupload dan dapat diverifikasi</p>
          </div>
        </div>
        <a href="{{ asset('storage/' . $motor->dokumen_kepemilikan) }}" target="_blank"
          class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors duration-200 flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
          Lihat Dokumen
        </a>
      </div>
      @else
      <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <div>
          <p class="text-sm font-medium text-yellow-800">Dokumen Kepemilikan Belum Diupload</p>
          <p class="text-xs text-yellow-600">Silakan upload dokumen STNK atau BPKB untuk verifikasi motor</p>
        </div>
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
                <div class="text-sm font-medium text-gray-900">{{ $penyewaan->penyewa->nama }}</div>
                <div class="text-sm text-gray-500">{{ $penyewaan->penyewa->email }}</div>
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
      $statusValue = $motor->status instanceof \App\Enums\MotorStatus ? $motor->status->value : $motor->status;
      @endphp

      <div class="text-center">
        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full border {{ $statusColors[$statusValue] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
          {{ $statusLabels[$statusValue] ?? ucfirst($statusValue) }}
        </span>
        <p class="text-sm text-gray-600 mt-2">{{ $statusDescriptions[$statusValue] ?? '' }}</p>
      </div>

      @if($statusValue === 'rejected' && $motor->admin_notes)
      <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <h4 class="text-sm font-medium text-red-800 mb-2">Catatan Admin:</h4>
        <p class="text-sm text-red-700">{{ $motor->admin_notes }}</p>
      </div>
      @endif

      @if($statusValue === 'verified' && $motor->admin_notes)
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

        <button type="button" id="deleteButton"
          class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
          Hapus Motor
        </button>

        @if($motor->status === \App\Enums\MotorStatus::VERIFIED || $motor->status === \App\Enums\MotorStatus::AVAILABLE)
        <form action="{{ route('owner.motors.set-maintenance', $motor) }}" method="POST" class="w-full">
          @csrf
          @method('PATCH')
          <button type="submit"
            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
            onclick="return confirm('Apakah Anda yakin ingin mengubah status motor ini ke maintenance?')">
            Set Maintenance
          </button>
        </form>
        @endif

        @if($motor->status === \App\Enums\MotorStatus::MAINTENANCE)
        <form action="{{ route('owner.motors.activate', $motor) }}" method="POST" class="w-full">
          @csrf
          @method('PATCH')
          <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
            onclick="return confirm('Apakah Anda yakin ingin mengaktifkan motor ini kembali?')">
            Aktifkan Kembali
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" action="{{ route('owner.motors.destroy', $motor) }}" method="POST" class="hidden">
  @csrf
  @method('DELETE')
</form>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript loaded successfully');

    // Delete button event listener
    const deleteButton = document.getElementById('deleteButton');
    const deleteForm = document.getElementById('deleteForm');

    console.log('Delete button found:', deleteButton);
    console.log('Delete form found:', deleteForm);

    if (deleteButton) {
      deleteButton.addEventListener('click', function() {
        console.log('Delete button clicked');

        if (confirm('⚠️ Apakah Anda yakin ingin menghapus motor ini?\n\nData motor, riwayat penyewaan, dan semua informasi terkait akan dihapus secara permanen dan tidak dapat dikembalikan.')) {
          console.log('User confirmed deletion');

          if (deleteForm) {
            console.log('Submitting delete form');
            deleteForm.submit();
          } else {
            console.error('Delete form not found');
            alert('Error: Form tidak ditemukan');
          }
        } else {
          console.log('User cancelled deletion');
        }
      });
    } else {
      console.error('Delete button not found');
    }
  });
</script>
@endpush
@endsection