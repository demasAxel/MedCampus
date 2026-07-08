<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Schedule - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
  <style>
    .sch-wrapper { background: var(--white); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 24px; transition: 0.3s; }
    .sch-top { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--border); transition: 0.3s; }
    .week-nav { font-size: 18px; font-weight: 700; color: var(--dark-navy); display: flex; align-items: center; gap: 16px; }
    .week-nav span { cursor: pointer; color: var(--text-gray); padding: 4px 12px; border-radius: 4px; transition: 0.2s; font-weight: 900; }
    .week-nav span:hover { background: var(--bg-gray); color: var(--dark-navy); }
    .view-tabs { display: flex; background: var(--bg-gray); border-radius: 8px; padding: 4px; transition: 0.3s; }
    .view-tabs button { background: transparent; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 600; color: var(--text-gray); cursor: pointer; font-size: 13px; transition: 0.2s; }
    .view-tabs button.active { background: var(--white); color: var(--dark-navy); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .sch-grid { display: grid; grid-template-columns: 110px repeat(7, 1fr); }
    .sch-header-cell { padding: 16px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); transition: 0.3s; }
    .sch-header-cell:last-child { border-right: none; }
    .sch-header-cell .day-name { font-size: 11px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; margin-bottom: 6px; display: block; }
    .sch-header-cell .day-date { font-size: 20px; font-weight: 700; color: var(--dark-navy); display: block; }
    .sch-header-cell.is-today .day-name { color: var(--primary-green); }
    .sch-header-cell.is-today .day-date { color: var(--primary-green); }
    .time-col-header { display: flex; align-items: center; font-size: 11px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; border-bottom: 1px solid var(--border); border-right: 1px solid var(--border); padding: 16px; transition: 0.3s; }
    .sch-time { padding: 16px; font-weight: 700; color: var(--text-gray); font-size: 13px; text-align: center; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: center; flex-direction: column; transition: 0.3s; }
    .sch-time span { font-size: 11px; font-weight: 700; }
    .sch-cell { padding: 16px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); transition: 0.3s; }
    .sch-cell:last-child { border-right: none; }
    
    .shift-card { background: var(--bg-gray); border: 1px solid var(--border); border-left: 4px solid var(--primary-green); border-radius: 6px; padding: 12px; height: 100%; box-sizing: border-box; transition: 0.3s; }
    .shift-card h4 { font-size: 13px; color: var(--dark-navy); margin-bottom: 6px; font-weight: 700; }
    .shift-card p { font-size: 11px; color: var(--text-gray); margin: 0; }
    
    .lunch-break { grid-column: 1 / -1; background: var(--bg-gray); text-align: center; padding: 10px; font-size: 11px; font-weight: 700; color: var(--text-gray); letter-spacing: 2px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.3s; }
    
    .today-shift-card { transition: 0.2s; }
    .today-shift-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
    
    .notif-panel { position:absolute; right:0; top:calc(100% + 8px); width:320px; background:var(--white); border:1px solid var(--border); border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200; display:none; overflow:hidden; transition: 0.3s; }
    .notif-panel.open { display:block; }
    .notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .notif-header h4 { font-size:14px; font-weight:700; margin:0; color: var(--dark-navy); }
    .notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
    .notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
    .notif-item:hover { background:var(--bg-gray); }
    .notif-item:last-child { border-bottom:none; }
    .notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
    .notif-item h5 { font-size:13px; margin-bottom:3px; margin-top:0; color: var(--dark-navy); }
    .notif-item p  { font-size:11px; color:var(--text-gray); margin:0; }
    .bell-wrapper { position:relative; }
  </style>
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
        <a href="{{ url('/doctor/patients') }}">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}" class="active">Schedule</a>
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

  <main class="main-content container">
    <div class="flex-between">
      <div>
        <h1 style="font-size:32px;margin-bottom:8px;">Schedule</h1>
        <p style="color:var(--text-gray);font-size:14px;">Weekly clinic room assignments and consultation times.</p>
      </div>
      <div>
        <button class="btn btn-outline" onclick="window.print()" style="display:flex;align-items:center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
          Print Schedule
        </button>
      </div>
    </div>

    <div class="sch-wrapper">
      <div class="sch-top">
        <div class="week-nav">
          <span onclick="changeDate(-1)">&lt;</span>
          <div id="dateLabel" style="width:250px; text-align:center;">Loading...</div>
          <span onclick="changeDate(1)">&gt;</span>
        </div>
        <div class="view-tabs">
          <button id="tabWeekly" class="active" onclick="switchView('weekly')">Weekly</button>
          <button id="tabToday" onclick="switchView('today')">Today</button>
        </div>
      </div>

      <div class="sch-grid" id="weeklyGrid"></div>
      
      <div id="todayGrid" style="display:none; padding:32px 24px; background:#fff;"></div>
    </div>
  </main>

  <script>
    const rawData = {!! json_encode($schedules) !!};
    const DB_SCHEDULES = rawData.map(s => ({
        id: s.id_schedule,
        date: s.schedule_date,
        shift: s.shift,
        room: s.room
    }));

    let viewMode = 'weekly';
    const serverTodayStr = "{{ now()->format('Y-m-d') }}";
    const SERVER_TODAY = new Date(serverTodayStr + "T00:00:00"); 
    let currentMonday = getMonday(SERVER_TODAY);
    let selectedDate = new Date(SERVER_TODAY);

    function getFormatDate(d) {
        let yyyy = d.getFullYear();
        let mm = String(d.getMonth() + 1).padStart(2, '0');
        let dd = String(d.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function getMonday(d) {
        let date = new Date(d);
        let day = date.getDay();
        let diff = date.getDate() - day + (day === 0 ? -6 : 1);
        return new Date(date.setDate(diff));
    }

    function changeDate(offset) {
        if (viewMode === 'weekly') {
            currentMonday.setDate(currentMonday.getDate() + (offset * 7));
            renderCalendar();
        } else {
            selectedDate.setDate(selectedDate.getDate() + offset);
            renderToday();
        }
    }

    function switchView(mode) {
        viewMode = mode;
        document.getElementById('tabWeekly').classList.toggle('active', mode === 'weekly');
        document.getElementById('tabToday').classList.toggle('active', mode === 'today');

        if (mode === 'today') {
            selectedDate = new Date(SERVER_TODAY);
            document.getElementById('weeklyGrid').style.display = 'none';
            document.getElementById('todayGrid').style.display = 'block';
            renderToday();
        } else {
            currentMonday = getMonday(SERVER_TODAY);
            document.getElementById('weeklyGrid').style.display = 'grid';
            document.getElementById('todayGrid').style.display = 'none';
            renderCalendar();
        }
    }

    function renderCalendar() {
        const grid = document.getElementById('weeklyGrid');
        grid.innerHTML = '';
        const days = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
        let weekDates = [];

        let headerHtml = `<div class="time-col-header">SHIFT</div>`;
        for (let i = 0; i < 7; i++) {
            let colDate = new Date(currentMonday);
            colDate.setDate(colDate.getDate() + i);
            let dateStr = getFormatDate(colDate);
            weekDates.push(dateStr);
            
            let isToday = (dateStr === serverTodayStr);
            headerHtml += `
                <div class="sch-header-cell ${isToday ? 'is-today' : ''}">
                    <span class="day-name">${days[i]} ${isToday ? '(TODAY)' : ''}</span>
                    <span class="day-date">${colDate.getDate()}</span>
                </div>
            `;
        }
        grid.innerHTML += headerHtml;

        let weekEndDate = new Date(currentMonday);
        weekEndDate.setDate(weekEndDate.getDate() + 6);
        document.getElementById('dateLabel').textContent = 
            `${currentMonday.toLocaleDateString('en-US', {month:'short', day:'numeric'})} – ${weekEndDate.toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'})}`;

        let currentWeekSchedules = DB_SCHEDULES.filter(s => weekDates.includes(s.date));
        
        let uniqueShifts = [...new Set(currentWeekSchedules.map(s => s.shift))];
        uniqueShifts.sort((a, b) => {
            let jamA = a.toLowerCase().includes('morning') ? 1 : (a.toLowerCase().includes('afternoon') ? 2 : (a.toLowerCase().includes('evening') ? 3 : 4));
            let jamB = b.toLowerCase().includes('morning') ? 1 : (b.toLowerCase().includes('afternoon') ? 2 : (b.toLowerCase().includes('evening') ? 3 : 4));
            return jamA - jamB;
        });

        if (uniqueShifts.length === 0) {
            grid.innerHTML += `<div style="grid-column: 1 / -1; text-align:center; padding: 60px; color: var(--text-gray);">
              <div style="display:flex;justify-content:center;margin-bottom:12px;color:#cbd5e1;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
              <h4 style="color:var(--dark-navy);font-size:15px;margin-bottom:4px;">No Schedules Found</h4>
              <p style="font-size:13px;margin:0;">There are no schedules assigned for this week.</p>
            </div>`;
            return;
        }

        const shiftRanges = {
            'morning': '08:00 – 14:00',
            'afternoon': '14:00 – 20:00',
            'evening': '20:00 – 02:00'
        };

        uniqueShifts.forEach(shiftTime => {
            let shiftKey = shiftTime.toLowerCase();
            
            let displayTitle = shiftTime.toUpperCase();
            let displayRange = shiftRanges[shiftKey] || '';

            let rowHtml = `<div class="sch-time" style="line-height: 1.5; justify-content: center;">
                <span style="font-size: 13px; font-weight: 800; color: var(--dark-navy); letter-spacing: 0.5px;">${displayTitle}</span><br>
                <span style="font-size: 10px; font-weight: 700; color: var(--text-gray);">${displayRange}</span>
            </div>`;

            for (let i = 0; i < 7; i++) {
                let cellData = currentWeekSchedules.find(s => s.date === weekDates[i] && s.shift === shiftTime);
                if (cellData) {
                    rowHtml += `<div class="sch-cell"><div class="shift-card"><h4>${cellData.room}</h4><p>Consultation</p></div></div>`;
                } else {
                    rowHtml += `<div class="sch-cell"></div>`;
                }
            }
            grid.innerHTML += rowHtml;
        });
    }

    function renderToday() {
        const grid = document.getElementById('todayGrid');
        const dateStr = getFormatDate(selectedDate);
        const isActuallyToday = (dateStr === serverTodayStr);
        
        document.getElementById('dateLabel').textContent = 
            selectedDate.toLocaleDateString('en-US', {weekday:'long', month:'long', day:'numeric', year:'numeric'}) + (isActuallyToday ? ' (Today)' : '');

        const todaySchedules = DB_SCHEDULES.filter(s => s.date === dateStr).sort((a,b) => {
            let jamA = a.shift.toLowerCase().includes('morning') ? 1 : (a.shift.toLowerCase().includes('afternoon') ? 2 : 3);
            let jamB = b.shift.toLowerCase().includes('morning') ? 1 : (b.shift.toLowerCase().includes('afternoon') ? 2 : 3);
            return jamA - jamB;
        });

        if (todaySchedules.length === 0) {
            grid.innerHTML = `<div style="text-align:center; padding: 60px 20px; color: var(--text-gray);">
              <div style="display:flex;justify-content:center;margin-bottom:12px;color:#cbd5e1;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
              <h4 style="color:var(--dark-navy);font-size:15px;margin-bottom:4px;">No Schedules Today</h4>
              <p style="font-size:13px;margin:0;">You have no assigned shifts for this date.</p>
            </div>`;
            return;
        }

        const shiftRanges = {
            'morning': '08:00 – 14:00',
            'afternoon': '14:00 – 20:00',
            'evening': '20:00 – 02:00'
        };

        let html = `<div style="display:flex; flex-direction:column; gap:16px; max-width: 800px; margin: 0 auto;">`;
        todaySchedules.forEach(s => {
            let shiftKey = s.shift.toLowerCase();
            let timeRange = shiftRanges[shiftKey] || '';

            html += `
                <div class="today-shift-card" style="display:flex; align-items:center; background:#f8fafc; border:1px solid var(--border); border-left:4px solid var(--primary-green); border-radius:10px; padding:24px;">
                    <div style="width:180px; font-weight:800; color:var(--dark-navy); font-size:16px; display:flex; flex-direction:column; gap:4px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            ${s.shift.toUpperCase()}
                        </div>
                        <span style="font-size:11px; color:var(--text-gray); padding-left:26px;">${timeRange}</span>
                    </div>
                    <div style="flex:1;">
                        <h3 style="margin:0 0 6px 0; color:var(--dark-navy); font-size:18px;">${s.room}</h3>
                        <p style="margin:0; color:var(--text-gray); font-size:13px; font-weight:600; display:flex; align-items:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path></svg>
                            Standard Clinical Shift • Outpatient Department
                        </p>
                    </div>
                    <div>
                        <span class="badge" style="background:var(--light-green); color:var(--primary-green); padding:8px 16px; border-radius:8px; font-weight:700; font-size:13px; display:flex; align-items:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Scheduled
                        </span>
                    </div>
                </div>
            `;
        });
        html += `</div>`;
        grid.innerHTML = html;
    }

    function renderToday() {
        const grid = document.getElementById('todayGrid');
        const dateStr = getFormatDate(selectedDate);
        const isActuallyToday = (dateStr === serverTodayStr);
        
        document.getElementById('dateLabel').textContent = 
            selectedDate.toLocaleDateString('en-US', {weekday:'long', month:'long', day:'numeric', year:'numeric'}) + (isActuallyToday ? ' (Today)' : '');

        const todaySchedules = DB_SCHEDULES.filter(s => s.date === dateStr).sort((a,b) => {
            let jamA = a.shift.toLowerCase().includes('morning') ? 8 : (a.shift.toLowerCase().includes('afternoon') ? 13 : parseInt(a.shift.split(':')[0]));
            let jamB = b.shift.toLowerCase().includes('morning') ? 8 : (b.shift.toLowerCase().includes('afternoon') ? 13 : parseInt(b.shift.split(':')[0]));
            return jamA - jamB;
        });

        if (todaySchedules.length === 0) {
            grid.innerHTML = `<div style="text-align:center; padding: 60px 20px; color: var(--text-gray);">
              <div style="display:flex;justify-content:center;margin-bottom:12px;color:#cbd5e1;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
              <h4 style="color:var(--dark-navy);font-size:15px;margin-bottom:4px;">No Schedules Today</h4>
              <p style="font-size:13px;margin:0;">You have no assigned shifts for this date.</p>
            </div>`;
            return;
        }

        let html = `<div style="display:flex; flex-direction:column; gap:16px; max-width: 800px; margin: 0 auto;">`;
        todaySchedules.forEach(s => {
            html += `
                <div class="today-shift-card" style="display:flex; align-items:center; background:#f8fafc; border:1px solid var(--border); border-left:4px solid var(--primary-green); border-radius:10px; padding:24px;">
                    <div style="width:180px; font-weight:800; color:var(--dark-navy); font-size:16px; display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        ${s.shift}
                    </div>
                    <div style="flex:1;">
                        <h3 style="margin:0 0 6px 0; color:var(--dark-navy); font-size:18px;">${s.room}</h3>
                        <p style="margin:0; color:var(--text-gray); font-size:13px; font-weight:600; display:flex; align-items:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path></svg>
                            Standard Clinical Shift • Outpatient Department
                        </p>
                    </div>
                    <div>
                        <span class="badge" style="background:var(--light-green); color:var(--primary-green); padding:8px 16px; border-radius:8px; font-weight:700; font-size:13px; display:flex; align-items:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Scheduled
                        </span>
                    </div>
                </div>
            `;
        });
        html += `</div>`;
        grid.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', renderCalendar);
    
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