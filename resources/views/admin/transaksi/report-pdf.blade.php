<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Transaksi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #3B82F6;
      padding-bottom: 20px;
    }

    .header h1 {
      margin: 0;
      color: #1E40AF;
      font-size: 24px;
      font-weight: bold;
    }

    .header p {
      margin: 5px 0;
      color: #6B7280;
      font-size: 14px;
    }

    .info-section {
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
    }

    .info-item {
      flex: 1;
    }

    .info-item strong {
      color: #1F2937;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: #F8FAFC;
      border: 1px solid #E5E7EB;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
    }

    .stat-number {
      font-size: 18px;
      font-weight: bold;
      color: #1E40AF;
      margin-bottom: 5px;
    }

    .stat-label {
      color: #6B7280;
      font-size: 11px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 10px;
    }

    th {
      background-color: #3B82F6;
      color: white;
      font-weight: bold;
      padding: 8px 6px;
      text-align: left;
      border: 1px solid #2563EB;
    }

    td {
      padding: 6px;
      border: 1px solid #D1D5DB;
      vertical-align: top;
    }

    tr:nth-child(even) {
      background-color: #F9FAFB;
    }

    tr:hover {
      background-color: #EFF6FF;
    }

    .status-badge {
      display: inline-block;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .status-pending {
      background-color: #FEF3C7;
      color: #92400E;
    }

    .status-confirmed {
      background-color: #DBEAFE;
      color: #1E40AF;
    }

    .status-active {
      background-color: #EDE9FE;
      color: #7C3AED;
    }

    .status-completed {
      background-color: #D1FAE5;
      color: #065F46;
    }

    .status-cancelled {
      background-color: #FEE2E2;
      color: #991B1B;
    }

    .amount {
      font-weight: bold;
      color: #059669;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      color: #6B7280;
      font-size: 10px;
      border-top: 1px solid #E5E7EB;
      padding-top: 15px;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN TRANSAKSI</h1>
    <p>Rental Motor Management System</p>
    <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
  </div>

  <div class="info-section">
    <div class="info-item">
      <strong>Periode:</strong>
      @if($startDate !== 'Semua' && $endDate !== 'Semua')
      {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
      @else
      Semua Data
      @endif
    </div>
    <div class="info-item">
      <strong>Total Transaksi:</strong> {{ $stats['total_transaksi'] }}
    </div>
    <div class="info-item">
      <strong>Total Revenue:</strong> Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
    </div>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-number">{{ $stats['total_transaksi'] }}</div>
      <div class="stat-label">Total Transaksi</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">{{ $stats['completed_transaksi'] }}</div>
      <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">{{ $stats['cancelled_transaksi'] }}</div>
      <div class="stat-label">Dibatalkan</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
      <div class="stat-label">Total Revenue</div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width: 10%;">Kode</th>
        <th style="width: 15%;">Penyewa</th>
        <th style="width: 20%;">Motor</th>
        <th style="width: 10%;">Metode</th>
        <th style="width: 12%;">Jumlah</th>
        <th style="width: 10%;">Status</th>
        <th style="width: 12%;">Tanggal Mulai</th>
        <th style="width: 11%;">Tanggal Selesai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksis as $transaksi)
      <tr>
        <td>{{ $transaksi->kode_transaksi }}</td>
        <td>
          <strong>{{ $transaksi->penyewa->name ?? '-' }}</strong><br>
          <small>{{ $transaksi->penyewa->email ?? '-' }}</small>
        </td>
        <td>
          <strong>{{ $transaksi->motor->merk ?? '-' }} {{ $transaksi->motor->nama_motor ?? '-' }}</strong><br>
          <small>{{ $transaksi->motor->no_plat ?? '-' }}</small>
        </td>
        <td>COD/Cash</td>
        <td class="amount">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
        <td>
          @php
          $statusValue = is_object($transaksi->status) ? $transaksi->status->value : $transaksi->status;
          @endphp
          <span class="status-badge status-{{ $statusValue }}">
            {{ ucfirst($statusValue) }}
          </span>
        </td>
        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align: center; color: #6B7280; font-style: italic;">
          Tidak ada data transaksi
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    <p>Laporan ini dibuat secara otomatis oleh sistem Rental Motor Management</p>
    <p>© {{ date('Y') }} Rental Motor. Semua hak dilindungi.</p>
  </div>
</body>

</html>