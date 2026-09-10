<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Routes - Budget Trucker</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{
  background: linear-gradient(135deg, #e9eef5 0%, #f7f9fc 100%);
  font-family:'Segoe UI',Arial,sans-serif;color:var(--text);
}.sidebar{width:var(--sidebar-w);height:100vh;background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;overflow-y:auto;}
.sidebar-logo{padding:20px 20px 18px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px;}
.sidebar-logo img{width:36px;height:36px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;}
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
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;justify-content:space-between;}
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
.btn-outline{background:#fff;color:var(--navy);border:1.5px solid var(--border);}
.btn-outline:hover{border-color:var(--navy);}
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
.empty .empty-icon{font-size:36px;margin-bottom:8px;}
.preview-box{background:#f8fafc;border:1.5px dashed var(--border);border-radius:10px;padding:12px 14px;margin-top:6px;font-size:13px;color:var(--navy);display:flex;justify-content:space-between;flex-wrap:wrap;gap:6px;}
.preview-box span strong{display:block;font-size:15px;}
.summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px;margin-bottom:20px;}
.sum-box{background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;}
.sum-box .s-label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;}
.sum-box .s-val{font-size:20px;font-weight:800;margin-top:5px;color:var(--navy);}
.toolbar{display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
.toolbar input,.toolbar select{width:auto;flex:1;min-width:110px;padding:9px 12px;font-size:13px;}
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
    <a href="route.php" class="active"><span class="icon">🗺️</span> Routes</a>
    <a href="fuel.php"><span class="icon">⛽</span> Fuel Monitor</a>
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
    <h1>🗺️ Route Management</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">

    <div class="summary-grid">
      <div class="sum-box"><div class="s-label">Total Trips</div><div class="s-val" id="totalTrips">0</div></div>
      <div class="sum-box"><div class="s-label">Total Distance</div><div class="s-val" id="totalDistance">0 KM</div></div>
      <div class="sum-box"><div class="s-label">Total Fuel Cost</div><div class="s-val" id="totalFuelCost">0</div></div>
      <div class="sum-box"><div class="s-label">Avg Efficiency</div><div class="s-val" id="avgEfficiency">0 KM/L</div></div>
      <div class="sum-box"><div class="s-label">Most Traveled Route</div><div class="s-val" id="topRoute" style="font-size:14px;">-</div></div>
    </div>

    <div class="two-col" style="margin-bottom:20px;align-items:start;">
      <div>
        <div class="card">
          <h3 id="formTitle">🚛 Add Trip Route</h3>
          <div class="form-group"><label>Starting Location</label><input type="text" id="origin" placeholder="e.g. Nairobi"></div>
          <div class="form-group"><label>Destination</label><input type="text" id="destination" placeholder="e.g. Mombasa"></div>
          <div class="form-group"><label>Distance (KM)</label><input type="number" id="distance" placeholder="e.g. 480"></div>
          <div class="form-group"><label>Fuel Used (Litres)</label><input type="number" id="fuelUsed" placeholder="e.g. 60"></div>
          <div class="form-group"><label>Fuel Price Per Litre</label><input type="number" id="fuelPrice" placeholder="e.g. 195"></div>
          <div class="preview-box" id="previewBox">
            <span>Est. Fuel Cost<strong id="previewCost">—</strong></span>
            <span>Efficiency<strong id="previewEff">—</strong></span>
          </div>
          <div class="btn-row">
            <button class="btn btn-primary" id="saveBtn" onclick="addTrip()">🚛 Save Trip</button>
            <button class="btn btn-outline" id="cancelBtn" onclick="cancelEdit()" style="display:none;">✖ Cancel</button>
          </div>
        </div>

        <div class="card" style="margin-bottom:0;">
          <h3>📈 Efficiency Trend</h3>
          <canvas id="effChart" height="160"></canvas>
        </div>
      </div>

      <div class="card" style="margin-bottom:0;">
        <h3>📋 Trip History
          <button class="btn btn-outline btn-sm" style="width:auto;margin-top:0;" onclick="exportCSV()">⬇️ Export CSV</button>
        </h3>
        <div class="toolbar">
          <input type="text" id="searchBox" placeholder="🔍 Search origin/destination...">
          <select id="sortBy">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="cost_high">Highest Cost</option>
            <option value="cost_low">Lowest Cost</option>
            <option value="eff_best">Best Efficiency</option>
            <option value="eff_worst">Worst Efficiency</option>
          </select>
        </div>
        <div id="tripList"><div class="empty"><div class="empty-icon">🚛</div>No trips recorded yet.</div></div>
      </div>
    </div>
  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
let currency='KSh';
let trips=[];
let editingId=null;
let effChartInst=null;

function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;render();}});
}
function fetchTrips(){
  fetch('api/trips.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){trips=d.data;render();}});
}

function updatePreview(){
  let distance=Number(document.getElementById('distance').value);
  let fuelUsed=Number(document.getElementById('fuelUsed').value);
  let fuelPrice=Number(document.getElementById('fuelPrice').value);
  let cost=document.getElementById('previewCost');
  let eff=document.getElementById('previewEff');
  cost.textContent=(fuelUsed>0&&fuelPrice>0)?currency+' '+(fuelUsed*fuelPrice).toLocaleString():'—';
  eff.textContent=(distance>0&&fuelUsed>0)?(distance/fuelUsed).toFixed(2)+' KM/L':'—';
}
['distance','fuelUsed','fuelPrice'].forEach(id=>document.getElementById(id).addEventListener('input',updatePreview));

function addTrip(){
  let origin=document.getElementById('origin').value.trim();
  let destination=document.getElementById('destination').value.trim();
  let distance=Number(document.getElementById('distance').value);
  let fuelUsed=Number(document.getElementById('fuelUsed').value);
  let fuelPrice=Number(document.getElementById('fuelPrice').value);
  if(!origin||!destination||!distance||!fuelUsed||!fuelPrice){alert('Please fill in all fields');return;}
  fetch('api/trips.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({origin,destination,distance,fuelUsed,fuelPrice})}).then(r=>r.json()).then(d=>{
    if(d.success){
      if(editingId){
        fetch('api/trips.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id:editingId})}).then(()=>{
          editingId=null;
          resetForm();
          fetchTrips();
        });
      } else {
        resetForm();
        fetchTrips();
      }
    }
  });
}
function resetForm(){
  ['origin','destination','distance','fuelUsed','fuelPrice'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('formTitle').textContent='🚛 Add Trip Route';
  document.getElementById('saveBtn').textContent='🚛 Save Trip';
  document.getElementById('cancelBtn').style.display='none';
  updatePreview();
}
function editTrip(id){
  let t=trips.find(x=>x.id===id);
  if(!t)return;
  editingId=id;
  document.getElementById('origin').value=t.origin;
  document.getElementById('destination').value=t.destination;
  document.getElementById('distance').value=t.distance;
  document.getElementById('fuelUsed').value=t.fuel_used;
  document.getElementById('fuelPrice').value=t.fuel_price;
  document.getElementById('formTitle').textContent='✏️ Edit Trip Route';
  document.getElementById('saveBtn').textContent='💾 Update Trip';
  document.getElementById('cancelBtn').style.display='block';
  updatePreview();
  window.scrollTo({top:0,behavior:'smooth'});
}
function cancelEdit(){
  editingId=null;
  resetForm();
}
function deleteTrip(id){
  if(!confirm('Delete this trip?'))return;
  fetch('api/trips.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchTrips());
}

function exportCSV(){
  if(!trips.length){alert('No trips to export.');return;}
  let rows=[['Date','Origin','Destination','Distance(KM)','FuelUsed(L)','FuelPrice','TripCost','Efficiency(KM/L)']];
  trips.forEach(t=>rows.push([t.date,t.origin,t.destination,t.distance,t.fuel_used,t.fuel_price,t.trip_cost,Number(t.consumption).toFixed(2)]));
  let csv=rows.map(r=>r.join(',')).join('\n');
  let blob=new Blob([csv],{type:'text/csv'});
  let a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='trip_routes.csv';
  a.click();
}

function getFiltered(){
  let search=document.getElementById('searchBox').value.toLowerCase();
  let sort=document.getElementById('sortBy').value;
  let list=trips.filter(t=>!search||t.origin.toLowerCase().includes(search)||t.destination.toLowerCase().includes(search));
  if(sort==='newest')list.sort((a,b)=>new Date(b.date)-new Date(a.date));
  else if(sort==='oldest')list.sort((a,b)=>new Date(a.date)-new Date(b.date));
  else if(sort==='cost_high')list.sort((a,b)=>b.trip_cost-a.trip_cost);
  else if(sort==='cost_low')list.sort((a,b)=>a.trip_cost-b.trip_cost);
  else if(sort==='eff_best')list.sort((a,b)=>b.consumption-a.consumption);
  else if(sort==='eff_worst')list.sort((a,b)=>a.consumption-b.consumption);
  return list;
}

function renderSummary(){
  document.getElementById('totalTrips').textContent=trips.length;
  let totalDistance=trips.reduce((s,t)=>s+Number(t.distance),0);
  let totalFuelCost=trips.reduce((s,t)=>s+Number(t.trip_cost),0);
  let avgEff=trips.length?trips.reduce((s,t)=>s+Number(t.consumption),0)/trips.length:0;
  document.getElementById('totalDistance').textContent=totalDistance.toLocaleString()+' KM';
  document.getElementById('totalFuelCost').textContent=currency+' '+totalFuelCost.toLocaleString();
  document.getElementById('avgEfficiency').textContent=avgEff.toFixed(2)+' KM/L';

  let routeCounts={};
  trips.forEach(t=>{let key=t.origin+' → '+t.destination;routeCounts[key]=(routeCounts[key]||0)+1;});
  let top=Object.entries(routeCounts).sort((a,b)=>b[1]-a[1])[0];
  document.getElementById('topRoute').textContent=top?`${top[0]} (${top[1]}x)`:'-';
}

function renderEffChart(){
  let sorted=trips.slice().sort((a,b)=>new Date(a.date)-new Date(b.date)).slice(-10);
  if(effChartInst)effChartInst.destroy();
  if(!sorted.length)return;
  effChartInst=new Chart(document.getElementById('effChart'),{
    type:'line',
    data:{
      labels:sorted.map(t=>t.origin+'→'+t.destination),
      datasets:[{label:'KM/L',data:sorted.map(t=>Number(t.consumption)),borderColor:'#f5a623',backgroundColor:'rgba(245,166,35,0.12)',fill:true,tension:0.3}]
    },
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}},maintainAspectRatio:true}
  });
}

