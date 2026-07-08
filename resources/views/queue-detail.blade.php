<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queue Details - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}" class="active">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
        <a href="{{ url('/patient/history') }}">Medical History</a>
      </div>
      <div class="nav-profile" style="position: relative;">
        <div class="bell-wrapper">
          <span class="bell">🔔</span>
        </div>
        
        <!-- Tombol Profil Utama -->
        <div id="mcProfileToggle" onclick="toggleDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px; margin-left:16px; border: 1px solid var(--border);">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-right: 4px;">▼</span>
        </div>

        <!-- Menu Dropdown Pop-up -->
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: var(--white); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: var(--bg-gray);">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            My Profile
          </a>
          
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Logout
          </a>
        </div>
      </div>

      <!-- Script Interaksi Dropdown -->
      <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('mcDropdownMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
        
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mcDropdownMenu');
            const toggle = document.getElementById('mcProfileToggle');
            if (menu && !menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
      </script>
    </div>
  </nav>

  <main class="main-content container">
    <a href="{{ url('/patient/dashboard') }}" style="color:var(--text-gray);font-size:14px;font-weight:500;display:inline-flex;align-items:center;gap:8px;margin-bottom:24px;text-decoration:none;">
      ← Back to Dashboard
    </a>

    <!-- INI GRID UTAMA (Yang Tadi Bocor) -->
    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:32px;">

      <!-- KIRI: TIKET & TOMBOL -->
      <div>
        <div class="card card-shadow" style="border-top:6px solid var(--primary-green);padding:32px;margin-bottom:24px;">
          <div class="flex-between" style="align-items:flex-start;">
            <div>
              <p style="font-size:11px;font-weight:700;color:var(--primary-green);letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Your Current Ticket</p>
              <p style="font-size:14px;color:var(--text-gray);font-weight:500;margin-bottom:4px;">{{ Auth::user()->user_name }}</p>
              <h1 style="font-size:56px;line-height:1;color:var(--dark-navy);margin-bottom:12px;">{{ $activeQueue->queue_number }}</h1>
              <p style="color:var(--text-gray);font-size:15px;">Please wait for your number to be called.</p>
            </div>
            <div style="background:var(--bg-gray);padding:16px;border-radius:12px;text-align:center;border:1px solid var(--border);">
              <div id="qr-canvas" style="width:80px;height:80px;background:white;margin:0 auto 8px;"></div>
              <span style="font-size:9px;font-weight:700;color:var(--text-gray);letter-spacing:1px;">SCAN FOR CHECK-IN</span>
            </div>
          </div>

          <hr style="border:none;border-bottom:1px solid var(--border);margin:32px 0;">

          <div>
            <div class="flex-between" style="margin-bottom:8px;">
              <h3 style="display:flex;align-items:center;gap:8px;font-size:18px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>{{ $aheadCount }} people ahead of you</span>
              </h3>
              <span style="font-size:13px;font-weight:600;color:var(--primary-green);">{{ $progress }}% Complete</span>
            </div>
            <div class="progress-container" style="background:#e2e8f0;border-radius:8px;height:8px;overflow:hidden;">
              <div style="background:var(--primary-green);height:100%;width:{{ $progress }}%;transition:width 0.5s;"></div>
            </div>
            <p style="font-size:13px;color:var(--text-gray);margin-top:12px;display:flex;align-items:center;gap:6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
              You are almost next. Please stay near the waiting area.
            </p>
          </div>
        </div>

        <div style="display:flex;gap:16px;">
          <a href="{{ url('/patient/ticket') }}" class="btn btn-primary" style="flex:1;font-size:15px;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> 
            Download Ticket
          </a>
          <button onclick="document.getElementById('cancelModal').classList.add('active')" type="button" class="btn btn-outline" style="flex:1;background:var(--bg-gray);border:1px solid var(--border);font-size:15px;display:flex;align-items:center;justify-content:center;gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> 
            Cancel Appointment
          </button>
        </div>
      </div> <!-- Akhir Sisi Kiri -->

      <!-- KANAN: DETAILS -->
      <div>
        <div class="card card-shadow" style="padding:32px;">
          <h2 style="font-size:20px;margin-bottom:32px;">Appointment Details</h2>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="color:var(--primary-green);display:flex;align-items:center;justify-content:center;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path></svg>
            </div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Clinic</p>
              <p style="font-weight:600;font-size:15px;">{{ $activeQueue->clinic }}</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="color:var(--primary-green);display:flex;align-items:center;justify-content:center;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Doctor</p>
              <p style="font-weight:600;font-size:15px;">{{ $activeQueue->doctor_name }}</p>
              <p style="font-size:12px;color:var(--text-gray);">{{ $activeQueue->specialty ?? 'Consultation' }}</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="color:var(--primary-green);display:flex;align-items:center;justify-content:center;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Estimated Service Time</p>
              <p style="font-weight:600;font-size:15px;">{{ \Carbon\Carbon::parse($activeQueue->appointment_date)->isToday() ? 'Today' : \Carbon\Carbon::parse($activeQueue->appointment_date)->format('d M Y') }}, {{ $estimatedTime }} WIB</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:32px;">
            <div style="color:#d97706;display:flex;align-items:center;justify-content:center;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            </div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Status</p>
              <p style="font-weight:600;font-size:15px;color:#d97706;">
                {{ $activeQueue->status == 'I' ? 'In Progress' : 'Waiting in Queue' }}
              </p>
            </div>
          </div>
        </div>

          <div style="background:#f8fafc;padding:16px;border-radius:8px;border:1px solid var(--border);">
            <h4 style="font-size:14px;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg> 
              Instructions
            </h4>
            <p style="font-size:13px;color:var(--text-gray);line-height:1.6;">
              Please arrive 10 minutes early. Have your health card and identification ready for verification at the reception desk.
            </p>
          </div>
        </div>
      </div> <!-- Akhir Sisi Kanan -->

    </div>
  </main>

  <!-- MODAL CANCEL -->
  <div id="cancelModal" class="modal-overlay">
    <div class="modal-card">
      <div class="modal-header">
        <div class="modal-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <h2 style="font-size:18px;color:var(--dark-navy);margin:0;">Cancel Appointment</h2>
      </div>
      <p style="color:var(--text-gray);font-size:14px;margin-bottom:24px;line-height:1.6;">
        Are you sure? Your queue position (<strong>{{ $activeQueue->queue_number }}</strong>) will be lost.
      </p>
      
      <!-- FORM PEMBATALAN -->
      <form action="{{ url('/patient/cancel-appointment') }}" method="POST">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $activeQueue->id_appointments }}">
        <div style="display:flex;flex-direction:column;gap:12px;">
          <button type="submit" class="btn btn-primary" style="background:#ef4444;border:none;width:100%;padding:12px;font-size:14px;">Yes, Cancel It</button>
          <!-- Tombol Tutup Modal (Pakai classList.remove) -->
          <button type="button" onclick="document.getElementById('cancelModal').classList.remove('active')" class="btn btn-outline" style="color:var(--primary-green);border-color:var(--border);width:100%;padding:12px;font-size:14px;">No, Keep Appointment</button>
        </div>
      </form>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        const el = document.getElementById('qr-canvas');
        if (el && window.QRCode) {
          const data = "{{ $activeQueue->id_appointments }}";
          new QRCode(el, { text: data, width: 80, height: 80, colorDark:'#151e2d', colorLight:'#ffffff' });
        }
      }, 300);
    });
  </script>

  <script>
    (function() {
      const bellWrap = document.querySelector('.bell-wrapper');
      if (!bellWrap) return;

      const panel = document.createElement('div');
      panel.className = 'notif-panel';
      panel.innerHTML = '<div class="notif-header"><h4 style="display:flex;align-items:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg> Notifications</h4><span id="clearNotifs">Mark all read</span></div><div id="notifList"></div>';
      bellWrap.style.position = 'relative';
      bellWrap.appendChild(panel);

      function renderNotifs() {
        const list = document.getElementById('notifList');
        if (!list) return;
        list.innerHTML = '';
        const notifs = [
            { color:'#94a3b8', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#059669;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> All Clear</span>', body: 'No new notifications right now.' }
        ];
        notifs.forEach(n => {
          const div = document.createElement('div');
          div.className = 'notif-item';
          div.innerHTML = `<div class="notif-dot" style="background:${n.color};"></div><div><h5 style="margin-bottom:4px;">${n.title}</h5><p>${n.body}</p></div>`;
          list.appendChild(div);
        });
      }

      bellWrap.addEventListener('click', e => {
        e.stopPropagation();
        renderNotifs();
        panel.classList.toggle('open');
      });
      document.addEventListener('click', () => panel.classList.remove('open'));
      document.getElementById('clearNotifs')?.addEventListener('click', () => { panel.classList.remove('open'); });
    })();
  </script>
</body>
</html>