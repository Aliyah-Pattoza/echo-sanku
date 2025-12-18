<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Echo Sanku - {{ \Carbon\Carbon::parse($month)->locale('id')->isoFormat('MMMM YYYY') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4A7C59;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4A7C59;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #4A7C59;
            border-bottom: 2px solid #7FB069;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #4A7C59;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary-box {
            background-color: #E8DCC4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .summary-item {
            display: inline-block;
            width: 23%;
            margin-right: 2%;
            margin-bottom: 10px;
        }
        .summary-item h3 {
            color: #4A7C59;
            margin: 0 0 5px 0;
            font-size: 14px;
        }
        .summary-item p {
            font-size: 20px;
            font-weight: bold;
            color: #2D3E2E;
            margin: 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ECHO SANKU</h1>
        <p><strong>Bank Sampah RSUD LDP Jeneponto</strong></p>
        <p>Laporan Periode: {{ \Carbon\Carbon::parse($month)->locale('id')->isoFormat('MMMM YYYY') }}</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
    </div>

    <!-- Summary Statistics -->
    <div class="section">
        <h2>Ringkasan</h2>
        <div class="summary-box">
            <div class="summary-item">
                <h3>Total Transaksi</h3>
                <p>{{ $transactions->count() }}</p>
            </div>
            <div class="summary-item">
                <h3>Total Poin</h3>
                <p>Rp {{ number_format($transactions->sum('total_points'), 0, ',', '.') }}</p>
            </div>
            <div class="summary-item">
                <h3>Total Penarikan</h3>
                <p>Rp {{ number_format($withdrawals->whereIn('status', ['approved', 'completed'])->sum('amount'), 0, ',', '.') }}</p>
            </div>
            <div class="summary-item">
                <h3>Nasabah Aktif</h3>
                <p>{{ $transactions->pluck('user_id')->unique()->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="section">
        <h2>Daftar Transaksi Penukaran</h2>
        @if($transactions->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Nasabah</th>
                        <th>Item</th>
                        <th>Total Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $transaction->transaction_code }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>
                                @foreach($transaction->items as $item)
                                    • {{ $item->wasteType->name }} ({{ $item->quantity }} {{ $item->wasteType->unit }})<br>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right;">TOTAL:</th>
                        <th>Rp {{ number_format($transactions->sum('total_points'), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>Tidak ada transaksi pada periode ini.</p>
        @endif
    </div>

    <!-- Withdrawals Table -->
    <div class="section">
        <h2>Daftar Penarikan</h2>
        @if($withdrawals->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Nasabah</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $index => $withdrawal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $withdrawal->requested_at->format('d/m/Y') }}</td>
                            <td>{{ $withdrawal->request_code }}</td>
                            <td>{{ $withdrawal->user->name }}</td>
                            <td style="text-transform: capitalize;">{{ ucfirst($withdrawal->method) }}</td>
                            <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                            <td style="text-transform: capitalize;">{{ ucfirst($withdrawal->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right;">TOTAL DISETUJUI:</th>
                        <th colspan="2">Rp {{ number_format($withdrawals->whereIn('status', ['approved', 'completed'])->sum('amount'), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>Tidak ada penarikan pada periode ini.</p>
        @endif
    </div>

    <div class="footer">
        <p><strong>Echo Sanku - Bank Sampah RSUD LDP Jeneponto</strong></p>
        <p>Alamat: RSUD Lanto Daeng Pasewang, Jeneponto | Telepon: +62 852-4283-4442</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 30px; background-color: #4A7C59; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            Print / Save as PDF
        </button>
    </div>
</body>
</html>