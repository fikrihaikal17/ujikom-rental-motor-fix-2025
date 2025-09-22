@extends('layouts.sidebar')

@section('title', 'Tambah Pengguna')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex items-center">
    <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Tambah Pengguna Baru</h1>
      <p class="mt-2 text-sm text-gray-700">Buat akun pengguna baru untuk sistem RideNow.</p>
    </div>
  </div>
</div>

<!-- Form -->
<div class="bg-white shadow rounded-lg overflow-hidden">
  <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="px-4 py-5 sm:p-6">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Nama -->
        <div>
          <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('nama') border-red-300 @enderror">
          @error('nama')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('email') border-red-300 @enderror">
          @error('email')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- No Telepon -->
        <div>
          <label for="no_tlpn" class="block text-sm font-medium text-gray-700">No. Telepon</label>
          <input type="text" name="no_tlpn" id="no_tlpn" value="{{ old('no_tlpn') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('no_tlpn') border-red-300 @enderror">
          @error('no_tlpn')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Role -->
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
          <select name="role" id="role"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('role') border-red-300 @enderror">
            <option value="">Pilih Role</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="pemilik" {{ old('role') === 'pemilik' ? 'selected' : '' }}>Pemilik Kendaraan</option>
            <option value="penyewa" {{ old('role') === 'penyewa' ? 'selected' : '' }}>Penyewa</option>
          </select>
          @error('role')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" id="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('password') border-red-300 @enderror">
          @error('password')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>

        <!-- Alamat -->
        <div class="sm:col-span-2">
          <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
          <textarea name="alamat" id="alamat" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('alamat') border-red-300 @enderror">{{ old('alamat') }}</textarea>
          @error('alamat')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
      <div class="flex justify-end space-x-3">
        <a href="{{ route('admin.users.index') }}"
          class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Batal
        </a>
        <button type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Simpan Pengguna
        </button>
      </div>
    </div>
  </form>
</div>
@endsection