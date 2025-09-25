<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Motor - {{ $owner->name }}</title>
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
            padding-bottom: 15px;
        }
        .header h1 {
            color: #333;
            font-size: 24px;
            margin: 0 0 5px 0;
        }
        .header h2 {
            color: #666;
            font-size: 16px;
            margin: 0 0 10px 0;
            font-weight: normal;
        }
        .owner-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }
        .owner-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .stats-container {
            margin-bottom: 25px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: #f1f5f9;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
            display: block;
        }
        .stat-label {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .motors-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .motors-table th,
        .motors-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .motors-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            font-size: 11px;
        }
        .motors-table td {
            font-size: 10px;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-available { background-color: #dcfce7; color: #166534; }
        .status-rented { background-color: #dbeafe; color: #1d4ed8; }
        .status-pending { background-color: #fef3c7; color: #b45309; }
        .status-maintenance { background-color: #fed7d7; color: #c53030; }
        .status-verified { background-color: #d1fae5; color: #065f46; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .no-motors {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
        .page-break {
            page-break-before: always;
        }
        .currency {
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🏍️ RIDENOW - Rental Motor</h1>
        <h2>Daftar Motor Milik {{ $owner->name }}</h2>
        <p style="margin: 5px 0; color: #666;">Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
        @if($motors->count() > 0)
        <p style="margin: 5px 0; color: #888; font-size: 11px;">{{ $motors->count() }} motor terdaftar</p>
        @endif
    </div>

    <!-- Owner Information -->
    <div class="owner-info">
        <h3>Informasi Pemilik Motor</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama:</span> {{ $owner->name }}
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span> {{ $owner->email }}
            </div>
            <div class="info-item">
                <span class="info-label">No. HP:</span> {{ $owner->phone ?? 'Tidak tersedia' }}
            </div>
            <div class="info-item">
                <span class="info-label">Alamat:</span> {{ $owner->alamat ?? 'Tidak tersedia' }}
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-container">
        <h3 style="margin-bottom: 15px;">Ringkasan Motor</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total_motors'] }}</span>
                <div class="stat-label">Total Motor</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['available_motors'] }}</span>
                <div class="stat-label">Tersedia</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['rented_motors'] }}</span>
                <div class="stat-label">Disewa</div>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['pending_motors'] }}</span>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <span class="stat-number currency">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
    </div>

    <!-- Motors Table -->
    @if($motors->count() > 0)
        <table class="motors-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 16%;">Nama Motor</th>
                    <th style="width: 14%;">Merk/Model</th>
                    <th style="width: 6%;">Tahun</th>
                    <th style="width: 6%;">CC</th>
                    <th style="width: 10%;">No. Plat</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 12%;">Tarif/Hari</th>
                    <th style="width: 8%;">Total Sewa</th>
                    <th style="width: 14%;">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($motors as $index => $motor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $motor->nama_motor }}</strong></td>
                    <td>{{ $motor->merk }} {{ $motor->model }}</td>
                    <td>{{ $motor->tahun }}</td>
                    <td>{{ $motor->tipe_cc }}cc</td>
                    <td>{{ $motor->no_plat ?? 'Belum ada' }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($motor->status->value) }}">
                            {{ $motor->status->getDisplayName() }}
                        </span>
                    </td>
                    <td>
                        @if($motor->tarifRental)
                            <span class="currency">Rp {{ number_format($motor->tarifRental->harga_per_hari, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #999;">Belum diset</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $motor->total_rentals ?? 0 }}x</td>
                    <td>
                        @if($motor->total_revenue)
                            <span class="currency">Rp {{ number_format($motor->total_revenue, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #999;">Rp 0</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-motors">
            <p>Belum ada motor yang terdaftar</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem RideNow</p>
        <p>© {{ now()->year }} RideNow - Rental Motor. Semua hak cipta dilindungi.</p>
    </div>
</body>
</html>