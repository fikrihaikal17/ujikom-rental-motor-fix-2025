@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')

<div class="mb-6 text-center">
  <h2 class="text-3xl font-bold text-gray-900 mb-1">
    Login 
  </h2>
</div><!-- Error Messages -->
@if ($errors->any())
<div class="rounded-lg border p-4 bg-red-50 border-red-200 text-red-800 mb-6">
  <ul class="list-disc list-inside space-y-1">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- Login Form -->
<form action="{{ route('login') }}" method="POST" class="space-y-4">
  @csrf
  <div class="space-y-4">
    <!-- Email -->
    <div>
      <label for="email" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
        Email
      </label>
      <input type="email" name="email" id="email"
        placeholder="nama@email.com"
        value="{{ old('email') }}"
        required
        class="block w-full px-3 py-2.5 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
      @error('email')
      <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Password -->
    <div>
      <label for="password" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">
        Password
      </label>
      <input type="password" name="password" id="password"
        placeholder="Password"
        required
        class="block w-full px-3 py-2.5 text-sm rounded-lg border border-gray-300 placeholder-gray-400 bg-gray-50 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none focus:bg-white transition-all duration-200">
      @error('password')
      <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
      <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-100 transition-all duration-200">
        Masuk
      </button>
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between text-sm">
      <div class="flex items-center">
        <input id="remember-me" name="remember" type="checkbox"
          class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
        <label for="remember-me" class="ml-2 block text-primary-600">
          Remember Me
        </label>
      </div>

      <div>
        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
          Forgot Password
        </a>
      </div>
    </div>
  </div>
</form>
@endsection