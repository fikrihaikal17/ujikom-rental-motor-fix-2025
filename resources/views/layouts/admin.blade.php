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
              <span class="text-xs text-gray-500 font-medium">Admin Panel</span>
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
                  <a href="{{ route('admin.dashboard') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-400 group-hover:text-blue-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                      </svg>
                    </div>
                    Dashboard
                  </a>
                </li>

                <!-- Kelola Pengguna -->
                <li>
                  <a href="{{ route('admin.users.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700 shadow-sm' : 'text-gray-700 hover:text-green-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-green-100 text-green-700' : 'text-gray-400 group-hover:text-green-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                      </svg>
                    </div>
                    Kelola Pengguna
                  </a>
                </li>

                <!-- Verifikasi Motor -->
                <li>
                  <a href="{{ route('admin.motors.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.motors.*') ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 shadow-sm' : 'text-gray-700 hover:text-purple-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.motors.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-400 group-hover:text-purple-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                      </svg>
                    </div>
                    Verifikasi Motor
                  </a>
                </li>

                <!-- Kelola Tarif -->
                <li>
                  <a href="{{ route('admin.tarif.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.tarif.*') ? 'bg-gradient-to-r from-yellow-50 to-yellow-100 text-yellow-700 shadow-sm' : 'text-gray-700 hover:text-yellow-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.tarif.*') ? 'bg-yellow-100 text-yellow-700' : 'text-gray-400 group-hover:text-yellow-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                      </svg>
                    </div>
                    Kelola Tarif
                  </a>
                </li>

                <!-- Transaksi -->
                <li>
                  <a href="{{ route('admin.transaksi.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.transaksi.*') ? 'bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.transaksi.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-400 group-hover:text-indigo-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                      </svg>
                    </div>
                    Transaksi
                  </a>
                </li>
              </ul>
            </li>

            <li class="mt-6">
              <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider mb-2">Laporan</div>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Daftar Motor Disewa -->
                <li>
                  <a href="{{ route('admin.laporan.motors') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.motors') ? 'bg-gradient-to-r from-red-50 to-red-100 text-red-700 shadow-sm' : 'text-gray-700 hover:text-red-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.laporan.motors') ? 'bg-red-100 text-red-700' : 'text-gray-400 group-hover:text-red-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                    </div>
                    Daftar Motor Disewa
                  </a>
                </li>

                <!-- Total Pendapatan -->
                <li>
                  <a href="{{ route('admin.laporan.revenue') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.revenue') ? 'bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 shadow-sm' : 'text-gray-700 hover:text-teal-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.laporan.revenue') ? 'bg-teal-100 text-teal-700' : 'text-gray-400 group-hover:text-teal-700' }}">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                      </svg>
                    </div>
                    Total Pendapatan
                  </a>
                </li>
              </ul>
            </li>

            <!-- Profile & User Info -->
            <li class="mt-auto">
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center">
                      <span class="text-sm font-bold text-white">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                    </div>
                  </div>
                  <div class="ml-3 min-w-0 flex-1">
                    <div class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->nama }}</div>
                    <div class="text-xs text-gray-500">Administrator</div>
                  </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                  @csrf
                  <button type="submit" class="group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-red-700 hover:bg-red-50 transition-all duration-200">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-gray-400 group-hover:text-red-700">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                      </svg>
                    </div>
                    Logout
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    </li>
    </ul>
    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state.">
      <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

      <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
          <div x-show="sidebarOpen" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-full top-0 flex w-16 justify-center pt-5">
            <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
              <span class="sr-only">Close sidebar</span>
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- Mobile sidebar content (same as desktop) -->
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
                  <span class="text-xs text-gray-500 font-medium">Admin Panel</span>
                </div>
              </div>
            </div>

            <!-- Mobile Navigation (same structure as desktop) -->
            <nav class="flex flex-1 flex-col px-4 py-6">
              <!-- Same navigation menu items as desktop -->
              <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                  class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }}">
                  <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-400 group-hover:text-blue-700' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                  </div>
                  Dashboard
                </a>
                <!-- Add other mobile nav items if needed -->
              </div>
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

<!-- Mobile sidebar -->
<div x-show="sidebarOpen" class="relative z-50 lg:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state.">
  <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

  <div class="fixed inset-0 flex">
    <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
      <div x-show="sidebarOpen" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-full top-0 flex w-16 justify-center pt-5">
        <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
          <span class="sr-only">Close sidebar</span>
          <x-icons.x-mark class="h-6 w-6 text-white" />
        </button>
      </div>

      <!-- Mobile sidebar content (same as desktop but with click to close) -->
      <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
          <h1 class="text-2xl font-bold text-primary-600">RideNow</h1>
          <span class="ml-2 text-sm text-gray-500">Admin</span>
        </div>

        <nav class="flex flex-1 flex-col">
          <!-- Same navigation as desktop -->
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li>
                  <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.dashboard class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Dashboard
                  </a>
                </li>
                <!-- Add other mobile nav items similarly -->
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<div class="lg:pl-72">
  <!-- Top bar -->
  <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
      <span class="sr-only">Open sidebar</span>
      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>

    <!-- Separator -->
    <div class="h-6 w-px bg-gray-200 lg:hidden"></div>

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
      <div class="flex items-center gap-x-4 lg:gap-x-6">
        <!-- Page title -->
        <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
      </div>

      <div class="flex items-center gap-x-4 lg:gap-x-6 ml-auto">
        <!-- Notifications -->
        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
        </button>

        <!-- Current time -->
        <div class="hidden sm:block text-sm text-gray-500">
          {{ now()->format('d M Y, H:i') }}
        </div>
      </div>
    </div>
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