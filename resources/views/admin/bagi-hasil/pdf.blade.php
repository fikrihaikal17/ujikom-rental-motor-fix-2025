<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.4;
      margin: 0;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    .header p {
      margin: 5px 0 0 0;
      color: #666;
    }

    .summary {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
    }

    .summary-item {
      text-align: center;
    }

    .summary-item h3 {
      margin: 0 0 5px 0;
      font-size: 14px;
      color: #333;
    }

    .summary-item p {
      margin: 0;
      font-size: 16px;
      font-weight: bold;
      color: #007bff;
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
    }

    td {
      font-size: 10px;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .status-settled {
      background-color: #d4edda;
      color: #155724;
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 9px;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 9px;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>{{ $title }}</h1>
    <p>Tanggal: {{ $date }}</p>
  </div>

  <div class="summary">
    <div class="summary-item">
      <h3>Total Revenue</h3>
      <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="summary-item">
      <h3>Bagian Owner</h3>
      <p>Rp {{ number_format($totalOwnerShare, 0, ',', '.') }}</p>
    </div>
    <div class="summary-item">
      <h3>Bagian Admin</h3>
      <p>Rp {{ number_format($totalAdminShare, 0, ',', '.') }}</p>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pemilik Motor</th>
        <th>Motor</th>
        <th>Total Pendapatan</th>
        <th>Bagi Hasil Pemilik</th>
        <th>Bagi Hasil Admin</th>
        <th>Persentase</th>
        <th>Status</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @forelse($bagiHasils as $index => $bagiHasil)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{ $bagiHasil->penyewaan->motor->user->name ?? '-' }}</td>
        <td>{{ $bagiHasil->penyewaan->motor->nama_motor ?? '-' }}</td>
        <td class="text-right">Rp {{ number_format($bagiHasil->total_pendapatan, 0, ',', '.') }}</td>
        <td class="text-right">Rp {{ number_format($bagiHasil->bagi_hasil_pemilik, 0, ',', '.') }}</td>
        <td class="text-right">Rp {{ number_format($bagiHasil->bagi_hasil_admin, 0, ',', '.') }}</td>
        <td class="text-center">{{ number_format($bagiHasil->owner_percentage, 1) }}% / {{ number_format($bagiHasil->admin_percentage, 1) }}%</td>
        <td class="text-center">
          @if($bagiHasil->settled_at)
          <span class="status-settled">Diselesaikan</span>
          @else
          <span class="status-pending">Menunggu</span>
          @endif
        </td>
        <td class="text-center">{{ $bagiHasil->created_at->format('d/m/Y') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="9" class="text-center">Tidak ada data bagi hasil</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    <p>Laporan ini dibuat secara otomatis oleh sistem RideNow pada {{ now()->format('d F Y H:i:s') }}</p>
  </div>
</body>

</html>