function render(){
  renderSummary();
  renderEffChart();
  let filtered=getFiltered();
  let list=document.getElementById('tripList');
  if(!trips.length){list.innerHTML='<div class="empty"><div class="empty-icon">🚛</div>No trips recorded yet.</div>';return;}
  if(!filtered.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔍</div>No trips match your search.</div>';return;}
  list.innerHTML=filtered.map(t=>{
    return `<div class="record-item trip-item">
      <div class="record-title">🚛 ${t.origin} → ${t.destination}</div>
      <div class="record-amount" style="color:var(--navy);">${currency} ${Number(t.trip_cost).toLocaleString()}</div>
      <div class="record-meta">
        ${t.distance} KM &nbsp;·&nbsp; ${t.fuel_used} L &nbsp;·&nbsp; ${currency}${t.fuel_price}/L<br>
        Efficiency: <strong>${Number(t.consumption).toFixed(2)} KM/L</strong> &nbsp;·&nbsp; ${t.date}
      </div>
      <div class="btn-row">
        <button class="btn btn-warning btn-sm" onclick="editTrip(${t.id})">✏️ Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteTrip(${t.id})">🗑️ Delete</button>
      </div>
    </div>`;
  }).join('');
}

document.getElementById('searchBox').addEventListener('input',render);
document.getElementById('sortBy').addEventListener('change',render);

fetchSettings();
fetchTrips();
</script>
</body>
</html>