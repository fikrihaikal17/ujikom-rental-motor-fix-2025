@extends('layouts.owner')

@section('title', 'Pengaturan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Pengaturan</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola pengaturan akun dan keamanan Anda.</p>
    </div>
  </div>

  @if(session('success'))
  <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
    {{ session('success') }}
  </div>
  @endif

  <div class="mt-8 space-y-10">
    <!-- Change Password Section -->
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Ubah Password</h3>
          <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang aman.</p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <form method="POST" action="{{ route('owner.settings.update') }}">
          @csrf
          @method('PUT')

          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                  <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                  <input type="password" name="password" id="password" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('password') border-red-300 @enderror">
                  @error('password')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Update Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Notification Settings -->
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Pengaturan Notifikasi</h3>
          <p class="mt-1 text-sm text-gray-600">Kelola bagaimana Anda menerima notifikasi.</p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <form method="POST" action="{{ route('owner.settings.update') }}">
          @csrf
          @method('PUT')

          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <fieldset>
                <legend class="text-base font-medium text-gray-900">Notifikasi Email</legend>
                <div class="mt-4 space-y-4">
                  <div class="flex items-start">
                    <div class="flex items-center h-5">
                      <input id="notification_email" name="notification_email" type="checkbox" checked class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                      <label for="notification_email" class="font-medium text-gray-700">Email</label>
                      <p class="text-gray-500">Terima notifikasi melalui email untuk penyewaan baru dan pembaruan.</p>
                    </div>
                  </div>

                  <div class="flex items-start">
                    <div class="flex items-center h-5">
                      <input id="notification_sms" name="notification_sms" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                      <label for="notification_sms" class="font-medium text-gray-700">SMS</label>
                      <p class="text-gray-500">Terima notifikasi melalui SMS untuk urusan penting.</p>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Simpan Pengaturan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Account Information -->
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Akun</h3>
          <p class="mt-1 text-sm text-gray-600">Detail akun dan status verifikasi.</p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Status Akun</dt>
                  <dd class="text-sm text-gray-900">Aktif</dd>
                </div>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  Terverifikasi
                </span>
              </div>

              <div class="flex justify-between items-center">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Tipe Akun</dt>
                  <dd class="text-sm text-gray-900">Pemilik Motor</dd>
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Bergabung Sejak</dt>
                  <dd class="text-sm text-gray-900">{{ Auth::user()->created_at->format('d M Y') }}</dd>
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Terakhir Login</dt>
                  <dd class="text-sm text-gray-900">{{ Auth::user()->updated_at->diffForHumans() }}</dd>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection