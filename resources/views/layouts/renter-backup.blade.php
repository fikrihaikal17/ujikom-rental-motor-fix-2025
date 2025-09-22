<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard Penyewa') - RideNow</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .sidebar-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .sidebar-hover {
      transition: all 0.3s ease;
    }
    
    .sidebar-hover:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
    }
    
    .notification-badge {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
  </style>
</head>
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

<body class="h-full" x-data="{ mobileMenuOpen: false }">
  <div class="min-h-full">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo and primary navigation -->
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-2xl font-bold text-primary-600">RideNow</h1>
            </div>

            <!-- Desktop navigation -->
            <div class="hidden md:ml-8 md:flex md:space-x-8">
              <a href="{{ route('renter.dashboard') }}"
                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('renter.dashboard') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <x-icons.dashboard class="h-5 w-5 mr-2" />
                Dashboard
              </a>

              <a href="{{ route('renter.motors.index') }}"
                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('renter.motors.*') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <x-icons.motor class="h-5 w-5 mr-2" />
                Cari Motor
              </a>

              <a href="{{ route('renter.bookings.index') }}"
                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('renter.bookings.*') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <x-icons.clipboard class="h-5 w-5 mr-2" />
                Riwayat Sewa
              </a>

              <a href="{{ route('renter.transactions.index') }}"
                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('renter.transactions.*') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <x-icons.credit-card class="h-5 w-5 mr-2" />
                Transaksi
              </a>
            </div>
          </div>

          <!-- Right side - user menu and actions -->
          <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
            <!-- Search -->
            <div class="relative">
              <input type="text" placeholder="Cari motor..."
                class="block w-64 rounded-md border-gray-300 pl-10 pr-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-icons.search class="h-5 w-5 text-gray-400" />
              </div>
            </div>

            <!-- Notifications -->
            <button type="button" class="relative p-2 text-gray-400 hover:text-gray-500">
              <span class="sr-only">View notifications</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
              </svg>
              <!-- Notification badge -->
              <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
            </button>

            <!-- Profile dropdown -->
            <div class="relative" x-data="{ open: false }">
              <button type="button" @click="open = !open"
                class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <span class="sr-only">Open user menu</span>
                <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                  <span class="text-sm font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                </div>
                <span class="ml-2 text-sm font-medium text-gray-700">{{ auth()->user()->nama }}</span>
                <svg class="ml-1 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <!-- Dropdown menu -->
              <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                <div class="py-1">
                  <a href="{{ route('renter.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <x-icons.users class="h-4 w-4 mr-2 inline" />
                    Profil Saya
                  </a>
                  <a href="{{ route('renter.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <x-icons.cog class="h-4 w-4 mr-2 inline" />
                    Pengaturan
                  </a>
                  <div class="border-t border-gray-100"></div>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <x-icons.logout class="h-4 w-4 mr-2 inline" />
                      Logout
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden flex items-center">
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
              <span class="sr-only">Open main menu</span>
              <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div x-show="mobileMenuOpen" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
          <a href="{{ route('renter.dashboard') }}"
            class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('renter.dashboard') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
            <x-icons.dashboard class="h-5 w-5 mr-3 inline" />
            Dashboard
          </a>
          <a href="{{ route('renter.motors.index') }}"
            class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('renter.motors.*') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
            <x-icons.motor class="h-5 w-5 mr-3 inline" />
            Cari Motor
          </a>
          <a href="{{ route('renter.bookings.index') }}"
            class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('renter.bookings.*') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
            <x-icons.clipboard class="h-5 w-5 mr-3 inline" />
            Riwayat Sewa
          </a>
          <a href="{{ route('renter.transactions.index') }}"
            class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('renter.transactions.*') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
            <x-icons.credit-card class="h-5 w-5 mr-3 inline" />
            Transaksi
          </a>
        </div>

        <!-- Mobile user section -->
        <div class="pt-4 pb-3 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                <span class="text-lg font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
              </div>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">{{ auth()->user()->nama }}</div>
              <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <a href="{{ route('renter.profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              Profil Saya
            </a>
            <a href="{{ route('renter.settings.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              Pengaturan
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Header (if provided) -->
    @if(isset($header))
    <header class="bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-sm text-gray-500">
            © {{ date('Y') }} RideNow. Sewa motor online terpercaya.
          </div>
          <div class="flex space-x-4 mt-4 md:mt-0">
            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Bantuan</a>
            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Syarat & Ketentuan</a>
            <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Kebijakan Privasi</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>