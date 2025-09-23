@extends('layouts.sidebar')

@section('title', 'Kelola Pengguna')

@section('content')
<!-- Header -->
<div class="mb-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900">Kelola Pengguna</h1>
      <p class="mt-2 text-sm text-gray-700">Daftar semua pengguna yang terdaftar di sistem RideNow.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3 flex">
      <a href="#" onclick="exportPDF()" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        Export PDF
      </a>
      <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Pengguna
      </a>
    </div>
  </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="mb-4 rounded-md bg-green-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
  </div>
</div>
@endif

@if(session('error'))
<div class="mb-4 rounded-md bg-red-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
    </div>
  </div>
</div>
@endif

<!-- Users Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
  <div class="px-4 py-5 sm:p-6">
    <!-- Search and Filter -->
    <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form">
      <div class="mb-4 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div class="sm:w-48">
          <select name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="pemilik" {{ request('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Kendaraan</option>
            <option value="penyewa" {{ request('role') == 'penyewa' ? 'selected' : '' }}>Penyewa</option>
          </select>
        </div>
        <div class="flex gap-2">
          <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Filter
          </button>
          @if(request('search') || request('role'))
          <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Reset
          </a>
          @endif
        </div>
      </div>
    </form>

    @if($users->count() > 0)
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Pengguna
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Role
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Kontak
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Bergabung
            </th>
            <th scope="col" class="relative px-6 py-3">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($users as $user)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                  <div class="text-sm text-gray-500">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role->value === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role->value === 'pemilik' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                {{ $user->role->getDisplayName() }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              <div>{{ $user->no_tlpn }}</div>
              <div class="text-gray-500 text-xs">{{ Str::limit($user->alamat, 30) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <time datetime="{{ $user->created_at->toISOString() }}" data-format="date">{{ $user->created_at->format('d M Y') }}</time>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-2">
                <a href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:text-primary-900">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $users->links() }}
    </div>
    @else
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengguna</h3>
      <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pengguna baru.</p>
      <div class="mt-6">
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Tambah Pengguna
        </a>
      </div>
    </div>
    @endif
  </div>
</div>

<script>
  // Export PDF function that includes current filters
  function exportPDF() {
    const form = document.getElementById('filter-form');
    const formData = new FormData(form);

    // Build URL with current filters
    let exportUrl = '{{ route("admin.users.export") }}';

    const params = new URLSearchParams();
    for (let [key, value] of formData.entries()) {
      if (value) {
        params.append(key, value);
      }
    }

    if (params.toString()) {
      exportUrl += '?' + params.toString();
    }

    // Navigate to export URL
    window.location.href = exportUrl;
  }
</script>
@endsection