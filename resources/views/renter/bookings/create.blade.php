@extends('layouts.renter')

@section('title', 'Booking Motor')

@section('content')
<div class="container mx-auto px-4 py-6">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center mb-4">
      <a href="{{ route('renter.motors.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Booking Motor</h1>
        <p class="text-gray-600">Isi detail booking untuk motor {{ $motor->merk }} {{ $motor->model }}</p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Motor Information -->
    <div class="lg:col-span-1">
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="aspect-w-16 aspect-h-9">
          <img src="{{ $motor->photo ? asset('storage/' . $motor->photo) : asset('images/motor-placeholder.png') }}"
            alt="{{ $motor->merk }} {{ $motor->model }}"
            class="w-full h-48 object-cover">
        </div>
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-900">{{ $motor->merk }} {{ $motor->model }}</h3>
          <p class="text-sm text-gray-600 mb-2">{{ $motor->tahun }} • {{ $motor->tipe_cc }}cc</p>
          <p class="text-sm text-gray-600 mb-3">Plat: {{ $motor->no_plat }}</p>

          @if($motor->deskripsi)
          <div class="border-t pt-3">
            <h4 class="text-sm font-medium text-gray-900 mb-1">Deskripsi</h4>
            <p class="text-sm text-gray-600">{{ $motor->deskripsi }}</p>
          </div>
          @endif

          <!-- Tariff Information -->
          @if($motor->tarifRental)
          <div class="border-t pt-3 mt-3">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Tarif Rental</h4>
            <div class="space-y-1">
              @if($motor->tarifRental->tarif_harian)
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Harian:</span>
                <span class="font-medium">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span>
              </div>
              @endif
              @if($motor->tarifRental->tarif_mingguan)
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Mingguan:</span>
                <span class="font-medium">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span>
              </div>
              @endif
              @if($motor->tarifRental->tarif_bulanan)
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Bulanan:</span>
                <span class="font-medium">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</span>
              </div>
              @endif
            </div>
          </div>
          @endif

          <!-- Owner Info -->
          <div class="border-t pt-3 mt-3">
            <h4 class="text-sm font-medium text-gray-900 mb-1">Pemilik</h4>
            <p class="text-sm text-gray-600">{{ $motor->owner->nama }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Booking Form -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Detail Booking</h3>
        </div>

        <form action="{{ route('renter.bookings.store') }}" method="POST" class="p-6 space-y-6">
          @csrf
          <input type="hidden" name="motor_id" value="{{ $motor->id }}">

          <!-- Duration Type -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Durasi</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              @if($motor->tarifRental && $motor->tarifRental->tarif_harian)
              <label class="relative">
                <input type="radio" name="tipe_durasi" value="harian" class="sr-only peer" required
                  data-price="{{ $motor->tarifRental->tarif_harian }}">
                <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                  <div class="text-center">
                    <div class="text-sm font-medium text-gray-900">Harian</div>
                    <div class="text-xs text-gray-500 mt-1">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}/hari</div>
                  </div>
                </div>
              </label>
              @endif

              @if($motor->tarifRental && $motor->tarifRental->tarif_mingguan)
              <label class="relative">
                <input type="radio" name="tipe_durasi" value="mingguan" class="sr-only peer"
                  data-price="{{ $motor->tarifRental->tarif_mingguan }}">
                <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                  <div class="text-center">
                    <div class="text-sm font-medium text-gray-900">Mingguan</div>
                    <div class="text-xs text-gray-500 mt-1">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}/minggu</div>
                  </div>
                </div>
              </label>
              @endif

              @if($motor->tarifRental && $motor->tarifRental->tarif_bulanan)
              <label class="relative">
                <input type="radio" name="tipe_durasi" value="bulanan" class="sr-only peer"
                  data-price="{{ $motor->tarifRental->tarif_bulanan }}">
                <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                  <div class="text-center">
                    <div class="text-sm font-medium text-gray-900">Bulanan</div>
                    <div class="text-xs text-gray-500 mt-1">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}/bulan</div>
                  </div>
                </div>
              </label>
              @endif
            </div>
            @error('tipe_durasi')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Date Range -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', now()->format('Y-m-d')) }}"
                min="{{ now()->format('Y-m-d') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_mulai') border-red-300 @enderror"
                required>
              @error('tanggal_mulai')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
              <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                min="{{ now()->addDay()->format('Y-m-d') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_selesai') border-red-300 @enderror"
                required>
              @error('tanggal_selesai')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Notes -->
          <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="catatan" id="catatan" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              placeholder="Tambahkan catatan untuk pemilik motor...">{{ old('catatan') }}</textarea>
            @error('catatan')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Price Calculation -->
          <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Ringkasan Biaya</h4>
            <div class="space-y-2">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Durasi:</span>
                <span id="duration-display" class="font-medium">-</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tarif per unit:</span>
                <span id="rate-display" class="font-medium">-</span>
              </div>
              <div class="border-t border-gray-200 pt-2">
                <div class="flex justify-between text-base font-medium">
                  <span class="text-gray-900">Total:</span>
                  <span id="total-price" class="text-blue-600">Rp 0</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end space-x-3">
            <a href="{{ route('renter.motors.index') }}"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
              Batal
            </a>
            <button type="submit" id="submit-btn"
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
              <span id="submit-text">Buat Booking</span>
              <span id="loading-text" class="hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Price Calculation -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const durationRadios = document.querySelectorAll('input[name="tipe_durasi"]');
    const startDateInput = document.getElementById('tanggal_mulai');
    const endDateInput = document.getElementById('tanggal_selesai');
    const durationDisplay = document.getElementById('duration-display');
    const rateDisplay = document.getElementById('rate-display');
    const totalPriceDisplay = document.getElementById('total-price');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const loadingText = document.getElementById('loading-text');
    const form = document.querySelector('form');

    function validateForm() {
      const selectedDuration = document.querySelector('input[name="tipe_durasi"]:checked');
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;

      const isValid = selectedDuration && startDate && endDate && new Date(endDate) > new Date(startDate);
      submitBtn.disabled = !isValid;

      return isValid;
    }

    function calculatePrice() {
      const selectedDuration = document.querySelector('input[name="tipe_durasi"]:checked');
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);

      if (!selectedDuration || !startDateInput.value || !endDateInput.value) {
        durationDisplay.textContent = '-';
        rateDisplay.textContent = '-';
        totalPriceDisplay.textContent = 'Rp 0';
        validateForm();
        return;
      }

      if (endDate <= startDate) {
        durationDisplay.textContent = '-';
        rateDisplay.textContent = '-';
        totalPriceDisplay.textContent = 'Rp 0';
        validateForm();
        return;
      }

      const diffTime = Math.abs(endDate - startDate);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      const pricePerUnit = parseFloat(selectedDuration.dataset.price);
      const durationType = selectedDuration.value;

      let duration, totalPrice;

      switch (durationType) {
        case 'harian':
          duration = diffDays;
          totalPrice = duration * pricePerUnit;
          durationDisplay.textContent = `${duration} hari`;
          rateDisplay.textContent = `Rp ${pricePerUnit.toLocaleString('id-ID')}`;
          break;
        case 'mingguan':
          duration = Math.ceil(diffDays / 7);
          totalPrice = duration * pricePerUnit;
          durationDisplay.textContent = `${duration} minggu`;
          rateDisplay.textContent = `Rp ${pricePerUnit.toLocaleString('id-ID')}`;
          break;
        case 'bulanan':
          duration = Math.ceil(diffDays / 30);
          totalPrice = duration * pricePerUnit;
          durationDisplay.textContent = `${duration} bulan`;
          rateDisplay.textContent = `Rp ${pricePerUnit.toLocaleString('id-ID')}`;
          break;
      }

      totalPriceDisplay.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
      validateForm();
    }

    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
      const startDate = new Date(this.value);
      const nextDay = new Date(startDate);
      nextDay.setDate(startDate.getDate() + 1);
      endDateInput.min = nextDay.toISOString().split('T')[0];

      if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
        endDateInput.value = nextDay.toISOString().split('T')[0];
      }

      calculatePrice();
    });

    // Add event listeners
    durationRadios.forEach(radio => {
      radio.addEventListener('change', calculatePrice);
    });

    endDateInput.addEventListener('change', calculatePrice);

    // Form submission handling
    form.addEventListener('submit', function(e) {
      if (!validateForm()) {
        e.preventDefault();
        return;
      }

      submitBtn.disabled = true;
      submitText.classList.add('hidden');
      loadingText.classList.remove('hidden');
    });

    // Initial calculation and validation
    calculatePrice();
  });
</script>
@endsection