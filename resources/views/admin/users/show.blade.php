@extends('layouts.sidebar')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="space-y-1">
  <!-- Dashboard -->
  <a href="{{ r@if($user->role->value === 'owner' || $user->role->value === 'renter')
<div class="mt-8">
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aktivitas</h3>
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @if($user->role->value === 'owner')'admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v8l4-4 4 4V5"></path>
    </svg>
    Dashboard
  </a>

  <!-- Users Management -->
  <a href="{{ route('admin.users.index') }}" class="bg-primary-100 text-primary-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-primary-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
    </svg>
    Kelola Pengguna
  </a>

  <!-- Motor Verification -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Verifikasi Motor
  </a>

  <!-- Tarif Management -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
    </svg>
    Kelola Tarif
  </a>

  <!-- Transactions -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    Transaksi
  </a>

  <!-- Reports -->
  <div x-data="{ open: false }" class="space-y-1">
    <button @click="open = !open" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group w-full flex items-center pl-2 pr-1 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
      <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
      </svg>
      <span class="flex-1">Laporan</span>
      <svg :class="{'text-gray-400 rotate-90': open, 'text-gray-300': !open}" class="ml-3 flex-shrink-0 h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
      </svg>
    </button>
    <div x-show="open" class="space-y-1">
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Pendapatan
      </a>
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Analitik
      </a>
      <a href="#" class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        Export Data
      </a>
    </div>
  </div>

  <!-- Settings -->
  <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
    Pengaturan
  </a>
</div>
@endsection

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Detail Pengguna</h1>
        <p class="mt-2 text-sm text-gray-700">Informasi lengkap pengguna {{ $user->nama }}.</p>
      </div>
    </div>
    <div class="flex space-x-3">
      <a href="{{ route('admin.users.edit', $user) }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        Edit
      </a>
      @if($user->id !== auth()->id())
      <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
        @csrf
        @method('DELETE')
        <button type="submit"
          class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
          Hapus
        </button>
      </form>
      @endif
    </div>
  </div>
</div>

<!-- User Details -->
<div class="bg-white shadow rounded-lg overflow-hidden">
  <div class="px-4 py-5 sm:p-0">
    <dl class="sm:divide-y sm:divide-gray-200">
      <!-- Profile Header -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Profil</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-16 w-16">
              <div class="h-16 w-16 rounded-full bg-primary-500 flex items-center justify-center">
                <span class="text-xl font-medium text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
              </div>
            </div>
            <div class="ml-4">
              <div class="text-lg font-medium text-gray-900">{{ $user->nama }}</div>
              <div class="text-sm text-gray-500">{{ $user->email }}</div>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1
                                {{ $user->role->value === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role->value === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                {{ ucfirst($user->role->value) }}
              </span>
            </div>
          </div>
        </dd>
      </div>

      <!-- Email -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Email</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
      </div>

      <!-- No Telepon -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->no_telp }}</dd>
      </div>

      <!-- Alamat -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->alamat }}</dd>
      </div>

      <!-- Role -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Role</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->role->value === 'admin' ? 'bg-purple-100 text-purple-800' : 
                           ($user->role->value === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
            {{ ucfirst($user->role->value) }}
          </span>
        </dd>
      </div>

      <!-- Bergabung -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Bergabung</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{ $user->created_at->format('d M Y H:i') }}
          <span class="text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
        </dd>
      </div>

      <!-- Terakhir Update -->
      <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Terakhir Update</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{ $user->updated_at->format('d M Y H:i') }}
          <span class="text-gray-500">({{ $user->updated_at->diffForHumans() }})</span>
        </dd>
      </div>
    </dl>
  </div>
</div>

<!-- Activity Stats (if applicable) -->
@if($user->role === 'owner' || $user->role === 'renter')
<div class="mt-8">
  <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aktivitas</h3>
  <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @if($user->role === 'owner')
    <!-- Motor yang Dimiliki -->
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
              <dt class="text-sm font-medium text-gray-500 truncate">Motor yang Dimiliki</dt>
              <dd class="text-lg font-medium text-gray-900">{{ $user->motors()->count() }}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>

    <!-- Transaksi Rental -->
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
              <dt class="text-sm font-medium text-gray-500 truncate">Total Rental</dt>
              <dd class="text-lg font-medium text-gray-900">
                {{ \App\Models\Penyewaan::whereHas('motor', function($q) use ($user) {
                                    $q->where('owner_id', $user->id);
                                })->count() }}
              </dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    @endif

    @if($user->role->value === 'renter')
    <!-- Rental yang Dilakukan -->
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
              <dt class="text-sm font-medium text-gray-500 truncate">Total Rental</dt>
              <dd class="text-lg font-medium text-gray-900">{{ $user->penyewaans()->count() }}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Status Account -->
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
              <dt class="text-sm font-medium text-gray-500 truncate">Status Akun</dt>
              <dd class="text-lg font-medium text-green-600">Aktif</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection