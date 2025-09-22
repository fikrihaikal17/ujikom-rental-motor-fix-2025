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

<body class="bg-gray-100">
  <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
      <div class="flex items-center justify-center h-16 bg-primary-600">
        <div class="flex items-center">
          <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
          </svg>
          <span class="ml-2 text-xl font-bold text-white">RideNow</span>
        </div>
      </div>

      <nav class="mt-5 px-2">
        @hasSection('sidebar-menu')
        @yield('sidebar-menu')
        @else
        {{-- Default admin sidebar for authenticated admin users --}}
        @if(auth()->check() && auth()->user()->role->value === 'admin')
        @include('components.admin-sidebar')
        @endif
        @endif
      </nav>
    </div>

    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"></div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top bar -->
      <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between h-16 px-4">
          <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 lg:hidden">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
            <h1 class="ml-4 text-xl font-semibold text-gray-900 lg:ml-0">@yield('page-title', 'Dashboard')</h1>
          </div>

          <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="text-gray-500 hover:text-gray-700">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5-5 5h5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </button>

            <!-- User menu -->
            <div x-data="{ open: false }" class="relative">
              <button @click="open = !open" class="flex items-center text-sm rounded-full text-gray-500 hover:text-gray-700 focus:outline-none">
                <span class="mr-2">{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>

              <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
        <div class="container mx-auto px-6 py-8">
          @yield('content')
        </div>
      </main>
    </div>
  </div>
</body>

</html>