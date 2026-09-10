<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Notifications - Budget Trucker</title>
<style>
:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:var(--text);}
.sidebar{width:var(--sidebar-w);height:100vh;background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;overflow-y:auto;}
.sidebar-logo{padding:20px 20px 18px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px;}
.sidebar-logo img{width:36px;height:36px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;}
.sidebar-logo h2{color:#fff;font-size:17px;font-weight:700;display:flex;align-items:center;gap:8px;}
.sidebar nav{flex:1;padding:14px 0;}
.sidebar a{display:flex;align-items:center;gap:11px;color:rgba(255,255,255,0.72);text-decoration:none;padding:12px 22px;font-size:14px;font-weight:500;transition:all 0.18s;border-left:3px solid transparent;position:relative;}
.sidebar a:hover,.sidebar a.active{color:#fff;background:rgba(255,255,255,0.08);border-left-color:var(--accent);}
.sidebar a .icon{font-size:16px;width:20px;text-align:center;}
.nav-badge{margin-left:auto;background:var(--danger);color:#fff;font-size:11px;font-weight:700;border-radius:10px;padding:1px 7px;}
.sidebar-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,0.08);}
.sidebar-footer a{display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.5);text-decoration:none;font-size:13px;padding:8px 0;}
.sidebar-footer a:hover{color:var(--danger);}
.main{margin-left:var(--sidebar-w);min-height:100vh;}
.topbar{background:#fff;padding:16px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
.topbar h1{font-size:20px;font-weight:700;color:var(--navy);}
.user-chip{display:flex;align-items:center;gap:8px;background:var(--bg);border-radius:20px;padding:6px 14px 6px 8px;font-size:13px;font-weight:600;color:var(--navy);}
.avatar{width:30px;height:30px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;}
.content{padding:28px;}
.card{background:var(--card);border-radius:12px;padding:22px 24px;box-shadow:0 2px 8px rgba(26,46,74,0.07);border:1px solid var(--border);margin-bottom:20px;}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;justify-content:space-between;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 20px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:all 0.15s;text-decoration:none;width:100%;margin-top:4px;}
.btn-danger{background:var(--danger);color:#fff;}
.btn-outline{background:#fff;color:var(--navy);border:1.5px solid var(--border);}
.btn-outline:hover{border-color:var(--navy);}
.btn-sm{padding:7px 12px;font-size:12px;width:auto;margin-top:0;}
.empty{text-align:center;padding:36px 20px;color:var(--muted);font-size:14px;}
.empty .empty-icon{font-size:36px;margin-bottom:8px;}
.notif-item{background:#f8fafc;border-radius:10px;padding:14px 16px;margin-bottom:10px;border-left:4px solid var(--accent);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.notif-item.notif-warning{border-left-color:var(--danger);}
.notif-item.notif-success{border-left-color:var(--success);}
.notif-item.notif-normal{border-left-color:var(--accent);}
.notif-body{flex:1;}
.notif-msg{font-size:14px;font-weight:600;color:var(--navy);}
.notif-date{font-size:11px;color:var(--muted);margin-top:3px;}
.toolbar{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center;}
.toolbar input{flex:1;min-width:160px;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;}
.filter-tabs{display:flex;gap:6px;flex-wrap:wrap;}
.filter-tab{padding:7px 13px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:#fff;color:var(--navy);}
.filter-tab.active{background:var(--navy);color:#fff;border-color:var(--navy);}
.filter-tab .count{margin-left:4px;opacity:0.75;}
</style>
</head>
<body>
<div class="sidebar">
  <div class="sidebar-logo">
    <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
    <h2>🚛 Budget<span style="color:#f5a623">Trucker</span></h2>
  </div>
  <nav>
    <a href="dashboard.php"><span class="icon">📊</span> Dashboard</a>
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php"><span class="icon">📤</span> Expenses</a>
    <a href="budget.php"><span class="icon">📋</span> Budget</a>
    <a href="reports.php"><span class="icon">📈</span> Reports</a>
    <a href="route.php"><span class="icon">🗺️</span> Routes</a>
    <a href="fuel.php"><span class="icon">⛽</span> Fuel Monitor</a>
    <a href="notifications.php" class="active"><span class="icon">🔔</span> Notifications<span class="nav-badge" id="navBadge" style="display:none;">0</span></a>
    <a href="storage.php"><span class="icon">💾</span> Data Storage</a>
    <a href="settings.php"><span class="icon">⚙️</span> Settings</a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php"><span class="icon">🚪</span> Logout</a>
  </div>
</div>
<div class="main">
  <div class="topbar">
    <h1>🔔 Notifications & Alerts</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
    <div class="card">
      <h3>🔔 Notification Center
        <button class="btn btn-outline btn-sm" onclick="clearAll()">🧹 Clear All</button>
      </h3>
      <div class="toolbar">
        <input type="text" id="searchBox" placeholder="🔍 Search notifications...">
      </div>
      <div class="filter-tabs" id="filterTabs"></div>
      <div id="notifList" style="margin-top:16px;"></div>
    </div>
  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
let currency='KSh';
let notifications=[];
let activeFilter='all';
let tempIdCounter=-1;

function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;}});
}

function fetchAll(){
  Promise.all([
    fetch('api/expenses.php',{credentials:'same-origin'}),
    fetch('api/incomes.php',{credentials:'same-origin'}),
    fetch('api/fuels.php',{credentials:'same-origin'}),
    fetch('api/budget.php',{credentials:'same-origin'}),
    fetch('api/notifications.php',{credentials:'same-origin'})
  ]).then(responses=>Promise.all(responses.map(r=>r.json()))).then(results=>{
    let expenses=(results[0].data||[]);
    let incomes=(results[1].data||[]);
    let fuels=(results[2].data||[]);
    let budget=results[3].budget||0;
    let savedNotifs=results[4].data||[];
    let totalExpenses=expenses.reduce((s,i)=>s+i.amount,0);
    let totalIncome=incomes.reduce((s,i)=>s+i.amount,0);
    let profit=totalIncome-totalExpenses;

    tempIdCounter=-1;
    let generated=[];
    if(budget>0&&totalExpenses>=budget){
      generated.unshift({type:'notif-warning',msg:'⚠️ Budget limit exceeded! You have spent '+currency+' '+totalExpenses.toLocaleString()+' of your '+currency+' '+budget.toLocaleString()+' budget.',date:new Date().toLocaleString(),id:tempIdCounter--});
    } else if(budget>0&&totalExpenses>=budget*0.8){
      generated.unshift({type:'notif-warning',msg:'⚠️ You have used 80% of your budget.',date:new Date().toLocaleString(),id:tempIdCounter--});
    }
    if(fuels.length>0&&fuels[fuels.length-1].litres<20){
      generated.unshift({type:'notif-warning',msg:'⛽ Low fuel warning — last record below 20 litres.',date:new Date().toLocaleString(),id:tempIdCounter--});
    }
    fuels.forEach(f=>{if(f.warning)generated.unshift({type:'notif-warning',msg:f.warning+' on route: '+f.trip,date:f.date,id:tempIdCounter--});});
    generated.unshift({type:'notif-success',msg:'📊 Summary: Income = '+currency+' '+totalIncome.toLocaleString()+', Expenses = '+currency+' '+totalExpenses.toLocaleString()+', Profit = '+currency+' '+profit.toLocaleString(),date:new Date().toLocaleString(),id:tempIdCounter--});
    generated.unshift({type:'notif-normal',msg:'💡 Remember to record today\'s expenses and fuel.',date:new Date().toLocaleString(),id:tempIdCounter--});
    generated.unshift({type:'notif-normal',msg:'✅ Budget Trucker is running smoothly.',date:new Date().toLocaleString(),id:tempIdCounter--});

    notifications=generated.concat(savedNotifs.map(n=>({...n})));
    renderTabs();
    render();
    updateBadge();
  });
}

function updateBadge(){
  let warnCount=notifications.filter(n=>n.type==='notif-warning').length;
  let badge=document.getElementById('navBadge');
  if(warnCount>0){badge.style.display='inline-block';badge.textContent=warnCount;}
  else{badge.style.display='none';}
}

function renderTabs(){
  let counts={all:notifications.length,'notif-warning':0,'notif-success':0,'notif-normal':0};
  notifications.forEach(n=>counts[n.type]=(counts[n.type]||0)+1);
  let tabs=[
    {key:'all',label:'All'},
    {key:'notif-warning',label:'⚠️ Warnings'},
    {key:'notif-success',label:'📊 Summary'},
    {key:'notif-normal',label:'💡 Info'}
  ];
  document.getElementById('filterTabs').innerHTML=tabs.map(t=>
    `<div class="filter-tab ${activeFilter===t.key?'active':''}" onclick="setFilter('${t.key}')">${t.label} <span class="count">${counts[t.key]||0}</span></div>`
  ).join('');
}
function setFilter(key){activeFilter=key;renderTabs();render();}

function getFiltered(){
  let search=document.getElementById('searchBox').value.toLowerCase();
  return notifications.filter(n=>{
    let matchesType=activeFilter==='all'||n.type===activeFilter;
    let matchesSearch=!search||n.msg.toLowerCase().includes(search);
    return matchesType&&matchesSearch;
  });
}

function render(){
  let filtered=getFiltered();
  let list=document.getElementById('notifList');
  if(!notifications.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔔</div>No notifications.</div>';return;}
  if(!filtered.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔍</div>No notifications match your filter.</div>';return;}
  list.innerHTML=filtered.map(n=>
    `<div class="notif-item ${n.type}">
      <div class="notif-body"><div class="notif-msg">${n.msg}</div><div class="notif-date">${n.date}</div></div>
      <button class="btn btn-danger btn-sm" style="flex-shrink:0;" onclick="del(${n.id})">✕</button>
    </div>`
  ).join('');
}

function del(id){
  if(id>0){
    fetch('api/notifications.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchAll());
  } else {
    notifications=notifications.filter(n=>n.id!==id);
    renderTabs();
    render();
    updateBadge();
  }
}

function clearAll(){
  if(!notifications.length)return;
  if(!confirm('Clear all notifications? Saved alerts will be permanently deleted.'))return;
  let savedIds=notifications.filter(n=>n.id>0).map(n=>n.id);
  Promise.all(savedIds.map(id=>fetch('api/notifications.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}))).then(()=>{
    notifications=notifications.filter(n=>n.id<0&&false); // generated ones are re-derived from live data, so just refetch
    fetchAll();
  });
}

document.getElementById('searchBox').addEventListener('input',render);

fetchSettings();
fetchAll();
setInterval(fetchAll,60000); // auto-refresh every 60s
</script>
</body>
</html><?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Notifications - Budget Trucker</title>
<style>
:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:var(--text);}
.sidebar{width:var(--sidebar-w);height:100vh;background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;overflow-y:auto;}
.sidebar-logo{padding:20px 20px 18px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px;}
.sidebar-logo img{width:36px;height:36px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;}
.sidebar-logo h2{color:#fff;font-size:17px;font-weight:700;display:flex;align-items:center;gap:8px;}
.sidebar nav{flex:1;padding:14px 0;}
.sidebar a{display:flex;align-items:center;gap:11px;color:rgba(255,255,255,0.72);text-decoration:none;padding:12px 22px;font-size:14px;font-weight:500;transition:all 0.18s;border-left:3px solid transparent;position:relative;}
.sidebar a:hover,.sidebar a.active{color:#fff;background:rgba(255,255,255,0.08);border-left-color:var(--accent);}
.sidebar a .icon{font-size:16px;width:20px;text-align:center;}
.nav-badge{margin-left:auto;background:var(--danger);color:#fff;font-size:11px;font-weight:700;border-radius:10px;padding:1px 7px;}
.sidebar-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,0.08);}
.sidebar-footer a{display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.5);text-decoration:none;font-size:13px;padding:8px 0;}
.sidebar-footer a:hover{color:var(--danger);}
.main{margin-left:var(--sidebar-w);min-height:100vh;}
.topbar{background:#fff;padding:16px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
.topbar h1{font-size:20px;font-weight:700;color:var(--navy);}
.user-chip{display:flex;align-items:center;gap:8px;background:var(--bg);border-radius:20px;padding:6px 14px 6px 8px;font-size:13px;font-weight:600;color:var(--navy);}
.avatar{width:30px;height:30px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;}
.content{padding:28px;}
.card{background:var(--card);border-radius:12px;padding:22px 24px;box-shadow:0 2px 8px rgba(26,46,74,0.07);border:1px solid var(--border);margin-bottom:20px;}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;justify-content:space-between;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 20px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:all 0.15s;text-decoration:none;width:100%;margin-top:4px;}
.btn-danger{background:var(--danger);color:#fff;}
.btn-outline{background:#fff;color:var(--navy);border:1.5px solid var(--border);}
.btn-outline:hover{border-color:var(--navy);}
.btn-sm{padding:7px 12px;font-size:12px;width:auto;margin-top:0;}
.empty{text-align:center;padding:36px 20px;color:var(--muted);font-size:14px;}
.empty .empty-icon{font-size:36px;margin-bottom:8px;}
.notif-item{background:#f8fafc;border-radius:10px;padding:14px 16px;margin-bottom:10px;border-left:4px solid var(--accent);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.notif-item.notif-warning{border-left-color:var(--danger);}
.notif-item.notif-success{border-left-color:var(--success);}
.notif-item.notif-normal{border-left-color:var(--accent);}
.notif-body{flex:1;}
.notif-msg{font-size:14px;font-weight:600;color:var(--navy);}
.notif-date{font-size:11px;color:var(--muted);margin-top:3px;}
.toolbar{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center;}
.toolbar input{flex:1;min-width:160px;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;}
.filter-tabs{display:flex;gap:6px;flex-wrap:wrap;}
.filter-tab{padding:7px 13px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:#fff;color:var(--navy);}
.filter-tab.active{background:var(--navy);color:#fff;border-color:var(--navy);}
.filter-tab .count{margin-left:4px;opacity:0.75;}
</style>
</head>
<body>
<div class="sidebar">
  <div class="sidebar-logo">
    <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
    <h2>🚛 Budget<span style="color:#f5a623">Trucker</span></h2>
  </div>
  <nav>
    <a href="dashboard.php"><span class="icon">📊</span> Dashboard</a>
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php"><span class="icon">📤</span> Expenses</a>
    <a href="budget.php"><span class="icon">📋</span> Budget</a>
    <a href="reports.php"><span class="icon">📈</span> Reports</a>
    <a href="route.php"><span class="icon">🗺️</span> Routes</a>
    <a href="fuel.php"><span class="icon">⛽</span> Fuel Monitor</a>
    <a href="notifications.php" class="active"><span class="icon">🔔</span> Notifications<span class="nav-badge" id="navBadge" style="display:none;">0</span></a>
    <a href="storage.php"><span class="icon">💾</span> Data Storage</a>
    <a href="settings.php"><span class="icon">⚙️</span> Settings</a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php"><span class="icon">🚪</span> Logout</a>
  </div>
</div>
<div class="main">
  <div class="topbar">
    <h1>🔔 Notifications & Alerts</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
    <div class="card">
      <h3>🔔 Notification Center
        <button class="btn btn-outline btn-sm" onclick="clearAll()">🧹 Clear All</button>
      </h3>
      <div class="toolbar">
        <input type="text" id="searchBox" placeholder="🔍 Search notifications...">
      </div>
      <div class="filter-tabs" id="filterTabs"></div>
      <div id="notifList" style="margin-top:16px;"></div>
    </div>
  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
let currency='KSh';
let notifications=[];
let activeFilter='all';
let tempIdCounter=-1;

function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;}});
}

function fetchAll(){
  Promise.all([
    fetch('api/expenses.php',{credentials:'same-origin'}),
    fetch('api/incomes.php',{credentials:'same-origin'}),
    fetch('api/fuels.php',{credentials:'same-origin'}),
    fetch('api/budget.php',{credentials:'same-origin'}),
    fetch('api/notifications.php',{credentials:'same-origin'})
  ]).then(responses=>Promise.all(responses.map(r=>r.json()))).then(results=>{
    let expenses=(results[0].data||[]);
    let incomes=(results[1].data||[]);
    let fuels=(results[2].data||[]);
    let budget=results[3].budget||0;
    let savedNotifs=results[4].data||[];
    let totalExpenses=expenses.reduce((s,i)=>s+i.amount,0);
    let totalIncome=incomes.reduce((s,i)=>s+i.amount,0);
    let profit=totalIncome-totalExpenses;

    tempIdCounter=-1;
    let generated=[];
    if(budget>0&&totalExpenses>=budget){
      generated.unshift({type:'notif-warning',msg:'⚠️ Budget limit exceeded! You have spent '+currency+' '+totalExpenses.toLocaleString()+' of your '+currency+' '+budget.toLocaleString()+' budget.',date:new Date().toLocaleString(),id:tempIdCounter--});
    } else if(budget>0&&totalExpenses>=budget*0.8){
      generated.unshift({type:'notif-warning',msg:'⚠️ You have used 80% of your budget.',date:new Date().toLocaleString(),id:tempIdCounter--});
    }
    if(fuels.length>0&&fuels[fuels.length-1].litres<20){
      generated.unshift({type:'notif-warning',msg:'⛽ Low fuel warning — last record below 20 litres.',date:new Date().toLocaleString(),id:tempIdCounter--});
    }
    fuels.forEach(f=>{if(f.warning)generated.unshift({type:'notif-warning',msg:f.warning+' on route: '+f.trip,date:f.date,id:tempIdCounter--});});
    generated.unshift({type:'notif-success',msg:'📊 Summary: Income = '+currency+' '+totalIncome.toLocaleString()+', Expenses = '+currency+' '+totalExpenses.toLocaleString()+', Profit = '+currency+' '+profit.toLocaleString(),date:new Date().toLocaleString(),id:tempIdCounter--});
    generated.unshift({type:'notif-normal',msg:'💡 Remember to record today\'s expenses and fuel.',date:new Date().toLocaleString(),id:tempIdCounter--});
    generated.unshift({type:'notif-normal',msg:'✅ Budget Trucker is running smoothly.',date:new Date().toLocaleString(),id:tempIdCounter--});

    notifications=generated.concat(savedNotifs.map(n=>({...n})));
    renderTabs();
    render();
    updateBadge();
  });
}

function updateBadge(){
  let warnCount=notifications.filter(n=>n.type==='notif-warning').length;
  let badge=document.getElementById('navBadge');
  if(warnCount>0){badge.style.display='inline-block';badge.textContent=warnCount;}
  else{badge.style.display='none';}
}

function renderTabs(){
  let counts={all:notifications.length,'notif-warning':0,'notif-success':0,'notif-normal':0};
  notifications.forEach(n=>counts[n.type]=(counts[n.type]||0)+1);
  let tabs=[
    {key:'all',label:'All'},
    {key:'notif-warning',label:'⚠️ Warnings'},
    {key:'notif-success',label:'📊 Summary'},
    {key:'notif-normal',label:'💡 Info'}
  ];
  document.getElementById('filterTabs').innerHTML=tabs.map(t=>
    `<div class="filter-tab ${activeFilter===t.key?'active':''}" onclick="setFilter('${t.key}')">${t.label} <span class="count">${counts[t.key]||0}</span></div>`
  ).join('');
}
function setFilter(key){activeFilter=key;renderTabs();render();}

function getFiltered(){
  let search=document.getElementById('searchBox').value.toLowerCase();
  return notifications.filter(n=>{
    let matchesType=activeFilter==='all'||n.type===activeFilter;
    let matchesSearch=!search||n.msg.toLowerCase().includes(search);
    return matchesType&&matchesSearch;
  });
}

function render(){
  let filtered=getFiltered();
  let list=document.getElementById('notifList');
  if(!notifications.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔔</div>No notifications.</div>';return;}
  if(!filtered.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔍</div>No notifications match your filter.</div>';return;}
  list.innerHTML=filtered.map(n=>
    `<div class="notif-item ${n.type}">
      <div class="notif-body"><div class="notif-msg">${n.msg}</div><div class="notif-date">${n.date}</div></div>
      <button class="btn btn-danger btn-sm" style="flex-shrink:0;" onclick="del(${n.id})">✕</button>
    </div>`
  ).join('');
}

function del(id){
  if(id>0){
    fetch('api/notifications.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchAll());
  } else {
    notifications=notifications.filter(n=>n.id!==id);
    renderTabs();
    render();
    updateBadge();
  }
}

function clearAll(){
  if(!notifications.length)return;
  if(!confirm('Clear all notifications? Saved alerts will be permanently deleted.'))return;
  let savedIds=notifications.filter(n=>n.id>0).map(n=>n.id);
  Promise.all(savedIds.map(id=>fetch('api/notifications.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}))).then(()=>{
    notifications=notifications.filter(n=>n.id<0&&false); // generated ones are re-derived from live data, so just refetch
    fetchAll();
  });
}

document.getElementById('searchBox').addEventListener('input',render);

fetchSettings();
fetchAll();
setInterval(fetchAll,60000); // auto-refresh every 60s
</script>
</body>
</html>