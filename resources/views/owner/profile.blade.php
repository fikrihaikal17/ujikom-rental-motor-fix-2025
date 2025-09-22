@extends('layouts.owner')

@section('title', 'Profil Saya')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Profil Saya</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola informasi profil dan data pribadi Anda.</p>
    </div>
  </div>

  @if(session('success'))
  <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
    {{ session('success') }}
  </div>
  @endif

  <div class="mt-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Pribadi</h3>
          <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil dan alamat email Anda.</p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <form method="POST" action="{{ route('owner.profile.update') }}">
          @csrf
          @method('PUT')

          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                  <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                  <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                  @error('name')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                  @error('email')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                  <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                  @error('phone')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div class="col-span-6">
                  <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                  <textarea name="address" id="address" rows="3" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 @enderror">{{ old('address', $user->address) }}</textarea>
                  @error('address')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Simpan Perubahan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Statistics Section -->
  <div class="mt-10">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Statistik Akun</h3>
          <p class="mt-1 text-sm text-gray-600">Ringkasan aktivitas dan pencapaian Anda.</p>
        </div>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
              <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Motor</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ Auth::user()->motors()->count() }}</dd>
              </div>

              <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Motor Terverifikasi</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-600">{{ Auth::user()->motors()->where('status', \App\Enums\MotorStatus::VERIFIED)->count() }}</dd>
              </div>

              <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Bergabung Sejak</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</dd>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection