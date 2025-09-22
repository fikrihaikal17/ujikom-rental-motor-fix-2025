@extends('layouts.sidebar')

@section('title', 'Detail Motor')

@section('content')
<!-- Header -->
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
                <p class="text-gray-900">{{ $motor->nama }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Tipe</label>
                <p class="text-gray-900">{{ $motor->tipe->value }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Nomor Plat</label>
                <p class="text-gray-900">{{ $motor->nomor_plat }}</p>
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
                <p class="text-gray-900">{{ $motor->user->name }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Email</label>
                <p class="text-gray-900">{{ $motor->user->email }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                <p class="text-gray-900">{{ $motor->user->no_telepon ?? '-' }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Bergabung</label>
                <p class="text-gray-900">{{ $motor->user->created_at->format('d M Y') }}</p>
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
              <p class="text-gray-900">{{ $motor->verifiedBy->name }}</p>
            </div>
            @endif
          </div>

          @if($motor->verification_notes)
          <div class="mt-4">
            <label class="text-sm font-medium text-gray-500">Catatan Verifikasi</label>
            <p class="text-gray-700 mt-1">{{ $motor->verification_notes }}</p>
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

      <div class="space-y-3">
        @if(!$motor->verified_at)
        <form action="{{ route('admin.motors.verify', $motor) }}" method="POST" class="w-full">
          @csrf
          @method('PATCH')
          <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Verifikasi Motor
          </button>
        </form>
        @else
        <form action="{{ route('admin.motors.unverify', $motor) }}" method="POST" class="w-full">
          @csrf
          @method('PATCH')
          <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Batalkan Verifikasi
          </button>
        </form>
        @endif

        <a href="{{ route('admin.motors.edit', $motor) }}" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
          Edit Motor
        </a>

        <button type="button" onclick="confirmDelete()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
          Hapus Motor
        </button>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
  <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
    <div class="mt-3 text-center">
      <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
      <div class="mt-2 px-7 py-3">
        <p class="text-sm text-gray-500">
          Apakah Anda yakin ingin menghapus motor ini? Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>
      <div class="items-center px-4 py-3">
        <form action="{{ route('admin.motors.destroy', $motor) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 mr-2">
            Hapus
          </button>
        </form>
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600">
          Batal
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
  }
</script>
@endsection