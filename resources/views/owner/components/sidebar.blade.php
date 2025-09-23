<!-- Owner Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200">
  <!-- Logo -->
  <div class="flex items-center justify-center h-16 border-b border-gray-200">
    <h1 class="text-2xl font-bold text-blue-600">RideNow</h1>
    <span class="ml-2 text-sm text-gray-500">Owner</span>
  </div>

  <!-- User Info -->
  <div class="p-4 border-b border-gray-200">
    <div class="flex items-center">
      <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
        <span class="text-white font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
        <p class="text-xs text-gray-500">Pemilik Motor</p>
      </div>
    </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="mt-4 px-4">
    <div class="space-y-2">
      <!-- Dashboard -->
      <a href="{{ route('owner.dashboard') }}"
        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('owner.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v8l4-4 4 4V5"></path>
        </svg>
        Dashboard
      </a>

      <!-- Motor Management -->
      <div class="space-y-1">
        <div class="flex items-center px-3 py-2 text-sm font-medium text-gray-900">
          <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
          Kelola Motor
        </div>
        <div class="ml-8 space-y-1">
          <a href="{{ route('owner.motors.index') }}"
            class="flex items-center px-3 py-2 text-sm rounded-md transition-colors duration-200 {{ request()->routeIs('owner.motors.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            Daftar Motor
          </a>
          <a href="{{ route('owner.motors.create') }}"
            class="flex items-center px-3 py-2 text-sm rounded-md transition-colors duration-200 {{ request()->routeIs('owner.motors.create') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            Tambah Motor
          </a>
        </div>
      </div>

      <!-- Revenue Reports -->
      <a href="{{ route('owner.revenue') }}"
        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('owner.revenue*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Laporan Pendapatan
      </a>

      <!-- Divider -->
      <hr class="my-4 border-gray-200">

      <!-- Settings & Profile -->
      <a href="#"
        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profil
      </a>

      <a href="#"
        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Pengaturan
      </a>

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit"
          class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
          <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
          Keluar
        </button>
      </form>
    </div>
  </nav>
</div>