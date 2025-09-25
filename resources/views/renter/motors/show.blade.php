@extends('layouts.renter')

@section('title', 'Detail Motor')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Breadcrumb -->
  <nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
      <li><a href="{{ route('renter.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
      <li>/</li>
      <li><a href="{{ route('renter.motors.index') }}" class="hover:text-blue-600">Motor</a></li>
      <li>/</li>
      <li class="text-gray-900">{{ $motor->nama_motor }}</li>
    </ol>
  </nav>

  <!-- Motor Detail Card -->
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="md:flex">
      <!-- Motor Image -->
      <div class="md:w-1/2">
        <div class="h-96 bg-gray-300 flex items-center justify-center">
          @if($motor->photo)
          <img src="{{ asset($motor->photo) }}" alt="{{ $motor->merk }} {{ $motor->model }}"
            class="w-full h-full object-cover">
          @else
          <div class="text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
            </svg>
            <p>Foto Motor</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Motor Info -->
      <div class="md:w-1/2 p-6">
        <div class="mb-4">
          <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $motor->nama_motor }}</h1>
          <div class="flex items-center mb-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($motor->status?->value == 'available') bg-green-100 text-green-800
                            @elseif($motor->status?->value == 'verified') bg-blue-100 text-blue-800
                            @elseif($motor->status?->value == 'rented') bg-red-100 text-red-800
                            @elseif($motor->status?->value == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
              {{ ucfirst($motor->status?->value ?? 'N/A') }}
            </span>
            <span
              class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
              {{ $motor->tipe_cc?->getDisplayName() ?? 'N/A' }}
            </span>
          </div>
        </div>

        <!-- Motor Details -->
        <div class="space-y-3 mb-6">
          <div class="flex justify-between">
            <span class="text-gray-600">Merek:</span>
            <span class="font-medium">{{ $motor->merek }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Tahun:</span>
            <span class="font-medium">{{ $motor->tahun_produksi }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Plat Nomor:</span>
            <span class="font-medium">{{ $motor->plat_nomor }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Warna:</span>
            <span class="font-medium">{{ $motor->warna }}</span>
          </div>
          @if($motor->deskripsi)
          <div class="pt-3 border-t">
            <span class="text-gray-600 block mb-2">Deskripsi:</span>
            <p class="text-gray-800">{{ $motor->deskripsi }}</p>
          </div>
          @endif
        </div>

        <!-- Pricing -->
        @if($motor->tarifRental)
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <h3 class="font-semibold text-lg mb-3">Tarif Rental</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-gray-600">Harian:</span>
              <span class="font-semibold text-blue-600">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',',
                '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Mingguan:</span>
              <span class="font-semibold text-blue-600">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',',
                '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Bulanan:</span>
              <span class="font-semibold text-blue-600">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',',
                '.') }}</span>
            </div>
          </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex space-x-3">
          @if($motor->status?->value == 'available' || $motor->status?->value == 'verified')
          <button onclick="openBookingModal()"
            class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
            Sewa Sekarang
          </button>
          @else
          <button class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed font-medium" disabled>
            Motor Tidak Tersedia
          </button>
          @endif
          <a href="{{ route('renter.motors.index') }}"
            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Booking Motor</h3>
          <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <form action="{{ route('renter.bookings.store') }}" method="POST" id="bookingForm">
          @csrf
          <input type="hidden" name="motor_id" value="{{ $motor->id }}">

          <div class="space-y-4">
            <!-- Tanggal Mulai -->
            <div>
              <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
              <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                min="{{ date('Y-m-d') }}" required onchange="calculatePrice()">
            </div>

            <!-- Tanggal Selesai -->
            <div>
              <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
              <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                min="{{ date('Y-m-d') }}" required onchange="calculatePrice()">
            </div>

            <!-- Tipe Durasi -->
            <div>
              <label for="tipe_durasi" class="block text-sm font-medium text-gray-700 mb-1">Tipe Durasi</label>
              <select id="tipe_durasi" name="tipe_durasi"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required onchange="calculatePrice()">
                <option value="">Pilih Tipe Durasi</option>
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
              </select>
            </div>

            <!-- Total Harga -->
            <div class="bg-gray-50 p-3 rounded-lg">
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Total Harga:</span>
                <span id="totalPrice" class="text-lg font-semibold text-blue-600">Rp 0</span>
              </div>
              <div class="text-sm text-gray-500 mt-1">
                <span id="duration">0 hari</span>
              </div>
            </div>

            <!-- Catatan -->
            <div>
              <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
              <textarea id="catatan" name="catatan" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tambahkan catatan untuk rental ini..."></textarea>
            </div>
          </div>

          <div class="flex space-x-3 mt-6">
            <button type="button" onclick="closeBookingModal()"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
              Batal
            </button>
            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
              Buat Booking
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function openBookingModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  function calculatePrice() {
    const tanggalMulai = document.getElementById('tanggal_mulai').value;
    const tanggalSelesai = document.getElementById('tanggal_selesai').value;
    const tipeDurasi = document.getElementById('tipe_durasi').value;

    if (!tanggalMulai || !tanggalSelesai || !tipeDurasi) {
      document.getElementById('totalPrice').textContent = 'Rp 0';
      document.getElementById('duration').textContent = '0 hari';
      return;
    }

    const startDate = new Date(tanggalMulai);
    const endDate = new Date(tanggalSelesai);
    const timeDiff = endDate - startDate;
    const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

    if (daysDiff <= 0) {
      document.getElementById('totalPrice').textContent = 'Rp 0';
      document.getElementById('duration').textContent = '0 hari';
      return;
    }

    let price = 0;
    let durationText = '';

    @if($motor->tarifRental)
    const tarifHarian = {{ $motor->tarifRental->tarif_harian ?? 0 }};
    const tarifMingguan = {{ $motor->tarifRental->tarif_mingguan ?? 0 }};
    const tarifBulanan = {{ $motor->tarifRental->tarif_bulanan ?? 0 }};

    switch (tipeDurasi) {
      case 'harian':
        price = tarifHarian * daysDiff;
        durationText = daysDiff + ' hari';
        break;
      case 'mingguan':
        const weeks = Math.ceil(daysDiff / 7);
        price = tarifMingguan * weeks;
        durationText = weeks + ' minggu (' + daysDiff + ' hari)';
        break;
      case 'bulanan':
        const months = Math.ceil(daysDiff / 30);
        price = tarifBulanan * months;
        durationText = months + ' bulan (' + daysDiff + ' hari)';
        break;
    }
    @endif

    document.getElementById('totalPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('duration').textContent = durationText;
  }

  // Set minimum date for tanggal_selesai when tanggal_mulai changes
  document.getElementById('tanggal_mulai').addEventListener('change', function() {
    const tanggalMulai = this.value;
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    tanggalSelesai.min = tanggalMulai;

    // Clear tanggal_selesai if it's before tanggal_mulai
    if (tanggalSelesai.value && tanggalSelesai.value < tanggalMulai) {
      tanggalSelesai.value = '';
    }
    calculatePrice();
  });

  // Close modal when clicking outside
  document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeBookingModal();
    }
  });
</script>
@endsection