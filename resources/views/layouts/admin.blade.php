<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? 'Dashboard' }} - RideNow</title>

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
        <div class="flex h-16 shrink-0 items-center">
          <h1 class="text-2xl font-bold text-primary-600">RideNow</h1>
          <span class="ml-2 text-sm text-gray-500">Admin Panel</span>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Dashboard -->
                <li>
                  <a href="{{ route('admin.dashboard') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.dashboard class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Dashboard
                  </a>
                </li>

                <!-- Manajemen Pengguna -->
                <li>
                  <a href="{{ route('admin.users.index') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.users class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Manajemen Pengguna
                  </a>
                </li>

                <!-- Verifikasi Motor -->
                <li>
                  <a href="{{ route('admin.motors.verification') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.motors.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.motor class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.motors.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Verifikasi Motor
                  </a>
                </li>

                <!-- Manajemen Transaksi -->
                <li>
                  <a href="{{ route('admin.transactions.index') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.transactions.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.credit-card class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.transactions.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Manajemen Transaksi
                  </a>
                </li>

                <!-- Laporan Keuangan -->
                <li>
                  <a href="{{ route('admin.reports.financial') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.reports.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.chart class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.reports.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Laporan Keuangan
                  </a>
                </li>

                <!-- Pengaturan Sistem -->
                <li>
                  <a href="{{ route('admin.settings.index') }}"
                    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-50' }}">
                    <x-icons.cog class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" />
                    Pengaturan Sistem
                  </a>
                </li>
              </ul>
            </li>

            <!-- Profile & Logout -->
            <li class="mt-auto">
              <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center px-2">
                  <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                      <span class="text-sm font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                    </div>
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-medium text-gray-700">{{ auth()->user()->nama }}</div>
                    <div class="text-xs text-gray-500">Administrator</div>
                  </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                  @csrf
                  <button type="submit" class="group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-primary-700 hover:bg-gray-50">
                    <x-icons.logout class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-700" />
                    Logout
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>

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
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>
</body>

</html>