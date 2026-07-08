<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Medical Entry - MedCampus</title>
  <style>
.notif-panel {
  position:absolute; right:0; top:calc(100% + 8px); width:320px;
  background:var(--white); border:1px solid var(--border); border-radius:12px;
  box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200;
  display:none; overflow:hidden;
}
.notif-panel.open { display:block; }
.notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
.notif-header h4 { font-size:14px; font-weight:700; }
.notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
.notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
.notif-item:hover { background:var(--bg-gray); }
.notif-item:last-child { border-bottom:none; }
.notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
.notif-item h5 { font-size:13px; margin-bottom:3px; }
.notif-item p  { font-size:11px; color:var(--text-gray); }
.bell-wrapper  { position:relative; }
</style>
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}">

<script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-left">
        <div class="nav-logo">
          <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
          MedCampus
        </div>
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}">Dashboard</a>
        <a href="{{ url('/doctor/patients') }}" class="active">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}">Schedule</a>
      </div>
      
      <div class="nav-profile" style="position: relative; display: flex; align-items: center; gap: 16px;">
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        </div>
        
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);margin-left:2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </div>

        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: var(--white); width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left; transition: 0.3s;">
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
            My Profile
          </a>
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
            Logout
          </a>
        </div>
      </div>
    </div>
  </nav>

  <main class="main-content container" style="max-width:900px;">
    <div class="flex-between" style="margin-bottom:32px;">
      <div>
        <h1 style="font-size:28px;margin-bottom:8px;">
          New Medical Entry — <span style="color:var(--primary-green);">{{ $appointment->patient_name ?? 'Patient' }}</span>
        </h1>
        <p style="color:var(--text-gray);font-size:13px;display:flex;gap:16px;">
          <span>Queue: <strong>{{ $appointment->queue_number ?? '—' }}</strong></span>
          <span>
            @if(isset($appointment))
               {{ $appointment->gender == 'M' ? 'Male' : 'Female' }}, {{ $appointment->date_of_birth ? \Carbon\Carbon::parse($appointment->date_of_birth)->age : 0 }} yrs • Consultation
            @else
               —
            @endif
          </span>
          <span style="display:flex;align-items:center;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Today, {{ now()->format('M d, Y') }}
          </span>
        </p>
      </div>
      
      <div style="display:flex;gap:12px;">
        <a href="{{ url('/doctor/patients') }}" class="btn btn-outline" id="btnCancelEntry" style="display:flex;align-items:center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          Back
        </a>
      </div>
    </div>

    <div class="card" style="padding:40px;">
      <form id="newEntryForm" action="{{ url('/doctor/store-entry') }}" method="POST">
        @csrf
        
        <input type="hidden" name="appointment_id" value="{{ $appointmentId }}">

        <div class="form-section">
          <h2 class="form-section-title" style="display:flex;align-items:center;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> 1. Patient Vitals</h2>
          <div class="grid-3">
            <div class="form-group">
              <label class="form-label">Blood Pressure (mmHg)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="blood_pressure" placeholder="e.g. 120/80">
                <span class="suffix-text">mmHg</span>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Heart Rate (bpm)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="heart_rate" placeholder="e.g. 72">
                <span class="suffix-text">bpm</span>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Temperature (°C)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="temperature" placeholder="e.g. 36.6">
                <span class="suffix-text">°C</span>
              </div>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h2 class="form-section-title" style="display:flex;align-items:center;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> 2. Diagnosis &amp; Symptoms</h2>
          <div class="form-group">
            <label class="form-label">Presenting Symptoms</label>
            <textarea class="form-textarea" name="symptoms" placeholder="Describe symptoms reported by patient…"></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Primary Diagnosis <span style="color:#ef4444;">*</span></label>
            <input type="text" class="form-input" name="diagnosis" placeholder="Enter ICD-10 or clinical diagnosis" required>
          </div>
        </div>

        <div class="form-section">
          <div class="flex-between" style="margin-bottom:20px;">
            <h2 class="form-section-title" style="margin-bottom:0;display:flex;align-items:center;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path></svg> 3. Prescription</h2>
            <span style="color:var(--primary-green);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;" data-action="add-med">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
              Add Medication
            </span>
          </div>
          <div style="display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:8px;font-size:11px;font-weight:700;color:var(--text-gray);text-transform:uppercase;">
            <span>Medication Name</span><span>Dosage</span><span>Frequency</span><span></span>
          </div>
          <div id="prescriptionRows">
            <div class="prescription-row" style="display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:16px;align-items:center;">
              <select name="medicines[]" class="form-input" style="width:100%;">
                <option value="">-- Select Medication --</option>
                @foreach($medicines as $med)
                  <option value="{{ $med->id_med }}">{{ $med->med_name }} (Stock: {{ $med->stock }})</option>
                @endforeach
              </select>
              <input type="text" name="dosages[]" class="form-input" placeholder="e.g. 500mg">
              <input type="text" name="frequencies[]" class="form-input" placeholder="e.g. Once daily">
              <div></div>
            </div>
          </div>
        </div>

        <div class="form-section" style="margin-bottom:0;">
          <h2 class="form-section-title" style="display:flex;align-items:center;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> 4. Clinical Notes</h2>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Detailed Observations</label>
            <textarea class="form-textarea" name="notes" placeholder="Enter detailed findings, recommendations, or patient history updates…" style="min-height:150px;"></textarea>
          </div>
        </div>

        <div style="border-top:1px solid var(--border);margin-top:40px;padding-top:32px;display:flex;justify-content:flex-end;gap:16px;align-items:center;">
          <span style="color:var(--text-gray);font-size:14px;cursor:pointer;margin-right:auto;" data-action="discard">Discard Draft</span>
          <button type="submit" class="btn btn-primary" id="btnSubmitForm">Finalize &amp; Submit Entry</button>
        </div>
      </form>
    </div>
  </main>

  <footer style="text-align:center;padding:24px 0 40px;color:var(--text-gray);font-size:12px;">
    © 2026 MedCampus Portal. HIPAA Compliant Environment.
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/doctor.js') }}"></script>
  
  <script>
    const rawMeds = {!! json_encode($medicines) !!};
    const DB_MEDICINES = rawMeds.map(m => ({
        id: m.id_med,
        name: m.med_name,
        stock: m.stock
    }));

    const entryOrigin = sessionStorage.getItem('mc_entry_origin') || '{{ url('/doctor/patients') }}';
    const backBtn = document.getElementById('btnCancelEntry');
    if (backBtn) backBtn.href = entryOrigin;

    document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));
    const originLink = document.querySelector(`.nav-links a[href="${entryOrigin}"]`);
    if (originLink) originLink.classList.add('active');

    document.querySelector('[data-action="add-med"]').addEventListener('click', () => {
      const row = document.createElement('div');
      row.className = 'prescription-row';
      row.style.cssText = 'display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:16px;align-items:center;';
      
      let optionsHtml = '<option value="">-- Select Medication --</option>';
      DB_MEDICINES.forEach(m => {
        optionsHtml += `<option value="${m.id}">${m.name} (Stock: ${m.stock})</option>`;
      });

      row.innerHTML = `
        <select name="medicines[]" class="form-input" style="width:100%;">${optionsHtml}</select>
        <input type="text" name="dosages[]" class="form-input" placeholder="e.g. 5ml">
        <input type="text" name="frequencies[]" class="form-input" placeholder="e.g. Once daily">
        <button type="button" class="icon-btn delete-row" style="color:#ef4444;border:none;background:#fee2e2;display:flex;align-items:center;justify-content:center;padding:8px;border-radius:6px;cursor:pointer;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>`;
      
      row.querySelector('.delete-row').addEventListener('click', () => row.remove());
      document.getElementById('prescriptionRows').appendChild(row);
    });

    document.querySelector('[data-action="discard"]').addEventListener('click', () => {
      if (confirm('Are you sure you want to discard this medical entry?')) {
          window.location.href = entryOrigin;
      }
    });

    document.getElementById('newEntryForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitForm');
        btn.textContent = 'Saving Record...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    });
  </script>

  <script>
        function toggleProfileDropdown(event) {
            if (event) event.stopPropagation();
            const drop = document.getElementById('mcProfileDropdown');
            drop.style.display = (drop.style.display === 'none' || drop.style.display === '') ? 'flex' : 'none';
        }
        
        document.addEventListener('click', function(e) {
            const drop = document.getElementById('mcProfileDropdown');
            const trigger = document.getElementById('mcProfileToggle');
            if (drop && drop.style.display === 'flex') {
                if (!trigger.contains(e.target) && !drop.contains(e.target)) {
                    drop.style.display = 'none';
                }
            }
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
            { color:'#3b82f6', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#2563eb;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Reminder</span>', body: 'Afternoon shift begins in 30 mins.' }
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