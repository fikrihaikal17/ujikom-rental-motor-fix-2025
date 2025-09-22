@extends('layouts.owner')

@section('title', 'Tambah Motor Baru - RideNow')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex items-center space-x-4">
    <a href="{{ route('owner.motors.index') }}"
      class="text-blue-600 hover:text-blue-800 flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Kembali
    </a>
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Tambah Motor Baru</h1>
      <p class="text-gray-600 mt-2">Daftarkan motor Anda untuk disewakan</p>
    </div>
  </div>
</div>

<!-- Form -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
    <h2 class="text-lg font-semibold text-gray-800">Informasi Motor</h2>
    <p class="text-sm text-gray-600 mt-1">Lengkapi data motor Anda dengan detail</p>
  </div>

  <form action="{{ route('owner.motors.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
    @csrf

    <!-- Motor Basic Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Motor Name -->
      <div class="space-y-2">
        <label for="nama_motor" class="block text-sm font-semibold text-gray-700">
          Nama Motor <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input type="text" name="nama_motor" id="nama_motor" value="{{ old('nama_motor') }}" required
            class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_motor') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
            placeholder="Honda Beat Street, Yamaha NMAX, dll">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
        @error('nama_motor')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- Brand -->
      <div class="space-y-2">
        <label for="merk" class="block text-sm font-semibold text-gray-700">
          Merk <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select name="merk" id="merk" required
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none @error('merk') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            <option value="">Pilih Merk</option>
            <option value="Honda" {{ old('merk') === 'Honda' ? 'selected' : '' }}>Honda</option>
            <option value="Yamaha" {{ old('merk') === 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
            <option value="Suzuki" {{ old('merk') === 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
            <option value="Kawasaki" {{ old('merk') === 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
            <option value="TVS" {{ old('merk') === 'TVS' ? 'selected' : '' }}>TVS</option>
            <option value="Benelli" {{ old('merk') === 'Benelli' ? 'selected' : '' }}>Benelli</option>
            <option value="KTM" {{ old('merk') === 'KTM' ? 'selected' : '' }}>KTM</option>
            <option value="Viar" {{ old('merk') === 'Viar' ? 'selected' : '' }}>Viar</option>
            <option value="Lainnya" {{ old('merk') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        @error('merk')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- Model/Type -->
      <div class="space-y-2">
        <label for="model" class="block text-sm font-semibold text-gray-700">
          Tipe Motor <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select name="model" id="model" required
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none @error('model') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            <option value="">Pilih Tipe Motor</option>
            <option value="Matic" {{ old('model') == 'Matic' ? 'selected' : '' }}>Matic</option>
            <option value="Manual" {{ old('model') == 'Manual' ? 'selected' : '' }}>Manual</option>
            <option value="Sport" {{ old('model') == 'Sport' ? 'selected' : '' }}>Sport</option>
            <option value="Moge" {{ old('model') == 'Moge' ? 'selected' : '' }}>Moge</option>
            <option value="Bebek" {{ old('model') == 'Bebek' ? 'selected' : '' }}>Bebek</option>
            <option value="Trail" {{ old('model') == 'Trail' ? 'selected' : '' }}>Trail</option>
            <option value="Cruiser" {{ old('model') == 'Cruiser' ? 'selected' : '' }}>Cruiser</option>
          </select>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        @error('model')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- Year -->
      <div class="space-y-2">
        <label for="tahun" class="block text-sm font-semibold text-gray-700">
          Tahun <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select name="tahun" id="tahun" required
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none @error('tahun') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            <option value="">Pilih Tahun</option>
            @for($year = date('Y'); $year >= 2010; $year--)
            <option value="{{ $year }}" {{ old('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endfor
          </select>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        @error('tahun')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- License Plate -->
      <div class="space-y-2">
        <label for="no_plat" class="block text-sm font-semibold text-gray-700">
          Plat Nomor <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input type="text" name="no_plat" id="no_plat" value="{{ old('no_plat') }}" required
            class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('no_plat') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror uppercase tracking-wider font-mono"
            placeholder="B 1234 XYZ" maxlength="11">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
        </div>
        <p class="text-xs text-gray-500 mt-1">Format: Huruf Angka Huruf (contoh: B 1234 XYZ)</p>
        @error('no_plat')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- Engine Capacity -->
      <div class="space-y-2">
        <label for="tipe_cc" class="block text-sm font-semibold text-gray-700">
          Kapasitas Mesin (CC) <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select name="tipe_cc" id="tipe_cc" required
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none @error('tipe_cc') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            <option value="">Pilih Kapasitas Mesin</option>
            <option value="100" {{ old('tipe_cc') == '100' ? 'selected' : '' }}>100 CC</option>
            <option value="125" {{ old('tipe_cc') == '125' ? 'selected' : '' }}>125 CC</option>
            <option value="150" {{ old('tipe_cc') == '150' ? 'selected' : '' }}>150 CC</option>
          </select>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        @error('tipe_cc')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>

      <!-- Color -->
      <div class="space-y-2">
        <label for="warna" class="block text-sm font-semibold text-gray-700">
          Warna Motor
        </label>
        <div class="relative">
          <input type="text" name="warna" id="warna" value="{{ old('warna') }}"
            class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('warna') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
            placeholder="Merah, Hitam, Putih, dll">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z"></path>
            </svg>
          </div>
        </div>
        @error('warna')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>
    </div>

    <!-- Price Section -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
        Harga Sewa
      </h3>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="harga_per_hari" class="block text-sm font-semibold text-gray-700">
            Harga Sewa per Hari (Rp) <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="text" name="harga_per_hari" id="harga_per_hari" value="{{ old('harga_per_hari') }}" required
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('harga_per_hari') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
              placeholder="75,000">
          </div>
          @error('harga_per_hari')
          <p class="text-sm text-red-500 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $message }}
          </p>
          @enderror
        </div>
        <div class="flex items-center">
          <div class="bg-white p-4 rounded-lg border border-gray-200 w-full">
            <p class="text-sm text-gray-600 mb-1">💡 Info Bagi Hasil</p>
            <p class="text-xs text-gray-500">Harga akan dibagi sesuai kesepakatan bagi hasil dengan platform</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Description Section -->
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
        </svg>
        Deskripsi Motor
      </h3>
      <div class="space-y-2">
        <label for="deskripsi" class="block text-sm font-semibold text-gray-700">
          Deskripsi <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <textarea name="deskripsi" id="deskripsi" rows="4" required
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('deskripsi') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror resize-none"
            placeholder="Deskripsikan kondisi motor, fitur khusus, kelengkapan, dll...">{{ old('deskripsi') }}</textarea>
        </div>
        @error('deskripsi')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
        <p class="text-sm text-gray-500">
          💡 Tip: Semakin detail deskripsi, semakin menarik untuk penyewa!
        </p>
      </div>
    </div>

    <!-- Images Section -->
    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl border border-indigo-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Foto Motor
      </h3>
      <div class="space-y-4">
        <label for="foto_motor" class="block text-sm font-semibold text-gray-700">
          Unggah Foto <span class="text-red-500">*</span>
        </label>
        <div class="relative border-2 border-dashed border-indigo-300 rounded-xl p-8 text-center hover:border-indigo-400 transition-colors duration-200">
          <div class="space-y-4">
            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <label for="foto_motor" class="cursor-pointer">
                <span class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                  </svg>
                  Pilih Foto
                </span>
                <input id="foto_motor" name="foto_motor" type="file" class="sr-only" accept="image/*" required onchange="previewImage(event)">
              </label>
              <p class="mt-2 text-sm text-gray-600">atau drag and drop file ke sini</p>
            </div>
            <div class="text-xs text-gray-500 space-y-1">
              <p>📸 Format: PNG, JPG, JPEG (maksimal 2MB)</p>
              <p>💡 Tip: Gunakan foto yang jelas dan menarik!</p>
            </div>
          </div>
        </div>

        <!-- Image Preview Container -->
        <div id="imagePreview" style="display: none;" class="mt-4">
          <h4 class="text-sm font-semibold text-gray-700 mb-3">Preview Foto:</h4>
          <div class="relative w-full max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <img id="previewImg" src="" alt="Preview" class="w-full h-64 object-cover">
            <button type="button" onclick="clearImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors duration-200 shadow-lg">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2">
              <p class="text-sm text-center" id="imageInfo">Klik tombol X untuk menghapus</p>
            </div>
          </div>
        </div>

        @error('foto_motor')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
      </div>
    </div>

    <!-- Documents Section -->
    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 p-6 rounded-xl border border-orange-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Dokumen Kepemilikan
      </h3>
      <div class="space-y-4">
        <label for="dokumen_kepemilikan" class="block text-sm font-semibold text-gray-700">
          Upload Dokumen STNK/BPKB <span class="text-red-500">*</span>
        </label>
        <div class="relative border-2 border-dashed border-orange-300 rounded-xl p-8 text-center hover:border-orange-400 transition-colors duration-200">
          <div class="space-y-4">
            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div>
              <input type="file" name="dokumen_kepemilikan" id="dokumen_kepemilikan" accept=".pdf,.jpg,.jpeg,.png" required
                class="hidden" onchange="handleDocumentChange(this)">
              <label for="dokumen_kepemilikan" class="cursor-pointer">
                <span class="text-lg font-medium text-gray-900">Upload Dokumen</span>
                <span class="block text-sm text-gray-500 mt-1">atau drag & drop file di sini</span>
              </label>
            </div>
            <p class="text-xs text-gray-500">
              Format yang didukung: PDF, JPG, JPEG, PNG (Max: 5MB)
            </p>
          </div>
        </div>

        <!-- Document Preview -->
        <div id="documentPreview" class="hidden">
          <div class="bg-white border-2 border-orange-200 rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center">
              <svg class="w-8 h-8 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <div>
                <p class="text-sm font-medium text-gray-900" id="documentName">Dokumen dipilih</p>
                <p class="text-xs text-gray-500" id="documentSize"></p>
              </div>
            </div>
            <button type="button" onclick="removeDocument()" class="text-red-500 hover:text-red-700">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>

        @error('dokumen_kepemilikan')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror

        <div class="bg-orange-100 border border-orange-300 rounded-lg p-4">
          <div class="flex">
            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-orange-800">
              <p class="font-medium mb-1">Dokumen yang Diperlukan:</p>
              <ul class="list-disc list-inside space-y-1 text-xs">
                <li>STNK (Surat Tanda Nomor Kendaraan) yang masih berlaku</li>
                <li>BPKB (Buku Pemilik Kendaraan Bermotor)</li>
                <li>Pastikan dokumen terbaca dengan jelas</li>
                <li>Dokumen harus atas nama pendaftar</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
      <a href="{{ route('owner.motors.index') }}"
        class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-8 rounded-lg transition-all duration-200 text-center border border-gray-300">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        Batal
      </a>
      <button type="submit"
        class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Daftarkan Motor
      </button>
    </div>
  </form>
</div>

<!-- Enhanced Information Box -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm">
  <div class="flex">
    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <div class="ml-4 text-sm text-blue-800">
      <h4 class="font-semibold mb-3 text-blue-900">📋 Informasi Penting</h4>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="flex items-start">
          <svg class="w-4 h-4 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Motor akan diverifikasi admin sebelum aktif</span>
        </div>
        <div class="flex items-start">
          <svg class="w-4 h-4 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Pastikan dokumen motor lengkap dan valid</span>
        </div>
        <div class="flex items-start">
          <svg class="w-4 h-4 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Foto motor harus jelas dan menunjukkan kondisi sebenarnya</span>
        </div>
        <div class="flex items-start">
          <svg class="w-4 h-4 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Harga akan dibagi sesuai kesepakatan bagi hasil</span>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOM Content Loaded - Starting Motor Form Enhancement ===');

    // Debug: Check all required elements
    const photoInput = document.getElementById('photo');
    const previewContainer = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const imageInfo = document.getElementById('imageInfo');

    console.log('Photo input element:', photoInput);
    console.log('Preview container element:', previewContainer);
    console.log('Preview image element:', previewImg);
    console.log('Image info element:', imageInfo);

    if (!photoInput) console.error('❌ Photo input not found with ID: photo');
    if (!previewContainer) console.error('❌ Preview container not found with ID: imagePreview');
    if (!previewImg) console.error('❌ Preview image not found with ID: previewImg');
    if (!imageInfo) console.error('❌ Image info not found with ID: imageInfo');
    // Image preview function
    window.previewImage = function(event) {
      console.log('previewImage function called', event);
      const input = event.target;
      const file = input.files[0];
      console.log('File selected:', file);

      if (file) {
        // Validate file size (2MB = 2097152 bytes)
        if (file.size > 2097152) {
          alert('❌ Ukuran file terlalu besar! Maksimal 2MB.');
          input.value = '';
          return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
          alert('❌ Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.');
          input.value = '';
          return;
        }

        console.log('File validation passed, creating FileReader');
        const reader = new FileReader();
        reader.onload = function(e) {
          console.log('FileReader onload triggered');
          const previewContainer = document.getElementById('imagePreview');
          const previewImg = document.getElementById('previewImg');
          const imageInfo = document.getElementById('imageInfo');

          if (previewContainer && previewImg) {
            console.log('Preview elements found:', previewContainer, previewImg);
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';

            // Update image info
            if (imageInfo) {
              const sizeInMB = (file.size / 1024 / 1024).toFixed(2);
              imageInfo.textContent = `${file.name} (${sizeInMB}MB)`;
            }

            console.log('Preview should be visible now');

            // Scroll to preview
            setTimeout(() => {
              previewContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
              });
            }, 100);
          } else {
            console.error('Preview elements not found');
          }
        };

        reader.onerror = function() {
          console.error('Error reading file');
          alert('❌ Error membaca file. Silakan coba lagi.');
        };

        reader.readAsDataURL(file);
      } else {
        console.log('No file selected');
      }
    };

    // Drag and Drop functionality
    const uploadArea = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('foto_motor');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
      uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
      uploadArea.classList.add('border-indigo-500', 'bg-indigo-50');
    }

    function unhighlight(e) {
      uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
      const dt = e.dataTransfer;
      const files = dt.files;

      if (files.length > 0) {
        fileInput.files = files;
        previewImage({
          target: fileInput
        });
      }
    }

    // Clear image function
    window.clearImage = function() {
      console.log('clearImage function called');
      const photoInput = document.getElementById('photo');
      const previewContainer = document.getElementById('imagePreview');
      const previewImg = document.getElementById('previewImg');
      const imageInfo = document.getElementById('imageInfo');

      if (photoInput) {
        photoInput.value = '';
        console.log('Photo input cleared');
      } else {
        console.error('Photo input not found');
      }

      if (previewContainer) {
        previewContainer.style.display = 'none';
        console.log('Preview container hidden');
      } else {
        console.error('Preview container not found');
      }

      if (previewImg) {
        previewImg.src = '';
        console.log('Preview image src cleared');
      } else {
        console.error('Preview image not found');
      }

      if (imageInfo) {
        imageInfo.textContent = '';
        console.log('Image info cleared');
      }

      console.log('Image cleared successfully');
    };

    // Format price input with thousand separators
    const hargaInput = document.getElementById('harga_per_hari');
    hargaInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/[^\d]/g, '');
      if (value) {
        // Format with dots as thousand separators (Indonesian format)
        e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }
    });

    // Auto format license plate with spaces and validation
    const platNomorInput = document.getElementById('no_plat');
    platNomorInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();

      // Format: Letter(s) + Space + Numbers + Space + Letters
      let formatted = '';

      if (value.length > 0) {
        // First part: 1-2 letters
        let firstPart = value.substring(0, Math.min(value.length, 2));
        if (!/^[A-Z]+$/.test(firstPart) && value.length <= 2) {
          // Only allow letters for first part
          firstPart = firstPart.replace(/[^A-Z]/g, '');
        }
        formatted += firstPart;

        if (value.length > 2) {
          formatted += ' ';

          // Second part: up to 4 numbers
          let secondPart = value.substring(2, Math.min(value.length, 6));
          secondPart = secondPart.replace(/[^0-9]/g, '');
          formatted += secondPart;

          if (value.length > 6) {
            formatted += ' ';

            // Third part: 1-3 letters
            let thirdPart = value.substring(6, Math.min(value.length, 9));
            thirdPart = thirdPart.replace(/[^A-Z]/g, '');
            formatted += thirdPart;
          }
        }
      }

      e.target.value = formatted;

      // Validate format
      const pattern = /^[A-Z]{1,2} \d{1,4} [A-Z]{1,3}$/;
      const isValid = pattern.test(formatted) || formatted.length < 4;

      if (!isValid && formatted.length >= 4) {
        e.target.style.borderColor = '#ef4444';
      } else {
        e.target.style.borderColor = '';
      }
    });

    // Enhanced form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
      const requiredFields = [{
          id: 'nama_motor',
          name: 'Nama Motor'
        },
        {
          id: 'merk',
          name: 'Merk'
        },
        {
          id: 'model',
          name: 'Model'
        },
        {
          id: 'tahun',
          name: 'Tahun'
        },
        {
          id: 'no_plat',
          name: 'Plat Nomor'
        },
        {
          id: 'tipe_cc',
          name: 'Kapasitas Mesin'
        },
        {
          id: 'harga_per_hari',
          name: 'Harga per Hari'
        },
        {
          id: 'deskripsi',
          name: 'Deskripsi'
        },
        {
          id: 'foto_motor',
          name: 'Foto Motor'
        },
        {
          id: 'dokumen_kepemilikan',
          name: 'Dokumen Kepemilikan'
        }
      ];

      let isValid = true;
      let firstErrorField = null;
      let errorMessages = [];

      requiredFields.forEach(function(field) {
        const input = document.getElementById(field.id);
        const value = field.id === 'foto_motor' ? input.files.length : input.value.trim();

        console.log(`Validating field: ${field.id}, value: ${value}`);

        if (!value) {
          isValid = false;
          if (!firstErrorField) firstErrorField = input;
          errorMessages.push(field.name);

          // Add error styling
          input.classList.add('border-red-400', 'focus:border-red-500', 'focus:ring-red-500');
          input.classList.remove('border-gray-200', 'focus:border-blue-500', 'focus:ring-blue-500', 'focus:border-green-500', 'focus:ring-green-500', 'focus:border-purple-500', 'focus:ring-purple-500');
        } else {
          // Remove error styling
          input.classList.remove('border-red-400', 'focus:border-red-500', 'focus:ring-red-500');
          input.classList.add('border-gray-200');
        }
      });

      if (!isValid) {
        e.preventDefault();

        // Show detailed error message
        const errorText = errorMessages.length > 1 ?
          `Mohon lengkapi field berikut: ${errorMessages.join(', ')}` :
          `Mohon lengkapi field: ${errorMessages[0]}`;

        alert(`❌ ${errorText}`);

        // Scroll to first error field
        if (firstErrorField) {
          firstErrorField.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
          setTimeout(() => firstErrorField.focus(), 500);
        }
      } else {
        // Show loading state
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mendaftarkan...
            `;
        submitBtn.disabled = true;
      }
    });

    // Real-time validation feedback
    const inputs = document.querySelectorAll('input[required], textarea[required], select[required]');
    inputs.forEach(function(input) {
      input.addEventListener('blur', function() {
        const value = input.type === 'file' ? input.files.length : input.value.trim();

        if (value) {
          input.classList.remove('border-red-400', 'focus:border-red-500', 'focus:ring-red-500');
          input.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
        }
      });
    });

    // Document handling functions
    function handleDocumentChange(input) {
      const file = input.files[0];
      const preview = document.getElementById('documentPreview');
      const nameElement = document.getElementById('documentName');
      const sizeElement = document.getElementById('documentSize');

      if (file) {
        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (file.size > maxSize) {
          alert('Ukuran file terlalu besar. Maksimal 5MB.');
          input.value = '';
          return;
        }

        // Validate file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
          alert('Format file tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.');
          input.value = '';
          return;
        }

        // Show preview
        nameElement.textContent = file.name;
        sizeElement.textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
        preview.classList.remove('hidden');

        // Remove error styling
        input.classList.remove('border-red-400');
      }
    }

    function removeDocument() {
      const input = document.getElementById('dokumen_kepemilikan');
      const preview = document.getElementById('documentPreview');

      input.value = '';
      preview.classList.add('hidden');
    }
  });
</script>
@endpush
@endsection