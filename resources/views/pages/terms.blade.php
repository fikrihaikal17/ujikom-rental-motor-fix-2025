@extends('layouts.fullpage')

@section('title', 'Syarat & Ketentuan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <!-- Header -->
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Syarat & Ketentuan</h1>
    <p class="text-lg text-gray-600">Ketentuan penggunaan platform RideNow</p>
    <p class="text-sm text-gray-500 mt-2">Terakhir diperbarui: 25 September 2025</p>
  </div>

  <!-- Content -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-8 space-y-8">
      
      <!-- 1. Ketentuan Umum -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-gavel text-blue-500 mr-3"></i>
          1. Ketentuan Umum
        </h2>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <p>Dengan menggunakan platform RideNow, Anda menyetujui syarat dan ketentuan berikut:</p>
            <ul class="list-disc list-inside space-y-2 ml-4">
              <li>Platform RideNow adalah layanan intermediasi antara pemilik motor dan penyewa</li>
              <li>Anda harus berusia minimal 18 tahun dan memiliki dokumen yang sah</li>
              <li>Informasi yang Anda berikan harus akurat dan terkini</li>
              <li>Satu orang hanya diperbolehkan memiliki satu akun aktif</li>
              <li>Akun bersifat personal dan tidak dapat dipindahtangankan</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 2. Untuk Penyewa (Renter) -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-user text-green-500 mr-3"></i>
          2. Ketentuan untuk Penyewa (Renter)
        </h2>
        <div class="space-y-6">
          
          <!-- 2.1 Persyaratan Penyewa -->
          <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">2.1 Persyaratan Penyewa</h3>
            <ul class="list-disc list-inside space-y-2 text-green-800 ml-4">
              <li>Memiliki KTP yang masih berlaku</li>
              <li>Memiliki SIM C yang masih berlaku</li>
              <li>Berusia minimal 18 tahun</li>
              <li>Mampu mengoperasikan kendaraan bermotor dengan baik</li>
              <li>Tidak sedang dalam pengaruh alkohol atau obat-obatan</li>
            </ul>
          </div>

          <!-- 2.2 Kewajiban Penyewa -->
          <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">2.2 Kewajiban Penyewa</h3>
            <ul class="list-disc list-inside space-y-2 text-green-800 ml-4">
              <li>Menggunakan motor sesuai dengan peruntukan dan tidak untuk hal ilegal</li>
              <li>Menjaga kondisi motor selama masa sewa</li>
              <li>Mengisi bahan bakar motor saat pengembalian</li>
              <li>Mengembalikan motor tepat waktu dan dalam kondisi baik</li>
              <li>Membayar biaya sewa dan deposit sesuai kesepakatan</li>
              <li>Melaporkan kerusakan atau kecelakaan sesegera mungkin</li>
            </ul>
          </div>

          <!-- 2.3 Larangan untuk Penyewa -->
          <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-3">2.3 Larangan untuk Penyewa</h3>
            <ul class="list-disc list-inside space-y-2 text-red-800 ml-4">
              <li>Menggunakan motor untuk kegiatan ilegal atau melanggar hukum</li>
              <li>Memberikan atau menyewakan motor kepada pihak ketiga</li>
              <li>Memodifikasi atau mengubah kondisi motor tanpa izin</li>
              <li>Menggunakan motor di luar area yang disepakati</li>
              <li>Mengemudi dalam kondisi mabuk atau tidak fit</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 3. Untuk Pemilik Motor (Owner) -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-key text-purple-500 mr-3"></i>
          3. Ketentuan untuk Pemilik Motor (Owner)
        </h2>
        <div class="space-y-6">
          
          <!-- 3.1 Persyaratan Owner -->
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-3">3.1 Persyaratan Pemilik Motor</h3>
            <ul class="list-disc list-inside space-y-2 text-purple-800 ml-4">
              <li>Motor atas nama sendiri dengan STNK yang sah</li>
              <li>Motor dalam kondisi layak jalan dan terawat</li>
              <li>Memiliki asuransi kendaraan yang masih berlaku</li>
              <li>Pajak kendaraan dalam kondisi aktif</li>
              <li>Motor telah lulus verifikasi tim RideNow</li>
            </ul>
          </div>

          <!-- 3.2 Kewajiban Owner -->
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-3">3.2 Kewajiban Pemilik Motor</h3>
            <ul class="list-disc list-inside space-y-2 text-purple-800 ml-4">
              <li>Menyediakan motor dalam kondisi baik dan bersih</li>
              <li>Memberikan informasi yang akurat tentang kondisi motor</li>
              <li>Menanggapi booking request dalam waktu yang wajar</li>
              <li>Menyediakan helm standar untuk penyewa</li>
              <li>Memastikan dokumen motor lengkap dan valid</li>
              <li>Melakukan maintenance berkala pada motor</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 4. Pembayaran dan Finansial -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-credit-card text-yellow-500 mr-3"></i>
          4. Pembayaran dan Finansial
        </h2>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">Ketentuan Pembayaran</h3>
            <ul class="list-disc list-inside space-y-2 ml-4">
              <li>Pembayaran dilakukan melalui sistem RideNow</li>
              <li>Deposit wajib dibayar saat konfirmasi booking</li>
              <li>Biaya sewa dibayar di awal periode sewa</li>
              <li>RideNow mengenakan komisi dari setiap transaksi</li>
              <li>Refund diproses sesuai kebijakan yang berlaku</li>
              <li>Biaya tambahan (kerusakan, keterlambatan) akan dipotong dari deposit</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 5. Asuransi dan Tanggung Jawab -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
          5. Asuransi dan Tanggung Jawab
        </h2>
        <div class="space-y-6">
          
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">5.1 Asuransi</h3>
            <ul class="list-disc list-inside space-y-2 text-blue-800 ml-4">
              <li>Setiap motor yang terdaftar harus memiliki asuransi kendaraan</li>
              <li>RideNow menyediakan asuransi tambahan untuk setiap transaksi</li>
              <li>Klaim asuransi harus dilaporkan maksimal 24 jam setelah kejadian</li>
              <li>Dokumentasi lengkap diperlukan untuk proses klaim</li>
            </ul>
          </div>

          <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">5.2 Tanggung Jawab</h3>
            <ul class="list-disc list-inside space-y-2 text-blue-800 ml-4">
              <li>Penyewa bertanggung jawab penuh selama masa sewa</li>
              <li>Kerusakan akibat kelalaian menjadi tanggung jawab penyewa</li>
              <li>RideNow tidak bertanggung jawab atas kecelakaan lalu lintas</li>
              <li>Kehilangan kendaraan menjadi tanggung jawab penyewa</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 6. Pembatalan dan Pengembalian -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-undo text-orange-500 mr-3"></i>
          6. Pembatalan dan Pengembalian
        </h2>
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <h3 class="text-lg font-semibold text-orange-900 mb-3">Kebijakan Pembatalan</h3>
            <ul class="list-disc list-inside space-y-2 ml-4">
              <li><strong>24 jam sebelum:</strong> Refund 100% (dikurangi biaya admin)</li>
              <li><strong>12-24 jam sebelum:</strong> Refund 75%</li>
              <li><strong>6-12 jam sebelum:</strong> Refund 50%</li>
              <li><strong>Kurang dari 6 jam:</strong> Tidak ada refund</li>
              <li><strong>Force majeure:</strong> Refund 100% dengan bukti yang sah</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 7. Pelanggaran dan Sanksi -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
          7. Pelanggaran dan Sanksi
        </h2>
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <h3 class="text-lg font-semibold text-red-900 mb-3">Sanksi Pelanggaran</h3>
            <ul class="list-disc list-inside space-y-2 ml-4">
              <li><strong>Peringatan:</strong> Untuk pelanggaran ringan</li>
              <li><strong>Suspend akun:</strong> 7-30 hari untuk pelanggaran sedang</li>
              <li><strong>Banned permanent:</strong> Untuk pelanggaran berat</li>
              <li><strong>Blacklist:</strong> Tidak dapat membuat akun baru</li>
              <li><strong>Tindakan hukum:</strong> Untuk tindakan kriminal</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 8. Perubahan Ketentuan -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-edit text-indigo-500 mr-3"></i>
          8. Perubahan Ketentuan
        </h2>
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <p>RideNow berhak mengubah syarat dan ketentuan ini sewaktu-waktu dengan ketentuan:</p>
            <ul class="list-disc list-inside space-y-2 ml-4">
              <li>Perubahan akan diberitahukan melalui email dan notifikasi aplikasi</li>
              <li>Berlaku efektif 7 hari setelah pemberitahuan</li>
              <li>Pengguna yang tidak setuju dapat menghentikan penggunaan layanan</li>
              <li>Penggunaan layanan setelah perubahan dianggap menyetujui ketentuan baru</li>
            </ul>
          </div>
        </div>
      </section>

    </div>
  </div>

  <!-- Bottom Navigation -->
  <div class="mt-8 flex justify-between items-center">
    <a href="{{ route('login') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
      <i class="fas fa-arrow-left mr-2"></i>
      Kembali ke Login
    </a>
    <div class="flex space-x-4">
      <a href="{{ route('help') }}" class="text-gray-600 hover:text-gray-800">Bantuan</a>
      <a href="{{ route('privacy') }}" class="text-gray-600 hover:text-gray-800">Kebijakan Privasi</a>
    </div>
  </div>
</div>
@endsection