@extends('layouts.sidebar')

@section('title', 'Entry Transaksi Pembayaran')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Entry Transaksi Pembayaran</h1>
      <p class="mt-2 text-sm text-gray-700">Tambah transaksi pembayaran baru ke dalam sistem.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>
  </div>
</div>

<!-- Error Messages -->
@if($errors->any())
<div class="mb-4 rounded-md bg-red-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
      <div class="mt-2 text-sm text-red-700">
        <ul class="list-disc pl-5 space-y-1">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Payment Entry Form -->
<div class="bg-white shadow rounded-lg">
  <div class="px-4 py-5 sm:p-6">
    <form method="POST" action="{{ route('admin.payments.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
        <!-- Penyewaan -->
        <div class="sm:col-span-2">
          <label for="penyewaan_id" class="block text-sm font-medium text-gray-700">Penyewaan</label>
          <select id="penyewaan_id" name="penyewaan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            <option value="">Pilih Penyewaan</option>
            @if(isset($penyewaans))
            @foreach($penyewaans as $penyewaan)
            <option value="{{ $penyewaan->id }}" {{ old('penyewaan_id') == $penyewaan->id ? 'selected' : '' }}>
              {{ $penyewaan->kode_booking }} - {{ $penyewaan->user->nama }} ({{ $penyewaan->motor->merk }} {{ $penyewaan->motor->model }})
            </option>
            @endforeach
            @endif
          </select>
          @error('penyewaan_id')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Transaction ID -->
        <div>
          <label for="transaction_id" class="block text-sm font-medium text-gray-700">ID Transaksi</label>
          <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id', 'TRX-' . time()) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          @error('transaction_id')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Amount -->
        <div>
          <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <span class="text-gray-500 sm:text-sm">Rp</span>
            </div>
            <input type="number" id="amount" name="amount" value="{{ old('amount') }}" required min="0" step="1000" class="mt-1 block w-full pl-12 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="0">
          </div>
          @error('amount')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Payment Method -->
        <div>
          <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
          <select id="payment_method" name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            <option value="">Pilih Metode Pembayaran</option>
            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="ewallet" {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
          </select>
          @error('payment_method')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Payment Status -->
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
          <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Berhasil</option>
            <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
          </select>
          @error('status')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Payment Date -->
        <div>
          <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
          <input type="datetime-local" id="payment_date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          @error('payment_date')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Reference Number -->
        <div>
          <label for="reference_number" class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
          <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Nomor referensi dari bank/payment gateway">
          @error('reference_number')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Payment Proof -->
        <div class="sm:col-span-2">
          <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <div class="flex text-sm text-gray-600">
                <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                  <span>Upload file</span>
                  <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*,.pdf">
                </label>
                <p class="pl-1">atau drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
            </div>
          </div>
          @error('payment_proof')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Notes -->
        <div class="sm:col-span-2">
          <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
          <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Catatan tambahan tentang pembayaran ini...">{{ old('notes') }}</textarea>
          @error('notes')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Form Actions -->
      <div class="mt-6 flex items-center justify-end space-x-4">
        <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Batal
        </a>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Simpan Pembayaran
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white shadow rounded-lg">
  <div class="px-4 py-5 sm:p-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
      <a href="{{ route('admin.penyewaan.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        Lihat Penyewaan
      </a>
      <a href="{{ route('admin.payments.report') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a4 4 0 01-4-4V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Laporan Pembayaran
      </a>
      <a href="{{ route('admin.bagi-hasil.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
        History Bagi Hasil
      </a>
    </div>
  </div>
</div>

<script>
  // Auto-calculate amount based on selected penyewaan
  document.getElementById('penyewaan_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
      // In real implementation, you would fetch the amount via AJAX
      // For now, just clear the amount field
      document.getElementById('amount').focus();
    }
  });

  // File upload preview
  document.getElementById('payment_proof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const fileInfo = document.createElement('p');
      fileInfo.className = 'text-sm text-gray-600 mt-2';
      fileInfo.textContent = `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

      // Remove existing file info
      const existingInfo = document.querySelector('.file-info');
      if (existingInfo) {
        existingInfo.remove();
      }

      fileInfo.className += ' file-info';
      e.target.parentNode.parentNode.parentNode.appendChild(fileInfo);
    }
  });
</script>
@endsection