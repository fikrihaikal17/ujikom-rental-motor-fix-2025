@extends('layouts.owner')

@section('title', 'Pengaturan')

@section('content')
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Pengaturan</h1>
      <p class="mt-2 text-gray-600">Kelola pengaturan akun dan keamanan Anda.</p>
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
      <!-- Change Password Section -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Ubah Password</h3>
          <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang kuat dan aman.</p>
        </div>

        <form method="POST" action="{{ route('owner.settings.update') }}" class="px-6 py-6">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password Baru <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input 
                  type="password" 
                  name="password" 
                  id="password" 
                  placeholder="Masukkan password baru"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                </div>
              </div>
              @error('password')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Password <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input 
                  type="password" 
                  name="password_confirmation" 
                  id="password_confirmation" 
                  placeholder="Ulangi password baru"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <p class="mt-1 text-xs text-gray-500">Harus sama dengan password baru</p>
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <button 
              type="submit" 
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              Update Password
            </button>
          </div>
        </form>
      </div>

      <!-- Notification Settings -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Pengaturan Notifikasi</h3>
          <p class="mt-1 text-sm text-gray-600">Kelola bagaimana Anda menerima notifikasi dari sistem.</p>
        </div>

        <form method="POST" action="{{ route('owner.settings.update') }}" class="px-6 py-6">
          @csrf
          @method('PUT')

          <div class="space-y-6">
            <div class="space-y-4">
              <h4 class="text-base font-medium text-gray-900">Preferensi Notifikasi</h4>
              
              <div class="space-y-4">
                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input 
                      id="notification_email" 
                      name="notification_email" 
                      type="checkbox" 
                      checked 
                      class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                    >
                  </div>
                  <div class="ml-3">
                    <label for="notification_email" class="font-medium text-gray-700">
                      Notifikasi Email
                    </label>
                    <p class="text-sm text-gray-500">
                      Terima notifikasi melalui email untuk penyewaan baru, pembayaran, dan pembaruan status motor.
                    </p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input 
                      id="notification_sms" 
                      name="notification_sms" 
                      type="checkbox" 
                      class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                    >
                  </div>
                  <div class="ml-3">
                    <label for="notification_sms" class="font-medium text-gray-700">
                      Notifikasi SMS
                    </label>
                    <p class="text-sm text-gray-500">
                      Terima notifikasi melalui SMS untuk urusan penting dan darurat.
                    </p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input 
                      id="notification_push" 
                      name="notification_push" 
                      type="checkbox" 
                      checked
                      class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                    >
                  </div>
                  <div class="ml-3">
                    <label for="notification_push" class="font-medium text-gray-700">
                      Notifikasi Browser
                    </label>
                    <p class="text-sm text-gray-500">
                      Terima notifikasi real-time di browser untuk aktivitas terbaru.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <button 
              type="submit" 
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Simpan Pengaturan
            </button>
          </div>
        </form>
      </div>

      <!-- Account Information -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Informasi Akun</h3>
          <p class="mt-1 text-sm text-gray-600">Detail akun dan status verifikasi Anda.</p>
        </div>

        <div class="px-6 py-6">
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-4">
              <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Status Akun</p>
                    <p class="text-sm text-gray-600">Aktif</p>
                  </div>
                </div>
                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  Terverifikasi
                </span>
              </div>

              <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                  <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Tipe Akun</p>
                  <p class="text-sm text-gray-600">Pemilik Motor</p>
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                  <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Bergabung Sejak</p>
                  <p class="text-sm text-gray-600">{{ Auth::user()->created_at->format('d F Y') }}</p>
                </div>
              </div>

              <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                  <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Terakhir Login</p>
                  <p class="text-sm text-gray-600">{{ Auth::user()->updated_at->diffForHumans() }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- User Profile Info -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-base font-medium text-gray-900 mb-4">Informasi Profil</h4>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->nama }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->no_telepon ?? 'Belum diisi' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->alamat ?? 'Belum diisi' }}</p>
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
    // Password confirmation validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    function validatePasswordMatch() {
        if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Password tidak cocok');
            confirmPasswordInput.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            confirmPasswordInput.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
        } else {
            confirmPasswordInput.setCustomValidity('');
            confirmPasswordInput.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            confirmPasswordInput.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
        }
    }
    
    if (passwordInput && confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        passwordInput.addEventListener('input', validatePasswordMatch);
    }
    
    // Auto-hide success messages after 5 seconds
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
    
    // Form submission loading state
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = submitBtn.innerHTML.replace(/Update|Simpan/, 'Menyimpan...');
            }
        });
    });
});
</script>
@endpush

@endsection