<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Penyewaan - {{ ucfirst($filterInfo['status']) }}</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 10px;
      margin: 15px;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
    }

    .header h1 {
      font-size: 18px;
      margin: 0;
      font-weight: bold;
      color: #2c5aa0;
    }

    .header h2 {
      font-size: 14px;
      margin: 5px 0;
      color: #666;
    }

    .info-section {
      margin-bottom: 15px;
      display: table;
      width: 100%;
    }

    .info-left {
      display: table-cell;
      width: 50%;
      vertical-align: top;
    }

    .info-right {
      display: table-cell;
      width: 50%;
      text-align: right;
      vertical-align: top;
    }

    .info-item {
      margin-bottom: 3px;
    }

    .label {
      font-weight: bold;
      color: #555;
    }

    .stats-section {
      background: #f8f9fa;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #dee2e6;
    }

    .stats-title {
      font-weight: bold;
      margin-bottom: 8px;
      color: #495057;
    }

    .stats-grid {
      display: table;
      width: 100%;
    }

    .stat-item {
      display: table-cell;
      text-align: center;
      width: 14.28%;
    }

    .stat-number {
      font-size: 14px;
      font-weight: bold;
      color: #007bff;
    }

    .stat-label {
      font-size: 8px;
      color: #6c757d;
      margin-top: 2px;
    }

    .revenue-stat {
      color: #28a745 !important;
      font-size: 16px;
    }

    .table-container {
      margin-top: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 9px;
    }

    th {
      background-color: #2c5aa0;
      color: white;
      padding: 8px 4px;
      text-align: left;
      font-weight: bold;
      border: 1px solid #1a4480;
    }

    td {
      padding: 6px 4px;
      border: 1px solid #dee2e6;
      vertical-align: top;
    }

    tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    tr:hover {
      background-color: #e9ecef;
    }

    .status-badge {
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 8px;
      font-weight: bold;
      text-align: center;
      display: inline-block;
      min-width: 60px;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeaa7;
    }

    .status-confirmed {
      background-color: #cce5ff;
      color: #004085;
      border: 1px solid #0074d9;
    }

    .status-active {
      background-color: #d1ecf1;
      color: #0c5460;
      border: 1px solid #17a2b8;
    }

    .status-completed {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #00b894;
    }

    .status-cancelled {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #d63031;
    }

    .currency {
      text-align: right;
      font-weight: bold;
      color: #28a745;
    }

    .footer {
      margin-top: 20px;
      text-align: center;
      font-size: 8px;
      color: #6c757d;
      border-top: 1px solid #dee2e6;
      padding-top: 10px;
    }

    .page-break {
      page-break-before: always;
    }

    .text-center {
      text-align: center;
    }

    .text-muted {
      color: #6c757d;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN DATA PENYEWAAN</h1>
    <h2>Sistem Rental Motor</h2>
  </div>

  <div class="info-section">
    <div class="info-left">
      <div class="info-item">
        <span class="label">Filter Status:</span>
        @if($filterInfo['status'] === 'all')
        Semua Status
        @elseif($filterInfo['status'] === 'pending')
        Menunggu Konfirmasi
        @elseif($filterInfo['status'] === 'confirmed')
        Dikonfirmasi
        @elseif($filterInfo['status'] === 'active')
        Sedang Berjalan
        @elseif($filterInfo['status'] === 'completed')
        Selesai
        @elseif($filterInfo['status'] === 'cancelled')
        Dibatalkan
        @endif
      </div>
      @if($filterInfo['start_date'] || $filterInfo['end_date'])
      <div class="info-item">
        <span class="label">Periode:</span>
        @if($filterInfo['start_date'])
        {{ \Carbon\Carbon::parse($filterInfo['start_date'])->format('d/m/Y') }}
        @endif
        @if($filterInfo['start_date'] && $filterInfo['end_date'])
        s/d
        @endif
        @if($filterInfo['end_date'])
        {{ \Carbon\Carbon::parse($filterInfo['end_date'])->format('d/m/Y') }}
        @endif
      </div>
      @endif
      @if($filterInfo['search'])
      <div class="info-item">
        <span class="label">Pencarian:</span> {{ $filterInfo['search'] }}
      </div>
      @endif
    </div>
    <div class="info-right">
      <div class="info-item">
        <span class="label">Tanggal Cetak:</span> {{ $filterInfo['date'] }}
      </div>
      <div class="info-item">
        <span class="label">Total Data:</span> {{ $stats['total'] }} penyewaan
      </div>
      <div class="info-item">
        <span class="label">Total Pendapatan:</span> Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
      </div>
    </div>
  </div>

  <div class="stats-section">
    <div class="stats-title">Statistik Penyewaan</div>
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-number">{{ $stats['total'] }}</div>
        <div class="stat-label">Total</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['pending'] }}</div>
        <div class="stat-label">Pending</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['confirmed'] }}</div>
        <div class="stat-label">Konfirmasi</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['active'] }}</div>
        <div class="stat-label">Aktif</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['completed'] }}</div>
        <div class="stat-label">Selesai</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['cancelled'] }}</div>
        <div class="stat-label">Batal</div>
      </div>
      <div class="stat-item">
        <div class="stat-number revenue-stat">Rp {{ number_format($stats['total_revenue']/1000000, 1) }}M</div>
        <div class="stat-label">Pendapatan</div>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th style="width: 4%;">No</th>
          <th style="width: 15%;">Penyewa</th>
          <th style="width: 15%;">Motor</th>
          <th style="width: 12%;">Periode Sewa</th>
          <th style="width: 8%;">Durasi</th>
          <th style="width: 12%;">Total Harga</th>
          <th style="width: 10%;">Status</th>
          <th style="width: 12%;">Tgl Booking</th>
          <th style="width: 12%;">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @forelse($penyewaans as $index => $penyewaan)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>
            <div>{{ $penyewaan->penyewa->name ?? '-' }}</div>
            <div style="font-size: 8px; color: #6c757d;">{{ $penyewaan->penyewa->email ?? '-' }}</div>
          </td>
          <td>
            <div>{{ $penyewaan->motor->nama_motor ?? '-' }}</div>
            <div style="font-size: 8px; color: #6c757d;">{{ $penyewaan->motor->no_plat ?? $penyewaan->motor->plat_nomor ?? '-' }}</div>
          </td>
          <td class="text-center">
            <div>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d/m/Y') }}</div>
            <div style="font-size: 8px; color: #6c757d;">s/d {{ \Carbon\Carbon::parse($penyewaan->tanggal_selesai)->format('d/m/Y') }}</div>
          </td>
          <td class="text-center">{{ $penyewaan->durasi_sewa ?? '-' }} hari</td>
          <td class="currency">Rp {{ number_format($penyewaan->total_harga ?? 0, 0, ',', '.') }}</td>
          <td class="text-center">
            @if($penyewaan->status === 'pending')
            <span class="status-badge status-pending">Pending</span>
            @elseif($penyewaan->status === 'confirmed')
            <span class="status-badge status-confirmed">Konfirmasi</span>
            @elseif($penyewaan->status === 'active')
            <span class="status-badge status-active">Aktif</span>
            @elseif($penyewaan->status === 'completed')
            <span class="status-badge status-completed">Selesai</span>
            @elseif($penyewaan->status === 'cancelled')
            <span class="status-badge status-cancelled">Batal</span>
            @else
            <span class="status-badge">{{ $penyewaan->status ?? '-' }}</span>
            @endif
          </td>
          <td class="text-center">{{ $penyewaan->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
          <td style="font-size: 8px;">
            @if($penyewaan->catatan)
            {{ Str::limit($penyewaan->catatan, 30) }}
            @else
            -
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center text-muted">Tidak ada data penyewaan ditemukan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="footer">
    <p>Dokumen ini digenerate secara otomatis pada {{ $filterInfo['date'] }} | Sistem Rental Motor</p>
    <p class="text-muted">© {{ date('Y') }} Rental Motor. Semua hak cipta dilindungi.</p>
  </div>
</body>

</html>