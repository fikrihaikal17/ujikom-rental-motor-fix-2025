@extends('layouts.sidebar')

@section('title', 'Kelola Tarif')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Tarif</h1>
      <p class="text-gray-600">Mengelola tarif rental motor</p>
    </div>
    <a href="{{ route('admin.tarif.create') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
      <i class="fas fa-plus mr-2"></i>Tambah Tarif
    </a>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
          <i class="fas fa-tags text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Total Tarif</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_tarifs']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
          <i class="fas fa-check-circle text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Tarif Aktif</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['active_tarifs']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
          <i class="fas fa-coins text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Rata-rata Harga</p>
          <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['avg_price'] ?? 0, 0, ',', '.') }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-red-100 text-red-600">
          <i class="fas fa-exclamation-triangle text-xl"></i>
        </div>
        <div class="ml-4">
          <p class="text-sm text-gray-600">Motor Tanpa Tarif</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['motors_without_tarif']) }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters -->
  <div class="bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-4 items-center">
      <div class="flex-1 min-w-64">
        <input type="text"
          placeholder="Cari motor atau pemilik..."
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          id="searchInput">
      </div>
      <div>
        <select class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          id="statusFilter">
          <option value="">Semua Status</option>
          <option value="active">Aktif</option>
          <option value="inactive">Tidak Aktif</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Tarif Table -->
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Harian</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Mingguan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Bulanan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="tarifTable">
          @forelse($tarifs as $tarif)
          <tr data-motor="{{ strtolower($tarif->motor->merk . ' ' . $tarif->motor->model) }}"
            data-owner="{{ strtolower($tarif->motor->owner->name) }}"
            data-status="{{ $tarif->is_active ? 'active' : 'inactive' }}">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                  @if($tarif->motor->foto)
                  <img class="h-10 w-10 rounded-full object-cover"
                    src="{{ asset('storage/' . $tarif->motor->foto) }}"
                    alt="{{ $tarif->motor->merk }}">
                  @else
                  <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-motorcycle text-gray-500"></i>
                  </div>
                  @endif
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">
                    {{ $tarif->motor->merk }} {{ $tarif->motor->model }}
                  </div>
                  <div class="text-sm text-gray-500">{{ $tarif->motor->plat_nomor }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $tarif->motor->owner->name }}</div>
              <div class="text-sm text-gray-500">{{ $tarif->motor->owner->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @if($tarif->tarif_harian)
              Rp {{ number_format($tarif->tarif_harian, 0, ',', '.') }}
              @else
              <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @if($tarif->tarif_mingguan)
              Rp {{ number_format($tarif->tarif_mingguan, 0, ',', '.') }}
              @else
              <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              @if($tarif->tarif_bulanan)
              Rp {{ number_format($tarif->tarif_bulanan, 0, ',', '.') }}
              @else
              <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @if($tarif->is_active)
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Aktif
              </span>
              @else
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                Tidak Aktif
              </span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <div class="flex space-x-2">
                <a href="{{ route('admin.tarif.show', $tarif) }}"
                  class="text-blue-600 hover:text-blue-900">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.tarif.edit', $tarif) }}"
                  class="text-indigo-600 hover:text-indigo-900">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.tarif.destroy', $tarif) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
              Belum ada data tarif
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($tarifs->hasPages())
    <div class="px-6 py-3 border-t border-gray-200">
      {{ $tarifs->links() }}
    </div>
    @endif
  </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
  {{ session('success') }}
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto hide success alert
    const alert = document.getElementById('successAlert');
    if (alert) {
      setTimeout(() => {
        alert.style.display = 'none';
      }, 3000);
    }

    // Search and filter functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('#tarifTable tr[data-motor]');

    function filterTable() {
      const searchTerm = searchInput.value.toLowerCase();
      const statusValue = statusFilter.value;

      tableRows.forEach(row => {
        const motorData = row.dataset.motor;
        const ownerData = row.dataset.owner;
        const statusData = row.dataset.status;

        const matchesSearch = motorData.includes(searchTerm) || ownerData.includes(searchTerm);
        const matchesStatus = !statusValue || statusData === statusValue;

        if (matchesSearch && matchesStatus) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
  });
</script>
@endsection