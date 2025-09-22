@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        Selamat datang kembali, {{ auth()->user()->name }}!
                    </h3>
                    <div class="mt-1 text-sm text-primary-100">
                        Kelola seluruh sistem RideNow dengan mudah dari dashboard admin ini.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Users -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pengguna</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ \App\Models\User::count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-primary-700 hover:text-primary-900">Lihat semua</a>
            </div>
        </div>
    </div>

    <!-- Total Motors -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Motor</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Motor::count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-primary-700 hover:text-primary-900">Lihat semua</a>
            </div>
        </div>
    </div>

    <!-- Pending Verifications -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Verifikasi</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Motor::where('status', 'pending')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-primary-700 hover:text-primary-900">Verifikasi sekarang</a>
            </div>
        </div>
    </div>

    <!-- Revenue This Month -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pendapatan Bulan Ini</dt>
                        <dd class="text-lg font-medium text-gray-900">Rp {{ number_format(\App\Models\Transaksi::whereMonth('created_at', now()->month)->sum('jumlah')) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-primary-700 hover:text-primary-900">Lihat detail</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 gap-5 lg:grid-cols-2 mb-8">
    <!-- Charts Section -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Statistik Penyewaan</h3>
                    <div class="flex space-x-2">
                        <button onclick="updateChart('today')" class="filter-btn px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500" data-period="today">
                            Hari Ini
                        </button>
                        <button onclick="updateChart('week')" class="filter-btn px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500" data-period="week">
                            Minggu Ini
                        </button>
                        <button onclick="updateChart('month')" class="filter-btn px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 bg-primary-50 text-primary-700" data-period="month">
                            Bulan Ini
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="rentalChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
    <!-- Recent Activity -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aktivitas Terbaru</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    @foreach(\App\Models\User::latest()->take(3)->get() as $user)
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Pengguna baru <a href="#" class="font-medium text-gray-900">{{ $user->name }}</a> mendaftar sebagai {{ $user->role }}</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6">
                <a href="#" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Lihat semua aktivitas
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Kelola Pengguna</p>
                        <p class="text-sm text-gray-500">Lihat & edit pengguna</p>
                    </div>
                </a>

                <a href="#" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Verifikasi Motor</p>
                        <p class="text-sm text-gray-500">Approve motor baru</p>
                    </div>
                </a>

                <a href="#" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Kelola Tarif</p>
                        <p class="text-sm text-gray-500">Set harga sewa</p>
                    </div>
                </a>

                <a href="#" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Laporan</p>
                        <p class="text-sm text-gray-500">Lihat analitik</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rentalChart').getContext('2d');
    let rentalChart;

    // Data untuk grafik
    const chartData = {
        today: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
            data: [
                0, 0, 0, 0, 0, 0 // Static data for demo purposes
            ],
            title: 'Penyewaan Hari Ini (Per 4 Jam)'
        },
        week: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            data: [
                0, 0, 0, 0, 0, 0, 0 // Static data for demo purposes
            ],
            title: 'Penyewaan Minggu Ini (Per Hari)'
        },
        month: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            data: [
                0, 0, 0, 0 // Static data for demo purposes
            ],
            title: 'Penyewaan Bulan Ini (Per Minggu)'
        }
    };

    function initChart() {
        rentalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.month.labels,
                datasets: [{
                    label: 'Jumlah Penyewaan',
                    data: chartData.month.data,
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: chartData.month.title,
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    function updateChart(period) {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-primary-50', 'text-primary-700');
        });
        document.querySelector(`[data-period="${period}"]`).classList.add('bg-primary-50', 'text-primary-700');

        // Update chart data
        rentalChart.data.labels = chartData[period].labels;
        rentalChart.data.datasets[0].data = chartData[period].data;
        rentalChart.options.plugins.title.text = chartData[period].title;
        rentalChart.update();
    }

    // Initialize chart when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initChart();
    });
</script>
@endsection