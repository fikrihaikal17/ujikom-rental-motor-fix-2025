<!DOCTYPE html>
<html>

<head>
  <title>Riwayat Pendapatan - {{ $owner->nama }}</title>
  <meta charset="utf-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      font-size: 12px;
      line-height: 1.4;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 20px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #333;
      font-weight: bold;
    }

    .header h2 {
      margin: 5px 0;
      font-size: 18px;
      color: #666;
      font-weight: normal;
    }

    .header p {
      margin: 5px 0;
      color: #888;
      font-size: 11px;
    }

    .summary-section {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 25px;
      border: 1px solid #dee2e6;
    }

    .summary-section h3 {
      margin: 0 0 15px 0;
      color: #333;
      font-size: 16px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
    }

    .summary-grid {
      display: table;
      width: 100%;
    }

    .summary-row {
      display: table-row;
    }

    .summary-cell {
      display: table-cell;
      padding: 8px 12px;
      border-bottom: 1px solid #eee;
      vertical-align: top;
    }

    .summary-cell:first-child {
      font-weight: bold;
      width: 40%;
      color: #555;
    }

    .summary-cell:last-child {
      text-align: right;
      color: #2d5f2f;
      font-weight: bold;
    }

    .table-section {
      margin-bottom: 20px;
    }

    .table-section h3 {
      margin: 0 0 15px 0;
      color: #333;
      font-size: 16px;
      border-bottom: 2px solid #333;
      padding-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-size: 11px;
    }

    table th {
      background-color: #333;
      color: white;
      padding: 10px 8px;
      text-align: left;
      font-weight: bold;
      border: 1px solid #333;
    }

    table td {
      padding: 8px;
      border: 1px solid #ddd;
      vertical-align: top;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tr:hover {
      background-color: #f0f0f0;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .font-bold {
      font-weight: bold;
    }

    .text-green {
      color: #2d5f2f;
      font-weight: bold;
    }

    .text-red {
      color: #dc3545;
    }

    .status-badge {
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 10px;
      font-weight: bold;
      text-align: center;
      color: white;
    }

    .status-paid {
      background-color: #28a745;
    }

    .status-pending {
      background-color: #ffc107;
      color: #000;
    }

    .status-cancelled {
      background-color: #dc3545;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      color: #888;
      font-size: 10px;
      border-top: 1px solid #ddd;
      padding-top: 15px;
    }

    .page-break {
      page-break-before: always;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: #888;
      font-style: italic;
    }

    .owner-info {
      background-color: #e8f4fd;
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid #0066cc;
    }

    .owner-info h4 {
      margin: 0 0 8px 0;
      color: #0066cc;
      font-size: 14px;
    }

    .owner-info p {
      margin: 3px 0;
      font-size: 11px;
      color: #555;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>RIWAYAT PENDAPATAN</h1>
    <h2>{{ $owner->nama }}</h2>
    <p>Laporan digenerate pada: {{ now()->format('d F Y H:i') }} WIB</p>
  </div>

  <!-- Owner Information -->
  <div class="owner-info">
    <h4>Informasi Pemilik</h4>
    <p><strong>Nama:</strong> {{ $owner->nama }}</p>
    <p><strong>Email:</strong> {{ $owner->email }}</p>
    <p><strong>No. Telepon:</strong> {{ $owner->no_telepon ?? 'Tidak tersedia' }}</p>
  </div>

  <!-- Summary Statistics -->
  <div class="summary-section">
    <h3>Ringkasan Pendapatan</h3>
    <div class="summary-grid">
      <div class="summary-row">
        <div class="summary-cell">Total Pendapatan Keseluruhan</div>
        <div class="summary-cell">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Pendapatan Bulan Ini</div>
        <div class="summary-cell">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Pendapatan Tahun Ini</div>
        <div class="summary-cell">Rp {{ number_format($stats['this_year'], 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Total Transaksi</div>
        <div class="summary-cell">{{ $stats['total_transactions'] }} transaksi</div>
      </div>
    </div>
  </div>

  <!-- Revenue History Table -->
  <div class="table-section">
    <h3>Detail Riwayat Pendapatan</h3>

    @if($revenueHistory->count() > 0)
    <table>
      <thead>
        <tr>
          <th width="8%">No</th>
          <th width="12%">Tanggal</th>
          <th width="25%">Motor</th>
          <th width="20%">Penyewa</th>
          <th width="15%">Pendapatan</th>
          <th width="10%">Status</th>
          <th width="10%">Periode</th>
        </tr>
      </thead>
      <tbody>
        @foreach($revenueHistory as $index => $revenue)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>{{ $revenue->created_at->format('d/m/Y') }}</td>
          <td>
            <strong>{{ $revenue->penyewaan->motor->merk ?? 'N/A' }}</strong><br>
            <small>{{ $revenue->penyewaan->motor->no_plat ?? 'N/A' }}</small>
          </td>
          <td>{{ $revenue->penyewaan->user->nama ?? 'N/A' }}</td>
          <td class="text-right text-green">
            Rp {{ number_format($revenue->bagi_hasil_pemilik, 0, ',', '.') }}
          </td>
          <td class="text-center">
            <span class="status-badge status-paid">Dibayar</span>
          </td>
          <td class="text-center">
            {{ $revenue->created_at->format('M Y') }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Summary Footer -->
    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
      <div style="display: table; width: 100%;">
        <div style="display: table-row;">
          <div style="display: table-cell; padding: 5px; font-weight: bold;">
            TOTAL PENDAPATAN:
          </div>
          <div style="display: table-cell; padding: 5px; text-align: right; font-weight: bold; color: #2d5f2f; font-size: 14px;">
            Rp {{ number_format($revenueHistory->sum('bagi_hasil_pemilik'), 0, ',', '.') }}
          </div>
        </div>
      </div>
    </div>

    @else
    <div class="no-data">
      <p>Belum ada riwayat pendapatan yang tercatat.</p>
      <p>Riwayat akan muncul setelah ada transaksi penyewaan yang selesai.</p>
    </div>
    @endif
  </div>

  <!-- Additional Statistics -->
  @if($revenueHistory->count() > 0)
  <div class="summary-section" style="margin-top: 30px;">
    <h3>Analisis Tambahan</h3>
    <div class="summary-grid">
      <div class="summary-row">
        <div class="summary-cell">Rata-rata Pendapatan per Transaksi</div>
        <div class="summary-cell">Rp {{ number_format($revenueHistory->avg('bagi_hasil_pemilik'), 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Pendapatan Tertinggi</div>
        <div class="summary-cell">Rp {{ number_format($revenueHistory->max('bagi_hasil_pemilik'), 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Pendapatan Terendah</div>
        <div class="summary-cell">Rp {{ number_format($revenueHistory->min('bagi_hasil_pemilik'), 0, ',', '.') }}</div>
      </div>
      <div class="summary-row">
        <div class="summary-cell">Motor Paling Produktif</div>
        <div class="summary-cell">
          @php
          $topMotor = $revenueHistory->groupBy('penyewaan.motor.merk')->map(function ($group) {
          return [
          'merk' => $group->first()->penyewaan->motor->merk,
          'total' => $group->sum('bagi_hasil_pemilik'),
          'count' => $group->count()
          ];
          })->sortByDesc('total')->first();
          @endphp
          {{ $topMotor['merk'] ?? 'N/A' }}
          @if($topMotor)
          ({{ $topMotor['count'] }} sewa, Rp {{ number_format($topMotor['total'], 0, ',', '.') }})
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Footer -->
  <div class="footer">
    <p>Dokumen ini digenerate secara otomatis oleh sistem RentalMotor</p>
    <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
  </div>
</body>

</html>