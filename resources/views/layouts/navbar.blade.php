<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') - RideNow</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#60a5fa',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              800: '#1e3a8a',
              900: '#1e3a8a',
            }
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50">
  <div class="min-h-screen">
    <!-- Navigation -->
    <nav x-data="{ open: false }" class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo and main nav -->
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
              </svg>
              <span class="ml-2 text-xl font-bold text-gray-900">RideNow</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              @yield('navbar-menu')
            </div>
          </div>

          <!-- Right side -->
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <!-- Search -->
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <input type="text" placeholder="Cari motor..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
            </div>

            <!-- Notifications -->
            <button class="ml-3 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
              <span class="sr-only">View notifications</span>
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5-5 5h5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div x-data="{ open: false }" class="ml-3 relative">
              <div>
                <button @click="open = !open" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                  <span class="sr-only">Open user menu</span>
                  <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                  </div>
                </button>
              </div>

              <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                  <div class="font-medium">{{ auth()->user()->nama }}</div>
                  <div class="text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
              </div>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button @click="open = !open" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
              <span class="sr-only">Open main menu</span>
              <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div x-show="open" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          @yield('mobile-menu')
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                <span class="text-sm font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
              </div>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">{{ auth()->user()->nama }}</div>
              <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Settings</a>
            <form method="POST" action="{{ route('logout') }}" class="block">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page content -->
    <main>
      @yield('content')
    </main>
  </div>
</body>

</html>