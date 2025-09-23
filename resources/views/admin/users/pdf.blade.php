<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Data Pengguna</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      line-height: 1.4;
      color: #333;
      margin: 0;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #2563eb;
    }

    .header h2 {
      margin: 5px 0 0 0;
      font-size: 16px;
      color: #666;
      font-weight: normal;
    }

    .stats-section {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 25px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
    }

    .stat-item {
      text-align: center;
    }

    .stat-value {
      font-size: 16px;
      font-weight: bold;
      color: #2563eb;
      display: block;
    }

    .stat-label {
      font-size: 10px;
      color: #666;
      margin-top: 3px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #f8f9fa;
      font-weight: bold;
      font-size: 10px;
      text-transform: uppercase;
    }

    td {
      font-size: 10px;
    }

    .role-badge {
      padding: 2px 6px;
      border-radius: 10px;
      font-size: 9px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .role-admin {
      background-color: #fee2e2;
      color: #991b1b;
    }

    .role-pemilik {
      background-color: #dbeafe;
      color: #1e40af;
    }

    .role-penyewa {
      background-color: #d1fae5;
      color: #065f46;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 9px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 15px;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>RENTAL MOTOR</h1>
    <h2>Laporan Data Pengguna</h2>
    <p>Digenerate pada: {{ now()->format('d F Y H:i:s') }}</p>
    @if($filters['applied'])
    <div style="margin-top: 10px; font-size: 12px; color: #666;">
      <strong>Filter yang diterapkan:</strong>
      @if($filters['search'])
      Pencarian: "{{ $filters['search'] }}"
      @endif
      @if($filters['role'])
      {{ $filters['search'] ? ', ' : '' }}Role: {{ ucfirst($filters['role']) }}
      @endif
    </div>
    @endif
  </div>

  <div class="stats-section">
    <h3 style="margin-top: 0; margin-bottom: 15px; text-align: center;">Ringkasan Statistik</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-value">{{ $stats['total_users'] }}</span>
        <div class="stat-label">Total Pengguna</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $stats['admin_count'] }}</span>
        <div class="stat-label">Admin</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $stats['pemilik_count'] }}</span>
        <div class="stat-label">Pemilik</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $stats['penyewa_count'] }}</span>
        <div class="stat-label">Penyewa</div>
      </div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th width="5%">No</th>
        <th width="18%">Nama</th>
        <th width="25%">Email</th>
        <th width="12%">Role</th>
        <th width="15%">No. Telepon</th>
        <th width="20%">Alamat</th>
        <th width="10%">Total Motor</th>
        <th width="10%">Total Booking</th>
        <th width="15%">Tanggal Daftar</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach($users as $user)
      <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>{{ $user->nama ?? $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          <span class="role-badge role-{{ $user->role->value }}">
            {{ ucfirst($user->role->value) }}
          </span>
        </td>
        <td>{{ $user->no_tlpn ?? $user->phone ?? '-' }}</td>
        <td>{{ Str::limit($user->alamat ?? '-', 30) }}</td>
        <td class="text-center">
          @if($user->role->value === 'pemilik')
          {{ $user->motors->count() }}
          @else
          -
          @endif
        </td>
        <td class="text-center">
          @if($user->role->value === 'penyewa')
          {{ $user->penyewaans->count() }}
          @else
          -
          @endif
        </td>
        <td class="text-center">{{ $user->created_at->format('d/m/Y') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    <p>Dokumen ini digenerate secara otomatis pada {{ now()->format('d F Y \p\u\k\u\l H:i:s') }}</p>
    <p>© {{ date('Y') }} Rental Motor - Sistem Manajemen Penyewaan Motor</p>
  </div>
</body>

</html>