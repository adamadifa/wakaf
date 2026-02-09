<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakat Diterima</title>
</head>
<body style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 0; background-color: #f8f9fa;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="background-color: #d1e7dd; color: #0f5132; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 30px;">
                ✓
            </div>
            <h2 style="color: #198754; margin: 0; font-size: 24px;">Alhamdulillah, Zakat Diterima</h2>
            <p style="color: #6c757d; font-size: 14px; margin-top: 5px;">Terima kasih telah menunaikan zakat melalui WakafApp</p>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="margin: 0 0 20px;">Assalamu'alaikum <strong>{{ $transaction->name }}</strong>,</p>
            <p style="margin: 0 0 20px;">
                Semoga Allah SWT menerima zakat Anda, menyucikan harta Anda, dan memberikan keberkahan atas apa yang tersisa.
                Zakat Anda untuk program <strong>{{ $transaction->zakatType->name }}</strong> telah berhasil diverifikasi oleh tim kami.
            </p>

            <div style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Invoice ID</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">#{{ $transaction->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6c757d; font-size: 14px;">Tanggal</td>
                        <td align="right" style="padding: 8px 0; font-weight: 600;">{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px dashed #dee2e6; margin: 10px 0; padding-top: 10px; font-weight: 700;">Nominal Zakat</td>
                        <td align="right" style="border-top: 1px dashed #dee2e6; margin: 10px 0; padding-top: 10px; font-weight: 700; color: #198754; font-size: 18px;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div style="background-color: #fff3cd; color: #664d03; padding: 15px; border-radius: 8px; font-size: 14px; font-style: italic; text-align: center; margin-bottom: 25px;">
                "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka..." <br> (QS. At-Taubah: 103)
            </div>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" style="display: inline-block; background-color: #2596be; color: #ffffff; text-decoration: none; font-weight: 600; padding: 12px 30px; border-radius: 50px; font-size: 16px;">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #e9ecef; padding-top: 20px; text-align: center; font-size: 12px; color: #adb5bd;">
            <p style="margin: 0;">&copy; {{ date('Y') }} WakafApp. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
