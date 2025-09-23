<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Analytics</title>
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
      border-bottom: 3px solid #3B82F6;
      padding-bottom: 20px;
    }

    .header h1 {
      margin: 0;
      color: #1E40AF;
      font-size: 28px;
      font-weight: bold;
    }

    .header p {
      margin: 5px 0;
      color: #6B7280;
      font-size: 14px;
    }

    .summary-section {
      margin-bottom: 25px;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      margin-bottom: 25px;
    }

    .summary-card {
      background: #F8FAFC;
      border: 1px solid #E5E7EB;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
    }

    .summary-number {
      font-size: 22px;
      font-weight: bold;
      color: #1E40AF;
      margin-bottom: 5px;
    }

    .summary-label {
      color: #6B7280;
      font-size: 11px;
      text-transform: uppercase;
    }

    .section-title {
      background: #3B82F6;
      color: white;
      padding: 10px 15px;
      margin: 20px 0 15px 0;
      font-weight: bold;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-size: 10px;
    }

    th {
      background-color: #F3F4F6;
      color: #374151;
      font-weight: bold;
      padding: 8px 6px;
      text-align: left;
      border: 1px solid #D1D5DB;
    }

    td {
      padding: 6px;
      border: 1px solid #E5E7EB;
      vertical-align: top;
    }

    tr:nth-child(even) {
      background-color: #F9FAFB;
    }

    .revenue-amount {
      font-weight: bold;
      color: #059669;
    }

    .status-pending {
      background-color: #FEF3C7;
      color: #92400E;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
    }

    .status-confirmed {
      background-color: #DBEAFE;
      color: #1E40AF;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
    }

    .status-active {
      background-color: #EDE9FE;
      color: #7C3AED;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
    }

    .status-completed {
      background-color: #D1FAE5;
      color: #065F46;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
    }

    .status-cancelled {
      background-color: #FEE2E2;
      color: #991B1B;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 9px;
    }

    .chart-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 25px;
    }

    .chart-card {
      background: #F8FAFC;
      border: 1px solid #E5E7EB;
      border-radius: 8px;
      padding: 15px;
    }

    .chart-title {
      font-weight: bold;
      color: #374151;
      margin-bottom: 10px;
      font-size: 12px;
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

    .flex-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN ANALYTICS PENYEWAAN MOTOR</h1>
    <p>Sistem Manajemen Rental Motor</p>
    <p>Periode: {{ date('Y') }} | Dicetak pada: {{ date('d F Y H:i:s') }}</p>
  </div>

  <!-- Summary Statistics -->
  <div class="summary-section">
    <h2 class="section-title">📊 RINGKASAN STATISTIK</h2>
    <div class="summary-grid">
      <div class="summary-card">
        <div class="summary-number">{{ number_format($totalBookings) }}</div>
        <div class="summary-label">Total Booking</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="summary-label">Total Revenue</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">{{ number_format($totalMotors) }}</div>
        <div class="summary-label">Total Motor</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">{{ number_format($totalUsers) }}</div>
        <div class="summary-label">Total Users</div>
      </div>
    </div>

    <div class="summary-grid">
      <div class="summary-card">
        <div class="summary-number">{{ number_format($completedBookings) }}</div>
        <div class="summary-label">Booking Selesai</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">{{ number_format($activeBookings) }}</div>
        <div class="summary-label">Booking Aktif</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">{{ number_format($pendingBookings) }}</div>
        <div class="summary-label">Booking Pending</div>
      </div>
      <div class="summary-card">
        <div class="summary-number">{{ number_format($cancelledBookings) }}</div>
        <div class="summary-label">Booking Dibatalkan</div>
      </div>
    </div>
  </div>

  <!-- Monthly Statistics -->
  <h2 class="section-title">📈 STATISTIK BULANAN {{ date('Y') }}</h2>
  <div class="chart-section">
    <div class="chart-card">
      <div class="chart-title">Booking Per Bulan</div>
      <table>
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Jumlah Booking</th>
            <th>Persentase</th>
          </tr>
        </thead>
        <tbody>
          @php
          $monthNames = [
          1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
          5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
          9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
          ];
          $totalMonthlyBookings = $monthlyBookings->sum('count');
          @endphp
          @forelse($monthlyBookings as $booking)
          <tr>
            <td>{{ $monthNames[$booking->month] }}</td>
            <td>{{ $booking->count }}</td>
            <td>{{ $totalMonthlyBookings > 0 ? number_format(($booking->count / $totalMonthlyBookings) * 100, 1) : 0 }}%</td>
          </tr>
          @empty
          <tr>
            <td colspan="3" style="text-align: center; color: #6B7280;">Tidak ada data booking</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="chart-card">
      <div class="chart-title">Revenue Per Bulan</div>
      <table>
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Revenue</th>
            <th>Persentase</th>
          </tr>
        </thead>
        <tbody>
          @php
          $totalMonthlyRevenue = $monthlyRevenue->sum('total');
          @endphp
          @forelse($monthlyRevenue as $revenue)
          <tr>
            <td>{{ $monthNames[$revenue->month] }}</td>
            <td class="revenue-amount">Rp {{ number_format($revenue->total, 0, ',', '.') }}</td>
            <td>{{ $totalMonthlyRevenue > 0 ? number_format(($revenue->total / $totalMonthlyRevenue) * 100, 1) : 0 }}%</td>
          </tr>
          @empty
          <tr>
            <td colspan="3" style="text-align: center; color: #6B7280;">Tidak ada data revenue</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Top Performing Motors -->
  <h2 class="section-title">🏆 TOP 10 MOTOR TERBAIK</h2>
  <table>
    <thead>
      <tr>
        <th style="width: 5%;">Rank</th>
        <th style="width: 25%;">Motor</th>
        <th style="width: 20%;">Pemilik</th>
        <th style="width: 15%;">Total Booking</th>
        <th style="width: 20%;">Total Revenue</th>
        <th style="width: 15%;">Rata-rata per Booking</th>
      </tr>
    </thead>
    <tbody>
      @forelse($topMotors as $index => $motor)
      <tr>
        <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
        <td><strong>{{ $motor['motor'] }}</strong></td>
        <td>{{ $motor['owner'] }}</td>
        <td style="text-align: center;">{{ $motor['total_bookings'] }}</td>
        <td class="revenue-amount">Rp {{ number_format($motor['total_revenue'], 0, ',', '.') }}</td>
        <td class="revenue-amount">
          Rp {{ $motor['total_bookings'] > 0 ? number_format($motor['total_revenue'] / $motor['total_bookings'], 0, ',', '.') : 0 }}
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align: center; color: #6B7280;">Tidak ada data motor</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Motor Types Distribution -->
  <h2 class="section-title">🚗 DISTRIBUSI JENIS MOTOR</h2>
  <table>
    <thead>
      <tr>
        <th style="width: 50%;">Merk Motor</th>
        <th style="width: 25%;">Jumlah Motor</th>
        <th style="width: 25%;">Persentase</th>
      </tr>
    </thead>
    <tbody>
      @php
      $totalMotorTypes = $motorTypes->sum('count');
      @endphp
      @forelse($motorTypes as $type)
      <tr>
        <td><strong>{{ $type->merk }}</strong></td>
        <td style="text-align: center;">{{ $type->count }}</td>
        <td style="text-align: center;">{{ $totalMotorTypes > 0 ? number_format(($type->count / $totalMotorTypes) * 100, 1) : 0 }}%</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="text-align: center; color: #6B7280;">Tidak ada data motor</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Status Distribution -->
  <h2 class="section-title">📋 DISTRIBUSI STATUS BOOKING</h2>
  <table>
    <thead>
      <tr>
        <th style="width: 50%;">Status</th>
        <th style="width: 25%;">Jumlah</th>
        <th style="width: 25%;">Persentase</th>
      </tr>
    </thead>
    <tbody>
      @php
      $totalStatus = array_sum($statusDistribution->toArray());
      @endphp
      @forelse($statusDistribution as $status => $count)
      <tr>
        <td>
          <span class="status-{{ $status }}">{{ ucfirst($status) }}</span>
        </td>
        <td style="text-align: center;">{{ $count }}</td>
        <td style="text-align: center;">{{ $totalStatus > 0 ? number_format(($count / $totalStatus) * 100, 1) : 0 }}%</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="text-align: center; color: #6B7280;">Tidak ada data status</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    <p><strong>Laporan Analytics Rental Motor</strong></p>
    <p>Laporan ini dibuat secara otomatis berdasarkan data real sistem</p>
    <p>© {{ date('Y') }} Rental Motor Management System. Semua hak dilindungi.</p>
  </div>
</body>

</html>