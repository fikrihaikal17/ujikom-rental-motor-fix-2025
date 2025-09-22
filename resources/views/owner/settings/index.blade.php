@extends('layouts.owner')

@section('title', 'Pengaturan - Rental Motor')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold leading-6 text-gray-900">Pengaturan</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola preferensi dan pengaturan akun Anda</p>
    </div>
  </div>

  <!-- Settings Form -->
  <div class="mt-8">
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <form method="POST" action="{{ route('owner.settings.update') }}">
          @csrf
          @method('PUT')

          <div class="space-y-6">
            <!-- Notification Settings -->
            <div>
              <h3 class="text-lg font-medium text-gray-900">Notifikasi</h3>
              <p class="mt-1 text-sm text-gray-600">Pilih jenis notifikasi yang ingin Anda terima</p>

              <div class="mt-4 space-y-4">
                <div class="flex items-center">
                  <input id="notifications" name="notifications" type="checkbox" value="1"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="notifications" class="ml-2 block text-sm text-gray-900">
                    Notifikasi Push
                  </label>
                </div>

                <div class="flex items-center">
                  <input id="email_notifications" name="email_notifications" type="checkbox" value="1"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="email_notifications" class="ml-2 block text-sm text-gray-900">
                    Notifikasi Email
                  </label>
                </div>
              </div>
            </div>

            <!-- Privacy Settings -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-medium text-gray-900">Privasi</h3>
              <p class="mt-1 text-sm text-gray-600">Kontrol informasi yang dapat dilihat orang lain</p>

              <div class="mt-4 space-y-4">
                <div class="flex items-center">
                  <input id="public_profile" name="public_profile" type="checkbox" value="1"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="public_profile" class="ml-2 block text-sm text-gray-900">
                    Profile Publik
                  </label>
                </div>

                <div class="flex items-center">
                  <input id="show_contact" name="show_contact" type="checkbox" value="1"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="show_contact" class="ml-2 block text-sm text-gray-900">
                    Tampilkan Kontak ke Penyewa
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <button type="submit"
              class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Simpan Pengaturan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Danger Zone -->
  <div class="mt-8">
    <div class="bg-white shadow rounded-lg border-l-4 border-red-400">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900">Danger Zone</h3>
        <p class="mt-1 text-sm text-gray-600">Tindakan berikut tidak dapat dibatalkan</p>

        <div class="mt-4">
          <button type="button"
            class="inline-flex justify-center rounded-md border border-red-300 bg-white py-2 px-4 text-sm font-medium text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            Hapus Akun
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection