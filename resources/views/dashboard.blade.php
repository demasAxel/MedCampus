<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - MedCampus</title>
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
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;margin-right:12px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
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
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: white; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <!-- Info Singkat di dalam Dropdown -->
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: #f8fafc;">
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
          
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
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
        
        // Auto-close jika klik sembarang tempat di layar
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
    <div class="hero-dashboard">
      <h1 id="dash-welcome">Welcome, {{ explode(' ', Auth::user()->user_name)[0] }}!</h1>
      <p>Your health is our top priority at MedCampus Clinic. Track your queue and access medical services with ease.</p>
      <a href="{{ url('/service-guide') }}" class="btn btn-primary">Service Guide</a>
    </div>

    <div class="flex-between" style="margin-bottom:20px;">
      <h2 class="section-title" style="margin:0;">Your Active Queue</h2>
      <span style="font-size:13px;color:var(--primary-green);font-weight:600;">Updated: {{ now()->format('h:i A') }}</span>
    </div>

    <!-- 🌟 LOGIKA BLADE: Cek apakah pasien punya antrean aktif di database -->
    @if(!$activeQueue)
      <!-- STATE: TIDAK ADA ANTREAN -->
      <div id="noQueueState" style="text-align:center;padding:60px 24px;background:var(--white);border-radius:12px;border:1px solid var(--border);">
        <div style="margin-bottom:16px;color:#cbd5e1;display:flex;justify-content:center;">
          <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        </div>
        <h3 style="font-size:20px;margin-bottom:8px;">No Active Queue</h3>
        <p style="color:var(--text-gray);margin-bottom:24px;">You don't have any upcoming appointments today.</p>
        <a href="{{ url('/patient/booking') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Book an Appointment
        </a>
      </div>
    @else
      <!-- STATE: ADA ANTREAN AKTIF -->
      <div id="queueCard" class="queue-card card-shadow">
        <div class="queue-number-box">
          <span>Queue Number</span>
          <h2>{{ $activeQueue->queue_number }}</h2>
        </div>
        <div class="queue-details">
          <div style="display:flex;gap:12px;align-items:center;margin-bottom:16px;">
            @if($activeQueue->status == 'I')
              <span class="badge" style="background:#fef3c7;color:#d97706;display:flex;align-items:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.59-9.21l-5.36-2.14"></path></svg> In Progress
              </span>
            @else
              <span class="badge badge-waiting" style="display:flex;align-items:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Waiting
              </span>
            @endif
            <span style="font-size:13px;color:var(--text-gray);">• {{ \Carbon\Carbon::parse($activeQueue->appointment_date)->format('M d, Y') }}</span>
          </div>
          <div class="grid-2">
            <div>
              <p style="font-size:11px;color:var(--text-gray);text-transform:uppercase;font-weight:700;">Clinic</p>
              <p style="font-weight:600;">{{ $activeQueue->clinic }}</p>
            </div>
            <div>
              <p style="font-size:11px;color:var(--text-gray);text-transform:uppercase;font-weight:700;">Doctor</p>
              <p style="font-weight:600;">{{ $activeQueue->doctor_name }}</p>
            </div>
          </div>
          <div style="margin-top:16px;color:var(--primary-green);font-weight:500;font-size:14px;display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Estimated Service Time: <span style="margin-left:4px;">{{ $estimatedTime }} WIB</span>
          </div>
        </div>
        <div class="queue-actions" style="display:flex; flex-direction:column; gap:12px;">
          <a href="{{ url('/patient/queue-detail') }}" class="btn btn-primary" style="text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            Queue Details
          </a>
          <button onclick="document.getElementById('cancelModal').classList.add('active')" type="button" class="btn btn-outline" style="background:var(--bg-gray);border:1px solid var(--border);color:var(--text-gray);text-align:center;display:flex;align-items:center;justify-content:center;width:100%;cursor:pointer;padding:12px;font-size:14px;font-weight:600;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            Cancel Appointment
          </button>
        </div>
      </div>
      </div>
    @endif

    <div style="text-align:center;margin-top:60px;">
      <h3>Need another consultation?</h3>
      <p style="color:var(--text-gray);margin-bottom:24px;">You can make a new reservation for a different clinic.</p>
      <a href="{{ url('/patient/booking') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Book New Appointment
      </a>
    </div>

    @if($activeQueue)
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
        
        <form action="{{ url('/patient/cancel-appointment') }}" method="POST">
          @csrf
          <input type="hidden" name="appointment_id" value="{{ $activeQueue->id_appointments }}">
          <div style="display:flex;flex-direction:column;gap:12px;">
            <button type="submit" class="btn btn-primary" style="background:#ef4444;border:none;width:100%;padding:12px;font-size:14px;cursor:pointer;">Yes, Cancel It</button>
            <button type="button" onclick="document.getElementById('cancelModal').classList.remove('active')" class="btn btn-outline" style="color:var(--primary-green);border-color:var(--border);width:100%;padding:12px;font-size:14px;cursor:pointer;">No, Keep Appointment</button>
          </div>
        </form>
      </div>
    </div>
    @endif
  </main>

  <footer class="footer">
    <div class="container footer-content">
      <span>© 2026 MedCampus Patient Portal. All rights reserved.</span>
    </div>
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>