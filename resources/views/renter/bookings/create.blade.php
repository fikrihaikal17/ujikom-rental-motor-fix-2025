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
            <p class="text-xs text-gray-500 mt-2">
              * Harga otomatis disesuaikan dengan durasi
            </p>
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

          <!-- Hidden input for automatic duration type calculation -->
          <input type="hidden" name="tipe_durasi" id="tipe_durasi" value="harian">

          <!-- Tariff Information Display -->
          @if($motor->tarifRental)
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="text-sm font-medium text-blue-900 mb-2">Informasi Tarif</h4>
            <div class="space-y-1 text-sm text-blue-700">
              @if($motor->tarifRental->tarif_harian)
              <p>• <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span> per hari</p>
              @endif
              @if($motor->tarifRental->tarif_mingguan)
              <p>• <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span> per minggu (7 hari)</p>
              @endif
              @if($motor->tarifRental->tarif_bulanan)
              <p>• <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</span> per bulan (30 hari)</p>
              @endif
            </div>
            <p class="text-xs text-blue-600 mt-2">
              Sistem akan otomatis menentukan tarif terbaik berdasarkan durasi penyewaan Anda
            </p>
          </div>
          @endif

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

<!-- Motor Rate Data -->
@php
$tarifHarian = $motor->tarifRental ? $motor->tarifRental->tarif_harian : 0;
$tarifMingguan = $motor->tarifRental ? $motor->tarifRental->tarif_mingguan : 0;
$tarifBulanan = $motor->tarifRental ? $motor->tarifRental->tarif_bulanan : 0;
@endphp

<script>
  window.motorRates = {
    daily: {{ $tarifHarian ?? 0 }},
    weekly: {{ $tarifMingguan ?? 0 }},
    monthly: {{ $tarifBulanan ?? 0 }}
  };
</script>

<!-- JavaScript for Price Calculation -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('tanggal_mulai');
    const endDateInput = document.getElementById('tanggal_selesai');
    const durationDisplay = document.getElementById('duration-display');
    const rateDisplay = document.getElementById('rate-display');
    const totalPriceDisplay = document.getElementById('total-price');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const loadingText = document.getElementById('loading-text');
    const form = document.querySelector('form');

    // Tariff rates from motor 
    const rates = window.motorRates || {
      daily: 25000,
      weekly: 150000,
      monthly: 625000
    };

    const tipeDurasiInput = document.getElementById('tipe_durasi');

    function validateForm() {
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;

      const isValid = startDate && endDate && new Date(endDate) > new Date(startDate);
      submitBtn.disabled = !isValid;

      return isValid;
    }

    function calculatePrice() {
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);

      if (!startDateInput.value || !endDateInput.value) {
        durationDisplay.textContent = '-';
        rateDisplay.textContent = '-';
        totalPriceDisplay.textContent = 'Rp 0';
        tipeDurasiInput.value = 'harian';
        validateForm();
        return;
      }

      if (endDate <= startDate) {
        durationDisplay.textContent = '-';
        rateDisplay.textContent = '-';
        totalPriceDisplay.textContent = 'Rp 0';
        tipeDurasiInput.value = 'harian';
        validateForm();
        return;
      }

      // Calculate number of days
      const diffTime = Math.abs(endDate - startDate);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      let totalPrice, rateText, durationType, durationText;

      // Calculate optimal pricing combination
      if (diffDays >= 30 && rates.monthly > 0) {
        // Calculate months + remaining days
        const months = Math.floor(diffDays / 30);
        const remainingDays = diffDays % 30;

        // Calculate weekly option for remaining days if beneficial
        if (remainingDays >= 7 && rates.weekly > 0) {
          const weeks = Math.floor(remainingDays / 7);
          const finalRemainingDays = remainingDays % 7;

          const monthlyPrice = months * rates.monthly;
          const weeklyPrice = weeks * rates.weekly;
          const dailyPrice = finalRemainingDays * rates.daily;

          totalPrice = monthlyPrice + weeklyPrice + dailyPrice;

          if (weeks > 0 && finalRemainingDays > 0) {
            durationText = `${diffDays} hari (${months} bulan + ${weeks} minggu + ${finalRemainingDays} hari)`;
            rateText = `Bulanan + Mingguan + Harian`;
          } else if (weeks > 0) {
            durationText = `${diffDays} hari (${months} bulan + ${weeks} minggu)`;
            rateText = `Bulanan + Mingguan`;
          } else {
            durationText = `${diffDays} hari (${months} bulan + ${finalRemainingDays} hari)`;
            rateText = `Bulanan + Harian`;
          }
        } else {
          // Just monthly + daily
          const monthlyPrice = months * rates.monthly;
          const dailyPrice = remainingDays * rates.daily;
          totalPrice = monthlyPrice + dailyPrice;

          if (remainingDays > 0) {
            durationText = `${diffDays} hari (${months} bulan + ${remainingDays} hari)`;
            rateText = `Bulanan + Harian`;
          } else {
            durationText = `${diffDays} hari (${months} bulan)`;
            rateText = `Rp ${rates.monthly.toLocaleString('id-ID')}/bulan`;
          }
        }
        durationType = 'bulanan';
      } else if (diffDays >= 7 && rates.weekly > 0) {
        // Calculate weeks + remaining days
        const weeks = Math.floor(diffDays / 7);
        const remainingDays = diffDays % 7;

        const weeklyPrice = weeks * rates.weekly;
        const dailyPrice = remainingDays * rates.daily;
        const totalPriceWithWeekly = weeklyPrice + dailyPrice;

        // Compare with pure daily pricing
        const pureDaily = diffDays * rates.daily;

        if (totalPriceWithWeekly <= pureDaily) {
          totalPrice = totalPriceWithWeekly;
          if (remainingDays > 0) {
            durationText = `${diffDays} hari (${weeks} minggu + ${remainingDays} hari)`;
            rateText = `Mingguan + Harian`;
          } else {
            durationText = `${diffDays} hari (${weeks} minggu)`;
            rateText = `Rp ${rates.weekly.toLocaleString('id-ID')}/minggu`;
          }
          durationType = 'mingguan';
        } else {
          // Pure daily is better
          totalPrice = pureDaily;
          durationText = `${diffDays} hari`;
          rateText = `Rp ${rates.daily.toLocaleString('id-ID')}/hari`;
          durationType = 'harian';
        }
      } else {
        // Daily pricing only
        totalPrice = diffDays * rates.daily;
        durationText = `${diffDays} hari`;
        rateText = `Rp ${rates.daily.toLocaleString('id-ID')}/hari`;
        durationType = 'harian';
      }

      // Update display
      durationDisplay.textContent = durationText;
      rateDisplay.textContent = rateText;
      totalPriceDisplay.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
      tipeDurasiInput.value = durationType;

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