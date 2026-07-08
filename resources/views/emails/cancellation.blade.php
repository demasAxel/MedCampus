<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <h2 style="color: #ef4444;">Pembatalan Janji Temu MedCampus</h2>
    <p>Halo, <strong>{{ $cancellationData['patient_name'] }}</strong></p>
    <p style="color: #4b5563; line-height: 1.6;">
    Janji temu Anda dengan nomor ID <strong>{{ $cancellationData['appointment_id'] }}</strong> telah berhasil dibatalkan sesuai dengan permintaan Anda.
    </p>

    @if(isset($cancellationData['refund_amount']) && $cancellationData['refund_amount'] > 0)
    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px; margin: 24px 0; border-radius: 4px;">
        <h3 style="margin-top: 0; color: #1e3a8a; font-size: 16px;">Informasi Pengembalian Dana</h3>
        <p style="margin-bottom: 0; color: #1e40af; font-size: 14px;"> Karena Anda telah melakukan pembayaran sebelumnya, dana sebesar <strong>Rp {{ number_format($cancellationData['refund_amount'], 0, ',', '.') }}</strong> akan dikembalikan ke saldo <i>Student ID Balance</i> Anda. Proses pengembalian ini akan memakan waktu maksimal 1x24 jam kerja.
        </p> 
    </div>
    @endif

    <p style="color: #4b5563; line-height: 1.6;">
        Jika Anda memiliki pertanyaan lebih lanjut atau ingin menjadwalkan ulang, silakan kunjungi kembali portal MedCampus.
    </p>
    
    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 30px;">
    <p style="font-size: 10px; color: #888;">© 2026 MedCampus System</p>
</body>
</html>