@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden shadow-xl rounded-xl">
        <div class="px-6 py-8 sm:p-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-white bg-opacity-20 backdrop-blur-sm">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-6 w-0 flex-1">
                    <h3 class="text-2xl leading-7 font-bold text-white">
                        Selamat datang kembali, {{ Auth::user()->nama }}!
                    </h3>
                    <div class="mt-2 text-blue-100 text-lg">
                        Kelola seluruh sistem RideNow dengan mudah dari dashboard admin ini.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-semibold text-gray-600 truncate">Total Pengguna</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-3 border-t border-blue-100">
            <div class="text-sm">
                <a href="{{ route('admin.users.index') }}" class="font-medium text-blue-700 hover:text-blue-900 transition-colors duration-200">Lihat semua</a>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-semibold text-gray-600 truncate">Total Motor</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $totalMotors }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-3 border-t border-green-100">
            <div class="text-sm">
                <a href="{{ route('admin.motors.index') }}" class="font-medium text-green-700 hover:text-green-900 transition-colors duration-200">Lihat semua</a>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-semibold text-gray-600 truncate">Menunggu Verifikasi</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $pendingMotors }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-3 border-t border-yellow-100">
            <div class="text-sm">
                <a href="{{ route('admin.motors.index') }}" class="font-medium text-yellow-700 hover:text-yellow-900 transition-colors duration-200">Verifikasi sekarang</a>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-semibold text-gray-600 truncate">Pendapatan Bulan Ini</dt>
                        <dd class="text-2xl font-bold text-gray-900">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</dd>
                        @if($completedBookingsThisMonth > 0)
                        <p class="text-xs text-gray-500 mt-1">Dari {{ $completedBookingsThisMonth }} booking selesai</p>
                        @else
                        <p class="text-xs text-gray-500 mt-1">Belum ada booking selesai bulan ini</p>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-3 border-t border-purple-100">
            <div class="text-sm">
                <a href="{{ route('admin.laporan.revenue') }}" class="font-medium text-purple-700 hover:text-purple-900 transition-colors duration-200">Lihat detail</a>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-600 truncate">Booking Selesai Bulan Ini</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $completedBookingsThisMonth }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-600 truncate">Booking Aktif</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $activeBookings }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-600 truncate">Total Pendapatan</dt>
                        <dd class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Pengguna Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @if($recentUsers->count() > 0)
                @foreach($recentUsers as $user)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ substr($user->nama ?? $user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->nama ?? $user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($user->role->value) }}
                        </span>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-gray-500 text-center py-4">Belum ada pengguna</p>
                @endif
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    Lihat semua pengguna
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Motor Pending</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @if($pendingMotorsList->count() > 0)
                @foreach($pendingMotorsList as $motor)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        @if($motor->photo)
                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($motor->photo) }}" alt="{{ $motor->merk }}">
                        @else
                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $motor->merk }} {{ $motor->model ?? $motor->nama_motor }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $motor->no_plat ?? $motor->plat_nomor }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-gray-500 text-center py-4">Tidak ada motor pending</p>
                @endif
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.motors.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    Lihat semua motor
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection