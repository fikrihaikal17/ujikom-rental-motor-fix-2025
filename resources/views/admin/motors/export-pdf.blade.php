<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Motor - {{ ucfirst($filterInfo['status']) }}</title>
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
      width: 25%;
    }

    .stat-number {
      font-size: 16px;
      font-weight: bold;
      color: #007bff;
    }

    .stat-label {
      font-size: 9px;
      color: #6c757d;
      margin-top: 2px;
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

    .status-verified {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #00b894;
    }

    .status-rejected {
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
    <h1>LAPORAN DATA MOTOR</h1>
    <h2>Sistem Rental Motor</h2>
  </div>

  <div class="info-section">
    <div class="info-left">
      <div class="info-item">
        <span class="label">Filter Status:</span>
        @if($filterInfo['status'] === 'all')
        Semua Status
        @elseif($filterInfo['status'] === 'verified')
        Motor Terverifikasi
        @elseif($filterInfo['status'] === 'pending')
        Motor Pending
        @elseif($filterInfo['status'] === 'rejected')
        Motor Ditolak
        @endif
      </div>
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
        <span class="label">Total Data:</span> {{ $stats['total'] }} motor
      </div>
    </div>
  </div>

  <div class="stats-section">
    <div class="stats-title">Statistik Motor</div>
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-number">{{ $stats['total'] }}</div>
        <div class="stat-label">Total Motor</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['verified'] }}</div>
        <div class="stat-label">Terverifikasi</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['pending'] }}</div>
        <div class="stat-label">Pending</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">{{ $stats['rejected'] }}</div>
        <div class="stat-label">Ditolak</div>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th style="width: 4%;">No</th>
          <th style="width: 18%;">Nama Motor</th>
          <th style="width: 12%;">Merk/Model</th>
          <th style="width: 10%;">Plat Nomor</th>
          <th style="width: 15%;">Pemilik</th>
          <th style="width: 10%;">Status</th>
          <th style="width: 12%;">Tarif/Hari</th>
          <th style="width: 12%;">Tgl Dibuat</th>
          <th style="width: 7%;">Tahun</th>
        </tr>
      </thead>
      <tbody>
        @forelse($motors as $index => $motor)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>{{ $motor->nama_motor ?? $motor->name ?? '-' }}</td>
          <td>{{ ($motor->merk ?? '-') . ' / ' . ($motor->model ?? '-') }}</td>
          <td class="text-center">{{ $motor->plat_nomor ?? $motor->no_plat ?? '-' }}</td>
          <td>{{ $motor->owner->nama ?? $motor->owner->name ?? '-' }}</td>
          <td class="text-center">
            @if($motor->status?->value === 'verified')
            <span class="status-badge status-verified">Terverifikasi</span>
            @elseif($motor->status?->value === 'pending' && !$motor->admin_notes)
            <span class="status-badge status-pending">Pending</span>
            @elseif($motor->status?->value === 'pending' && $motor->admin_notes)
            <span class="status-badge status-rejected">Ditolak</span>
            @else
            <span class="status-badge">{{ $motor->status?->getDisplayName() ?? $motor->status ?? '-' }}</span>
            @endif
          </td>
          <td class="currency">Rp {{ number_format($motor->tarifRental?->tarif_per_hari ?? 0, 0, ',', '.') }}</td>
          <td class="text-center">{{ $motor->created_at?->format('d/m/Y') ?? '-' }}</td>
          <td class="text-center">{{ $motor->tahun ?? '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center text-muted">Tidak ada data motor ditemukan</td>
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