@extends('layouts.fullpage')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <!-- Header -->
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Kebijakan Privasi</h1>
    <p class="text-lg text-gray-600">Komitmen kami dalam melindungi data dan privasi Anda</p>
    <p class="text-sm text-gray-500 mt-2">Terakhir diperbarui: 25 September 2025</p>
  </div>

  <!-- Content -->
  <div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-8 space-y-8">
      
      <!-- 1. Pengantar -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
          1. Komitmen Privasi Kami
        </h2>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <p class="text-lg font-medium text-blue-900">RideNow berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda.</p>
            <p>Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan platform RideNow. Dengan menggunakan layanan kami, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini.</p>
          </div>
        </div>
      </section>

      <!-- 2. Informasi yang Kami Kumpulkan -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-database text-green-500 mr-3"></i>
          2. Informasi yang Kami Kumpulkan
        </h2>
        <div class="space-y-6">
          
          <!-- 2.1 Data Pribadi -->
          <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">2.1 Data Pribadi</h3>
            <ul class="list-disc list-inside space-y-2 text-green-800 ml-4">
              <li><strong>Informasi Identitas:</strong> Nama lengkap, tanggal lahir, alamat</li>
              <li><strong>Informasi Kontak:</strong> Email, nomor telepon</li>
              <li><strong>Dokumen:</strong> KTP, SIM, STNK (untuk owner)</li>
              <li><strong>Informasi Pembayaran:</strong> Detail rekening bank, riwayat transaksi</li>
              <li><strong>Foto Profil:</strong> Gambar yang Anda upload sebagai foto profil</li>
            </ul>
          </div>

          <!-- 2.2 Data Teknis -->
          <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">2.2 Data Teknis dan Penggunaan</h3>
            <ul class="list-disc list-inside space-y-2 text-green-800 ml-4">
              <li><strong>Log Aktivitas:</strong> Waktu login, fitur yang digunakan</li>
              <li><strong>Data Perangkat:</strong> IP address, browser, sistem operasi</li>
              <li><strong>Data Lokasi:</strong> GPS untuk layanan berbasis lokasi</li>
              <li><strong>Cookies:</strong> Preferensi dan pengaturan Anda</li>
              <li><strong>Komunikasi:</strong> Pesan dengan customer service</li>
            </ul>
          </div>

          <!-- 2.3 Data Motor (Khusus Owner) -->
          <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">2.3 Data Motor (Khusus Owner)</h3>
            <ul class="list-disc list-inside space-y-2 text-green-800 ml-4">
              <li><strong>Spesifikasi Motor:</strong> Merk, model, tahun, warna</li>
              <li><strong>Dokumentasi:</strong> Foto motor, STNK, asuransi</li>
              <li><strong>Kondisi:</strong> Status verifikasi, riwayat maintenance</li>
              <li><strong>Lokasi:</strong> Area operasional motor</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 3. Bagaimana Kami Menggunakan Data -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-cogs text-purple-500 mr-3"></i>
          3. Bagaimana Kami Menggunakan Data Anda
        </h2>
        <div class="space-y-6">
          
          <!-- 3.1 Layanan Utama -->
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-3">3.1 Penyediaan Layanan</h3>
            <ul class="list-disc list-inside space-y-2 text-purple-800 ml-4">
              <li>Memfasilitasi transaksi rental motor</li>
              <li>Verifikasi identitas dan dokumen</li>
              <li>Proses pembayaran dan refund</li>
              <li>Customer support dan bantuan</li>
              <li>Notifikasi terkait booking dan transaksi</li>
            </ul>
          </div>

          <!-- 3.2 Keamanan -->
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-3">3.2 Keamanan dan Perlindungan</h3>
            <ul class="list-disc list-inside space-y-2 text-purple-800 ml-4">
              <li>Deteksi dan pencegahan penipuan</li>
              <li>Monitoring aktivitas mencurigakan</li>
              <li>Verifikasi keamanan akun</li>
              <li>Investigasi pelanggaran kebijakan</li>
              <li>Backup dan recovery data</li>
            </ul>
          </div>

          <!-- 3.3 Peningkatan Layanan -->
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-3">3.3 Analisis dan Peningkatan</h3>
            <ul class="list-disc list-inside space-y-2 text-purple-800 ml-4">
              <li>Analisis penggunaan dan performa platform</li>
              <li>Pengembangan fitur baru</li>
              <li>Personalisasi pengalaman pengguna</li>
              <li>Riset pasar dan tren</li>
              <li>Optimasi algoritma pencarian dan rekomendasi</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 4. Berbagi Data dengan Pihak Ketiga -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-share-alt text-orange-500 mr-3"></i>
          4. Berbagi Data dengan Pihak Ketiga
        </h2>
        <div class="space-y-6">
          
          <!-- 4.1 Partner Resmi -->
          <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-orange-900 mb-3">4.1 Partner dan Penyedia Layanan</h3>
            <p class="text-orange-800 mb-3">Kami dapat berbagi data dengan pihak ketiga terpercaya untuk:</p>
            <ul class="list-disc list-inside space-y-2 text-orange-800 ml-4">
              <li><strong>Payment Gateway:</strong> Untuk proses pembayaran yang aman</li>
              <li><strong>Penyedia Asuransi:</strong> Untuk klaim dan verifikasi polis</li>
              <li><strong>Layanan Cloud:</strong> Untuk penyimpanan data yang aman</li>
              <li><strong>Analitik:</strong> Untuk insight penggunaan (data ter-anonymize)</li>
              <li><strong>Customer Support:</strong> Tools untuk bantuan pelanggan</li>
            </ul>
          </div>

          <!-- 4.2 Persyaratan Hukum -->
          <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-orange-900 mb-3">4.2 Kewajiban Hukum</h3>
            <p class="text-orange-800 mb-3">Data dapat dibagikan jika diperlukan untuk:</p>
            <ul class="list-disc list-inside space-y-2 text-orange-800 ml-4">
              <li>Mematuhi perintah pengadilan atau proses hukum</li>
              <li>Melindungi hak, properti, atau keselamatan RideNow</li>
              <li>Investigasi penipuan atau aktivitas ilegal</li>
              <li>Penegakan syarat dan ketentuan platform</li>
            </ul>
          </div>

          <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-red-800 text-sm">
              <i class="fas fa-exclamation-triangle mr-2"></i>
              <strong>Penting:</strong> Kami TIDAK PERNAH menjual data pribadi Anda untuk tujuan komersial atau marketing pihak ketiga.
            </p>
          </div>
        </div>
      </section>

      <!-- 5. Keamanan Data -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-lock text-red-500 mr-3"></i>
          5. Keamanan dan Perlindungan Data
        </h2>
        <div class="space-y-6">
          
          <!-- 5.1 Teknical Safeguards -->
          <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-3">5.1 Perlindungan Teknis</h3>
            <ul class="list-disc list-inside space-y-2 text-red-800 ml-4">
              <li><strong>Enkripsi:</strong> SSL/TLS untuk transmisi data</li>
              <li><strong>Database Security:</strong> Enkripsi data sensitif</li>
              <li><strong>Access Control:</strong> Autentikasi berlapis</li>
              <li><strong>Firewall:</strong> Perlindungan dari akses tidak sah</li>
              <li><strong>Monitoring:</strong> Deteksi ancaman real-time</li>
              <li><strong>Backup:</strong> Pencadangan data reguler</li>
            </ul>
          </div>

          <!-- 5.2 Administrative Safeguards -->
          <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-3">5.2 Perlindungan Administratif</h3>
            <ul class="list-disc list-inside space-y-2 text-red-800 ml-4">
              <li><strong>Pelatihan Tim:</strong> Staff terlatih tentang keamanan data</li>
              <li><strong>Access Management:</strong> Akses data berdasarkan kebutuhan</li>
              <li><strong>Audit Regular:</strong> Review keamanan berkala</li>
              <li><strong>Incident Response:</strong> Prosedur tanggap darurat</li>
              <li><strong>Vendor Management:</strong> Evaluasi keamanan partner</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- 6. Hak-Hak Anda -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-user-shield text-indigo-500 mr-3"></i>
          6. Hak-Hak Privasi Anda
        </h2>
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
          <div class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              
              <!-- Access & Portability -->
              <div class="space-y-4">
                <h3 class="text-lg font-semibold text-indigo-900">Akses & Portabilitas</h3>
                <ul class="list-disc list-inside space-y-2 text-indigo-800 text-sm ml-4">
                  <li><strong>Akses Data:</strong> Melihat data pribadi Anda</li>
                  <li><strong>Download Data:</strong> Mendapat salinan data</li>
                  <li><strong>Portabilitas:</strong> Transfer ke layanan lain</li>
                </ul>
              </div>

              <!-- Control & Correction -->
              <div class="space-y-4">
                <h3 class="text-lg font-semibold text-indigo-900">Kontrol & Koreksi</h3>
                <ul class="list-disc list-inside space-y-2 text-indigo-800 text-sm ml-4">
                  <li><strong>Update Data:</strong> Mengubah informasi</li>
                  <li><strong>Koreksi:</strong> Perbaiki data yang salah</li>
                  <li><strong>Pembatasan:</strong> Batasi penggunaan data</li>
                </ul>
              </div>

              <!-- Privacy Control -->
              <div class="space-y-4">
                <h3 class="text-lg font-semibold text-indigo-900">Kontrol Privasi</h3>
                <ul class="list-disc list-inside space-y-2 text-indigo-800 text-sm ml-4">
                  <li><strong>Opt-out:</strong> Keluar dari marketing email</li>
                  <li><strong>Cookie Control:</strong> Atur preferensi cookie</li>
                  <li><strong>Notifikasi:</strong> Kontrol pemberitahuan</li>
                </ul>
              </div>

              <!-- Deletion Rights -->
              <div class="space-y-4">
                <h3 class="text-lg font-semibold text-indigo-900">Hak Penghapusan</h3>
                <ul class="list-disc list-inside space-y-2 text-indigo-800 text-sm ml-4">
                  <li><strong>Delete Account:</strong> Hapus akun permanen</li>
                  <li><strong>Data Erasure:</strong> Hapus data tertentu</li>
                  <li><strong>Right to be Forgotten:</strong> Penghapusan menyeluruh</li>
                </ul>
              </div>
            </div>

            <div class="bg-indigo-100 border border-indigo-300 rounded-lg p-4 mt-6">
              <h4 class="font-semibold text-indigo-900 mb-2">Cara Menggunakan Hak Anda:</h4>
              <p class="text-indigo-800 text-sm">
                Untuk menggunakan hak-hak di atas, hubungi kami melalui email: 
                <a href="mailto:privacy@ridenow.com" class="font-medium underline">privacy@ridenow.com</a>
                atau melalui pengaturan akun Anda.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- 7. Retensi Data -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-clock text-yellow-500 mr-3"></i>
          7. Penyimpanan dan Retensi Data
        </h2>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">Periode Penyimpanan Data</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-3">
                <h4 class="font-semibold text-yellow-900">Data Aktif</h4>
                <ul class="list-disc list-inside space-y-1 text-yellow-800 text-sm ml-4">
                  <li><strong>Profil Pengguna:</strong> Selama akun aktif</li>
                  <li><strong>Transaksi:</strong> 5 tahun untuk audit</li>
                  <li><strong>Komunikasi:</strong> 2 tahun</li>
                  <li><strong>Log Sistem:</strong> 1 tahun</li>
                </ul>
              </div>
              
              <div class="space-y-3">
                <h4 class="font-semibold text-yellow-900">Setelah Akun Dihapus</h4>
                <ul class="list-disc list-inside space-y-1 text-yellow-800 text-sm ml-4">
                  <li><strong>Data Pribadi:</strong> Dihapus dalam 30 hari</li>
                  <li><strong>Data Transaksi:</strong> Disimpan untuk kepatuhan hukum</li>
                  <li><strong>Data Analytics:</strong> Di-anonymize</li>
                  <li><strong>Backup:</strong> Dihapus dalam 90 hari</li>
                </ul>
              </div>
            </div>

            <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 mt-4">
              <p class="text-yellow-800 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                Data tertentu mungkin disimpan lebih lama jika diperlukan untuk kepatuhan hukum, penyelesaian sengketa, atau penegakan kebijakan.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- 8. Transfer Data Internasional -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-globe text-teal-500 mr-3"></i>
          8. Transfer Data Internasional
        </h2>
        <div class="bg-teal-50 border border-teal-200 rounded-lg p-6">
          <div class="space-y-4 text-gray-700">
            <p class="text-teal-900 font-medium">Data Anda mungkin diproses di server yang berlokasi di luar Indonesia untuk keperluan:</p>
            <ul class="list-disc list-inside space-y-2 text-teal-800 ml-4">
              <li>Cloud storage dan backup yang aman</li>
              <li>Layanan pembayaran internasional</li>
              <li>Analytics dan peningkatan performa global</li>
              <li>Customer support 24/7</li>
            </ul>
            <div class="bg-teal-100 border border-teal-300 rounded-lg p-4 mt-4">
              <p class="text-teal-800 text-sm">
                <i class="fas fa-shield-alt mr-2"></i>
                <strong>Perlindungan:</strong> Kami memastikan transfer data internasional menggunakan safeguards yang memadai seperti Standard Contractual Clauses dan sertifikasi keamanan.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- 9. Cookies dan Teknologi Pelacakan -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-cookie-bite text-brown-500 mr-3"></i>
          9. Cookies dan Teknologi Pelacakan
        </h2>
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
          <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              
              <div>
                <h3 class="text-lg font-semibold text-amber-900 mb-3">Jenis Cookies</h3>
                <ul class="list-disc list-inside space-y-2 text-amber-800 text-sm ml-4">
                  <li><strong>Essential:</strong> Fungsi dasar platform</li>
                  <li><strong>Performance:</strong> Analisis penggunaan</li>
                  <li><strong>Functional:</strong> Preferensi pengguna</li>
                  <li><strong>Targeting:</strong> Konten yang relevan</li>
                </ul>
              </div>

              <div>
                <h3 class="text-lg font-semibold text-amber-900 mb-3">Kontrol Cookies</h3>
                <ul class="list-disc list-inside space-y-2 text-amber-800 text-sm ml-4">
                  <li><strong>Browser Settings:</strong> Blokir cookies</li>
                  <li><strong>Preference Center:</strong> Pilih jenis cookies</li>
                  <li><strong>Clear Data:</strong> Hapus cookies tersimpan</li>
                  <li><strong>Opt-out Links:</strong> Keluar dari tracking</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- 10. Kontak Privacy -->
      <section>
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-envelope text-gray-500 mr-3"></i>
          10. Hubungi Tim Privacy
        </h2>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
          <div class="space-y-4">
            <p class="text-gray-700">Jika Anda memiliki pertanyaan, keluhan, atau ingin menggunakan hak privasi Anda:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
              <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Kontak Langsung</h4>
                <p class="text-sm text-gray-700"><strong>Email Privacy:</strong> privacy@ridenow.com</p>
                <p class="text-sm text-gray-700"><strong>Data Protection Officer:</strong> dpo@ridenow.com</p>
                <p class="text-sm text-gray-700"><strong>WhatsApp:</strong> +62 851 8909 4514</p>
              </div>
              
              <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Waktu Respon</h4>
                <p class="text-sm text-gray-700"><strong>Pertanyaan Umum:</strong> 1-2 hari kerja</p>
                <p class="text-sm text-gray-700"><strong>Hak Akses Data:</strong> 3-5 hari kerja</p>
                <p class="text-sm text-gray-700"><strong>Penghapusan Data:</strong> 5-10 hari kerja</p>
              </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
              <p class="text-blue-800 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Tips:</strong> Sertakan detail yang jelas dan lengkap dalam pertanyaan Anda agar kami dapat membantu dengan lebih efektif.
              </p>
            </div>
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
      <a href="{{ route('terms') }}" class="text-gray-600 hover:text-gray-800">Syarat & Ketentuan</a>
    </div>
  </div>
</div>
@endsection