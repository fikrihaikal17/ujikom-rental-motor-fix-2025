@extends('layouts.owner')

@section('title', 'Kelola Motor - RideNow')

@push('styles')
<style>
.btn-loading {
  pointer-events: none;
  opacity: 0.7;
}
</style>
@endpush

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Kelola Motor</h1>
      <p class="text-gray-600 mt-2">Daftar motor yang telah Anda daftarkan</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('owner.motors.print-pdf') }}"
        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 flex items-center shadow-sm hover:shadow-md hover:scale-105"
        title="Download daftar motor dalam format PDF"
        onclick="this.innerHTML='<svg class=\'w-5 h-5 mr-2 animate-spin\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><circle cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\' class=\'opacity-25\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg>Generating PDF...'; setTimeout(() => this.innerHTML='<svg class=\'w-5 h-5 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'></path></svg>Cetak PDF', 3000);">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Cetak PDF
      </a>
      <a href="{{ route('owner.motors.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Motor Baru
      </a>
    </div>
  </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
  <form method="GET" action="{{ route('owner.motors.index') }}" class="flex flex-wrap gap-4">
    <div class="flex-1 min-w-64">
      <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Motor</label>
      <input type="text" name="search" id="search" value="{{ request('search') }}"
        placeholder="Nama motor, merk, model..."
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="min-w-48">
      <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
      <select name="status" id="status"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">Semua Status</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
        <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Disewa</option>
        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
      </select>
    </div>

    <div class="flex items-end">
      <button type="submit"
        class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
        Filter
      </button>
      @if(request()->hasAny(['search', 'status']))
      <a href="{{ route('owner.motors.index') }}"
        class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200">
        Reset
      </a>
      @endif
    </div>
  </form>
</div>

<!-- Results Info -->
@if(request()->hasAny(['search', 'status']))
<div class="mb-4">
  <p class="text-sm text-gray-600">
    Menampilkan {{ $motors->count() }} dari {{ $motors->total() }} motor
    @if(request('search'))
    untuk pencarian "<strong>{{ request('search') }}</strong>"
    @endif
    @if(request('status'))
    dengan status "<strong>{{ ucfirst(str_replace('_', ' ', request('status'))) }}</strong>"
    @endif
  </p>
</div>
@endif

<!-- Quick Actions Info -->
@if($motors->count() > 0)
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
  <div class="flex items-center">
    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-blue-800 text-sm">
      <strong>Tips:</strong> Klik tombol "Cetak PDF" untuk mendownload daftar lengkap motor Anda dalam format PDF. 
      File PDF akan berisi informasi detail semua motor, status, dan pendapatan.
    </p>
  </div>
</div>
@endif

