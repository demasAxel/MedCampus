<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2 style="color: #059669;">Konfirmasi Janji Temu MedCampus</h2>
    <p>Halo, <strong>{{ $bookingData['patient_name'] }}</strong></p>
    <p>Pemesanan jadwal konsultasi Anda telah berhasil direkam ke dalam sistem kami. Berikut adalah rincian janji temu Anda:</p>
    
    <table style="width: 100%; max-width: 500px; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb; width: 40%;">Dokter</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $bookingData['doctor_name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb;">Tanggal & Waktu</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $bookingData['schedule_time'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background-color: #f9fafb;">Nomor Antrean</td>
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 18px; font-weight: bold; color: #059669;">{{ $bookingData['queue_number'] }}</td>
        </tr>
    </table>
    
    <p style="margin-top: 20px; color: #ef4444; font-size: 13px;">Harap datang 15 menit sebelum waktu yang telah ditentukan pada jadwal Anda.</p>
    
    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 30px;">
    <p style="font-size: 10px; color: #888;">© 2026 MedCampus System</p>
</body>
</html>