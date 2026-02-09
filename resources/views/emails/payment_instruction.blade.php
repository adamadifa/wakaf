<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #F8F9FA;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F8F9FA; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: #FFFFFF; font-size: 24px; font-weight: 700;">Instruksi Pembayaran</h1>
                            <p style="margin: 10px 0 0; color: #E0E0E0; font-size: 14px;">Mohon segera selesaikan pembayaran Anda</p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #212529; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $donation->is_anonymous ? 'Hamba Allah' : $donation->donor->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #6C757D; font-size: 14px; line-height: 1.6;">
                                Terima kasih atas donasi Anda untuk program <strong>{{ $donation->campaign->title }}</strong>. Berikut adalah rincian pembayaran yang harus Anda lakukan:
                            </p>
                            
                            <!-- Payment Details Box -->
                            <div style="background: #F8F9FA; border: 1px solid #DEE2E6; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Nominal Donasi</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($donation->admin_fee > 0)
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Biaya Admin</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">Rp {{ number_format($donation->admin_fee, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                    @if($donation->unique_code > 0)
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Kode Unik</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">{{ $donation->unique_code }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="padding-top: 10px; border-top: 1px dashed #DEE2E6; color: #212529; font-weight: 700; font-size: 16px;">Total Tagihan</td>
                                        <td align="right" style="padding-top: 10px; border-top: 1px dashed #DEE2E6; color: #0d6efd; font-weight: 700; font-size: 18px;">Rp {{ number_format($donation->total_transfer, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>

                            @if(!$donation->snap_token && $donation->paymentMethod)
                            <!-- Manual Transfer Instructions -->
                            <p style="margin: 0 0 10px; color: #6C757D; font-size: 14px; font-weight: 600;">Silakan transfer ke rekening berikut:</p>
                            <div style="background: #fff; border: 1px solid #DEE2E6; border-radius: 8px; padding: 15px; margin-bottom: 25px; display: flex; align-items: center;">
                                <!-- Optional: Bank Logo could go here -->
                                <div>
                                    <div style="font-weight: 700; color: #212529; font-size: 16px; margin-bottom: 4px;">{{ $donation->paymentMethod->bank_name }}</div>
                                    <div style="font-family: monospace; font-size: 18px; letter-spacing: 1px; color: #212529; background: #f1f3f5; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-bottom: 4px;">{{ $donation->paymentMethod->account_number }}</div>
                                    <div style="font-size: 13px; color: #6C757D;">a.n {{ $donation->paymentMethod->account_name }}</div>
                                </div>
                            </div>
                            
                            <div style="background: #FFF3CD; border: 1px solid #FFECB5; color: #856404; padding: 10px 15px; border-radius: 6px; font-size: 13px; margin-bottom: 25px;">
                                <strong>PENTING:</strong> Mohon transfer sesuai dengan nominal hingga 3 digit terakhir (jika ada) untuk memudahkan verifikasi otomatis.
                            </div>
                            @endif
                            
                            <!-- Action Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('campaign.success', $donation->invoice_number) }}" style="display: inline-block; background-color: #0d6efd; color: #FFFFFF; text-decoration: none; font-weight: 600; padding: 12px 30px; border-radius: 50px; font-size: 16px;">
                                            Konfirmasi Pembayaran
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0; color: #6C757D; font-size: 13px; text-align: center;">
                                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut di browser Anda:<br>
                                <a href="{{ route('campaign.success', $donation->invoice_number) }}" style="color: #0d6efd; text-decoration: none;">{{ route('campaign.success', $donation->invoice_number) }}</a>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #F8F9FA; border-radius: 0 0 12px 12px; text-align: center;">
                            <p style="margin: 0 0 10px; color: #6C757D; font-size: 12px;">
                                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                            </p>
                            <p style="margin: 0; color: #0d6efd; font-size: 14px; font-weight: 600;">
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
