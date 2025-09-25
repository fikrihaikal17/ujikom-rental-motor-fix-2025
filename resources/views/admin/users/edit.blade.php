@extends('layouts.sidebar')

@section('title', 'Edit Pengguna')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-8">
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-semibold leading-6 text-gray-900">Edit Pengguna</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola informasi pengguna <span class="font-medium text-blue-600">{{ $user->nama }}</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile Form -->
  <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Form Header -->
      <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="flex items-center space-x-3">
          <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg shadow-sm">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Informasi Pengguna</h3>
            <p class="text-sm text-gray-600">Update data pengguna sesuai kebutuhan</p>
          </div>
        </div>
      </div>

      <div class="px-6 py-6">
        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
          <!-- Nama -->
          <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              Nama Lengkap
            </label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('nama') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('nama')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
              </svg>
              Email
            </label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('email')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>

          <!-- No Telepon -->
          <div>
            <label for="no_tlpn" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              No. Telepon
            </label>
            <input type="text" name="no_tlpn" id="no_tlpn" value="{{ old('no_tlpn', $user->no_tlpn) }}" required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('no_tlpn') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('no_tlpn')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>

          <!-- Role -->
          <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
              </svg>
              Role
            </label>
            <select name="role" id="role" required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('role') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
              <option value="">Pilih Role</option>
              <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>🛡️ Administrator</option>
              <option value="pemilik" {{ old('role', $user->role) === 'pemilik' ? 'selected' : '' }}>🏍️ Pemilik Kendaraan</option>
              <option value="penyewa" {{ old('role', $user->role) === 'penyewa' ? 'selected' : '' }}>👤 Penyewa</option>
            </select>
            @error('role')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
              Password Baru
              <span class="text-gray-500 font-normal">(kosongkan jika tidak ingin mengubah)</span>
            </label>
            <input type="password" name="password" id="password"
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('password')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Konfirmasi Password Baru
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation"
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
          </div>

          <!-- Alamat -->
          <div class="sm:col-span-2">
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
              <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Alamat
            </label>
            <textarea name="alamat" id="alamat" rows="4" required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('alamat') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
              placeholder="Masukkan alamat lengkap pengguna...">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Account Information Section -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center space-x-3 mb-4">
          <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h4 class="text-lg font-semibold text-gray-900">Informasi Akun</h4>
        </div>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <label class="text-sm font-medium text-gray-700">Bergabung</label>
            </div>
            <p class="text-sm text-gray-900 font-medium">{{ $user->created_at->format('d M Y H:i') }} WIB</p>
            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
          </div>
          
          <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <label class="text-sm font-medium text-gray-700">Terakhir Update</label>
            </div>
            <p class="text-sm text-gray-900 font-medium">{{ $user->updated_at->format('d M Y H:i') }} WIB</p>
            <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="px-6 py-4 bg-white border-t border-gray-200 flex justify-end space-x-3">
        <a href="{{ route('admin.users.show', $user) }}"
          class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Batal
        </a>
        <button type="submit"
          class="inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

@push('styles')
<style>
  /* Custom focus styles for better user experience */
  .form-input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
  }
  
  /* Smooth transitions */
  input, select, textarea {
    transition: all 0.2s ease-in-out;
  }
  
  /* Enhanced button hover effects */
  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
  }
  
  /* Card hover effects */
  .info-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
  }
</style>
@endpush
@endsection