<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Data Storage - Budget Trucker</title>
<style>:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:var(--text);}
.sidebar{width:var(--sidebar-w);height:100vh;background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;overflow-y:auto;}
.sidebar-logo{padding:24px 20px 18px;border-bottom:1px solid rgba(255,255,255,0.08);}
.sidebar-logo h2{color:#fff;font-size:17px;font-weight:700;display:flex;align-items:center;gap:8px;}
.sidebar nav{flex:1;padding:14px 0;}
.sidebar a{display:flex;align-items:center;gap:11px;color:rgba(255,255,255,0.72);text-decoration:none;padding:12px 22px;font-size:14px;font-weight:500;transition:all 0.18s;border-left:3px solid transparent;}
.sidebar a:hover,.sidebar a.active{color:#fff;background:rgba(255,255,255,0.08);border-left-color:var(--accent);}
.sidebar a .icon{font-size:16px;width:20px;text-align:center;}
.sidebar-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,0.08);}
.sidebar-footer a{display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.5);text-decoration:none;font-size:13px;padding:8px 0;}
.sidebar-footer a:hover{color:var(--danger);}
.main{margin-left:var(--sidebar-w);min-height:100vh;}
.topbar{background:#fff;padding:16px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
.topbar h1{font-size:20px;font-weight:700;color:var(--navy);}
.user-chip{display:flex;align-items:center;gap:8px;background:var(--bg);border-radius:20px;padding:6px 14px 6px 8px;font-size:13px;font-weight:600;color:var(--navy);}
.avatar{width:30px;height:30px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;}
.content{padding:28px;max-width:900px;}
.card{background:var(--card);border-radius:12px;padding:22px 24px;box-shadow:0 2px 8px rgba(26,46,74,0.07);border:1px solid var(--border);margin-bottom:20px;}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:10px;display:flex;align-items:center;gap:8px;}
.card p{font-size:13px;color:var(--muted);margin-bottom:14px;line-height:1.6;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 20px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none;}
.btn-primary{background:var(--navy);color:#fff;}
.btn-success{background:var(--success);color:#fff;}
input[type=file]{margin-bottom:12px;}
#msg{margin-top:12px;font-size:13px;font-weight:600;}
.stat-row{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:6px;}
.stat-pill{background:#f8fafc;border:1px solid var(--border);border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;color:var(--navy);}
</style>
</head>
<body>
<div class="sidebar">
  <div class="sidebar-logo"><h2>🚛 Budget<span style="color:#f5a623">Trucker</span></h2></div>
  <nav>
    <a href="dashboard.php"><span class="icon">📊</span> Dashboard</a>
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php"><span class="icon">📤</span> Expenses</a>
    <a href="budget.php"><span class="icon">📋</span> Budget</a>
    <a href="reports.php"><span class="icon">📈</span> Reports</a>
    <a href="route.php"><span class="icon">🗺️</span> Routes</a>
    <a href="fuel.php"><span class="icon">⛽</span> Fuel Monitor</a>
    <a href="notifications.php"><span class="icon">🔔</span> Notifications</a>
    <a href="storage.php" class="active"><span class="icon">💾</span> Data Storage</a>
    <a href="settings.php"><span class="icon">⚙️</span> Settings</a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php"><span class="icon">🚪</span> Logout</a>
  </div>
</div>
<div class="main">
  <div class="topbar">
    <h1>💾 Data Storage</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">

    <div class="card">
      <h3>📦 Your Data</h3>
      <div class="stat-row" id="statRow"></div>
    </div>

    <div class="card">
      <h3>⬇️ Export All Data</h3>
      <p>Download every record (income, expenses, fuel, trips, budget) currently stored in your account as a single JSON file. Keep it somewhere safe as a backup.</p>
      <button class="btn btn-primary" onclick="exportData()">⬇️ Download Backup (.json)</button>
    </div>

    <div class="card">
      <h3>⬆️ Import Data</h3>
      <p>Restore records from a previously exported JSON file. Imported records are <strong>added</strong> to your existing data — they do not overwrite it.</p>
      <input type="file" id="fileInput" accept="application/json">
      <br>
      <button class="btn btn-success" onclick="importData()">⬆️ Import Backup</button>
      <div id="msg"></div>
    </div>

  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();

function showMsg(text,ok){
  document.getElementById('msg').innerHTML='<span style="color:'+(ok?'var(--success)':'var(--danger)')+'">'+text+'</span>';
}

function fetchAllData(){
  return Promise.all([
    fetch('api/incomes.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/expenses.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/fuels.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/trips.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/budget.php',{credentials:'same-origin'}).then(r=>r.json())
  ]).then(([inc,exp,fuel,trip,bud])=>({
    incomes:inc.data||[],
    expenses:exp.data||[],
    fuels:fuel.data||[],
    trips:trip.data||[],
    budget:bud.budget||0
  }));
}

function renderStats(d){
  document.getElementById('statRow').innerHTML=
    '<span class="stat-pill">💰 '+d.incomes.length+' income records</span>'+
    '<span class="stat-pill">📤 '+d.expenses.length+' expense records</span>'+
    '<span class="stat-pill">⛽ '+d.fuels.length+' fuel records</span>'+
    '<span class="stat-pill">🗺️ '+d.trips.length+' trip records</span>';
}

function exportData(){
  fetchAllData().then(data=>{
    let blob=new Blob([JSON.stringify(data,null,2)],{type:'application/json'});
    let a=document.createElement('a');
    a.href=URL.createObjectURL(blob);
    a.download='budget-trucker-backup-'+new Date().toISOString().slice(0,10)+'.json';
    a.click();
  });
}

function importData(){
  let file=document.getElementById('fileInput').files[0];
  if(!file){showMsg('Please choose a backup file first.',false);return;}
  let reader=new FileReader();
  reader.onload=function(e){
    let data;
    try{ data=JSON.parse(e.target.result); }catch(err){ showMsg('Invalid JSON file.',false); return; }

    let tasks=[];
    (data.incomes||[]).forEach(i=>tasks.push(fetch('api/incomes.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify(i)})));
    (data.expenses||[]).forEach(i=>tasks.push(fetch('api/expenses.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify(i)})));
    (data.fuels||[]).forEach(i=>tasks.push(fetch('api/fuels.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify(i)})));
    (data.trips||[]).forEach(i=>tasks.push(fetch('api/trips.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify(i)})));

    Promise.all(tasks).then(()=>{
      showMsg('✅ Import complete ('+tasks.length+' records added).',true);
      load();
    });
  };
  reader.readAsText(file);
}

function load(){
  fetchAllData().then(renderStats);
}
load();
</script>
</body>
</html>
