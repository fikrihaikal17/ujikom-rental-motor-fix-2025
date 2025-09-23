@extends('layouts.sidebar')

@section('title', 'Verifikasi Motor')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Verifikasi Motor</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola dan verifikasi motor yang didaftarkan oleh para owner.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:flex sm:space-x-3">
      <!-- Filter Form -->
      <form method="GET" action="{{ route('admin.motors.index') }}" class="flex items-center space-x-3">
        <div class="relative">
          <select name="status" class="block w-40 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
            <option value="">Semua Status</option>
            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>
        <div class="relative">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari motor, owner..."
            class="block w-64 pl-3 pr-10 py-2 border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Filter
        </button>
        @if(request('status') || request('search'))
        <a href="{{ route('admin.motors.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Reset
        </a>
        @endif
      </form>
      <!-- Export Button -->
      <a href="{{ route('admin.motors.export', request()->query()) }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Motor</dt>
            <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
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
            <dd class="text-lg font-medium text-yellow-600">{{ $stats['pending'] }}</dd>
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
            <dt class="text-sm font-medium text-gray-500 truncate">Terverifikasi</dt>
            <dd class="text-lg font-medium text-green-600">{{ $stats['verified'] }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
            <dd class="text-lg font-medium text-red-600">{{ $stats['rejected'] }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filtered Results Section -->
@if(request('status') || request('search'))
<div class="mb-8">
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Hasil Filter
        @if(request('status'))
        - {{ ucfirst(request('status') === 'verified' ? 'Terverifikasi' : (request('status') === 'pending' ? 'Pending' : 'Ditolak')) }}
        @endif
        @if(request('search'))
        - "{{ request('search') }}"
        @endif
      </h3>
      <p class="mt-1 text-sm text-gray-500">Menampilkan {{ $motors->total() }} dari {{ $stats['total'] }} total motor</p>
    </div>

    @if($motors->count() > 0)
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
          <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($motors as $motor)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex-shrink-0 h-10 w-10">
                @if($motor->status?->value === 'verified')
                <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                  <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                @elseif($motor->status?->value === 'pending' && !$motor->admin_notes)
                <div class="h-10 w-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                  <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                @elseif($motor->status?->value === 'pending' && $motor->admin_notes)
                <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                  <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                @else
                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
                @endif
              </div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $motor->nama_motor ?? $motor->merk . ' ' . $motor->model }}</div>
                <div class="text-sm text-gray-500">{{ $motor->tahun }} • {{ $motor->plat_nomor ?? $motor->no_plat }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <div>{{ $motor->owner->nama ?? $motor->owner->name }}</div>
            <div class="text-gray-500">{{ $motor->owner->email }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            @if($motor->status?->value === 'verified')
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
              Terverifikasi
            </span>
            @elseif($motor->status?->value === 'pending' && !$motor->admin_notes)
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
              Pending
            </span>
            @elseif($motor->status?->value === 'pending' && $motor->admin_notes)
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
              Ditolak
            </span>
            @else
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
              {{ $motor->status?->getDisplayName() ?? $motor->status ?? '-' }}
            </span>
            @endif
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @if($motor->tarifRental)
            Rp {{ number_format($motor->tarifRental->tarif_per_hari ?? 0, 0, ',', '.') }}/hari
            @else
            <span class="text-gray-400">Belum diset</span>
            @endif
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $motor->created_at->format('d M Y') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex items-center justify-end space-x-2">
              <a href="{{ route('admin.motors.show', $motor) }}" class="text-primary-600 hover:text-primary-900">
                Detail
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="px-6 py-3 border-t border-gray-200">
      {{ $motors->appends(request()->query())->links() }}
    </div>
    @else
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor ditemukan</h3>
      <p class="mt-1 text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian.</p>
    </div>
    @endif
  </div>
</div>
@endif

<!-- Tabs -->
<div x-data="{ activeTab: 'pending' }" class="mb-6">
  <div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-8">
      <button @click="activeTab = 'pending'"
        :class="{'border-primary-500 text-primary-600': activeTab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'pending'}"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
        Menunggu Verifikasi
        @if($stats['pending'] > 0)
        <span class="ml-2 bg-primary-100 text-primary-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['pending'] }}</span>
        @endif
      </button>
      <button @click="activeTab = 'verified'"
        :class="{'border-primary-500 text-primary-600': activeTab === 'verified', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'verified'}"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
        Terverifikasi
      </button>
      <button @click="activeTab = 'rejected'"
        :class="{'border-primary-500 text-primary-600': activeTab === 'rejected', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'rejected'}"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
        Ditolak
      </button>
    </nav>
  </div>

  <!-- Pending Motors Tab -->
  <div x-show="activeTab === 'pending'" class="mt-6">
    @if($pendingMotors->count() > 0)
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Bagi Hasil</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($pendingMotors as $motor)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $motor->merk }} {{ $motor->model }}</div>
                  <div class="text-sm text-gray-500">{{ $motor->tahun }} • {{ $motor->no_plat }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <div>{{ $motor->owner->nama }}</div>
              <div class="text-gray-500">{{ $motor->owner->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @if($motor->requested_owner_percentage)
              <div class="text-sm">
                <span class="font-medium text-blue-600">{{ $motor->requested_owner_percentage }}%</span>
                <span class="text-gray-500">pemilik</span>
              </div>
              @if($motor->revenue_sharing_notes)
              <div class="text-xs text-gray-400 truncate max-w-24" title="{{ $motor->revenue_sharing_notes }}">
                {{ Str::limit($motor->revenue_sharing_notes, 30) }}
              </div>
              @endif
              @else
              <span class="text-gray-400 text-sm">Default (70%)</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @if($motor->tarifRental)
              Rp {{ number_format($motor->tarifRental->harga_per_hari, 0, ',', '.') }}/hari
              @else
              <span class="text-gray-400">Belum diset</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $motor->created_at->format('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-2">
                <a href="{{ route('admin.motors.show', $motor) }}" class="text-primary-600 hover:text-primary-900">
                  Detail
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="px-6 py-3 border-t border-gray-200">
        {{ $pendingMotors->appends(['verified' => request('verified'), 'rejected' => request('rejected')])->links() }}
      </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-lg shadow">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor menunggu verifikasi</h3>
      <p class="mt-1 text-sm text-gray-500">Semua motor telah diverifikasi.</p>
    </div>
    @endif
  </div>

  <!-- Verified Motors Tab -->
  <div x-show="activeTab === 'verified'" class="mt-6">
    @if($verifiedMotors->count() > 0)
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diverifikasi</th>
            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($verifiedMotors as $motor)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $motor->merk }} {{ $motor->model }}</div>
                  <div class="text-sm text-gray-500">{{ $motor->tahun }} • {{ $motor->no_plat }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <div>{{ $motor->owner->nama }}</div>
              <div class="text-gray-500">{{ $motor->owner->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $motor->ketersediaan === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($motor->ketersediaan) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $motor->verified_at ? $motor->verified_at->format('d M Y') : '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{ route('admin.motors.show', $motor) }}" class="text-primary-600 hover:text-primary-900">
                Detail
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="px-6 py-3 border-t border-gray-200">
        {{ $verifiedMotors->appends(['pending' => request('pending'), 'rejected' => request('rejected')])->links() }}
      </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-lg shadow">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada motor terverifikasi</h3>
      <p class="mt-1 text-sm text-gray-500">Motor yang telah diverifikasi akan muncul di sini.</p>
    </div>
    @endif
  </div>

  <!-- Rejected Motors Tab -->
  <div x-show="activeTab === 'rejected'" class="mt-6">
    @if($rejectedMotors->count() > 0)
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Ditolak</th>
            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($rejectedMotors as $motor)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $motor->merk }} {{ $motor->model }}</div>
                  <div class="text-sm text-gray-500">{{ $motor->tahun }} • {{ $motor->no_plat }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <div>{{ $motor->owner->nama }}</div>
              <div class="text-gray-500">{{ $motor->owner->email }}</div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">
              <div class="max-w-xs">
                {{ Str::limit($motor->admin_notes, 50) }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $motor->updated_at->format('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{ route('admin.motors.show', $motor) }}" class="text-primary-600 hover:text-primary-900">
                Detail
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="px-6 py-3 border-t border-gray-200">
        {{ $rejectedMotors->appends(['pending' => request('pending'), 'verified' => request('verified')])->links() }}
      </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-lg shadow">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor ditolak</h3>
      <p class="mt-1 text-sm text-gray-500">Motor yang ditolak verifikasinya akan muncul di sini.</p>
    </div>
    @endif
  </div>
</div>
@endsection