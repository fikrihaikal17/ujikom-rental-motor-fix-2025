<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pembayaran</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
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

    .info-section {
      margin-bottom: 25px;
    }

    .info-row {
      display: flex;
      margin-bottom: 5px;
    }

    .info-label {
      font-weight: bold;
      width: 150px;
      display: inline-block;
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
      font-size: 18px;
      font-weight: bold;
      color: #2563eb;
      display: block;
    }

    .stat-label {
      font-size: 11px;
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
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f8f9fa;
      font-weight: bold;
      font-size: 11px;
      text-transform: uppercase;
    }

    td {
      font-size: 11px;
    }

    .status-badge {
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .status-completed {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status-failed {
      background-color: #fee2e2;
      color: #991b1b;
    }

    .total-row {
      background-color: #f3f4f6;
      font-weight: bold;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 15px;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: #666;
    }

    .payment-info {
      font-weight: bold;
    }

    .payment-details {
      font-size: 10px;
      color: #666;
    }

    .currency {
      text-align: right;
      font-weight: bold;
    }

    .page-break {
      page-break-after: always;
    }

    .method-badge {
      background-color: #dcfce7;
      color: #166534;
      padding: 2px 6px;
      border-radius: 8px;
      font-size: 10px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>RENTAL MOTOR</h1>
    <h2>Laporan Pembayaran</h2>
  </div>

  <div class="info-section">
    <div class="info-row">
      <span class="info-label">Periode Laporan:</span>
      <span>{{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Tanggal Cetak:</span>
      <span>{{ now()->format('d F Y H:i:s') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Dicetak Oleh:</span>
      <span>{{ auth()->user()->name }}</span>
    </div>
  </div>

  <div class="stats-section">
    <h3 style="margin-top: 0; margin-bottom: 15px; text-align: center;">Ringkasan Statistik</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-value">{{ $totalPayments }}</span>
        <div class="stat-label">Total Pembayaran</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $verifiedPayments }}</span>
        <div class="stat-label">Berhasil</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $pendingPayments }}</span>
        <div class="stat-label">Gagal</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
        <div class="stat-label">Total Nilai</div>
      </div>
    </div>
  </div>

  @if($payments->count() > 0)
  <table>
    <thead>
      <tr>
        <th width="3%">No</th>
        <th width="10%">ID Transaksi</th>
        <th width="15%">Penyewa</th>
        <th width="15%">Motor</th>
        <th width="12%">Tanggal Sewa</th>
        <th width="10%">Nilai</th>
        <th width="10%">Metode</th>
        <th width="10%">Status</th>
        <th width="15%">Tanggal Transaksi</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; $grandTotal = 0; @endphp
      @foreach($payments as $payment)
      <tr>
        <td style="text-align: center;">{{ $no++ }}</td>
        <td>{{ $payment->transaction_id }}</td>
        <td>
          <div class="payment-info">{{ $payment->penyewa->name }}</div>
          <div class="payment-details">{{ $payment->penyewa->email }}</div>
        </td>
        <td>
          <div class="payment-info">{{ $payment->motor->nama_motor }}</div>
          <div class="payment-details">{{ $payment->motor->merk }} | {{ $payment->motor->no_plat }}</div>
        </td>
        <td>
          <div>{{ \Carbon\Carbon::parse($payment->tanggal_mulai)->format('d/m/Y') }}</div>
          <div class="payment-details">s/d {{ \Carbon\Carbon::parse($payment->tanggal_selesai)->format('d/m/Y') }}</div>
        </td>
        <td class="currency">
          Rp {{ number_format($payment->amount, 0, ',', '.') }}
          @if($payment->payment_status == 'completed')
          @php $grandTotal += $payment->amount; @endphp
          @endif
        </td>
        <td style="text-align: center;">
          <span class="method-badge">COD/Cash</span>
        </td>
        <td>
          <span class="status-badge {{ $payment->payment_status == 'completed' ? 'status-completed' : 'status-failed' }}">
            {{ $payment->payment_status == 'completed' ? 'Berhasil' : 'Gagal' }}
          </span>
        </td>
        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
      </tr>
      @endforeach
      @if($grandTotal > 0)
      <tr class="total-row">
        <td colspan="5" style="text-align: right;">TOTAL PEMBAYARAN BERHASIL:</td>
        <td class="currency">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
        <td colspan="3"></td>
      </tr>
      @endif
    </tbody>
  </table>
  @else
  <div class="no-data">
    <h3>Tidak Ada Data</h3>
    <p>Tidak ada data pembayaran pada periode {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
  </div>
  @endif

  <div class="footer">
    <p>Dokumen ini digenerate secara otomatis pada {{ now()->format('d F Y \p\u\k\u\l H:i:s') }}</p>
    <p>© {{ date('Y') }} Rental Motor - Sistem Manajemen Penyewaan Motor</p>
  </div>
</body>

</html>