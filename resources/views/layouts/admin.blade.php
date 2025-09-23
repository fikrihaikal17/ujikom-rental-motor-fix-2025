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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
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
              <i class="fas fa-motorcycle text-white"></i>
            </div>
            <div class="ml-3 text-center">
              <h1 class="text-xl font-bold text-gray-900">RideNow</h1>
              <span class="text-xs text-gray-500 font-medium">Admin Panel</span>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Dashboard -->
                <li>
                  <a href="{{ route('admin.dashboard') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-400 group-hover:text-blue-700' }}">
                      <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                  </a>
                </li>

                <!-- Verifikasi Motor -->
                <li>
                  <a href="{{ route('admin.motors.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.motors.*') ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700 shadow-sm' : 'text-gray-700 hover:text-green-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.motors.*') ? 'bg-green-100 text-green-700' : 'text-gray-400 group-hover:text-green-700' }}">
                      <i class="fas fa-check-circle"></i>
                    </div>
                    Verifikasi Motor
                  </a>
                </li>

                <!-- Verifikasi Penyewaan -->
                <li>
                  <a href="{{ route('admin.penyewaan.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.penyewaan.*') ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 shadow-sm' : 'text-gray-700 hover:text-purple-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.penyewaan.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-400 group-hover:text-purple-700' }}">
                      <i class="fas fa-clipboard-check"></i>
                    </div>
                    Verifikasi Penyewaan
                  </a>
                </li>

                <!-- Kelola Transaksi -->
                <li>
                  <a href="{{ route('admin.transaksi.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.transaksi.*') ? 'bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 shadow-sm' : 'text-gray-700 hover:text-amber-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.transaksi.*') ? 'bg-amber-100 text-amber-700' : 'text-gray-400 group-hover:text-amber-700' }}">
                      <i class="fas fa-money-bill-wave"></i>
                    </div>
                    Kelola Transaksi
                  </a>
                </li>

                <!-- Kelola Pengguna -->
                <li>
                  <a href="{{ route('admin.users.index') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-400 group-hover:text-indigo-700' }}">
                      <i class="fas fa-users"></i>
                    </div>
                    Kelola Pengguna
                  </a>
                </li>
              </ul>
            </li>

            <!-- Laporan Section -->
            <li>
              <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider mb-2">Laporan</div>
              <ul role="list" class="-mx-2 space-y-1">
                <!-- Laporan Motor -->
                <li>
                  <a href="{{ route('admin.laporan.motor') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.motor') ? 'bg-gradient-to-r from-red-50 to-red-100 text-red-700 shadow-sm' : 'text-gray-700 hover:text-red-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.laporan.motor') ? 'bg-red-100 text-red-700' : 'text-gray-400 group-hover:text-red-700' }}">
                      <i class="fas fa-chart-bar"></i>
                    </div>
                    Laporan Motor
                  </a>
                </li>

                <!-- Laporan Revenue -->
                <li>
                  <a href="{{ route('admin.laporan.revenue') }}"
                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.revenue') ? 'bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 shadow-sm' : 'text-gray-700 hover:text-teal-700 hover:bg-gray-50' }}">
                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.laporan.revenue') ? 'bg-teal-100 text-teal-700' : 'text-gray-400 group-hover:text-teal-700' }}">
                      <i class="fas fa-dollar-sign"></i>
                    </div>
                    Laporan Revenue
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden">
      <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/80" @click="sidebarOpen = false"></div>

      <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
          x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
          x-transition:leave="transition ease-in-out duration-300 transform"
          x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
          class="relative mr-16 flex w-full max-w-xs flex-1">

          <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
            <!-- Mobile Logo -->
            <div class="flex h-20 shrink-0 items-center justify-center border-b border-gray-100">
              <div class="flex items-center">
                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                  <i class="fas fa-motorcycle text-white"></i>
                </div>
                <div class="ml-3">
                  <h1 class="text-xl font-bold text-gray-900">RideNow</h1>
                  <span class="text-xs text-gray-500 font-medium">Admin Panel</span>
                </div>
              </div>
            </div>

            <!-- Mobile Navigation (same as desktop) -->
            <nav class="flex flex-1 flex-col">
              <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                  <ul role="list" class="-mx-2 space-y-1">
                    <li><a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold text-gray-700 hover:text-blue-700 hover:bg-gray-50"><i class="fas fa-tachometer-alt w-6 text-gray-400"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.motors.index') }}" @click="sidebarOpen = false" class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold text-gray-700 hover:text-green-700 hover:bg-gray-50"><i class="fas fa-check-circle w-6 text-gray-400"></i>Verifikasi Motor</a></li>
                    <li><a href="{{ route('admin.penyewaan.index') }}" @click="sidebarOpen = false" class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold text-gray-700 hover:text-purple-700 hover:bg-gray-50"><i class="fas fa-clipboard-check w-6 text-gray-400"></i>Verifikasi Penyewaan</a></li>
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
          <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden"></div>

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <!-- Page title -->
            <h1 class="text-xl font-semibold leading-6 text-gray-900">@yield('title', 'Dashboard')</h1>
          </div>

          <div class="flex items-center gap-x-4 lg:gap-x-6 ml-auto">
            <!-- Notifications -->
            <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
              <span class="sr-only">View notifications</span>
              <i class="fas fa-bell text-lg"></i>
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