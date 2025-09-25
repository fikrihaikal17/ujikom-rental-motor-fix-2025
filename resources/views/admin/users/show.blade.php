@extends('layouts.sidebar')

@section('title', 'Detail Pengguna')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="mr-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </a>
        <div class="flex-1">
          <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-sm">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-semibold leading-6 text-gray-900">Detail Pengguna</h1>
              <p class="mt-1 text-sm text-gray-600">Kelola informasi lengkap pengguna <span class="font-medium text-blue-600">{{ $user->nama }}</span></p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Action Buttons -->
      <div class="flex items-center space-x-4">
        <a href="{{ route('admin.users.edit', $user) }}"
          class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm"
          style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
          Edit Pengguna
        </a>
        @if($user->id !== auth()->id())
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm"
            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>

  <!-- User Profile Card -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden mb-8 card-shadow hover-scale">
    <!-- Profile Header -->
    <div class="px-6 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 gradient-animate">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-lg avatar-container">
            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <h2 class="text-2xl font-bold text-gray-900">{{ $user->nama }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
          <div class="mt-3">
            <span class="role-badge">
              @if($user->role->value === 'admin')
                🛡️ {{ $user->role->getDisplayName() }}
              @elseif($user->role->value === 'pemilik')
                🏍️ {{ $user->role->getDisplayName() }}
              @else
                👤 {{ $user->role->getDisplayName() }}
              @endif
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Details -->
    <div class="px-6 py-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 info-grid">
        <!-- Personal Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Personal
          </h3>
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Email</p>
                <p class="text-gray-900">{{ $user->email }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">No. Telepon</p>
                <p class="text-gray-900">{{ $user->no_tlpn }}</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-lg">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Alamat</p>
                <p class="text-gray-900">{{ $user->alamat ?: 'Belum diisi' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Account Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Informasi Akun
          </h3>
          <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="flex items-center space-x-2 mb-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm font-medium text-gray-700">Bergabung</p>
              </div>
              <p class="text-gray-900 font-medium">{{ $user->created_at->format('d M Y H:i') }} WIB</p>
              <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="flex items-center space-x-2 mb-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-gray-700">Terakhir Update</p>
              </div>
              <p class="text-gray-900 font-medium">{{ $user->updated_at->format('d M Y H:i') }} WIB</p>
              <p class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Activity Stats -->
  @if($user->role->value === 'admin')
  <!-- Admin Activity Section -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden card-shadow hover-scale">
    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
      <div class="flex items-center space-x-3">
        <div class="flex items-center justify-center w-10 h-10 bg-purple-600 rounded-lg shadow-sm">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Aktivitas Administrator</h3>
          <p class="text-sm text-gray-600">Status dan informasi admin system</p>
        </div>
      </div>
    </div>
    
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Admin -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-green-800">Status Admin</p>
              <p class="text-lg font-bold text-green-900">Aktif</p>
            </div>
          </div>
        </div>

        <!-- Hak Akses -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-purple-800">Hak Akses</p>
              <p class="text-lg font-bold text-purple-900">Full Access</p>
            </div>
          </div>
        </div>

        <!-- Terakhir Login -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586l4.293-4.293A6 6 0 0115 7z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-blue-800">Terakhir Login</p>
              <p class="text-sm font-bold text-blue-900">{{ $user->updated_at->diffForHumans() }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @elseif($user->role->value === 'pemilik')
  <!-- Pemilik Activity Section -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden card-shadow hover-scale">
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
      <div class="flex items-center space-x-3">
        <div class="flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg shadow-sm">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Aktivitas Pemilik Motor</h3>
          <p class="text-sm text-gray-600">Informasi rental dan motor yang dimiliki</p>
        </div>
      </div>
    </div>
    
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Motor yang Dimiliki -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-blue-800">Motor yang Dimiliki</p>
              <p class="text-2xl font-bold text-blue-900">{{ $user->motors()->count() }}</p>
            </div>
          </div>
        </div>

        <!-- Total Rental -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-green-800">Total Rental</p>
              <p class="text-2xl font-bold text-green-900">
                {{ \App\Models\Penyewaan::whereHas('motor', function($q) use ($user) {
                    $q->where('owner_id', $user->id);
                })->count() }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @elseif($user->role->value === 'penyewa')
  <!-- Penyewa Activity Section -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden card-shadow hover-scale">
    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b border-gray-200">
      <div class="flex items-center space-x-3">
        <div class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-lg shadow-sm">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Aktivitas Penyewa</h3>
          <p class="text-sm text-gray-600">Riwayat rental dan status akun</p>
        </div>
      </div>
    </div>
    
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Rental -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-green-800">Total Rental</p>
              <p class="text-2xl font-bold text-green-900">{{ $user->penyewaans()->count() }}</p>
            </div>
          </div>
        </div>

        <!-- Status Akun -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-blue-800">Status Akun</p>
              <p class="text-lg font-bold text-blue-900">Aktif</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom hover effects and animations */
    .hover-scale {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .hover-scale:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Gradient animation */
    .gradient-animate {
        background-size: 200% 200%;
        animation: gradientAnimation 3s ease infinite;
    }
    
    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Enhanced card shadows */
    .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .card-shadow:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Custom badge styling */
    .role-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Avatar enhancement */
    .avatar-container {
        position: relative;
        overflow: hidden;
    }
    
    .avatar-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border-radius: 50%;
        z-index: 1;
    }
    
    /* Smooth transitions for all interactive elements */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Enhanced button styling */
    .btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    /* Modern action buttons with enhanced styling */
    .bg-gradient-to-r.from-blue-600.to-blue-700 {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        position: relative;
        overflow: hidden;
    }
    
    .bg-gradient-to-r.from-blue-600.to-blue-700::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s ease;
        z-index: 1;
    }
    
    .bg-gradient-to-r.from-blue-600.to-blue-700:hover::before {
        left: 100%;
    }
    
    .bg-gradient-to-r.from-blue-600.to-blue-700:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4) !important;
    }
    
    .bg-gradient-to-r.from-red-500.to-red-600 {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        position: relative;
        overflow: hidden;
    }
    
    .bg-gradient-to-r.from-red-500.to-red-600::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s ease;
        z-index: 1;
    }
    
    .bg-gradient-to-r.from-red-500.to-red-600:hover::before {
        left: 100%;
    }
    
    .bg-gradient-to-r.from-red-500.to-red-600:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4) !important;
    }
    
    /* Button text should be above the shine effect */
    .bg-gradient-to-r svg,
    .bg-gradient-to-r span {
        position: relative;
        z-index: 2;
    }
    
    /* Information grid styling */
    .info-grid dt {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .info-grid dd {
        color: #1f2937;
        font-weight: 600;
        margin-top: 2px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .card-shadow {
            margin: 0 -1rem;
            border-radius: 0;
        }
        
        .hover-scale:hover {
            transform: none;
        }
    }
</style>
@endpush