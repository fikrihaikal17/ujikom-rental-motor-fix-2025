<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pemilik - RideNow</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Dashboard Pemilik Motor</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">{{ auth()->user()->nama }}</span>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm">
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- Welcome Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Selamat datang, {{ auth()->user()->nama }}!
            </h3>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
              <p>
                Kelola motor Anda dan pantau pendapatan dari penyewaan. Daftarkan motor baru dan lihat statistik penyewaan.
              </p>
            </div>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
          <!-- Motor Terdaftar -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-primary-500 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                      <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Motor Terdaftar</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ $totalMotors }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Motor Tersewa -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Sedang Disewa</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ $activeMotoRentals }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Pendapatan Bulan Ini -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Pendapatan Bulan Ini</dt>
                    <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Pendapatan -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-900 truncate">Total Pendapatan</dt>
                    <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aksi Cepat</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Kelola motor dan pendapatan Anda</p>
          </div>
          <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
              <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path>
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Daftarkan Motor Baru</p>
                    <p class="text-sm text-gray-500">Tambahkan motor untuk disewakan</p>
                  </div>
                </div>
              </a>

              <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                      <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Kelola Motor</p>
                    <p class="text-sm text-gray-500">Lihat dan edit motor Anda</p>
                  </div>
                </div>
              </a>

              <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Laporan Pendapatan</p>
                    <p class="text-sm text-gray-500">Lihat detail pendapatan Anda</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Recent Rentals -->
        @if($recentRentals->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md mt-6">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Penyewaan Terbaru</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">5 penyewaan terbaru dari motor Anda</p>
          </div>
          <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
              @foreach($recentRentals as $rental)
              <li class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                          <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
                        </svg>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ $rental->motor->merk }} {{ $rental->motor->model }}
                      </div>
                      <div class="text-sm text-gray-500">
                        Disewa oleh {{ $rental->penyewa->nama }}
                      </div>
                    </div>
                  </div>
                  <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-900">
                      <span class="px-2 py-1 text-xs font-medium rounded-full 
                        @if($rental->status->value === 'active') bg-green-100 text-green-800
                        @elseif($rental->status->value === 'completed') bg-blue-100 text-blue-800
                        @elseif($rental->status->value === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($rental->status->value) }}
                      </span>
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ $rental->tanggal_mulai->format('d M Y') }}
                    </div>
                    <div class="text-sm font-medium text-gray-900">
                      Rp {{ number_format($rental->harga, 0, ',', '.') }}
                    </div>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif

        <!-- Monthly Revenue Chart -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md mt-6">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Grafik Pendapatan 6 Bulan Terakhir</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Pendapatan bulanan dari bagi hasil penyewaan</p>
          </div>
          <div class="border-t border-gray-200 p-6">
            <div class="grid grid-cols-6 gap-4">
              @php $maxRevenue = collect($monthlyRevenueChart)->max('revenue') ?: 1; @endphp
              @foreach($monthlyRevenueChart as $data)
              <div class="text-center">
                <div class="mb-2">
                  <div class="w-full bg-gray-200 rounded-full h-32 flex items-end">
                    @php $percentage = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 0; @endphp
                    <div class="bg-primary-500 rounded-full w-full transition-all duration-500" 
                         style="height: {{ max(5, $percentage) }}%"></div>
                  </div>
                </div>
                <div class="text-xs text-gray-600 font-medium">{{ $data['month'] }}</div>
                <div class="text-xs text-gray-500 mt-1">
                  Rp {{ number_format($data['revenue'], 0, ',', '.') }}
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>