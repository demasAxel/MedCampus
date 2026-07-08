<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical History - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
        <a href="{{ url('/patient/history') }}" class="active">Medical History</a>
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

    <!-- HEADER & DOWNLOAD REPORT -->
    <div class="flex-between" style="align-items: flex-start; margin-bottom: 24px;">
      <div>
        <h1 style="font-size: 28px; margin-bottom: 8px; color: var(--dark-navy);">Medical History</h1>
        <p style="color: var(--text-gray); font-size: 15px;">Manage and review your medical records, diagnoses, and prescriptions.</p>
      </div>
      <button class="btn btn-outline" style="background: var(--white); border-radius: 8px; font-size: 14px; display: flex; align-items: center; gap: 8px; padding: 10px 16px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Download Report
      </button>
    </div>

    <!-- SEARCH & FILTER BAR (Hanya Status) -->
    <div style="display: flex; gap: 16px; margin-bottom: 24px;">
      <input type="text" id="searchInput" placeholder="Search clinics, doctors..." style="flex: 1; padding: 10px 16px; border-radius: 8px; border: 1px solid var(--border); outline: none; background: var(--bg-gray); color: var(--dark-navy); transition: 0.3s; font-family: var(--font-main);">
      
      <div style="display: flex; gap: 12px;" id="filterContainer">
        <button class="btn btn-primary filter-btn" data-filter="All">All</button>
        <button class="btn btn-outline filter-btn" data-filter="Completed" style="background: var(--white); transition: 0.3s;">Completed</button>
        <button class="btn btn-outline filter-btn" data-filter="Cancelled" style="background: var(--white); transition: 0.3s;">Cancelled</button>
      </div>
    </div> 

    <!-- HISTORY CARDS -->
    <div style="display: flex; flex-direction: column; gap: 16px;" id="historyList">
      @forelse($histories as $history)
        <div class="card card-shadow history-card-item" 
             data-status="{{ $history->status == 'C' ? 'Cancelled' : 'Completed' }}" 
             data-clinic="{{ strtolower($history->clinic) }}" 
             data-doctor="{{ strtolower($history->doctor_name) }}"
             style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; margin-bottom: 0; border-radius: 12px; background: var(--white); border: 1px solid var(--border); transition: 0.3s;">
          
          <div style="display: flex; gap: 20px; align-items: center;">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: var(--bg-gray); display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); color: #ef4444;">
              @if($history->status == 'C') 
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
              @else 
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
              @endif
            </div>
            <div>
              <h3 style="margin-bottom: 4px; font-size: 16px; font-weight: 700; color: var(--dark-navy);">{{ $history->clinic }}</h3>
              <p style="color: var(--text-gray); font-size: 13px; margin-bottom: 6px;">{{ $history->doctor_name }} • {{ $history->specialty ?? 'Consultation' }}</p>
              <p style="font-size: 12px; font-weight: 600; color: var(--text-gray); display: flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                {{ \Carbon\Carbon::parse($history->appointment_date)->format('d M Y') }}
              </p>
            </div>
          </div>

          <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; justify-content: center; gap: 12px;">
            @if($history->status == 'C')
        <span class="badge badge-cancelled" style="background:#fee2e2; color:#dc2626;">Cancelled</span>
            @elseif($history->status == 'F')
                <span class="badge badge-completed" style="background:#dcfce7; color:#16a34a;">Completed</span>
                <a href="{{ url('/patient/visit-detail?id=' . $history->id_appointments) }}" class="btn btn-outline">View Details</a>
            @endif
          </div>
          
        </div>
      @empty
        <div style="text-align: center; padding: 60px 24px; background: var(--white); border-radius: 12px; border: 1px solid var(--border); display: none;" id="noMatchState">
          <div style="margin-bottom: 16px; color: #cbd5e1; display: flex; justify-content: center;">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
          </div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">No Medical History</h3>
          <p style="color: var(--text-gray);">You haven't completed or cancelled any consultations yet.</p>
        </div>
      @endforelse

      <div style="text-align: center; padding: 60px 24px; background: var(--white); border-radius: 12px; border: 1px solid var(--border); display: none;" id="noMatchState">
        <div style="margin-bottom: 16px; color: #cbd5e1; display: flex; justify-content: center;">
          <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
        <h3 style="font-size: 18px; margin-bottom: 8px;">No Results Found</h3>
        <p style="color: var(--text-gray);">Try adjusting your search or filter criteria.</p>
      </div>

    </div>
    
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterBtns = document.querySelectorAll('.filter-btn');
      const searchInput = document.getElementById('searchInput');
      const cards = document.querySelectorAll('.history-card-item');
      const noMatchState = document.getElementById('noMatchState');

      function filterHistory() {
        const activeBtn = document.querySelector('.filter-btn.btn-primary');
        const filterType = activeBtn ? activeBtn.getAttribute('data-filter') : 'All';
        const query = searchInput.value.toLowerCase();

        let visibleCount = 0;

        cards.forEach(card => {
          const status = card.getAttribute('data-status');
          const clinic = card.getAttribute('data-clinic');
          const doctor = card.getAttribute('data-doctor');

          let matchFilter = false;
          if (filterType === 'All') matchFilter = true;
          else if (filterType === 'Completed' && status === 'Completed') matchFilter = true;
          else if (filterType === 'Cancelled' && status === 'Cancelled') matchFilter = true;

          let matchSearch = clinic.includes(query) || doctor.includes(query);

          if (matchFilter && matchSearch) {
            card.style.display = 'flex';
            visibleCount++;
          } else {
            card.style.display = 'none';
          }
        });

        if (cards.length > 0) {
            noMatchState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
      }

      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          filterBtns.forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline');
            b.style.background = 'var(--white)';
          });
          btn.classList.remove('btn-outline');
          btn.classList.add('btn-primary');
          btn.style.background = ''; 

          filterHistory();
        });
      });

      searchInput.addEventListener('input', filterHistory);
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