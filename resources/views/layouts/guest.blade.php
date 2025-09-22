<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Masuk') - RideNow</title>

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
            'primary': {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#60a5fa',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a'
            }
          },
          fontFamily: {
            'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
          }
        }
      }
    }
  </script>

  <!-- Additional CSS to ensure styles load -->
  <style>
    body {
      font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
    }

    .text-primary {
      color: #2563eb;
    }

    .bg-primary {
      background-color: #2563eb;
    }

    .border-primary {
      border-color: #2563eb;
    }

    .hover\:bg-primary-dark:hover {
      background-color: #1d4ed8;
    }

    .text-primary-600 {
      color: #2563eb;
    }

    .hover\:text-primary-500:hover {
      color: #3b82f6;
    }

    .bg-primary-600 {
      background-color: #2563eb;
    }

    .hover\:bg-primary-700:hover {
      background-color: #1d4ed8;
    }

    .focus\:border-primary-500:focus {
      border-color: #3b82f6;
    }

    .focus\:ring-primary-100:focus {
      --tw-ring-color: rgba(59, 130, 246, 0.1);
      --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
      --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);
      box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    }

    .focus\:ring-primary-500:focus {
      --tw-ring-color: rgba(59, 130, 246, 0.5);
    }

    .from-primary-500 {
      --tw-gradient-from: #3b82f6;
    }

    .to-primary-700 {
      --tw-gradient-to: #1d4ed8;
    }

    .bg-gradient-to-br {
      background-image: linear-gradient(to bottom right, var(--tw-gradient-from), var(--tw-gradient-to));
    }

    /* Mobile responsiveness */
    @media (max-width: 1023px) {
      .hidden.lg\\:block {
        display: none !important;
      }

      .lg\\:flex-none {
        flex: 1 1 0%;
      }
    }
  </style>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full">
  <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-5xl w-full">
      <div class="flex">
        <!-- Left Column - Form -->
        <div class="w-1/2 p-8 lg:p-12">
          <div class="max-w-sm mx-auto">
            @yield('content')

            <!-- Footer -->
            <div class="mt-6 pt-4 border-t border-gray-200">
              <div class="text-center text-xs text-gray-500">
                @if(request()->routeIs('login'))
                <div class="mb-3">
                  <p class="text-sm text-gray-600 mb-2">Belum Punya Akun?</p>
                  <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-all duration-300">
                    Register
                  </a>
                </div>
                @elseif(request()->routeIs('register'))
                <div class="mb-3">
                  <p class="text-sm text-gray-600 mb-2">Sudah Punya Akun?</p>
                  <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-all duration-300">
                    Login
                  </a>
                </div>
                @endif
                <p>&copy; 2025 RideNow. Semua hak cipta dilindungi.</p>
                <div class="mt-1 space-x-3">
                  <a href="#" class="text-gray-400 hover:text-gray-600">Bantuan</a>
                  <a href="#" class="text-gray-400 hover:text-gray-600">Syarat & Ketentuan</a>
                  <a href="#" class="text-gray-400 hover:text-gray-600">Privasi</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column - Welcome Section -->
        <div class="w-1/2 bg-gradient-to-br from-primary-500 to-primary-700 flex flex-col justify-center items-center text-white p-8 relative overflow-hidden">
          <!-- Background Icons -->
          <div class="absolute inset-0 opacity-10">
            <!-- Motorcycle Icons -->
            <svg class="absolute top-10 left-10 w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9l-5 4.87L18.18 21 12 17.77 5.82 21 7 13.87 2 9l6.91-.74L12 2z" />
            </svg>
            <svg class="absolute top-20 right-16 w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
            </svg>
            <svg class="absolute bottom-16 left-8 w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9l-5 4.87L18.18 21 12 17.77 5.82 21 7 13.87 2 9l6.91-.74L12 2z" />
            </svg>
            <svg class="absolute bottom-10 right-12 w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M9 11H7l1.5-4.5h3L9 11zm4 0h2l-1.5-4.5h-3L12 11zm-5 1h8l1 4H7l1-4z" />
            </svg>
            <svg class="absolute top-32 right-8 w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
            </svg>
          </div>

          <div class="text-center relative z-10">
            <!-- Motor Icon -->
            <div class="flex justify-center mb-4">
              <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12,2A2,2 0 0,1 14,4V8H16.5C17.05,8 17.5,8.17 17.86,8.47L20.14,10.74C20.5,11.1 20.72,11.54 20.72,12C20.72,12.8 20.36,13.54 19.78,14L18,15.78V17C18,18.1 17.1,19 16,19H14V17H16V16.22L17.78,14.44C18.14,14.08 18.33,13.62 18.33,13.11C18.33,12.89 18.28,12.67 18.19,12.47L16.5,10.78C16.22,10.5 15.86,10.33 15.5,10.33H14V12H12V4A2,2 0 0,1 12,2M10,5V7H8V9H6V11H4V13H2V15H4V13H6V15H8V13H10V11H12V9H10V7H8V5H10M6,17A2,2 0 0,1 8,19A2,2 0 0,1 6,21A2,2 0 0,1 4,19A2,2 0 0,1 6,17M18,17A2,2 0 0,1 20,19A2,2 0 0,1 18,21A2,2 0 0,1 16,19A2,2 0 0,1 18,17Z" />
              </svg>
            </div>

            <h1 class="text-4xl font-bold mb-3">RideNow</h1>
            <p class="text-sm mb-6 opacity-90 leading-tight">Sewa motor online terpercaya</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>