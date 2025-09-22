<!-- Admin Sidebar Menu -->
<div class="space-y-1">
  <!-- Dashboard -->
  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.dashboard') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v8l4-4 4 4V5"></path>
    </svg>
    Dashboard
  </a>

  <!-- Users Management -->
  <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.users.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
    </svg>
    Kelola Pengguna
  </a>

  <!-- Motor Verification -->
  <a href="{{ route('admin.motors.index') }}" class="{{ request()->routeIs('admin.motors.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.motors.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Verifikasi Motor
  </a>

  <!-- Tarif Management -->
  <a href="{{ route('admin.tarif.index') }}" class="{{ request()->routeIs('admin.tarif.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.tarif.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
    </svg>
    Kelola Tarif
  </a>

  <!-- Transactions -->
  <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.transaksi.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    Transaksi
  </a>

  <!-- Settings -->
  <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="{{ request()->routeIs('admin.settings.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
    Pengaturan
  </a>
</div>