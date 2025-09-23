@extends('layouts.sidebar')

@section('title', 'Detail Motor')

@section('content') <div class="space-y-3">
  <div>
    <label class="text-sm font-medium text-gray-500">Nama Pemilik</label>
    <p class="text-gray-900">{{ $motor->owner->nama }}</p>
  </div>
  <div>
    <label class="text-sm font-medium text-gray-500">Email</label>
    <p class="text-gray-900">{{ $motor->owner->email }}</p>
  </div>
  <div>
    <label class="text-sm font-medium text-gray-500">No. Telepon</label>
    <p class="text-gray-900">{{ $motor->owner->no_tlpn ?? '-' }}</p>
  </div>
  <div>
    <label class="text-sm font-medium text-gray-500">Bergabung Sejak</label>
    <p class="text-gray-900">{{ $motor->owner->created_at->format('d M Y') }}</p>
  </div>
  <div class="mb-8">
    <div class="flex items-center">
      <a href="{{ route('admin.motors.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Detail Motor</h1>
        <p class="text-gray-600">Verifikasi dan kelola data motor</p>
      </div>
    </div>
  </div>

  <!-- Motor Information Card -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Motor Info -->
    <div class="lg:col-span-2">
      <div class="bg-white shadow-lg rounded-xl border border-gray-100 mb-8">
        <!-- Status Header -->
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Status Verifikasi</h2>
            <span class="px-3 py-1 rounded-full text-sm font-medium
            @if($motor->verified_at)
              bg-green-100 text-green-800
            @else
              bg-yellow-100 text-yellow-800
            @endif">
              @if($motor->verified_at)
              Terverifikasi
              @else
              Menunggu Verifikasi
              @endif
            </span>
          </div>
        </div>

        <!-- Motor Details -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Motor</h3>
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-500">Nama Motor</label>
                  <p class="text-gray-900">{{ $motor->nama_motor }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Merk</label>
                  <p class="text-gray-900">{{ $motor->merk }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Model</label>
                  <p class="text-gray-900">{{ $motor->model }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Tipe CC</label>
                  <p class="text-gray-900">{{ $motor->tipe_cc }} CC</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Nomor Plat</label>
                  <p class="text-gray-900">{{ $motor->no_plat }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Tahun</label>
                  <p class="text-gray-900">{{ $motor->tahun }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Warna</label>
                  <p class="text-gray-900">{{ $motor->warna }}</p>
                </div>
              </div>
            </div>

            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemilik</h3>
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-500">Nama Pemilik</label>
                  <p class="text-gray-900">{{ $motor->owner->nama }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Email</label>
                  <p class="text-gray-900">{{ $motor->owner->email }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                  <p class="text-gray-900">{{ $motor->owner->no_tlpn ?? '-' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Bergabung</label>
                  <p class="text-gray-900">{{ $motor->owner->created_at->format('d M Y') }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Description -->
          @if($motor->deskripsi)
          <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
            <p class="text-gray-700 leading-relaxed">{{ $motor->deskripsi }}</p>
          </div>
          @endif

          <!-- Verification Status -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Verifikasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-500">Status</label>
                <p class="text-gray-900">
                  @if($motor->verified_at)
                  Terverifikasi pada {{ $motor->verified_at->format('d M Y H:i') }}
                  @else
                  Belum diverifikasi
                  @endif
                </p>
              </div>
              @if($motor->verified_by)
              <div>
                <label class="text-sm font-medium text-gray-500">Diverifikasi oleh</label>
                <p class="text-gray-900">{{ $motor->verifiedBy->nama ?? 'Admin' }}</p>
              </div>
              @endif
            </div>

            @if($motor->admin_notes)
            <div class="mt-4">
              <label class="text-sm font-medium text-gray-500">Catatan Admin</label>
              <p class="text-gray-700 mt-1">{{ $motor->admin_notes }}</p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Action Sidebar -->
    <div class="lg:col-span-1">
      <div class="bg-white shadow-lg rounded-xl border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>

        <div class="space-y-4">
          @if(!$motor->verified_at)
          <form action="{{ route('admin.motors.verify', $motor) }}" method="POST" class="w-full space-y-4">
            @csrf
            @method('PATCH')

            <!-- Tarif Input -->
            <div class="space-y-3">
              <h4 class="text-sm font-semibold text-gray-900">Set Tarif Rental</h4>

              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tarif Harian (Rp)</label>
                <input type="number" name="tarif_harian"
                  value="{{ $motor->tarifRental->tarif_harian ?? 75000 }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  min="0" required>
              </div>

              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tarif Mingguan (Rp)</label>
                <input type="number" name="tarif_mingguan"
                  value="{{ $motor->tarifRental->tarif_mingguan ?? 450000 }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  min="0" required>
              </div>

              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tarif Bulanan (Rp)</label>
                <input type="number" name="tarif_bulanan"
                  value="{{ $motor->tarifRental->tarif_bulanan ?? 1875000 }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  min="0" required>
              </div>

              <!-- Revenue Sharing Section -->
              <div class="space-y-3 pt-4 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900">Pengaturan Bagi Hasil</h4>

                @if($motor->requested_owner_percentage)
                <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mb-3">
                  <p class="text-xs font-medium text-blue-800 mb-1">Request Pemilik:</p>
                  <p class="text-xs text-blue-700">{{ $motor->requested_owner_percentage }}% untuk pemilik</p>
                  @if($motor->revenue_sharing_notes)
                  <p class="text-xs text-blue-600 mt-1 italic">"{{ $motor->revenue_sharing_notes }}"</p>
                  @endif
                </div>
                @endif

                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Persentase Pemilik (%)</label>
                    <input type="number" name="owner_percentage"
                      value="{{ $motor->requested_owner_percentage ?? 70 }}"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                      min="50" max="90" step="5" required>
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Persentase Admin (%)</label>
                    <input type="number" name="admin_percentage"
                      value="{{ $motor->requested_owner_percentage ? (100 - $motor->requested_owner_percentage) : 30 }}"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                      min="10" max="50" step="5" required>
                  </div>
                </div>
                <p class="text-xs text-gray-500">Total harus 100%. Recommended: 70% pemilik, 30% admin.</p>
              </div>

              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea name="notes" rows="3"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  placeholder="Catatan verifikasi...">{{ $motor->admin_notes }}</textarea>
              </div>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
              Verifikasi Motor
            </button>
          </form>
          @else
          <div class="w-full bg-green-100 border border-green-200 text-green-800 px-4 py-2 rounded-lg text-center">
            Motor Sudah Diverifikasi
          </div>
          @endif

          <a href="{{ route('admin.motors.index') }}" class="w-full block text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Kembali ke Daftar Motor
          </a>

          @if(!$motor->verified_at)
          <form action="{{ route('admin.motors.reject', $motor) }}" method="POST" class="w-full space-y-3" id="rejectForm">
            @csrf
            @method('PATCH')

            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Alasan Penolakan</label>
              <textarea name="notes" rows="3"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                placeholder="Berikan alasan mengapa motor ini ditolak..."
                required></textarea>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200"
              onclick="return confirm('Apakah Anda yakin ingin menolak motor ini?')">
              Tolak Motor
            </button>
          </form>
          @endif
        </div>

        <!-- Statistics -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <h4 class="text-md font-semibold text-gray-900 mb-4">Statistik</h4>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Total Penyewaan</span>
              <span class="text-sm font-medium text-gray-900">{{ $motor->penyewaans->count() }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Pendapatan</span>
              <span class="text-sm font-medium text-gray-900">Rp {{ number_format($motor->penyewaans->sum('total_harga'), 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Rating</span>
              <span class="text-sm font-medium text-gray-900">-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-calculate admin percentage when owner percentage changes
      const ownerPercentageInput = document.querySelector('input[name="owner_percentage"]');
      const adminPercentageInput = document.querySelector('input[name="admin_percentage"]');

      if (ownerPercentageInput && adminPercentageInput) {
        ownerPercentageInput.addEventListener('input', function() {
          const ownerPercentage = parseFloat(this.value) || 0;
          const adminPercentage = 100 - ownerPercentage;

          // Ensure admin percentage is within valid range
          if (adminPercentage >= 10 && adminPercentage <= 50) {
            adminPercentageInput.value = adminPercentage;
            adminPercentageInput.style.borderColor = '';
          } else {
            adminPercentageInput.style.borderColor = '#ef4444';
          }
        });

        adminPercentageInput.addEventListener('input', function() {
          const adminPercentage = parseFloat(this.value) || 0;
          const ownerPercentage = 100 - adminPercentage;

          // Ensure owner percentage is within valid range
          if (ownerPercentage >= 50 && ownerPercentage <= 90) {
            ownerPercentageInput.value = ownerPercentage;
            ownerPercentageInput.style.borderColor = '';
          } else {
            ownerPercentageInput.style.borderColor = '#ef4444';
          }
        });
      }
    });
  </script>
  @endsection