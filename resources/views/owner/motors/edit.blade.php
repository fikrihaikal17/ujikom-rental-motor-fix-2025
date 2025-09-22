@extends('layouts.app')

@section('title', 'Edit Motor - RideNow')

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
            <p class="text-gray-600 mt-2">{{ $motor->nama_motor }}</p>
          </div>
        </div>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('owner.motors.update', $motor) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
          @csrf
          @method('PUT')

          <!-- Motor Basic Info -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Motor Name -->
            <div>
              <label for="nama_motor" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Motor <span class="text-red-500">*</span>
              </label>
              <input type="text" name="nama_motor" id="nama_motor" value="{{ old('nama_motor', $motor->nama_motor) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_motor') border-red-500 @enderror"
                placeholder="Honda Beat Street, Yamaha NMAX, dll">
              @error('nama_motor')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Brand -->
            <div>
              <label for="merk" class="block text-sm font-medium text-gray-700 mb-2">
                Merk <span class="text-red-500">*</span>
              </label>
              <select name="merk" id="merk" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('merk') border-red-500 @enderror">
                <option value="">Pilih Merk</option>
                <option value="Honda" {{ old('merk', $motor->merk) === 'Honda' ? 'selected' : '' }}>Honda</option>
                <option value="Yamaha" {{ old('merk', $motor->merk) === 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
                <option value="Suzuki" {{ old('merk', $motor->merk) === 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                <option value="Kawasaki" {{ old('merk', $motor->merk) === 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
                <option value="TVS" {{ old('merk', $motor->merk) === 'TVS' ? 'selected' : '' }}>TVS</option>
                <option value="Benelli" {{ old('merk', $motor->merk) === 'Benelli' ? 'selected' : '' }}>Benelli</option>
                <option value="KTM" {{ old('merk', $motor->merk) === 'KTM' ? 'selected' : '' }}>KTM</option>
                <option value="Viar" {{ old('merk', $motor->merk) === 'Viar' ? 'selected' : '' }}>Viar</option>
                <option value="Lainnya" {{ old('merk', $motor->merk) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
              </select>
              @error('merk')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Model -->
            <div>
              <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                Model <span class="text-red-500">*</span>
              </label>
              <input type="text" name="model" id="model" value="{{ old('model', $motor->model) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('model') border-red-500 @enderror"
                placeholder="Beat Street, NMAX 155, dll">
              @error('model')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Year -->
            <div>
              <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                Tahun <span class="text-red-500">*</span>
              </label>
              <select name="tahun" id="tahun" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tahun') border-red-500 @enderror">
                <option value="">Pilih Tahun</option>
                @for($year = date('Y'); $year >= 2010; $year--)
                <option value="{{ $year }}" {{ old('tahun', $motor->tahun) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
              </select>
              @error('tahun')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- License Plate -->
            <div>
              <label for="plat_nomor" class="block text-sm font-medium text-gray-700 mb-2">
                Plat Nomor <span class="text-red-500">*</span>
              </label>
              <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor', $motor->plat_nomor) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('plat_nomor') border-red-500 @enderror"
                placeholder="B 1234 XYZ" style="text-transform: uppercase;">
              @error('plat_nomor')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Engine Capacity -->
            <div>
              <label for="kapasitas_mesin" class="block text-sm font-medium text-gray-700 mb-2">
                Kapasitas Mesin (CC) <span class="text-red-500">*</span>
              </label>
              <input type="number" name="kapasitas_mesin" id="kapasitas_mesin" value="{{ old('kapasitas_mesin', $motor->kapasitas_mesin) }}" required min="50" max="2000"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kapasitas_mesin') border-red-500 @enderror"
                placeholder="150">
              @error('kapasitas_mesin')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Price -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
              <label for="harga_per_hari" class="block text-sm font-medium text-gray-700 mb-2">
                Harga Sewa per Hari (Rp) <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                <input type="number" name="harga_per_hari" id="harga_per_hari" value="{{ old('harga_per_hari', $motor->harga_per_hari) }}" required min="10000"
                  class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('harga_per_hari') border-red-500 @enderror"
                  placeholder="75000">
              </div>
              @error('harga_per_hari')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-sm text-gray-500">Harga akan dibagi sesuai kesepakatan bagi hasil</p>
            </div>
          </div>

          <!-- Description -->
          <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
              Deskripsi Motor
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror"
              placeholder="Jelaskan kondisi motor, fitur khusus, atau catatan penting lainnya...">{{ old('deskripsi', $motor->deskripsi) }}</textarea>
            @error('deskripsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Current Photo & Upload New -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Current Photo -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
              <div class="border border-gray-300 rounded-lg p-4">
                @if($motor->foto_motor)
                <img src="{{ asset('storage/' . $motor->foto_motor) }}"
                  alt="{{ $motor->nama_motor }}"
                  class="w-full h-48 object-cover rounded-lg">
                @else
                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                  <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
                @endif
              </div>
            </div>

            <!-- Upload New Photo -->
            <div>
              <label for="foto_motor" class="block text-sm font-medium text-gray-700 mb-2">
                Upload Foto Baru (Opsional)
              </label>
              <div class="flex items-center justify-center w-full">
                <label for="foto_motor" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500">
                      <span class="font-semibold">Klik untuk upload</span>
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG</p>
                  </div>
                  <input id="foto_motor" name="foto_motor" type="file" class="hidden" accept="image/*" />
                </label>
              </div>
              @error('foto_motor')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('owner.motors.show', $motor) }}"
              class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors duration-200">
              Batal
            </a>
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      <!-- Information Box -->
      @if($motor->status === 'verified')
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
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Format plat nomor to uppercase
    const platNomorInput = document.getElementById('plat_nomor');
    platNomorInput.addEventListener('input', function() {
      this.value = this.value.toUpperCase();
    });

    // Preview uploaded image
    const fotoMotorInput = document.getElementById('foto_motor');
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

    // Format price input
    const hargaInput = document.getElementById('harga_per_hari');
    hargaInput.addEventListener('input', function() {
      let value = this.value.replace(/\D/g, '');
      this.value = value;
    });
  });
</script>
@endpush
@endsection