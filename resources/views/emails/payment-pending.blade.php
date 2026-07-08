<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2 style="color: #eab308;">Tagihan Pembayaran MedCampus</h2>
    <p>Halo, <strong>{{ $paymentData['patient_name'] }}</strong></p>
    <p>Silakan selesaikan pembayaran untuk layanan medis yang Anda pesan.</p>
    
    <table style="width: 100%; max-width: 500px; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb; width: 40%;">ID Transaksi</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $paymentData['transaction_id'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb;">Total Tagihan</td>
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 18px; font-weight: bold; color: #eab308;">Rp {{ number_format($paymentData['amount'], 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <p style="margin-top: 20px;">Segera lakukan pembayaran sesuai instruksi pada aplikasi sebelum batas waktu berakhir.</p>
    
    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 30px;">
    <p style="font-size: 10px; color: #888;">© 2026 MedCampus System</p>
</body>
</html>