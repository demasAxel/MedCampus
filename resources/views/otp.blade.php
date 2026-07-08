<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi OTP - MedCampus</title>
  <style>
    body { font-family: 'Inter', Arial, sans-serif; background: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .otp-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); text-align: center; max-width: 400px; width: 90%; }
    .otp-icon { width: 64px; height: 64px; background: #dcfce7; color: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
    h2 { margin-top: 0; color: #0f172a; font-size: 24px; }
    .text-gray { color: #64748b; font-size: 14px; margin-bottom: 24px; line-height: 1.5; }
    .otp-input { width: 100%; font-size: 32px; letter-spacing: 16px; text-align: center; padding: 16px 0; border: 2px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px; outline: none; transition: 0.3s; font-weight: bold; color: #0f172a; }
    .otp-input:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.2); }
    .btn { background: #059669; color: white; border: none; padding: 14px 24px; border-radius: 10px; font-size: 16px; font-weight: bold; width: 100%; cursor: pointer; transition: 0.2s; }
    .btn:hover { background: #047857; }
    .error-msg { background: #fee2e2; color: #ef4444; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: bold; margin-bottom: 20px; text-align: left; }
  </style>
</head>
<body>
  <div class="otp-card">
    <div class="otp-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
    </div>
    <h2>Verifikasi Keamanan</h2>
    <p class="text-gray">Kami telah mengirimkan 6-digit kode OTP ke email Anda. Silakan masukkan kode tersebut di bawah ini untuk melanjutkan login.</p>
    
    @if(session('error'))
        <div class="error-msg">❌ {{ session('error') }}</div>
    @endif

    <form action="{{ url('/verify-otp') }}" method="POST">
      @csrf
      <input type="text" name="otp_code" class="otp-input" maxlength="6" placeholder="------" required autocomplete="off" autofocus oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
      <button type="submit" class="btn">Verifikasi Login</button>
    </form>
  </div>
</body>
</html>