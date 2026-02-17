<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran Infaq</title>
</head>
<body style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 0; background-color: #f8f9fa;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #2596be; margin: 0; font-size: 24px;">Instruksi Pembayaran Infaq</h2>
            <p style="color: #6c757d; font-size: 14px; margin-top: 5px;">Mohon segera selesaikan pembayaran Anda</p>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="margin: 0 0 20px;">Assalamu'alaikum <strong>{{ $transaction->name }}</strong>,</p>
            <p style="margin: 0 0 20px;">
                Terima kasih telah menyalurkan infaq melalui WakafApp. Berikut adalah detail pembayaran infaq Anda:
            </p>

            <!-- Transaction Details -->
            <div style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Invoice ID</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">#{{ $transaction->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Program Infaq</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">{{ $transaction->infaqCategory->name }}</td>
                    </tr>
                </table>
                <div style="border-top: 1px dashed #dee2e6; margin: 10px 0;"></div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Nominal Infaq</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($transaction->unique_code > 0)
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Kode Unik</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">{{ $transaction->unique_code }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding-top: 15px; font-weight: 700;">Total Transfer</td>
                        <td align="right" style="padding-top: 15px; font-weight: 700; color: #2596be; font-size: 18px;">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</td>
                    </tr>
                </table>
                 @if($transaction->unique_code > 0)
                <p style="font-size: 12px; color: #dc3545; margin-top: 10px; margin-bottom: 0;">*Mohon transfer <strong>tepat hingga 3 digit terakhir</strong> untuk verifikasi otomatis.</p>
                @endif
            </div>

            <!-- Payment Method -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; margin: 0 0 15px; color: #495057;">Silakan Transfer ke Rekening Berikut:</h3>
                
                @if($transaction->paymentMethod)
                <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; display: flex; align-items: center;">
                    @if($transaction->paymentMethod->logo_url)
                        <img src="{{ asset('storage/' . $transaction->paymentMethod->logo_url) }}" alt="{{ $transaction->paymentMethod->bank_name }}" style="height: 30px; margin-right: 15px;">
                    @else
                        <div style="font-weight: 700; font-size: 16px; margin-right: 15px;">{{ $transaction->paymentMethod->bank_name }}</div>
                    @endif
                    <div>
                        <div style="font-size: 14px; color: #6c757d;">Nomor Rekening</div>
                        <div style="font-size: 18px; font-weight: 700; color: #212529; letter-spacing: 1px;">{{ $transaction->paymentMethod->account_number }}</div>
                        <div style="font-size: 14px; color: #495057;">a.n {{ $transaction->paymentMethod->account_name }}</div>
                    </div>
                </div>
                @else
                <div style="background-color: #e9ecef; padding: 15px; border-radius: 8px; text-align: center;">
                    Metode Pembayaran Otomatis
                </div>
                @endif
            </div>

            <p style="margin: 0 0 20px;">
                Setelah melakukan transfer, silakan konfirmasi pembayaran Anda melalui tombol di bawah ini:
            </p>

            <div style="text-align: center; margin-bottom: 30px;">
                <a href="{{ route('infaq.success', $transaction->invoice_number) }}" style="display: inline-block; background-color: #2596be; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 50px; font-weight: 600; font-size: 16px;">Konfirmasi Pembayaran</a>
            </div>
            
            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                Semoga Allah menerima infaq Anda dan melipat gandakan pahalanya. Aamiin.
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #e9ecef; padding-top: 20px; text-align: center; font-size: 12px; color: #adb5bd;">
            <p style="margin: 0;">&copy; {{ date('Y') }} WakafApp. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
