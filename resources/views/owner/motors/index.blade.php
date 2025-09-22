@extends('layouts.app')

@section('title', 'Kelola Motor - RideNow')

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
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Motor</h1>
            <p class="text-gray-600 mt-2">Daftar motor yang telah Anda daftarkan</p>
          </div>
          <a href="{{ route('owner.motors.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Motor Baru
          </a>
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
              <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
              <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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

      <!-- Motors Grid -->
      @if($motors->count() > 0)
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($motors as $motor)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
          <!-- Motor Image -->
          <div class="h-48 bg-gray-200 relative">
            @if($motor->foto_motor)
            <img src="{{ asset('storage/' . $motor->foto_motor) }}"
              alt="{{ $motor->nama_motor }}"
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
              @php
              $statusColors = [
              'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
              'verified' => 'bg-green-100 text-green-800 border-green-200',
              'rejected' => 'bg-red-100 text-red-800 border-red-200',
              'maintenance' => 'bg-gray-100 text-gray-800 border-gray-200'
              ];
              $statusLabels = [
              'pending' => 'Pending',
              'verified' => 'Verified',
              'rejected' => 'Rejected',
              'maintenance' => 'Maintenance'
              ];
              @endphp
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                {{ $statusLabels[$motor->status] ?? ucfirst($motor->status) }}
              </span>
            </div>
          </div>

          <!-- Motor Info -->
          <div class="p-6">
            <div class="mb-4">
              <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $motor->nama_motor }}</h3>
              <p class="text-sm text-gray-600">{{ $motor->merk }} {{ $motor->model }} ({{ $motor->tahun }})</p>
            </div>

            <div class="space-y-2 mb-4">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Plat Nomor:</span>
                <span class="font-medium text-gray-900">{{ $motor->plat_nomor }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Harga/Hari:</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Terdaftar:</span>
                <span class="font-medium text-gray-900">{{ $motor->created_at->format('d M Y') }}</span>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
              <a href="{{ route('owner.motors.show', $motor) }}"
                class="flex-1 bg-blue-50 text-blue-700 hover:bg-blue-100 font-medium py-2 px-3 rounded-md text-sm text-center transition-colors duration-200">
                Detail
              </a>
              <a href="{{ route('owner.motors.edit', $motor) }}"
                class="flex-1 bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium py-2 px-3 rounded-md text-sm text-center transition-colors duration-200">
                Edit
              </a>
            </div>

            @if($motor->status === 'rejected' && $motor->admin_notes)
            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
              <p class="text-sm text-red-700">
                <strong>Catatan Admin:</strong> {{ $motor->admin_notes }}
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
        {{ $motors->links() }}
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
    </div>
  </div>
</div>
@endsection