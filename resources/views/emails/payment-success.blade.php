<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2 style="color: #059669;">Pembayaran Berhasil</h2>
    <p>Halo, <strong>{{ $paymentData['patient_name'] }}</strong></p>
    <p>Terima kasih, pembayaran Anda telah berhasil kami verifikasi. Berikut adalah tanda terima digital Anda:</p>
    
    <table style="width: 100%; max-width: 500px; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb; width: 40%;">ID Transaksi</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $paymentData['transaction_id'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb;">Total Dibayar</td>
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 18px; font-weight: bold; color: #059669;">Rp {{ number_format($paymentData['amount'], 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <p style="margin-top: 20px;">Anda dapat melihat rincian lengkap kunjungan melalui dasbor pasien.</p>
    
    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 30px;">
    <p style="font-size: 10px; color: #888;">© 2026 MedCampus System</p>
</body>
</html>