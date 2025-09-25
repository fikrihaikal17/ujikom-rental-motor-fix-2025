<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RideNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .smooth-scroll {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen smooth-scroll">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="flex items-center space-x-2">
                        <div class="bg-primary-600 rounded-lg p-2">
                            <i class="fas fa-motorcycle text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">RideNow</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('help') }}" class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('help') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <i class="fas fa-question-circle mr-2"></i>Bantuan
                    </a>
                    <a href="{{ route('terms') }}" class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('terms') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <i class="fas fa-file-contract mr-2"></i>Syarat & Ketentuan
                    </a>
                    <a href="{{ route('privacy') }}" class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('privacy') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <i class="fas fa-shield-alt mr-2"></i>Kebijakan Privasi
                    </a>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Daftar
                        </a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                                <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium">{{ auth()->user()->nama }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-200">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-600 hover:text-gray-800" x-data="{ open: false }" @click="open = !open">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" x-data="{ mobileOpen: false }">
            <div x-show="mobileOpen" class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                <a href="{{ route('help') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-question-circle mr-2"></i>Bantuan
                </a>
                <a href="{{ route('terms') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-file-contract mr-2"></i>Syarat & Ketentuan
                </a>
                <a href="{{ route('privacy') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-shield-alt mr-2"></i>Kebijakan Privasi
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-primary-600 rounded-lg p-2">
                            <i class="fas fa-motorcycle text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">RideNow</span>
                    </div>
                    <p class="text-gray-600 mb-4 max-w-md">
                        Platform rental motor terpercaya yang menghubungkan pemilik motor dengan penyewa di seluruh Indonesia. Aman, mudah, dan terpercaya.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
                        Quick Links
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('help') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                                Bantuan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                                Syarat & Ketentuan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                                Kebijakan Privasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                                Login
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <a href="mailto:support@ridenow.com" class="text-gray-600 hover:text-primary-600 transition-colors">
                                support@ridenow.com
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fab fa-whatsapp text-gray-400 mr-3"></i>
                            <a href="https://wa.me/6285189094514" class="text-gray-600 hover:text-primary-600 transition-colors">
                                +62 851 8909 4514
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <span class="text-gray-600">24/7 Customer Support</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm">
                        &copy; 2025 RideNow. Semua hak cipta dilindungi.
                    </p>
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="{{ route('help') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">
                            Bantuan
                        </a>
                        <a href="{{ route('terms') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">
                            Syarat & Ketentuan
                        </a>
                        <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">
                            Privasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>