<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Laporan Transaksi' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #f5f5f5;
            line-height: 1.4;
        }

        .page {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 30px 40px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }

        /* === KOP SURAT === */
        .kop-surat {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-bottom: 15px;
            border-bottom: 3px double #0E2C4C;
            margin-bottom: 25px;
        }
        .kop-logo {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
        }
        .kop-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-text h1 {
            font-size: 18px;
            font-weight: 800;
            color: #0E2C4C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .kop-text p {
            font-size: 10px;
            color: #555;
        }
        .kop-text .tagline {
            font-style: italic;
            color: #0F5B73;
            font-size: 10px;
            margin-top: 2px;
        }
        .kop-spacer {
            width: 70px;
            flex-shrink: 0;
        }

        /* === REPORT TITLE === */
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            font-size: 16px;
            font-weight: 700;
            color: #0E2C4C;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .report-title .periode {
            font-size: 11px;
            color: #666;
        }

        /* === SUMMARY === */
        .summary-grid {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .summary-item {
            flex: 1;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
        }
        .summary-item .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .summary-item .value {
            font-size: 14px;
            font-weight: 800;
            color: #0E2C4C;
        }
        .summary-item .value.green { color: #16a34a; }

        /* === TABLE === */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead th {
            background: #0E2C4C;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        thead th:first-child {
            border-radius: 4px 0 0 0;
        }
        thead th:last-child {
            border-radius: 0 4px 0 0;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            font-size: 10.5px;
        }
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        tbody tr:hover {
            background: #f0f7ff;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }
        .font-mono { font-family: 'Courier New', monospace; font-size: 10px; }
        
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-failed { background: #fee2e2; color: #991b1b; }
        .badge-infaq { background: #d1fae5; color: #065f46; }
        .badge-zakat { background: #ede9fe; color: #5b21b6; }
        .badge-donasi { background: #dbeafe; color: #1e40af; }

        tfoot td {
            padding: 10px;
            font-weight: 800;
            font-size: 12px;
            background: #f8fafc;
            border-top: 2px solid #0E2C4C;
        }

        /* === FOOTER === */
        .report-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .footer-left {
            font-size: 9px;
            color: #999;
        }
        .footer-right {
            text-align: center;
        }
        .footer-right .date {
            font-size: 10px;
            color: #555;
            margin-bottom: 50px;
        }
        .footer-right .sign-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 0 auto;
            padding-top: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #333;
        }

        /* === PRINT STYLES === */
        @media print {
            body { background: white; }
            .page {
                max-width: none;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            .no-print { display: none !important; }
        }

        /* === PRINT TOOLBAR === */
        .print-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #0E2C4C;
            color: white;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .print-toolbar .info {
            font-size: 13px;
            font-weight: 600;
        }
        .print-toolbar .actions {
            display: flex;
            gap: 10px;
        }
        .print-toolbar button {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-print {
            background: #4ade80;
            color: #052e16;
        }
        .btn-print:hover { background: #22c55e; }
        .btn-close {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .btn-close:hover { background: rgba(255,255,255,0.25); }
        
        .page { margin-top: 70px; }
        @media print { .page { margin-top: 0; } }
    </style>
</head>
<body>

<!-- Print Toolbar -->
<div class="print-toolbar no-print">
    <div class="info">📄 {{ $pageTitle ?? 'Laporan Transaksi' }}</div>
    <div class="actions">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Sekarang</button>
        <button class="btn-close" onclick="window.close()">✕ Tutup</button>
    </div>
</div>

<div class="page">
    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-logo">
            @if(isset($setting) && $setting->logo)
                <img src="{{ asset($setting->logo) }}" alt="Logo">
            @else
                <img src="{{ asset('images/logo_dashboard.png') }}" alt="Logo">
            @endif
        </div>
        <div class="kop-text">
            <h1>{{ config('app.name', 'Lembaga Amil Zakat') }}</h1>
            @if(isset($setting) && $setting->address)
                <p>{{ $setting->address }}</p>
            @endif
            @if(isset($setting) && $setting->phone_number)
                <p>Telp: {{ $setting->phone_number }}</p>
            @endif
            @if(isset($setting) && $setting->short_description)
                <p class="tagline">{{ $setting->short_description }}</p>
            @endif
        </div>
        <div class="kop-spacer"></div>
    </div>

    <!-- REPORT TITLE -->
    <div class="report-title">
        <h2>{{ $pageTitle ?? 'Laporan Transaksi' }}</h2>
        <div class="periode">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} — {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</div>
    </div>

    <!-- SUMMARY -->
    <div class="summary-grid">
        <div class="summary-item">
            <div class="label">Total Terkonfirmasi</div>
            <div class="value green">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ number_format($totalTransactions) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Menunggu Pembayaran</div>
            <div class="value">{{ number_format($pendingTransactions) }}</div>
        </div>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>
                    @if(isset($forceType) && $forceType == 'zakat')
                        Jenis Zakat
                    @elseif(isset($forceType) && $forceType == 'donation')
                        Program Wakaf
                    @elseif(isset($forceType) && $forceType == 'infaq')
                        Program Infaq
                    @else
                        Tipe / Detail
                    @endif
                </th>
                <th>Donatur</th>
                <th class="text-right">Nominal</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td class="font-mono">{{ $transaction->invoice_number }}</td>
                <td>
                    @if(!isset($forceType) || $forceType == 'all')
                        <span class="badge badge-{{ strtolower($transaction->type == 'Zakat' ? 'zakat' : ($transaction->type == 'Infaq' ? 'infaq' : 'donasi')) }}">{{ $transaction->type }}</span>
                        <span style="margin-left: 4px;">{{ $transaction->details }}</span>
                    @else
                        {{ $transaction->details }}
                    @endif
                </td>
                <td>
                    <div class="font-bold">{{ $transaction->name }}</div>
                    <div style="font-size: 9px; color: #888;">{{ $transaction->email }}</div>
                </td>
                <td class="text-right font-bold">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($transaction->status == 'confirmed')
                        <span class="badge badge-success">Berhasil</span>
                    @elseif($transaction->status == 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @else
                        <span class="badge badge-failed">Gagal</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 30px; color: #999;">Tidak ada data transaksi ditemukan</td>
            </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($transactions->sum('total_transfer'), 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- FOOTER -->
    <div class="report-footer">
        <div class="footer-left">
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            <p>{{ $pageTitle }} — {{ config('app.name') }}</p>
        </div>
        <div class="footer-right">
            <div class="date">{{ now()->translatedFormat('d F Y') }}</div>
            <div class="sign-line">Penanggung Jawab</div>
        </div>
    </div>
</div>

</body>
</html>