<!-- Motors Grid -->
@if($motors->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
  @foreach($motors as $motor)
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
    <!-- Motor Image -->
    <div class="h-48 bg-gray-200 relative">
      @if($motor->photo)
      <img src="{{ asset('storage/' . $motor->photo) }}"
        alt="{{ $motor->merk }} {{ $motor->model }}"
        class="w-full h-full object-cover">
      @else
      <div class="w-full h-full flex items-center justify-center">
        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
      @endif

      <!-- Status Badge -->
      <div class="absolute top-3 right-3">
        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border
          @if($motor->status === \App\Enums\MotorStatus::AVAILABLE)
            bg-green-100 text-green-800 border-green-200
          @elseif($motor->status === \App\Enums\MotorStatus::RENTED)
            bg-blue-100 text-blue-800 border-blue-200
          @elseif($motor->status === \App\Enums\MotorStatus::MAINTENANCE)
            bg-yellow-100 text-yellow-800 border-yellow-200
          @elseif($motor->status === \App\Enums\MotorStatus::PENDING)
            bg-orange-100 text-orange-800 border-orange-200
          @elseif($motor->status === \App\Enums\MotorStatus::VERIFIED)
            bg-emerald-100 text-emerald-800 border-emerald-200
          @else
            bg-gray-100 text-gray-800 border-gray-200
          @endif">
          @switch($motor->status)
          @case(\App\Enums\MotorStatus::AVAILABLE)
          Tersedia
          @break
          @case(\App\Enums\MotorStatus::RENTED)
          Disewa
          @break
          @case(\App\Enums\MotorStatus::MAINTENANCE)
          Maintenance
          @break
          @case(\App\Enums\MotorStatus::PENDING)
          Menunggu Verifikasi
          @break
          @case(\App\Enums\MotorStatus::VERIFIED)
          Terverifikasi
          @break
          @default
          {{ $motor->status instanceof \App\Enums\MotorStatus ? $motor->status->getDisplayName() : $motor->status }}
          @endswitch
        </span>
      </div>
    </div>

    <!-- Motor Info -->
    <div class="p-6">
      <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $motor->merk }} {{ $motor->model }}</h3>
        <p class="text-sm text-gray-600">{{ $motor->merk }} {{ $motor->model }} ({{ $motor->tahun }})</p>
      </div>

      <div class="space-y-2 mb-4">
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Plat Nomor:</span>
          <span class="font-medium text-gray-900">{{ $motor->no_plat }}</span>
        </div>
        @if($motor->warna)
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Warna:</span>
          <span class="font-medium text-gray-900">{{ $motor->warna }}</span>
        </div>
        @endif
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Harga/Hari:</span>
          <span class="font-medium text-gray-900">
            @if($motor->tarifRental)
            Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}
            @else
            <span class="text-yellow-600">Belum ditetapkan</span>
            @endif
          </span>
        </div>

        @if($motor->status === \App\Enums\MotorStatus::VERIFIED && $motor->tarifRental)
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Bagi Hasil Anda:</span>
          <span class="font-medium text-emerald-600">
            Rp {{ number_format($motor->tarifRental->tarif_harian * 0.7, 0, ',', '.') }}/hari (70%)
          </span>
        </div>
        @endif

        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Terdaftar:</span>
          <span class="font-medium text-gray-900">{{ $motor->created_at->format('d M Y') }}</span>
        </div>

        @if($motor->verified_at)
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Diverifikasi:</span>
          <span class="font-medium text-green-600">{{ \Carbon\Carbon::parse($motor->verified_at)->format('d M Y') }}</span>
        </div>
        @endif
      </div>

      <!-- Actions -->
      <div class="flex gap-2 mb-3">
        <a href="{{ route('owner.motors.show', $motor) }}"
          class="flex-1 bg-blue-50 text-blue-700 hover:bg-blue-100 font-medium py-2 px-3 rounded-md text-sm text-center transition-colors duration-200">
          Detail
        </a>
        <a href="{{ route('owner.motors.edit', $motor) }}"
          class="flex-1 bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium py-2 px-3 rounded-md text-sm text-center transition-colors duration-200">
          Edit
        </a>
      </div>

      <!-- Document Status -->
      @if($motor->dokumen_kepemilikan)
      <div class="mb-3 p-2 bg-green-50 border border-green-200 rounded-md">
        <div class="flex items-center justify-between">
          <span class="text-sm text-green-700">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Dokumen Lengkap
          </span>
          <a href="{{ asset('storage/' . $motor->dokumen_kepemilikan) }}" target="_blank"
            class="text-green-600 hover:text-green-800 text-xs underline">
            Lihat
          </a>
        </div>
      </div>
      @else
      <div class="mb-3 p-2 bg-yellow-50 border border-yellow-200 rounded-md">
        <span class="text-sm text-yellow-700">
          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          Dokumen Belum Lengkap
        </span>
      </div>
      @endif

      <!-- Status Messages -->
      @if($motor->status === \App\Enums\MotorStatus::PENDING)
      <div class="p-3 bg-orange-50 border border-orange-200 rounded-md">
        <p class="text-sm text-orange-700">
          <strong>⏳ Menunggu Verifikasi</strong><br>
          Motor Anda sedang dalam proses verifikasi oleh admin. Tarif akan ditetapkan setelah verifikasi selesai.
        </p>
      </div>
      @elseif($motor->status === \App\Enums\MotorStatus::VERIFIED && $motor->tarifRental)
      <div class="p-3 bg-green-50 border border-green-200 rounded-md">
        <p class="text-sm text-green-700">
          <strong>✅ Motor Terverifikasi</strong><br>
          Motor siap disewakan dengan sistem bagi hasil 70% untuk Anda, 30% untuk platform.
        </p>
      </div>
      @elseif($motor->admin_notes)
      <div class="p-3 bg-red-50 border border-red-200 rounded-md">
        <p class="text-sm text-red-700">
          <strong>❌ Catatan Admin</strong><br>
          {{ $motor->admin_notes }}
        </p>
      </div>
      @endif
    </div>
  </div>
  @endforeach
</div>

<!-- Pagination -->
@if($motors->hasPages())
<div class="flex justify-center">
  {{ $motors->links('custom.advanced-pagination') }}
</div>
@endif

@else
<!-- Empty State -->
<div class="bg-white rounded-lg shadow-sm p-12 text-center border border-gray-200">
  <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
  </svg>
  <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Motor Terdaftar</h3>
  <p class="text-gray-600 mb-6">
    @if(request()->hasAny(['search', 'status']))
    Tidak ada motor yang sesuai dengan filter yang dipilih.
    @else
    Mulai dengan mendaftarkan motor pertama Anda untuk disewakan.
    @endif
  </p>
  @if(request()->hasAny(['search', 'status']))
  <a href="{{ route('owner.motors.index') }}"
    class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 mr-2">
    Lihat Semua Motor
  </a>
  @endif
  <a href="{{ route('owner.motors.create') }}"
    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
    Daftarkan Motor Pertama
  </a>
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when status filter changes
    const statusSelect = document.getElementById('status');
    const searchInput = document.getElementById('search');
    const form = statusSelect.closest('form');

    statusSelect.addEventListener('change', function() {
      form.submit();
    });

    // Submit form on Enter key in search input
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        form.submit();
      }
    });
  });
</script>
@endsection