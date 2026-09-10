<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Fuel Monitor - Budget Trucker</title>
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
.content{padding:28px;}
.card{background:var(--card);border-radius:12px;padding:22px 24px;box-shadow:0 2px 8px rgba(26,46,74,0.07);border:1px solid var(--border);margin-bottom:20px;}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:22px;}
.form-group{margin-bottom:14px;}
.form-group label{display:block;font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;}
input,select,textarea{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;font-family:inherit;color:var(--text);background:#fff;outline:none;transition:border-color 0.15s;}
input:focus,select:focus,textarea:focus{border-color:var(--navy);}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 20px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:all 0.15s;text-decoration:none;width:100%;margin-top:4px;}
.btn-primary{background:var(--navy);color:#fff;}
.btn-primary:hover{background:var(--navy-dark);}
.btn-success{background:var(--success);color:#fff;}
.btn-danger{background:var(--danger);color:#fff;}
.btn-warning{background:var(--warning-color);color:#fff;}
.btn-sm{padding:7px 12px;font-size:12px;width:auto;}
.btn-row{display:flex;gap:8px;margin-top:10px;}
.btn-row .btn{flex:1;margin-top:0;}
.record-item{background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:14px 16px;margin-bottom:10px;}
.record-item.income-item{border-left:4px solid var(--success);}
.record-item.expense-item{border-left:4px solid var(--danger);}
.record-item.fuel-item{border-left:4px solid var(--accent);}
.record-item.trip-item{border-left:4px solid var(--navy);}
.record-title{font-weight:700;font-size:14px;color:var(--navy);}
.record-amount{font-size:16px;font-weight:800;margin:3px 0;}
.income-amt{color:var(--success);}.expense-amt{color:var(--danger);}
.record-meta{font-size:12px;color:var(--muted);margin-top:3px;}
.total-box{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 100%);color:#fff;border-radius:12px;padding:18px 24px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;}
.total-box .total-label{font-size:13px;opacity:0.75;font-weight:600;}
.total-box .total-value{font-size:26px;font-weight:800;}
.empty{text-align:center;padding:36px 20px;color:var(--muted);font-size:14px;}
.empty .empty-icon{font-size:36px;margin-bottom:8px;}</style>
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
    <a href="fuel.php" class="active"><span class="icon">⛽</span> Fuel Monitor</a>
    <a href="notifications.php"><span class="icon">🔔</span> Notifications</a>
    <a href="storage.php"><span class="icon">💾</span> Data Storage</a>
    <a href="settings.php"><span class="icon">⚙️</span> Settings</a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php"><span class="icon">🚪</span> Logout</a>
  </div>
</div>
<div class="main">
  <div class="topbar">
    <h1>⛽ Fuel Monitoring</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
    <div class="two-col" style="margin-bottom:20px;">
      <div class="card">
        <h3>⛽ Record Fuel Purchase</h3>
        <div class="form-group"><label>Trip Route</label><input type="text" id="trip" placeholder="e.g. Nairobi → Mombasa"></div>
        <div class="form-group"><label>Distance (KM)</label><input type="number" id="distance" placeholder="e.g. 480"></div>
        <div class="form-group"><label>Fuel Purchased (Litres)</label><input type="number" id="litres" placeholder="e.g. 60"></div>
        <div class="form-group"><label>Price Per Litre</label><input type="number" id="price" placeholder="e.g. 195"></div>
        <button class="btn btn-primary" onclick="saveFuel()">⛽ Save Fuel Record</button>
      </div>
      <div class="card">
        <h3>📋 Fuel Records</h3>
        <div id="fuelList"><div class="empty"><div class="empty-icon">⛽</div>No fuel records yet.</div></div>
      </div>
    </div>
  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
let currency='KSh';
let fuels=[];
function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;render();}});
}
function fetchFuels(){
  fetch('api/fuels.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){fuels=d.data;render();}});
}
function saveFuel(){
  let trip=document.getElementById('trip').value.trim();
  let distance=Number(document.getElementById('distance').value);
  let litres=Number(document.getElementById('litres').value);
  let price=Number(document.getElementById('price').value);
  if(!trip||!distance||!litres||!price){alert('Please fill in all fields');return;}
  fetch('api/fuels.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({trip,distance,litres,price})}).then(r=>r.json()).then(d=>{if(d.success){['trip','distance','litres','price'].forEach(id=>document.getElementById(id).value='');fetchFuels();}});
}
function deleteFuel(id){
  if(!confirm('Delete this fuel record?'))return;
  fetch('api/fuels.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchFuels());
}
function render(){
  let list=document.getElementById('fuelList');
  if(!fuels.length){list.innerHTML='<div class="empty"><div class="empty-icon">⛽</div>No fuel records yet.</div>';return;}
  list.innerHTML=fuels.slice().reverse().map((f,ri)=>{
    let index=fuels.length-1-ri;
    return `<div class="record-item fuel-item">
      <div class="record-title">🚛 ${f.trip}</div>
      <div class="record-amount" style="color:var(--accent);">${currency} ${Number(f.total_cost).toLocaleString()}</div>
      <div class="record-meta">
        ${f.distance} KM &nbsp;·&nbsp; ${f.litres} L &nbsp;·&nbsp; ${currency}${f.price}/L<br>
        Cost/KM: <strong>${currency}${Number(f.cost_per_km).toFixed(2)}</strong> &nbsp;·&nbsp; ${f.date}
        ${f.warning?'<br><span style="color:var(--danger);font-weight:700;">'+f.warning+'</span>':''}
      </div>
      <div class="btn-row">
        <button class="btn btn-danger btn-sm" onclick="deleteFuel(${f.id})">🗑️ Delete</button>
      </div>
    </div>`;
  }).join('');
}
fetchSettings();
fetchFuels();
</script>
</body>
</html>
