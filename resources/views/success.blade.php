<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Confirmed - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body style="background:var(--bg-gray);">
  <main class="container" style="padding:80px 0;text-align:center;">
    <div class="success-circle">
      <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    </div>
    <h1 style="font-size:32px;margin-bottom:12px;">Appointment Confirmed!</h1>
    <p style="color:var(--text-gray);margin-bottom:40px;">Your reservation has been successfully booked. You can now view your digital ticket.</p>

    <div class="ticket-wrapper">
      <div class="flex-between" style="background:var(--primary-green);color:white;padding:16px 24px;">
        <span style="font-size:12px;font-weight:700;letter-spacing:1px;">APPOINTMENT SUMMARY</span>
        <span class="badge" style="background:rgba(255,255,255,0.2);color:white;">Verified ✓</span>
      </div>
      <div style="padding:32px 24px;">
        <p style="font-size:12px;color:var(--text-gray);font-weight:700;letter-spacing:1px;">QUEUE NUMBER</p>
        <h2 id="sc-queue-num" style="font-size:64px;color:var(--primary-green);margin-bottom:32px;line-height:1;">—</h2>

        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Appointment ID</span>
          <span id="sc-appt-id" style="font-weight:600;">—</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Clinic</span>
          <span id="sc-clinic" style="font-weight:600;">—</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Doctor</span>
          <span id="sc-doctor" style="font-weight:600;">—</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:32px;">
          <span style="color:var(--text-gray);font-size:14px;">Date &amp; Time</span>
          <span id="sc-schedule" style="font-weight:600;">—</span>
        </div>

        <div style="background:var(--bg-gray);padding:16px;border-radius:8px;display:inline-block;">
          <div style="width:100px;height:100px;background:white;border:none;margin:0 auto 8px;"><div id="qr-canvas" style="width:100px;height:100px;"></div></div>
          <p style="font-size:10px;font-weight:700;color:var(--text-gray);">SCAN AT KIOSK</p>
        </div>
      </div>
    </div>

    <div style="margin-top:32px;display:flex;gap:16px;justify-content:center;">
      <a href="{{ url('/patient/ticket') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
          <path d="M13 5v2"></path>
          <path d="M13 17v2"></path>
          <path d="M13 11v2"></path>
        </svg>
        View Digital Ticket
      </a>
      
      <a href="{{ url('/patient/dashboard') }}" class="btn btn-outline" style="background:white; display:inline-flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        Return to Home
      </a>
    </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/profile-dropdown.js') }}"></script>
  <script src="{{ asset('js/patient.js') }}"></script>
  <script>
    const q = AppData.getQueue();
    document.getElementById('sc-queue-num').textContent = q.number;
    document.getElementById('sc-appt-id').textContent   = q.appointmentId;
    document.getElementById('sc-clinic').textContent    = q.clinic;
    document.getElementById('sc-doctor').textContent    = q.doctor;
    document.getElementById('sc-schedule').textContent  = q.date + ' • ' + q.time;

    // ── Commit booking to MOCK_VISITS (persisted history) ─────────────────────
    (function() {
      const q = AppData.getQueue();
      const session = AppData.getSession();
      if (!q || !q.appointmentId) return;

      const visits = AppData.getVisits ? AppData.getVisits() : [];
      const already = visits.find(v => v.id === q.appointmentId);
      if (already) return;

      const newVisit = {
        id:      q.appointmentId,
        status:  'upcoming',
        clinic:  q.clinic  || 'General Clinic',
        doctor:  q.doctor  || '—',
        date:    q.date    || new Date().toLocaleDateString('en-US', {month:'long', day:'numeric', year:'numeric'}),
        time:    q.time    || '—',
        diagnosis: null,
        medicines: [],
        cancelReason: null,
        clinic_address: q.clinic_address || 'Jl. Mulyorejo Utara No. 201',
        clinic_phone:   '+62 8127790926',
        clinic_hours:   'Mon – Fri, 8:00 AM – 6:00 PM',
      };

      if (AppData.saveVisits) {
        visits.push(newVisit);
        AppData.saveVisits(visits);
      }
    })();

  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        const el = document.getElementById('qr-canvas');
        if (el && window.QRCode) {
          const data = "MC-" + (document.getElementById("sc-appt-id")?.textContent || "MC-88291");
          new QRCode(el, { text: data, width: el.offsetWidth || 100, height: el.offsetHeight || 100, colorDark:'#151e2d', colorLight:'#ffffff' });
        }
      }, 300);
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>
