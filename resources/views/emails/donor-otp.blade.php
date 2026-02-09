<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Login</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #F8F9FA;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F8F9FA; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center; background: linear-gradient(135deg, #8CC63F 0%, #A3D95B 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: #FFFFFF; font-size: 28px; font-weight: 700;">Kode OTP Login</h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #212529; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $donor->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #6C757D; font-size: 14px; line-height: 1.6;">
                                Anda telah meminta kode OTP untuk login ke portal donatur. Gunakan kode berikut untuk melanjutkan:
                            </p>
                            
                            <!-- OTP Box -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 30px 0;">
                                        <div style="display: inline-block; background: #F8F9FA; border: 2px dashed #8CC63F; border-radius: 8px; padding: 20px 40px;">
                                            <p style="margin: 0; color: #6C757D; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Kode OTP Anda</p>
                                            <p style="margin: 0; color: #8CC63F; font-size: 36px; font-weight: 700; letter-spacing: 8px; font-family: 'Courier New', monospace;">{{ $otp }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0 0 20px; color: #6C757D; font-size: 14px; line-height: 1.6; text-align: center;">
                                Kode ini akan kadaluarsa dalam <strong style="color: #F5A623;">5 menit</strong>.
                            </p>
                            
                            <div style="background: #FFF3E0; border-left: 4px solid #F5A623; padding: 15px; margin: 20px 0; border-radius: 4px;">
                                <p style="margin: 0; color: #6C757D; font-size: 13px; line-height: 1.6;">
                                    <strong style="color: #F5A623;">⚠️ Penting:</strong> Jangan bagikan kode ini kepada siapapun. Tim kami tidak akan pernah meminta kode OTP Anda.
                                </p>
                            </div>
                            
                            <p style="margin: 20px 0 0; color: #6C757D; font-size: 13px; line-height: 1.6;">
                                Jika Anda tidak meminta kode ini, abaikan email ini atau hubungi kami jika Anda memiliki pertanyaan.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #F8F9FA; border-radius: 0 0 12px 12px; text-align: center;">
                            <p style="margin: 0 0 10px; color: #6C757D; font-size: 12px;">
                                Terima kasih atas kepercayaan Anda
                            </p>
                            <p style="margin: 0; color: #8CC63F; font-size: 14px; font-weight: 600;">
                                Platform Wakaf & Donasi
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
