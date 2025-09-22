@extends('layouts.sidebar')

@section('title', 'Tambah Tarif')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center space-x-4">
    <a href="{{ route('admin.tarif.index') }}"
      class="text-gray-600 hover:text-gray-900">
      <i class="fas fa-arrow-left text-xl"></i>
    </a>
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Tambah Tarif Baru</h1>
      <p class="text-gray-600">Menambahkan tarif rental untuk motor</p>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.tarif.store') }}" method="POST" class="p-6 space-y-6">
      @csrf

      <!-- Motor Selection -->
      <div>
        <label for="motor_id" class="block text-sm font-medium text-gray-700 mb-2">
          Motor <span class="text-red-500">*</span>
        </label>
        <select name="motor_id" id="motor_id" required
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('motor_id') border-red-500 @enderror">
          <option value="">Pilih Motor</option>
          @foreach($motors as $motor)
          <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>
            {{ $motor->merk }} {{ $motor->model }} ({{ $motor->plat_nomor }}) - {{ $motor->owner->name }}
          </option>
          @endforeach
        </select>
        @error('motor_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @if($motors->isEmpty())
        <p class="mt-1 text-sm text-yellow-600">
          <i class="fas fa-exclamation-triangle mr-1"></i>
          Semua motor sudah memiliki tarif aktif
        </p>
        @endif
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tarif Harian -->
        <div>
          <label for="tarif_harian" class="block text-sm font-medium text-gray-700 mb-2">
            Tarif Harian <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
            <input type="number"
              name="tarif_harian"
              id="tarif_harian"
              value="{{ old('tarif_harian') }}"
              min="0"
              step="1000"
              required
              class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tarif_harian') border-red-500 @enderror"
              placeholder="50000">
          </div>
          @error('tarif_harian')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Tarif Mingguan -->
        <div>
          <label for="tarif_mingguan" class="block text-sm font-medium text-gray-700 mb-2">
            Tarif Mingguan
          </label>
          <div class="relative">
            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
            <input type="number"
              name="tarif_mingguan"
              id="tarif_mingguan"
              value="{{ old('tarif_mingguan') }}"
              min="0"
              step="1000"
              class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tarif_mingguan') border-red-500 @enderror"
              placeholder="300000">
          </div>
          @error('tarif_mingguan')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Tarif Bulanan -->
        <div>
          <label for="tarif_bulanan" class="block text-sm font-medium text-gray-700 mb-2">
            Tarif Bulanan
          </label>
          <div class="relative">
            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
            <input type="number"
              name="tarif_bulanan"
              id="tarif_bulanan"
              value="{{ old('tarif_bulanan') }}"
              min="0"
              step="1000"
              class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tarif_bulanan') border-red-500 @enderror"
              placeholder="1000000">
          </div>
          @error('tarif_bulanan')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>



      <!-- Status -->
      <div>
        <div class="flex items-center">
          <input type="checkbox"
            name="is_active"
            id="is_active"
            value="1"
            {{ old('is_active') ? 'checked' : '' }}
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
          <label for="is_active" class="ml-2 block text-sm text-gray-700">
            Aktifkan tarif ini
          </label>
        </div>
        <p class="mt-1 text-sm text-gray-500">
          Jika diaktifkan, tarif lain untuk motor ini akan dinonaktifkan secara otomatis.
        </p>
      </div>

      <!-- Preview -->
      <div id="preview" class="bg-gray-50 rounded-lg p-4 hidden">
        <h3 class="text-sm font-medium text-gray-900 mb-2">Preview Tarif</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <span class="text-gray-600">Harga per hari:</span>
            <span id="preview-daily" class="font-medium"></span>
          </div>
          <div>
            <span class="text-gray-600">Harga per minggu:</span>
            <span id="preview-weekly" class="font-medium"></span>
          </div>
          <div>
            <span class="text-gray-600">Harga per bulan:</span>
            <span id="preview-monthly" class="font-medium"></span>
          </div>
        </div>
      </div>

      <!-- Submit Buttons -->
      <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.tarif.index') }}"
          class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
          Batal
        </a>
        <button type="submit"
          class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
          <i class="fas fa-save mr-2"></i>Simpan Tarif
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tarifInputs = ['tarif_harian', 'tarif_mingguan', 'tarif_bulanan'];

    tarifInputs.forEach(inputId => {
      const input = document.getElementById(inputId);
      if (input) {
        // Format number input on blur
        input.addEventListener('blur', function() {
          const value = parseInt(this.value) || 0;
          this.value = value;
        });
      }
    });
  });
</script>
@endsection