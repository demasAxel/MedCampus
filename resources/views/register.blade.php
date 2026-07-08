<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body class="auth-page">
  <main class="auth-container">
    <section class="auth-card">
      <h1>Create an Account</h1>

      <div class="auth-toggle">
        <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/register') }}" class="active">Register</a>
      </div>

      @if ($errors->any())
          <div style="background-color: #ffcccc; color: red; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
              <strong>Can't register account, Something is wrong:</strong>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ url('/register') }}" method="POST">
  @csrf
  
  <div class="form-group">
    <label for="user_name">Full Name</label>
    <input type="text" id="user_name" name="user_name" placeholder="e.g. Andy Jackson" required>
  </div>

  <div class="form-group">
    <label for="reg_email">University Email</label>
    <input type="email" id="reg_email" name="user_email" placeholder="your@email.com" required autocomplete="username">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
  </div>

  <div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Type your password again" required autocomplete="new-password">
  </div>

      <p class="auth-footer-text" style="margin-top:16px;">
        Are you a doctor or staff? Contact your admin to get access.
      </p>
    </section>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/guest.js') }}"></script>
</script>

  <div id="termsModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div class="policy-card" style="background:white;border-radius:16px;padding:32px;max-width:500px;width:calc(100% - 32px);max-height:80vh;display:flex;flex-direction:column;box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:12px;color:var(--primary-green, #529b2e);">Terms of Service</h2>
      <div style="overflow-y:auto;padding-right:12px;font-size:13px;line-height:1.6;color:#475569;margin-bottom:24px;">
        <h4 style="color:#151e2d;margin:12px 0 4px;">1. Account Eligibility</h4>
        <p style="margin:0;">The MedCampus portal is exclusively designed for registered students, faculty, and administrative staff of the university. By creating an account, you confirm that the University ID (NIM/NIP) provided is accurate.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">2. Appointment Booking</h4>
        <p style="margin:0;">MedCampus operates on a strict Time-Slot system. Users are expected to arrive at least 15 minutes prior to their time slot. Late arrivals may be placed in the waiting queue.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">3. System Misuse</h4>
        <p style="margin:0;">Any attempt to manipulate the queue system or input false medical data will result in immediate account termination.</p>
      </div>
      <button onclick="closePolicyModal('termsModal')" style="width:100%;background:none;border:1px solid #e2e8f0;padding:12px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;margin-top:auto;">Tutup / Close</button>
    </div>
  </div>

  <div id="privacyModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div class="policy-card" style="background:white;border-radius:16px;padding:32px;max-width:500px;width:calc(100% - 32px);max-height:80vh;display:flex;flex-direction:column;box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:12px;color:var(--primary-green, #529b2e);">Privacy Policy</h2>
      <div style="overflow-y:auto;padding-right:12px;font-size:13px;line-height:1.6;color:#475569;margin-bottom:24px;">
        <h4 style="color:#151e2d;margin:12px 0 4px;">1. Data Collection</h4>
        <p style="margin:0;">MedCampus collects essential personal information, including your Full Name, University ID, and Email. This data is strictly used to manage your clinic appointments effectively.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">2. Medical Records Confidentiality</h4>
        <p style="margin:0;">All medical records, diagnoses, symptoms, and prescriptions are strictly confidential. This sensitive health information is exclusively accessible only to attending medical practitioners. MedCampus will never share your medical data without explicit written consent.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">3. Data Security</h4>
        <p style="margin:0;">We employ standard security measures to protect your health information. Users must ensure they log out after using shared university devices.</p>
      </div>
      <button onclick="closePolicyModal('privacyModal')" style="width:100%;background:none;border:1px solid #e2e8f0;padding:12px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;margin-top:auto;">Tutup / Close</button>
    </div>
  </div>

  <script>
    function openPolicyModal(modalId) {
      const modal = document.getElementById(modalId);
      const card = modal.querySelector('.policy-card');
      modal.style.opacity = '1';
      modal.style.pointerEvents = 'auto';
      card.style.transform = 'translateY(0)';
    }

    function closePolicyModal(modalId) {
      const modal = document.getElementById(modalId);
      const card = modal.querySelector('.policy-card');
      modal.style.opacity = '0';
      modal.style.pointerEvents = 'none';
      card.style.transform = 'translateY(16px)';
    }

    window.addEventListener('click', function(e) {
      const tModal = document.getElementById('termsModal');
      const pModal = document.getElementById('privacyModal');
      if (e.target === tModal) closePolicyModal('termsModal');
      if (e.target === pModal) closePolicyModal('privacyModal');
    });
  </script>
</body>
</html>
