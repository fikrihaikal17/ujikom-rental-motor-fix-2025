<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Penyewaan Motor</title>
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
      grid-template-columns: repeat(2, 1fr);
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

    .status-cancelled {
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

    .motor-info {
      font-weight: bold;
    }

    .motor-details {
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
  </style>
</head>

<body>
  <div class="header">
    <h1>RENTAL MOTOR</h1>
    <h2>Riwayat Penyewaan Motor</h2>
  </div>

  <div class="info-section">
    <div class="info-row">
      <span class="info-label">Nama Penyewa:</span>
      <span>{{ $user->name }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Email:</span>
      <span>{{ $user->email }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">No. Telepon:</span>
      <span>{{ $user->phone ?? '-' }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Tanggal Cetak:</span>
      <span>{{ now()->format('d F Y H:i:s') }}</span>
    </div>
    @if($filters['year'] || $filters['month'] || $filters['status'])
    <div class="info-row">
      <span class="info-label">Filter:</span>
      <span>
        @if($filters['year'])
        Tahun: {{ $filters['year'] }}
        @endif
        @if($filters['month'])
        {{ $filters['year'] ? ', ' : '' }}Bulan: {{ $monthNames[$filters['month']] ?? '' }}
        @endif
        @if($filters['status'])
        {{ ($filters['year'] || $filters['month']) ? ', ' : '' }}Status: {{ ucfirst($filters['status']) }}
        @endif
      </span>
    </div>
    @endif
  </div>

  <div class="stats-section">
    <h3 style="margin-top: 0; margin-bottom: 15px; text-align: center;">Ringkasan Statistik</h3>
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-value">{{ $totalBookings }}</span>
        <div class="stat-label">Total Booking</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $completedBookings }}</span>
        <div class="stat-label">Selesai</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">{{ $cancelledBookings }}</span>
        <div class="stat-label">Dibatalkan</div>
      </div>
      <div class="stat-item">
        <span class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
        <div class="stat-label">Total Pengeluaran</div>
      </div>
    </div>
  </div>

  @if($history->count() > 0)
  <table>
    <thead>
      <tr>
        <th width="3%">No</th>
        <th width="18%">Motor</th>
        <th width="12%">Periode Sewa</th>
        <th width="8%">Durasi</th>
        <th width="10%">Harga Sewa</th>
        <th width="10%">Pembayaran</th>
        <th width="8%">Status</th>
        <th width="12%">Tanggal Booking</th>
        <th width="12%">Pemilik Motor</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; $grandTotal = 0; @endphp
      @foreach($history as $booking)
      <tr>
        <td style="text-align: center;">{{ $no++ }}</td>
        <td>
          <div class="motor-info">{{ $booking->motor->nama_motor }}</div>
          <div class="motor-details">
            {{ $booking->motor->merk }} | {{ $booking->motor->no_plat ?? $booking->motor->plat_nomor }}
          </div>
        </td>
        <td>
          <div>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d/m/Y') }}</div>
          <div class="motor-details">s/d {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d/m/Y') }}</div>
        </td>
        <td style="text-align: center;">
          {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) }} hari
        </td>
        <td class="currency">
          Rp {{ number_format($booking->harga, 0, ',', '.') }}
          @if($booking->status->value == 'completed')
          @php $grandTotal += $booking->harga; @endphp
          @endif
        </td>
        <td style="text-align: center;">
          <div style="font-size: 10px;">COD/Cash</div>
          @if($booking->status->value == 'completed')
          <div style="color: #059669; font-size: 9px;">Lunas</div>
          @elseif($booking->status->value == 'cancelled')
          <div style="color: #dc2626; font-size: 9px;">Dibatalkan</div>
          @else
          <div style="color: #d97706; font-size: 9px;">Pending</div>
          @endif
        </td>
        <td>
          <span class="status-badge {{ $booking->status->value == 'completed' ? 'status-completed' : 'status-cancelled' }}">
            {{ $booking->status->value == 'completed' ? 'Selesai' : 'Dibatalkan' }}
          </span>
        </td>
        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ $booking->motor->owner->name ?? '-' }}</td>
      </tr>
      @endforeach
      @if($grandTotal > 0)
      <tr class="total-row">
        <td colspan="4" style="text-align: right;">TOTAL PENGELUARAN:</td>
        <td class="currency">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
        <td colspan="4"></td>
      </tr>
      @endif
    </tbody>
  </table>
  @else
  <div class="no-data">
    <h3>Tidak Ada Data</h3>
    <p>
      @if($filters['year'] || $filters['month'] || $filters['status'])
      Tidak ada riwayat penyewaan yang sesuai dengan filter yang dipilih.
      @else
      Belum ada riwayat penyewaan motor.
      @endif
    </p>
  </div>
  @endif

  <div class="footer">
    <p>Dokumen ini digenerate secara otomatis pada {{ now()->format('d F Y \p\u\k\u\l H:i:s') }}</p>
    <p>© {{ date('Y') }} Rental Motor - Sistem Manajemen Penyewaan Motor</p>
  </div>
</body>

</html>