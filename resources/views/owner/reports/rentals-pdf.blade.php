<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Penyewaan - {{ $owner->nama }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 12px;
      line-height: 1.4;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 2px solid #007bff;
    }

    .header h1 {
      color: #007bff;
      font-size: 24px;
      margin-bottom: 5px;
    }

    .header h2 {
      color: #666;
      font-size: 16px;
      font-weight: normal;
    }

    .info-section {
      margin-bottom: 25px;
    }

    .summary-stats {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
    }

    .summary-stats h3 {
      color: #007bff;
      margin-bottom: 15px;
      font-size: 16px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
    }

    .stat-item {
      text-align: center;
    }

    .stat-value {
      font-size: 18px;
      font-weight: bold;
      color: #28a745;
      display: block;
    }

    .stat-label {
      color: #666;
      font-size: 11px;
    }

    .section {
      margin-bottom: 30px;
    }

    .section h3 {
      color: #007bff;
      margin-bottom: 15px;
      padding-bottom: 5px;
      border-bottom: 1px solid #ddd;
      font-size: 16px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .table th,
    .table td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      font-size: 10px;
    }

    .table th {
      background-color: #f8f9fa;
      font-weight: bold;
      color: #333;
    }

    .table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .currency {
      color: #28a745;
      font-weight: bold;
    }

    .status-badge {
      padding: 2px 6px;
      border-radius: 12px;
      font-size: 9px;
      font-weight: bold;
    }

    .status-active {
      background-color: #d4edda;
      color: #155724;
    }

    .status-completed {
      background-color: #cce7ff;
      color: #004085;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-cancelled {
      background-color: #f8d7da;
      color: #721c24;
    }

    .footer {
      position: fixed;
      bottom: 20px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 10px;
      color: #666;
    }

    .no-data {
      text-align: center;
      color: #666;
      font-style: italic;
      padding: 30px;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN PENYEWAAN MOTOR</h1>
    <h2>Periode: {{ now()->year }}</h2>
    <div style="margin-top: 10px;">
      <strong>Pemilik:</strong> {{ $owner->nama }}<br>
      <strong>Email:</strong> {{ $owner->email }}<br>
      <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y, H:i') }} WIB
    </div>
  </div>

  <div class="summary-stats">
    <h3>Ringkasan Penyewaan</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-value">{{ $totalRentals }}</span>
        <span class="stat-label">Total Penyewaan</span>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $activeRentals }}</span>
        <span class="stat-label">Sedang Aktif</span>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $completedRentals }}</span>
        <span class="stat-label">Selesai</span>
      </div>
    </div>
  </div>

  <div class="section">
    <h3>Statistik Bulanan {{ now()->year }}</h3>
    @if($monthlyRentals->count() > 0)
    <table class="table">
      <thead>
        <tr>
          <th>Bulan</th>
          <th class="text-right">Jumlah Penyewaan</th>
        </tr>
      </thead>
      <tbody>
        @php $totalRentalCount = 0; @endphp
        @for($i = 1; $i <= 12; $i++)
          @php
          $monthData=$monthlyRentals->where('month', $i)->first();
          $count = $monthData ? $monthData->total : 0;
          $totalRentalCount += $count;
          @endphp
          @if($count > 0)
          <tr>
            <td>{{ \Carbon\Carbon::create()->month($i)->format('F Y') }}</td>
            <td class="text-right">{{ $count }}</td>
          </tr>
          @endif
          @endfor
          <tr style="border-top: 2px solid #007bff; font-weight: bold;">
            <td><strong>TOTAL</strong></td>
            <td class="text-right"><strong>{{ $totalRentalCount }}</strong></td>
          </tr>
      </tbody>
    </table>
    @else
    <div class="no-data">
      Belum ada data penyewaan untuk tahun {{ now()->year }}
    </div>
    @endif
  </div>

  @if($allRentals->count() > 0)
  <div class="section page-break">
    <h3>Detail Penyewaan</h3>
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Motor</th>
          <th>No. Plat</th>
          <th>Penyewa</th>
          <th>Tanggal Mulai</th>
          <th>Tanggal Selesai</th>
          <th>Status</th>
          <th class="text-right">Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allRentals as $index => $rental)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $rental->motor?->merk ?? 'N/A' }}</td>
          <td>{{ $rental->motor?->no_plat ?? 'N/A' }}</td>
          <td>{{ $rental->penyewa?->nama ?? 'N/A' }}</td>
          <td>{{ $rental->tanggal_mulai->format('d/m/Y') }}</td>
          <td>{{ $rental->tanggal_selesai->format('d/m/Y') }}</td>
          <td>
            <span class="status-badge status-{{ $rental->status->value }}">
              {{ $rental->status->getDisplayName() }}
            </span>
          </td>
          <td class="text-right currency">Rp {{ number_format($rental->harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr style="border-top: 2px solid #007bff; font-weight: bold;">
          <td colspan="7"><strong>TOTAL PENDAPATAN</strong></td>
          <td class="text-right currency">
            <strong>Rp {{ number_format($allRentals->where('status.value', 'completed')->sum('harga'), 0, ',', '.') }}</strong>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  @else
  <div class="section">
    <div class="no-data">
      Belum ada data penyewaan
    </div>
  </div>
  @endif

  <div class="footer">
    <p>Dokumen ini dibuat secara otomatis oleh sistem RideNow pada {{ now()->format('d F Y, H:i') }} WIB</p>
    <p>Halaman {PAGE_NUM} dari {PAGE_COUNT}</p>
  </div>
</body>

</html>