@extends('layouts.renter')

@section('title', 'Profil Saya')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
      <p class="mt-2 text-gray-600">Kelola informasi profil dan data pribadi Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
      </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
          <div class="mt-2 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="space-y-8">
      <!-- Profile Information Section -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
          <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil dan kontak Anda.</p>
        </div>

        <form method="POST" action="{{ route('renter.profile.update') }}" class="px-6 py-6">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input 
                  type="text" 
                  name="nama" 
                  id="nama" 
                  value="{{ old('nama', $user->nama) }}" 
                  placeholder="Masukkan nama lengkap"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                  required
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
              </div>
              @error('nama')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input 
                  type="email" 
                  name="email" 
                  id="email" 
                  value="{{ old('email', $user->email) }}" 
                  placeholder="contoh@email.com"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                  required
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                  </svg>
                </div>
              </div>
              @error('email')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Telepon
              </label>
              <div class="relative">
                <input 
                  type="text" 
                  name="no_hp" 
                  id="no_hp" 
                  value="{{ old('no_hp', $user->no_hp) }}" 
                  placeholder="08xxxxxxxxxx"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_hp') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                </div>
              </div>
              @error('no_hp')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-xs text-gray-500">Format: 08xxxxxxxxxx</p>
            </div>

            <div>
              <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                Tipe Akun
              </label>
              <div class="relative">
                <input 
                  type="text" 
                  value="Penyewa Motor" 
                  disabled
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                  </svg>
                </div>
              </div>
              <p class="mt-1 text-xs text-gray-500">Tipe akun tidak dapat diubah</p>
            </div>
          </div>

          <div class="mt-6">
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
              Alamat Lengkap
            </label>
            <div class="relative">
              <textarea 
                name="alamat" 
                id="alamat" 
                rows="3" 
                placeholder="Masukkan alamat lengkap..."
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
              >{{ old('alamat', $user->alamat) }}</textarea>
              <div class="absolute top-2 right-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
            </div>
            @error('alamat')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Alamat lengkap termasuk kota dan kode pos</p>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button 
              type="button" 
              onclick="resetForm()"
              class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              Reset
            </button>
            <button 
              type="submit" 
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      <!-- Statistics Section -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Statistik Akun</h3>
          <p class="mt-1 text-sm text-gray-600">Ringkasan aktivitas dan pencapaian Anda.</p>
        </div>

        <div class="px-6 py-6">
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
              <div class="flex-shrink-0">
                <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="ml-4">
                <dt class="text-sm font-medium text-blue-700">Total Booking</dt>
                <dd class="text-2xl font-bold text-blue-900">{{ $stats['total_bookings'] }}</dd>
                <p class="text-xs text-blue-600">Penyewaan dilakukan</p>
              </div>
            </div>

            <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
              <div class="flex-shrink-0">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <dt class="text-sm font-medium text-green-700">Selesai</dt>
                <dd class="text-2xl font-bold text-green-900">{{ $stats['completed_bookings'] }}</dd>
                <p class="text-xs text-green-600">Penyewaan sukses</p>
              </div>
            </div>

            <div class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
              <div class="flex-shrink-0">
                <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2v-6a2 2 0 012-2z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <dt class="text-sm font-medium text-purple-700">Bergabung Sejak</dt>
                <dd class="text-2xl font-bold text-purple-900">{{ $user->created_at->format('M Y') }}</dd>
                <p class="text-xs text-purple-600">{{ $user->created_at->diffForHumans() }}</p>
              </div>
            </div>
          </div>

          <!-- Additional Account Info -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-base font-medium text-gray-900 mb-4">Informasi Akun</h4>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">
                  {{ $stats['active_bookings'] }}
                </div>
                <div class="text-sm text-gray-600">Booking Aktif</div>
              </div>
              
              <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">
                  {{ $stats['total_bookings'] }}
                </div>
                <div class="text-sm text-gray-600">Total Penyewaan</div>
              </div>
              
              <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">
                  Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                </div>
                <div class="text-sm text-gray-600">Total Pengeluaran</div>
              </div>
              
              <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">
                  {{ Auth::user()->penyewaans()->where('status', \App\Enums\BookingStatus::ACTIVE)->count() }}
                </div>
                <div class="text-sm text-gray-600">Sedang Menyewa</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('input[required]');
    
    // Real-time validation
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('border-red-300')) {
                validateField(this);
            }
        });
    });
    
    // Email validation
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            validateEmail(this);
        });
    }
    
    // Phone validation
    const phoneField = document.getElementById('no_hp');
    if (phoneField) {
        phoneField.addEventListener('input', function() {
            // Format phone number
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
            this.value = value;
        });
    }
    
    function validateField(field) {
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            field.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return false;
        } else {
            field.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            field.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return true;
        }
    }
    
    function validateEmail(field) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (field.value && !emailRegex.test(field.value)) {
            field.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            field.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return false;
        } else {
            field.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            field.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return true;
        }
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = submitBtn.innerHTML.replace('Simpan Perubahan', 'Menyimpan...');
        }
    });
    
    // Auto-hide success messages
    const successAlert = document.querySelector('.bg-green-50');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease-out';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
    }
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan akan hilang.')) {
        document.querySelector('form').reset();
        // Restore original values
        location.reload();
    }
}
</script>
@endpush

@endsection