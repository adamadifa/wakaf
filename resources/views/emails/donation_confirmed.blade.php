<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Diterima</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #F8F9FA;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F8F9FA; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center; background: linear-gradient(135deg, #198754 0%, #157347 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: #FFFFFF; font-size: 24px; font-weight: 700;">Alhamdulillah!</h1>
                            <p style="margin: 10px 0 0; color: #E0E0E0; font-size: 14px;">Donasi Anda telah kami terima.</p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #212529; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $donation->is_anonymous ? 'Hamba Allah' : $donation->donor->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #6C757D; font-size: 14px; line-height: 1.6;">
                                Terima kasih atas kebaikan hati Anda. Donasi Anda untuk program <strong>{{ $donation->campaign->title }}</strong> telah berhasil diverifikasi oleh tim kami. Semoga menjadi amal jariyah yang tak terputus pahalanya. Aamiin.
                            </p>
                            
                            <!-- Donation Details Box -->
                            <div style="background: #F8F9FA; border: 1px solid #DEE2E6; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Nomor Invoice</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">{{ $donation->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Tanggal Diterima</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">{{ \Carbon\Carbon::parse($donation->confirmed_at)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 10px; color: #6C757D; font-size: 14px;">Metode Pembayaran</td>
                                        <td align="right" style="padding-bottom: 10px; color: #212529; font-weight: 600;">{{ $donation->paymentMethod->bank_name ?? 'Transfer' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 10px; border-top: 1px dashed #DEE2E6; color: #212529; font-weight: 700; font-size: 16px;">Total Donasi</td>
                                        <td align="right" style="padding-top: 10px; border-top: 1px dashed #DEE2E6; color: #198754; font-weight: 700; font-size: 18px;">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Action Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('campaign.show', $donation->campaign->slug) }}" style="display: inline-block; background-color: #198754; color: #FFFFFF; text-decoration: none; font-weight: 600; padding: 12px 30px; border-radius: 50px; font-size: 16px;">
                                            Lihat Program
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0; color: #6C757D; font-size: 13px; text-align: center;">
                                Pantau terus perkembangan program wakaf ini melalui website kami.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #F8F9FA; border-radius: 0 0 12px 12px; text-align: center;">
                            <p style="margin: 0 0 10px; color: #6C757D; font-size: 12px;">
                                Email ini dikirim secara otomatis sebagai bukti donasi yang sah.
                            </p>
                            <p style="margin: 0; color: #198754; font-size: 14px; font-weight: 600;">
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
