@extends('layouts.sidebar')

@section('title', 'Pengaturan Admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold leading-6 text-gray-900">Pengaturan Admin</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola profil dan pengaturan akun admin</p>
    </div>
  </div>

  <!-- Navigation Tabs -->
  <div class="mt-8 border-b border-gray-200" x-data="{ activeTab: 'profile' }">
    <nav class="-mb-px flex space-x-8">
      <button @click="activeTab = 'profile'"
        :class="activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
        <i class="fas fa-user mr-2"></i>Profil Admin
      </button>
      <button @click="activeTab = 'password'"
        :class="activeTab === 'password' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
        <i class="fas fa-lock mr-2"></i>Ubah Password
      </button>
      <button @click="activeTab = 'system'"
        :class="activeTab === 'system' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
        <i class="fas fa-cogs mr-2"></i>Sistem
      </button>
      <button @click="activeTab = 'notifications'"
        :class="activeTab === 'notifications' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
        <i class="fas fa-bell mr-2"></i>Notifikasi
      </button>
      <button @click="activeTab = 'backup'"
        :class="activeTab === 'backup' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
        <i class="fas fa-database mr-2"></i>Backup
      </button>
    </nav>

    <!-- Profile Tab -->
    <div x-show="activeTab === 'profile'" class="mt-6">
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg font-medium text-gray-900">Informasi Profil</h3>
          <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil admin Anda</p>
          
          <form action="{{ route('admin.settings.profile') }}" method="POST" class="mt-6 space-y-6">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
              </label>
              <input type="text"
                name="name"
                id="name"
                value="{{ old('name', $admin->name) }}"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
              @error('name')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
              </label>
              <input type="email"
                name="email"
                id="email"
                value="{{ old('email', $admin->email) }}"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
              @error('email')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Telepon
              </label>
              <input type="text"
                name="phone"
                id="phone"
                value="{{ old('phone', $admin->phone) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                placeholder="08xxxxxxxxxx">
              @error('phone')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                Role
              </label>
              <input type="text"
                value="{{ ucfirst($admin->role->value) }}"
                disabled
                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
            </div>
          </div>

          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
              Alamat
            </label>
            <textarea name="address"
              id="address"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
              placeholder="Alamat lengkap">{{ old('address', $admin->address) }}</textarea>
            @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

            <div class="mt-6 flex justify-end">
              <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Password Tab -->
    <div x-show="activeTab === 'password'" class="mt-6">
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg font-medium text-gray-900">Ubah Password</h3>
          <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang kuat</p>
          
          <form action="{{ route('admin.settings.password') }}" method="POST" class="mt-6 space-y-6">
          @csrf
          @method('PUT')

          <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
              Password Saat Ini <span class="text-red-500">*</span>
            </label>
            <input type="password"
              name="current_password"
              id="current_password"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror">
            @error('current_password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password Baru <span class="text-red-500">*</span>
              </label>
              <input type="password"
                name="password"
                id="password"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
              @error('password')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Password Baru <span class="text-red-500">*</span>
              </label>
              <input type="password"
                name="password_confirmation"
                id="password_confirmation"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>

          <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Tips Password Kuat:</h3>
                <div class="mt-2 text-sm text-blue-700">
                  <ul class="list-disc list-inside space-y-1">
                    <li>Minimal 8 karakter</li>
                    <li>Kombinasi huruf besar dan kecil</li>
                    <li>Mengandung angka dan simbol</li>
                    <li>Tidak menggunakan informasi pribadi</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

            <div class="mt-6 flex justify-end">
              <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-key mr-2"></i>Update Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- System Tab -->
    <div x-show="activeTab === 'system'" class="mt-6">
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg font-medium text-gray-900">Pengaturan Sistem</h3>
          <p class="mt-1 text-sm text-gray-600">Konfigurasi pengaturan sistem aplikasi</p>
          
          <div class="mt-6 space-y-6">
          <!-- System Information -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
              <h4 class="text-sm font-medium text-gray-900 mb-2">Informasi Sistem</h4>
              <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                  <span>Versi Aplikasi:</span>
                  <span class="font-medium">1.0.0</span>
                </div>
                <div class="flex justify-between">
                  <span>Laravel Version:</span>
                  <span class="font-medium">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between">
                  <span>PHP Version:</span>
                  <span class="font-medium">{{ phpversion() }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Server Time:</span>
                  <span class="font-medium">{{ now()->format('Y-m-d H:i:s') }}</span>
                </div>
              </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
              <h4 class="text-sm font-medium text-gray-900 mb-2">Status Database</h4>
              <div class="space-y-2 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                  <span>Koneksi Database:</span>
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i>Terhubung
                  </span>
                </div>
                <div class="flex justify-between">
                  <span>Total Users:</span>
                  <span class="font-medium">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Total Motors:</span>
                  <span class="font-medium">{{ \App\Models\Motor::count() }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Total Transaksi:</span>
                  <span class="font-medium">{{ \App\Models\Transaksi::count() }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div>
            <h4 class="text-sm font-medium text-gray-900 mb-4">Aksi Cepat</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <button onclick="clearCache()"
                class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                <i class="fas fa-broom mr-2"></i>Clear Cache
              </button>
              <button onclick="optimizeDatabase()"
                class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                <i class="fas fa-database mr-2"></i>Optimize Database
              </button>
              <button onclick="viewLogs()"
                class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                <i class="fas fa-file-alt mr-2"></i>View Logs
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Notifications Tab -->
    <div x-show="activeTab === 'notifications'" class="mt-6">
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg font-medium text-gray-900">Pengaturan Notifikasi</h3>
          <p class="mt-1 text-sm text-gray-600">Kelola preferensi notifikasi Anda</p>
          
          <div class="mt-6">
          <div class="space-y-6">
            <div>
              <h4 class="text-sm font-medium text-gray-900 mb-4">Notifikasi Email</h4>
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-medium text-gray-900">Registrasi User Baru</p>
                    <p class="text-sm text-gray-500">Notifikasi saat ada user baru yang mendaftar</p>
                  </div>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                  </label>
                </div>

                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-medium text-gray-900">Motor Baru Didaftarkan</p>
                    <p class="text-sm text-gray-500">Notifikasi saat ada motor baru yang didaftarkan</p>
                  </div>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                  </label>
                </div>

                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-medium text-gray-900">Pembayaran Diterima</p>
                    <p class="text-sm text-gray-500">Notifikasi saat pembayaran berhasil diterima</p>
                  </div>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                  </label>
                </div>
              </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
              <h4 class="text-sm font-medium text-gray-900 mb-4">Notifikasi Browser</h4>
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-900">Push Notifications</p>
                  <p class="text-sm text-gray-500">Terima notifikasi langsung di browser</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                  <input type="checkbox" class="sr-only peer">
                  <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
              </div>
            </div>
          </div>

            <div class="mt-6 flex justify-end">
              <button type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i>Simpan Pengaturan
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Backup Tab -->
    <div x-show="activeTab === 'backup'" class="mt-6">
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h3 class="text-lg font-medium text-gray-900">Backup Database</h3>
              <p class="mt-1 text-sm text-gray-600">Kelola backup database sistem</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <button onclick="createBackup()"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>Buat Backup
              </button>
            </div>
          </div>
          
            <!-- Backup Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
              <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-database text-blue-500 text-2xl"></i>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Total Backups</p>
                    <p class="text-2xl font-bold text-blue-600">5</p>
                  </div>
                </div>
              </div>
              
              <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-clock text-green-500 text-2xl"></i>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-medium text-green-900">Last Backup</p>
                    <p class="text-lg font-semibold text-green-600">{{ now()->format('Y-m-d') }}</p>
                  </div>
                </div>
              </div>
              
              <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-hdd text-purple-500 text-2xl"></i>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-medium text-purple-900">Total Size</p>
                    <p class="text-lg font-semibold text-purple-600">12.5 MB</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Backup Actions -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
              <h4 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h4>
              <div class="flex flex-wrap gap-3">
                <button onclick="createFullBackup()" 
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200">
                  <i class="fas fa-database mr-1"></i>Full Backup
                </button>
                <button onclick="createDataBackup()" 
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200">
                  <i class="fas fa-table mr-1"></i>Data Only
                </button>
                <button onclick="scheduleBackup()" 
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-purple-700 bg-purple-100 hover:bg-purple-200">
                  <i class="fas fa-calendar mr-1"></i>Schedule
                </button>
                <button onclick="restoreBackup()" 
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-orange-700 bg-orange-100 hover:bg-orange-200">
                  <i class="fas fa-undo mr-1"></i>Restore
                </button>
              </div>
            </div>

            <!-- Backup List -->
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <i class="fas fa-file-archive text-blue-500 mr-3"></i>
                        <div>
                          <div class="text-sm font-medium text-gray-900">backup_{{ now()->format('Y_m_d') }}.sql</div>
                          <div class="text-sm text-gray-500">Full Database Backup</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.5 MB</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Manual</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ now()->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                      <button onclick="downloadBackup('backup_{{ now()->format('Y_m_d') }}.sql')" 
                        class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-download"></i>
                      </button>
                      <button onclick="restoreBackup('backup_{{ now()->format('Y_m_d') }}.sql')" 
                        class="text-green-600 hover:text-green-900">
                        <i class="fas fa-undo"></i>
                      </button>
                      <button onclick="deleteBackup('backup_{{ now()->format('Y_m_d') }}.sql')" 
                        class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <i class="fas fa-file-archive text-green-500 mr-3"></i>
                        <div>
                          <div class="text-sm font-medium text-gray-900">auto_backup_{{ now()->subDay()->format('Y_m_d') }}.sql</div>
                          <div class="text-sm text-gray-500">Automatic Daily Backup</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.3 MB</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Auto</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ now()->subDay()->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                      <button onclick="downloadBackup('auto_backup_{{ now()->subDay()->format('Y_m_d') }}.sql')" 
                        class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-download"></i>
                      </button>
                      <button onclick="restoreBackup('auto_backup_{{ now()->subDay()->format('Y_m_d') }}.sql')" 
                        class="text-green-600 hover:text-green-900">
                        <i class="fas fa-undo"></i>
                      </button>
                      <button onclick="deleteBackup('auto_backup_{{ now()->subDay()->format('Y_m_d') }}.sql')" 
                        class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Danger Zone -->
  <div class="mt-8">
    <div class="bg-white shadow rounded-lg border-l-4 border-red-400">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900">Danger Zone</h3>
        <p class="mt-1 text-sm text-gray-600">Tindakan berikut tidak dapat dibatalkan dan memerlukan konfirmasi khusus</p>

        <div class="mt-6 space-y-4">
          <!-- Clear All Data -->
          <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
            <div>
              <h4 class="text-sm font-medium text-red-800">Reset Semua Data</h4>
              <p class="text-sm text-red-600">Hapus semua data booking, motor, dan user (kecuali admin)</p>
            </div>
            <button type="button" onclick="confirmResetData()"
              class="inline-flex justify-center rounded-md border border-red-300 bg-white py-2 px-4 text-sm font-medium text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
              <i class="fas fa-exclamation-triangle mr-2"></i>Reset Data
            </button>
          </div>

          <!-- Maintenance Mode -->
          <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <div>
              <h4 class="text-sm font-medium text-yellow-800">Mode Maintenance</h4>
              <p class="text-sm text-yellow-600">Aktifkan mode maintenance untuk pemeliharaan sistem</p>
            </div>
            <button type="button" onclick="toggleMaintenance()"
              class="inline-flex justify-center rounded-md border border-yellow-300 bg-white py-2 px-4 text-sm font-medium text-yellow-700 shadow-sm hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
              <i class="fas fa-tools mr-2"></i>Toggle Maintenance
            </button>
          </div>

          <!-- Export All Data -->
          <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div>
              <h4 class="text-sm font-medium text-blue-800">Export Semua Data</h4>
              <p class="text-sm text-blue-600">Unduh semua data sistem dalam format JSON/CSV</p>
            </div>
            <button type="button" onclick="exportAllData()"
              class="inline-flex justify-center rounded-md border border-blue-300 bg-white py-2 px-4 text-sm font-medium text-blue-700 shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              <i class="fas fa-download mr-2"></i>Export Data
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
  {{ session('success') }}
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto hide success alert
    const alert = document.getElementById('successAlert');
    if (alert) {
      setTimeout(() => {
        alert.style.display = 'none';
      }, 3000);
    }
  });

  function clearCache() {
    alert('Cache telah dibersihkan!');
  }

  function optimizeDatabase() {
    alert('Database telah dioptimasi!');
  }

  function viewLogs() {
    alert('Membuka log sistem...');
  }

  function createBackup() {
    alert('Backup sedang dibuat...');
  }

  function createFullBackup() {
    if (confirm('Buat backup lengkap database?')) {
      alert('Full backup sedang dibuat...');
    }
  }

  function createDataBackup() {
    if (confirm('Buat backup data saja (tanpa struktur)?')) {
      alert('Data backup sedang dibuat...');
    }
  }

  function scheduleBackup() {
    alert('Fitur schedule backup akan segera hadir!');
  }

  function downloadBackup(filename) {
    alert(`Mengunduh backup: ${filename}`);
  }

  function restoreBackup(filename) {
    if (confirm(`PERINGATAN: Restore backup akan mengganti semua data saat ini dengan data dari ${filename}.\n\nLanjutkan?`)) {
      alert(`Memulai restore dari: ${filename}`);
    }
  }

  function deleteBackup(filename) {
    if (confirm(`Hapus backup: ${filename}?`)) {
      alert(`Backup ${filename} telah dihapus.`);
    }
  }

  function confirmResetData() {
    if (confirm('PERINGATAN: Ini akan menghapus SEMUA data booking, motor, dan user (kecuali admin). Tindakan ini TIDAK DAPAT DIBATALKAN!\n\nKetik "RESET" untuk konfirmasi:')) {
      const confirmation = prompt('Ketik "RESET" untuk melanjutkan:');
      if (confirmation === 'RESET') {
        alert('Reset data telah dikonfirmasi. Proses akan dimulai...');
      } else {
        alert('Reset dibatalkan.');
      }
    }
  }

  function toggleMaintenance() {
    if (confirm('Apakah Anda yakin ingin mengaktifkan/menonaktifkan mode maintenance?')) {
      alert('Mode maintenance telah diubah.');
    }
  }

  function exportAllData() {
    if (confirm('Mulai proses export semua data sistem?')) {
      alert('Export data dimulai. File akan diunduh setelah selesai.');
    }
  }
</script>
@endsection