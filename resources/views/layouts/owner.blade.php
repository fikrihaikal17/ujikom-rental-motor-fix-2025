<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') - RideNow</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN for development -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary': '#2563eb',
            'primary-dark': '#1d4ed8',
          }
        }
      }
    }
  </script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full" x-data="{ sidebarOpen: false }">
  <div class="min-h-full">
    <!-- Sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 shadow-lg">
        <!-- Logo -->
        <div class="flex h-20 shrink-0 items-center justify-center border-b border-gray-100 px-2 py-4">
          <div class="flex items-center">
            <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <div class="ml-3 text-center">
              <h1 class="text-xl font-bold text-gray-900">RideNow</h1>
              <span class="text-xs text-gray-500 font-medium">Pemilik Motor</span>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col px-4 py-6">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider mb-2">Menu Utama</div>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Dashboard -->
                <li>
                  <a href="{{ route('owner.dashboard') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('owner.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('owner.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-400 group-hover:text-blue-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                      </svg>
                    </div>
                    Dashboard
                  </a>
                </li>

                <!-- Kelola Motor -->
                <li>
                  <a href="{{ route('owner.motors.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('owner.motors.*') ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700 shadow-sm' : 'text-gray-700 hover:text-green-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('owner.motors.*') ? 'bg-green-100 text-green-700' : 'text-gray-400 group-hover:text-green-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                      </svg>
                    </div>
                    Kelola Motor
                  </a>
                </li>

                <!-- History Bagi Hasil -->
                <li>
                  <a href="{{ route('owner.revenue.history') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('owner.revenue.history*') ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 shadow-sm' : 'text-gray-700 hover:text-purple-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('owner.revenue.history*') ? 'bg-purple-100 text-purple-700' : 'text-gray-400 group-hover:text-purple-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                      </svg>
                    </div>
                    History Bagi Hasil
                  </a>
                </li>
              </ul>
            </li>

            <li>
              <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider mb-2">Laporan</div>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Daftar Motor Disewa -->
                <li>
                  <a href="{{ route('owner.rentals.report') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('owner.rentals.report*') ? 'bg-gradient-to-r from-orange-50 to-orange-100 text-orange-700 shadow-sm' : 'text-gray-700 hover:text-orange-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('owner.rentals.report*') ? 'bg-orange-100 text-orange-700' : 'text-gray-400 group-hover:text-orange-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                      </svg>
                    </div>
                    Daftar Motor Disewa
                  </a>
                </li>

                <!-- Total Pendapatan -->
                <li>
                  <a href="{{ route('owner.revenue.total') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('owner.revenue.total*') ? 'bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 shadow-sm' : 'text-gray-700 hover:text-emerald-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('owner.revenue.total*') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-400 group-hover:text-emerald-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                    </div>
                    Total Pendapatan
                  </a>
                </li>
              </ul>
            </li>
            </li>
          </ul>
          </li>
          </ul>
          </li>

          <!-- Account Section -->
          <li class="mt-auto">
            <div class="border-t border-gray-200 pt-4 px-2">
              <!-- User Info Card dengan Dropdown -->
              <div x-data="{ accountOpen: false }" class="relative">
                <button @click="accountOpen = !accountOpen" class="w-full bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-3 mb-3 hover:from-gray-100 hover:to-gray-200 transition-all duration-200">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-sm">
                        <span class="text-sm font-bold text-white">{{ substr(Auth::user()->nama ?? 'U', 0, 1) }}</span>
                      </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                      <div class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->nama ?? 'User' }}</div>
                      <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'user@example.com' }}</div>
                      <div class="text-xs text-gray-500 flex items-center mt-1">
                        <div class="h-2 w-2 bg-green-400 rounded-full mr-1.5"></div>
                        Pemilik Motor
                      </div>
                    </div>
                  </div>
                </button>

                <!-- Dropdown Menu - Positioned ABOVE the button -->
                <div x-show="accountOpen"
                  x-transition:enter="transition ease-out duration-100"
                  x-transition:enter-start="transform opacity-0 scale-95"
                  x-transition:enter-end="transform opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-75"
                  x-transition:leave-start="transform opacity-100 scale-100"
                  x-transition:leave-end="transform opacity-0 scale-95"
                  class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
                  style="display: none;">

                  <!-- Profile Menu Item -->
                  <a href="{{ route('owner.profile') }}" class="group flex items-center gap-x-3 px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex h-5 w-5 shrink-0 items-center justify-center">
                      <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                    </div>
                    Profil Saya
                  </a>

                  <!-- Settings Menu Item -->
                  <a href="{{ route('owner.settings') }}" class="group flex items-center gap-x-3 px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex h-5 w-5 shrink-0 items-center justify-center">
                      <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                    </div>
                    Pengaturan
                  </a>

                  <div class="border-t border-gray-100 my-1"></div>

                  <!-- Logout Menu Item -->
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group flex w-full items-center gap-x-3 px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-700 hover:bg-red-50 transition-colors duration-200">
                      <div class="flex h-5 w-5 shrink-0 items-center justify-center">
                        <svg class="h-4 w-4 text-gray-400 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                      </div>
                      Keluar
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden">
      <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

      <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
          <div x-show="sidebarOpen" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-full top-0 flex w-16 justify-center pt-5">
            <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
              <span class="sr-only">Close sidebar</span>
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Mobile sidebar content -->
          <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
              <h1 class="text-2xl font-bold text-primary-600">RideNow</h1>
              <span class="ml-2 text-sm text-gray-500">Owner</span>
            </div>

            <nav class="flex flex-1 flex-col">
              <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                  <ul role="list" class="-mx-2 space-y-1">
                    <!-- Mobile navigation items -->
                    <li>
                      <a href="{{ route('owner.dashboard') }}" @click="sidebarOpen = false"
                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('owner.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('owner.dashboard') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('owner.motors.index') }}" @click="sidebarOpen = false"
                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('owner.motors.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('owner.motors.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Kelola Motor
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('owner.rentals') }}" @click="sidebarOpen = false"
                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('owner.rentals*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('owner.rentals*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Kelola Penyewaan
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('owner.revenue') }}" @click="sidebarOpen = false"
                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('owner.revenue*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('owner.revenue*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Laporan Pendapatan
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- Mobile Account Section -->
                <li class="mt-auto">
                  <div class="border-t border-gray-200 pt-4">
                    <!-- Profile Links for Mobile -->
                    <div class="space-y-1">
                      <a href="{{ route('owner.profile') }}" @click="sidebarOpen = false" class="group flex items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-medium text-gray-700 hover:text-primary-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil Saya
                      </a>

                      <a href="{{ route('owner.settings') }}" @click="sidebarOpen = false" class="group flex items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-medium text-gray-700 hover:text-primary-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan
                      </a>

                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex w-full items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-medium text-gray-700 hover:text-red-700 hover:bg-red-50">
                          <svg class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                          </svg>
                          Keluar
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="lg:pl-72">
      <!-- Mobile menu button -->
      <div class="lg:hidden flex items-center justify-start p-4">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>

      <!-- Page content -->
      <main class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  @stack('scripts')
</body>

</html>