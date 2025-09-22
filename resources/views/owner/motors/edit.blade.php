@extends('layouts.owner')

@section('title', 'Edit Motor - RideNow')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="flex items-center space-x-4">
    <a href="{{ route('owner.motors.show', $motor) }}"
      class="text-blue-600 hover:text-blue-800 flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Kembali
    </a>
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Edit Motor</h1>
      <p class="text-gray-600 mt-2">Perbarui informasi motor Anda</p>
    </div>
  </div>
</div>

<!-- Form -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
    <h2 class="text-lg font-semibold text-gray-800">Edit Informasi Motor</h2>
    <p class="text-sm text-gray-600 mt-1">Perbarui data motor {{ $motor->merk }} {{ $motor->model }}</p>
  </div>

  <form action="{{ route('owner.motors.update', $motor) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
    @csrf
    @method('PUT')

    <!-- Motor Basic Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Motor Name -->
      <div class="space-y-2">
        <label for="nama_motor" class="block text-sm font-semibold text-gray-700">
          Nama Motor <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input type="text" name="nama_motor" id="nama_motor" value="{{ old('nama_motor', $motor->merk . ' ' . $motor->model) }}" required
            class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_motor') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
            placeholder="Honda Beat Street, Yamaha NMAX, dll">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
        @error('nama_motor')
        <p class="mt-1 text-sm text-red-600 flex items-center">
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
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('merk') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror appearance-none bg-white">
            <option value="">Pilih Merk Motor</option>
            <option value="Honda" {{ old('merk', $motor->merk) === 'Honda' ? 'selected' : '' }}>Honda</option>
            <option value="Yamaha" {{ old('merk', $motor->merk) === 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
            <option value="Suzuki" {{ old('merk', $motor->merk) === 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
            <option value="Kawasaki" {{ old('merk', $motor->merk) === 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
            <option value="TVS" {{ old('merk', $motor->merk) === 'TVS' ? 'selected' : '' }}>TVS</option>
            <option value="Benelli" {{ old('merk', $motor->merk) === 'Benelli' ? 'selected' : '' }}>Benelli</option>
            <option value="Viar" {{ old('merk', $motor->merk) === 'Viar' ? 'selected' : '' }}>Viar</option>
          </select>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        @error('merk')
        <p class="mt-1 text-sm text-red-600 flex items-center">
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
            <option value="Matic" {{ old('model', $motor->model) == 'Matic' ? 'selected' : '' }}>Matic</option>
            <option value="Manual" {{ old('model', $motor->model) == 'Manual' ? 'selected' : '' }}>Manual</option>
            <option value="Sport" {{ old('model', $motor->model) == 'Sport' ? 'selected' : '' }}>Sport</option>
            <option value="Moge" {{ old('model', $motor->model) == 'Moge' ? 'selected' : '' }}>Moge</option>
            <option value="Bebek" {{ old('model', $motor->model) == 'Bebek' ? 'selected' : '' }}>Bebek</option>
            <option value="Trail" {{ old('model', $motor->model) == 'Trail' ? 'selected' : '' }}>Trail</option>
            <option value="Cruiser" {{ old('model', $motor->model) == 'Cruiser' ? 'selected' : '' }}>Cruiser</option>
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
            <option value="{{ $year }}" {{ old('tahun', $motor->tahun) == $year ? 'selected' : '' }}>{{ $year }}</option>
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

      <!-- Engine Capacity -->
      <div class="space-y-2">
        <label for="tipe_cc" class="block text-sm font-semibold text-gray-700">
          Kapasitas Mesin <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select name="tipe_cc" id="tipe_cc" required
            class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none @error('tipe_cc') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            <option value="">Pilih Kapasitas</option>
            <option value="100" {{ old('tipe_cc', $motor->tipe_cc) == '100' ? 'selected' : '' }}>100 CC</option>
            <option value="125" {{ old('tipe_cc', $motor->tipe_cc) == '125' ? 'selected' : '' }}>125 CC</option>
            <option value="150" {{ old('tipe_cc', $motor->tipe_cc) == '150' ? 'selected' : '' }}>150 CC</option>
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
    </div>

    <!-- License Plate & Description -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- License Plate -->
      <div class="space-y-2">
        <label for="no_plat" class="block text-sm font-semibold text-gray-700">
          Plat Nomor <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input type="text" name="no_plat" id="no_plat" value="{{ old('no_plat', $motor->no_plat) }}" required
            class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('no_plat') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror uppercase"
            placeholder="B 1234 XYZ" maxlength="15">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
        </div>
        @error('no_plat')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
        <p class="text-xs text-gray-500">Format: B 1234 ABC</p>
      </div>

      <!-- Color -->
      <div class="space-y-2">
        <label for="warna" class="block text-sm font-semibold text-gray-700">
          Warna Motor
        </label>
        <div class="relative">
          <input type="text" name="warna" id="warna" value="{{ old('warna', $motor->warna) }}"
            class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('warna') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
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

    <!-- Description Section -->
    <div class="space-y-2">
      <label for="deskripsi" class="block text-sm font-semibold text-gray-700">
        Deskripsi Motor <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <textarea name="deskripsi" id="deskripsi" rows="4" required
          class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none @error('deskripsi') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
          placeholder="Deskripsikan kondisi motor, kelengkapan, dan informasi penting lainnya...">{{ old('deskripsi', $motor->deskripsi) }}</textarea>
      </div>
      @error('deskripsi')
      <p class="text-sm text-red-500 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
        {{ $message }}
      </p>
      @enderror
      <p class="text-xs text-gray-500">Minimal 50 karakter</p>
    </div>

    <!-- Documents & Photo Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Current Photo -->
      <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">Foto Saat Ini</label>
        <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
          @if($motor->photo)
          <img src="{{ asset('storage/' . $motor->photo) }}"
            alt="{{ $motor->nama_motor }}"
            class="w-full h-48 object-cover rounded-lg shadow-sm">
          @else
          <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          @endif
        </div>
      </div>

      <!-- Upload New Photo -->
      <div class="space-y-2">
        <label for="foto_motor" class="block text-sm font-semibold text-gray-700">
          Upload Foto Baru (Opsional)
        </label>
        <div class="relative">
          <label for="foto_motor" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-200 group">
            <div class="flex flex-col items-center justify-center py-6 px-4">
              <div class="p-4 bg-blue-100 rounded-full mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
              </div>
              <p class="mb-2 text-sm text-gray-700 font-medium">
                <span class="text-blue-600">Klik untuk upload</span>
              </p>
              <p class="text-xs text-gray-500">PNG, JPG atau JPEG</p>
            </div>
            <input id="foto_motor" name="foto_motor" type="file" class="hidden" accept="image/*" />
          </label>
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

    <!-- Document Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Current Document -->
      <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">Dokumen Kepemilikan Saat Ini</label>
        <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
          @if($motor->dokumen_kepemilikan)
          <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
              <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div>
                <p class="text-sm font-medium text-green-800">Dokumen Tersedia</p>
                <p class="text-xs text-green-600">{{ basename($motor->dokumen_kepemilikan) }}</p>
              </div>
            </div>
            <a href="{{ asset('storage/' . $motor->dokumen_kepemilikan) }}" target="_blank"
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors duration-200 flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              Lihat
            </a>
          </div>
          @else
          <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
              <p class="text-sm font-medium text-yellow-800">Belum ada dokumen</p>
              <p class="text-xs text-yellow-600">Silakan upload dokumen STNK/BPKB</p>
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Upload New Document -->
      <div class="space-y-2">
        <label for="dokumen_kepemilikan" class="block text-sm font-semibold text-gray-700">
          Upload Dokumen Baru (Opsional)
        </label>
        <div class="relative">
          <label for="dokumen_kepemilikan" class="flex flex-col items-center justify-center w-full h-64 border-2 border-orange-300 border-dashed rounded-lg cursor-pointer bg-orange-50 hover:bg-orange-100 transition-all duration-200 group">
            <div class="flex flex-col items-center justify-center py-6 px-4">
              <div class="p-4 bg-orange-100 rounded-full mb-4 group-hover:bg-orange-200 transition-colors duration-200">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <p class="mb-2 text-sm text-orange-700 font-medium">
                <span class="text-orange-600">Upload Dokumen STNK/BPKB</span>
              </p>
              <p class="text-xs text-orange-600">PDF, JPG, JPEG, PNG (Max 5MB)</p>
            </div>
            <input id="dokumen_kepemilikan" name="dokumen_kepemilikan" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" />
          </label>
        </div>
        @error('dokumen_kepemilikan')
        <p class="text-sm text-red-500 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
        @enderror
        <div class="bg-orange-100 border border-orange-300 rounded-lg p-3">
          <p class="text-xs text-orange-800">
            💡 <strong>Tips:</strong> Upload dokumen terbaru jika ada perubahan atau perpanjangan STNK
          </p>
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col space-y-4 pt-8 border-t border-gray-200">
      <div class="text-sm text-gray-500">
        <span class="text-red-500">*</span> Field yang wajib diisi
      </div>

      <!-- Main Actions -->
      <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <!-- Left side - Delete button -->
        <div class="w-full sm:w-auto">
          <button type="button" id="deleteButton"
            class="w-full sm:w-auto px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 flex items-center justify-center transform hover:scale-105 shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus Motor
          </button>
        </div>

        <!-- Right side - Cancel & Save buttons -->
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
          <a href="{{ route('owner.motors.show', $motor) }}"
            class="w-full sm:w-auto px-8 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Batal
          </a>
          <button type="submit"
            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </div>
    </div>
  </form>

  <!-- Hidden Delete Form -->
  <form id="deleteForm" action="{{ route('owner.motors.destroy', $motor) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
  </form>
</div>

<!-- Information Box -->
@if(($motor->status instanceof \App\Enums\MotorStatus ? $motor->status->value : $motor->status) === 'verified')
<div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
  <div class="flex">
    <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
    </svg>
    <div class="text-sm text-yellow-800">
      <h4 class="font-medium mb-2">Perhatian:</h4>
      <p>Motor ini sudah terverifikasi. Perubahan data mungkin memerlukan verifikasi ulang dari admin.</p>
    </div>
  </div>
</div>
@endif

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

    // Format plat nomor to uppercase
    const platNomorInput = document.getElementById('no_plat');
    if (platNomorInput) {
      platNomorInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
      });
    }

    // Preview uploaded image
    const fotoMotorInput = document.getElementById('foto_motor');
    if (fotoMotorInput) {
      fotoMotorInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const label = fotoMotorInput.parentElement;
            label.innerHTML = `
                      <div class="w-full h-48 relative">
                          <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
                          <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200 rounded-lg">
                              <p class="text-white text-sm">Klik untuk ganti foto</p>
                          </div>
                      </div>
                  `;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  });
</script>
@endpush
@endsection