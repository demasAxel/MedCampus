<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2 style="color: #059669;">MedCampus Login Verification</h2>
    <p>Halo,</p>
    <p>Seseorang mencoba masuk ke akun MedCampus Anda. Berikut adalah kode verifikasi OTP Anda:</p>
    <div style="background: #f3f4f6; padding: 15px; font-size: 24px; font-weight: bold; letter-spacing: 5px; text-align: center; border-radius: 8px; width: fit-content; margin: 20px 0;">
        {{ $otpCode }}
    </div>
    <p style="color: #ef4444; font-size: 12px;">Kode ini hanya berlaku selama 5 menit. Jangan berikan kode ini kepada siapapun!</p>
    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 30px;">
    <p style="font-size: 10px; color: #888;">© 2026 MedCampus System</p>
</body>
</html>