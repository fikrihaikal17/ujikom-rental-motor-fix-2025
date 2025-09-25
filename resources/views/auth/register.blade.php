@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')

<div class="mb-4 text-center">
  <h2 class="text-2xl font-bold text-gray-900 mb-1">
    Register
  </h2>
</div>

<!-- Error Messages -->
@if ($errors->any())
<div class="rounded-lg border p-3 bg-red-50 border-red-200 text-red-800 mb-4">
  <ul class="list-disc list-inside space-y-1">
    @foreach ($errors->all() as $error)
    <li class="text-xs">{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- Register Form -->
<form action="{{ route('register') }}" method="POST" class="space-y-3">
  @csrf
  <div class="space-y-3">
    <!-- Nama -->
    <div>
      <label for="nama" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
        Nama Lengkap
      </label>
      <input type="text" name="nama" id="nama"
        placeholder="Masukkan nama lengkap"
        value="{{ old('nama') }}"
        required
        class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
      @error('nama')
      <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Email & No Telepon (2 kolom) -->
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label for="email" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
          Email
        </label>
        <input type="email" name="email" id="email"
          placeholder="nama@email.com"
          value="{{ old('email') }}"
          required
          class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
        @error('email')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="no_tlpn" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
          No. HP
        </label>
        <input type="tel" name="no_tlpn" id="no_tlpn"
          placeholder="08xxxxxxxxxx"
          value="{{ old('no_tlpn') }}"
          required
          class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
        @error('no_tlpn')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <!-- Role Selection -->
    <div>
      <label for="role" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
        Daftar sebagai
      </label>
      <select name="role" id="role" required
        class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
        <option value="">Pilih jenis akun</option>
        <option value="penyewa" {{ old('role') == 'penyewa' ? 'selected' : '' }}>Penyewa - Saya ingin menyewa motor</option>
        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Motor - Saya ingin menyewakan motor</option>
      </select>
      @error('role')
      <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Password & Konfirmasi Password (2 kolom) -->
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label for="password" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
          Password
        </label>
        <input type="password" name="password" id="password"
          placeholder="Min. 8 karakter"
          required
          class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
        @error('password')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
          Konfirmasi
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"
          placeholder="Ulangi password"
          required
          class="block w-full px-3 py-2 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
      </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="flex items-start text-xs">
      <div class="flex items-center h-4">
        <input id="terms" name="terms" type="checkbox" required
          class="h-3 w-3 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
      </div>
      <div class="ml-2">
        <label for="terms" class="text-gray-700">
          Saya menyetujui
          <a href="{{ route('terms') }}" class="font-medium text-primary-600 hover:text-primary-500">Syarat & Ketentuan</a>
          dan
          <a href="{{ route('privacy') }}" class="font-medium text-primary-600 hover:text-primary-500">Kebijakan Privasi</a>
        </label>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-1">
      <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-100 transition-all duration-200">
        Buat Akun
      </button>
    </div>
  </div>
</form>
@endsection