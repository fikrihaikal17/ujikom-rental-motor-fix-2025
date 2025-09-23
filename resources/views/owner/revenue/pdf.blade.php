<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pendapatan - {{ $owner->nama }}</title>
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

    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }

    .info-label {
      font-weight: bold;
      width: 150px;
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
      grid-template-columns: 1fr 1fr;
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

    .footer {
      position: fixed;
      bottom: 20px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 10px;
      color: #666;
    }

    .chart-section {
      margin-bottom: 30px;
    }

    .month-item {
      display: inline-block;
      width: 60px;
      text-align: center;
      margin-right: 10px;
      vertical-align: bottom;
    }

    .month-bar {
      background-color: #007bff;
      width: 100%;
      margin-bottom: 5px;
    }

    .month-label {
      font-size: 10px;
      color: #666;
    }

    .no-data {
      text-align: center;
      color: #666;
      font-style: italic;
      padding: 30px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN PENDAPATAN</h1>
    <h2>Tahun {{ now()->year }}</h2>
    <div style="margin-top: 10px;">
      <strong>Pemilik:</strong> {{ $owner->nama }}<br>
      <strong>Email:</strong> {{ $owner->email }}<br>
      <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y, H:i') }} WIB
    </div>
  </div>

  <div class="summary-stats">
    <h3>Ringkasan Pendapatan</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-value">Rp {{ number_format($totalYearRevenue, 0, ',', '.') }}</span>
        <span class="stat-label">Total Pendapatan {{ now()->year }}</span>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $monthlyData->count() }}</span>
        <span class="stat-label">Bulan Aktif</span>
      </div>
    </div>
  </div>

  <div class="section">
    <h3>Pendapatan Bulanan {{ now()->year }}</h3>
    @if($monthlyData->count() > 0)
    <table class="table">
      <thead>
        <tr>
          <th>Bulan</th>
          <th class="text-right">Jumlah Transaksi</th>
          <th class="text-right">Total Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        @php
        $totalTransactions = 0;
        $grandTotal = 0;
        @endphp
        @for($i = 1; $i <= 12; $i++)
          @php
          $monthData=$monthlyData->where('month', $i)->first();
          $amount = $monthData ? $monthData->total : 0;
          $count = $monthData ? $monthData->count : 0;
          $totalTransactions += $count;
          $grandTotal += $amount;
          @endphp
          @if($amount > 0)
          <tr>
            <td>{{ \Carbon\Carbon::create()->month($i)->format('F Y') }}</td>
            <td class="text-right">{{ $count }}</td>
            <td class="text-right currency">Rp {{ number_format($amount, 0, ',', '.') }}</td>
          </tr>
          @endif
          @endfor
          <tr style="border-top: 2px solid #007bff; font-weight: bold;">
            <td><strong>TOTAL</strong></td>
            <td class="text-right"><strong>{{ $totalTransactions }}</strong></td>
            <td class="text-right currency"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
          </tr>
      </tbody>
    </table>
    @else
    <div class="no-data">
      Belum ada data pendapatan untuk tahun {{ now()->year }}
    </div>
    @endif
  </div>

  <div class="section">
    <h3>Motor Terbaik {{ now()->year }}</h3>
    @if($topMotors->count() > 0)
    <table class="table">
      <thead>
        <tr>
          <th>Ranking</th>
          <th>Merk Motor</th>
          <th>No. Plat</th>
          <th class="text-right">Total Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($topMotors as $index => $motor)
        <tr>
          <td class="text-center">
            @if($index === 0)
            🥇
            @elseif($index === 1)
            🥈
            @elseif($index === 2)
            🥉
            @else
            {{ $index + 1 }}
            @endif
          </td>
          <td>{{ $motor->merk }}</td>
          <td>{{ $motor->no_plat }}</td>
          <td class="text-right currency">Rp {{ number_format($motor->total_revenue ?? 0, 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="no-data">
      Belum ada data motor untuk tahun {{ now()->year }}
    </div>
    @endif
  </div>

  <div class="footer">
    <p>Dokumen ini dibuat secara otomatis oleh sistem RideNow pada {{ now()->format('d F Y, H:i') }} WIB</p>
  </div>
</body>

</html>