@extends('layouts.fullpage')

@section('title', 'Bantuan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <!-- Header -->
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pusat Bantuan</h1>
    <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
  </div>

  <!-- Quick Help Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
      <div class="flex items-center mb-4">
        <div class="bg-blue-500 rounded-full p-3">
          <i class="fas fa-user-plus text-white text-xl"></i>
        </div>
        <h3 class="ml-3 text-lg font-semibold text-blue-900">Cara Daftar</h3>
      </div>
      <p class="text-blue-700 text-sm mb-4">Pelajari cara mendaftar sebagai penyewa atau pemilik motor</p>
      <button onclick="showSection('register')" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
        Pelajari →
      </button>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
      <div class="flex items-center mb-4">
        <div class="bg-green-500 rounded-full p-3">
          <i class="fas fa-motorcycle text-white text-xl"></i>
        </div>
        <h3 class="ml-3 text-lg font-semibold text-green-900">Sewa Motor</h3>
      </div>
      <p class="text-green-700 text-sm mb-4">Panduan lengkap cara menyewa motor dengan mudah</p>
      <button onclick="showSection('rent')" class="text-green-600 hover:text-green-800 font-medium text-sm">
        Pelajari →
      </button>
    </div>

    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
      <div class="flex items-center mb-4">
        <div class="bg-purple-500 rounded-full p-3">
          <i class="fas fa-key text-white text-xl"></i>
        </div>
        <h3 class="ml-3 text-lg font-semibold text-purple-900">Jadi Owner</h3>
      </div>
      <p class="text-purple-700 text-sm mb-4">Cara mendaftarkan motor Anda untuk disewakan</p>
      <button onclick="showSection('owner')" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
        Pelajari →
      </button>
    </div>
  </div>

  <!-- Main Content -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Login Help Section -->
    <div id="login-section" class="p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-sign-in-alt text-blue-500 mr-3"></i>
        Panduan Login
      </h2>
      
      <div class="space-y-6">
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Cara Login ke Akun Anda</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
              <li>Masukkan <strong>email</strong> yang Anda gunakan saat registrasi</li>
              <li>Masukkan <strong>password</strong> yang benar</li>
              <li>Centang "Remember Me" jika ingin tetap login</li>
              <li>Klik tombol <strong>"Masuk"</strong></li>
            </ol>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Jenis Akun</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
              <h4 class="font-semibold text-blue-900">Admin</h4>
              <p class="text-sm text-blue-700 mt-1">Mengelola seluruh sistem dan transaksi</p>
            </div>
            <div class="border border-green-200 rounded-lg p-4 bg-green-50">
              <h4 class="font-semibold text-green-900">Owner</h4>
              <p class="text-sm text-green-700 mt-1">Pemilik motor yang menyewakan</p>
            </div>
            <div class="border border-orange-200 rounded-lg p-4 bg-orange-50">
              <h4 class="font-semibold text-orange-900">Renter</h4>
              <p class="text-sm text-orange-700 mt-1">Penyewa motor</p>
            </div>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Trouble Login?</h3>
          <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
              <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
              <div>
                <h4 class="font-semibold text-yellow-800">Jika Anda tidak bisa login:</h4>
                <ul class="list-disc list-inside mt-2 text-yellow-700 space-y-1">
                  <li>Pastikan email dan password benar</li>
                  <li>Periksa koneksi internet Anda</li>
                  <li>Hapus cache browser</li>
                  <li>Hubungi admin jika masih bermasalah</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Register Section -->
    <div id="register-section" class="p-6 border-b border-gray-200 hidden">
      <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-user-plus text-green-500 mr-3"></i>
        Cara Mendaftar
      </h2>
      
      <div class="space-y-6">
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Langkah Registrasi</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
              <li>Klik tombol <strong>"Daftar"</strong> di halaman login</li>
              <li>Isi <strong>nama lengkap</strong> Anda</li>
              <li>Masukkan <strong>email</strong> yang valid</li>
              <li>Buat <strong>password</strong> yang kuat (minimal 8 karakter)</li>
              <li>Konfirmasi password</li>
              <li>Pilih role: <strong>Owner</strong> (pemilik motor) atau <strong>Renter</strong> (penyewa)</li>
              <li>Klik <strong>"Daftar"</strong></li>
            </ol>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Persyaratan</h3>
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <ul class="list-disc list-inside space-y-1 text-blue-700">
              <li>Email yang belum terdaftar</li>
              <li>Password minimal 8 karakter</li>
              <li>Nama sesuai KTP untuk verifikasi</li>
              <li>Nomor telepon yang aktif</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Rent Section -->
    <div id="rent-section" class="p-6 border-b border-gray-200 hidden">
      <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-motorcycle text-orange-500 mr-3"></i>
        Cara Sewa Motor
      </h2>
      
      <div class="space-y-6">
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Proses Penyewaan</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
              <li>Login sebagai <strong>Renter</strong></li>
              <li>Browse motor yang tersedia</li>
              <li>Pilih motor dan tanggal sewa</li>
              <li>Isi form booking dengan lengkap</li>
              <li>Upload KTP dan SIM</li>
              <li>Lakukan pembayaran</li>
              <li>Tunggu konfirmasi owner</li>
              <li>Motor siap diambil!</li>
            </ol>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Dokumen yang Diperlukan</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-red-200 rounded-lg p-4 bg-red-50">
              <h4 class="font-semibold text-red-900">KTP</h4>
              <p class="text-sm text-red-700 mt-1">Kartu Tanda Penduduk yang masih berlaku</p>
            </div>
            <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
              <h4 class="font-semibold text-blue-900">SIM C</h4>
              <p class="text-sm text-blue-700 mt-1">Surat Izin Mengemudi kelas C</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Owner Section -->
    <div id="owner-section" class="p-6 hidden">
      <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-key text-purple-500 mr-3"></i>
        Jadi Pemilik Motor
      </h2>
      
      <div class="space-y-6">
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Cara Mendaftarkan Motor</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
              <li>Login sebagai <strong>Owner</strong></li>
              <li>Masuk ke menu <strong>"Motor Saya"</strong></li>
              <li>Klik <strong>"Tambah Motor"</strong></li>
              <li>Isi detail motor (merk, model, tahun, dll)</li>
              <li>Upload foto motor (minimal 3 foto)</li>
              <li>Upload STNK</li>
              <li>Set harga sewa per hari</li>
              <li>Tunggu verifikasi admin</li>
            </ol>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Keuntungan Jadi Owner</h3>
          <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <ul class="list-disc list-inside space-y-1 text-green-700">
              <li>Passive income dari motor yang menganggur</li>
              <li>Sistem pembayaran yang aman</li>
              <li>Asuransi untuk motor saat disewa</li>
              <li>Dashboard lengkap untuk monitoring</li>
              <li>Customer support 24/7</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Support -->
  <div class="mt-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white text-center">
    <h3 class="text-xl font-bold mb-2">Masih Butuh Bantuan?</h3>
    <p class="mb-4">Tim support kami siap membantu Anda 24/7</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="mailto:support@ridenow.com" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors">
        <i class="fas fa-envelope mr-2"></i>support@ridenow.com
      </a>
      <a href="https://wa.me/6285189094514" class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors">
        <i class="fab fa-whatsapp mr-2"></i>WhatsApp Support
      </a>
    </div>
  </div>

  <!-- Back to Login -->
  <div class="mt-6 text-center">
    <a href="{{ route('login') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
      <i class="fas fa-arrow-left mr-2"></i>
      Kembali ke Login
    </a>
  </div>
</div>

<script>
function showSection(sectionName) {
  // Hide all sections
  const sections = ['login-section', 'register-section', 'rent-section', 'owner-section'];
  sections.forEach(section => {
    document.getElementById(section).classList.add('hidden');
  });
  
  // Show selected section
  document.getElementById(sectionName + '-section').classList.remove('hidden');
  
  // Scroll to section
  document.getElementById(sectionName + '-section').scrollIntoView({ 
    behavior: 'smooth',
    block: 'start' 
  });
}
</script>

@endsection