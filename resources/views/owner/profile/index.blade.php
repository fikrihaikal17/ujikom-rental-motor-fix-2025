@extends('layouts.owner')

@section('title', 'Profile - Rental Motor')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold leading-6 text-gray-900">Profile</h1>
      <p class="mt-2 text-sm text-gray-700">Kelola informasi profile Anda</p>
    </div>
  </div>

  <!-- Profile Form -->
  <div class="mt-8">
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <form method="POST" action="{{ route('owner.profile.update') }}">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
            <!-- Name -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input type="text" name="name" id="name" value="{{ old('name', $owner->name) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
              @error('name')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email', $owner->email) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
              @error('email')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Phone -->
            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
              <input type="text" name="phone" id="phone" value="{{ old('phone', $owner->phone) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
              @error('phone')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Role (Read Only) -->
            <div>
              <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
              <input type="text" value="{{ ucfirst($owner->role->value) }}" readonly
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500">
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <button type="submit"
              class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection