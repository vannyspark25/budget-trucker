<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Dashboard - Budget Trucker</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:var(--text);}
.sidebar{width:var(--sidebar-w);height:100vh;background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;overflow-y:auto;}
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
.topbar{background:#fff;padding:16px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;gap:16px;flex-wrap:wrap;}
.topbar h1{font-size:20px;font-weight:700;color:var(--navy);}
.topbar-right{display:flex;align-items:center;gap:12px;}
.date-filter{padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-weight:600;color:var(--navy);background:#f8fafc;cursor:pointer;}
.btn-icon{display:flex;align-items:center;gap:6px;background:var(--navy);color:#fff;border:none;border-radius:8px;padding:9px 14px;font-size:13px;font-weight:600;cursor:pointer;transition:0.15s;}
.btn-icon:hover{background:var(--accent-dark);}
.user-chip{display:flex;align-items:center;gap:8px;background:var(--bg);border-radius:20px;padding:6px 14px 6px 8px;font-size:13px;font-weight:600;color:var(--navy);}
.avatar{width:30px;height:30px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;}
.content{padding:28px;}
.card{background:var(--card);border-radius:12px;padding:22px 24px;box-shadow:0 2px 8px rgba(26,46,74,0.07);border:1px solid var(--border);margin-bottom:20px;}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.welcome-banner{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 100%);color:#fff;border-radius:14px;padding:28px 32px;margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;}
.welcome-banner h2{font-size:24px;margin-bottom:6px;}
.welcome-banner p{opacity:0.8;font-size:14px;}
.summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;margin-bottom:22px;}
.sum-box{background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px;}
.sum-box .s-label{font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;}
.sum-box .s-val{font-size:24px;font-weight:800;margin-top:6px;color:var(--navy);}
.sum-box .s-sub{font-size:12px;color:var(--muted);margin-top:4px;}
.sum-box.green .s-val{color:var(--success);}
.sum-box.red .s-val{color:var(--danger);}
.sum-box.orange .s-val{color:var(--accent-dark);}
.sum-box.blue .s-val{color:#3498db;}
.two-col{display:grid;grid-template-columns:1.4fr 1fr;gap:22px;}
.quick-links{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;}
.quick-links a{display:flex;align-items:center;gap:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:14px;text-decoration:none;color:var(--navy);font-weight:600;font-size:13px;transition:0.15s;}
.quick-links a:hover{background:var(--navy);color:#fff;}
.progress-track{background:#eef1f6;border-radius:8px;height:14px;overflow:hidden;margin-top:10px;}
.progress-fill{height:100%;width:0%;transition:width 0.6s ease;border-radius:8px;}
.progress-text{margin-top:8px;font-size:13px;color:var(--muted);}
.pie-wrap{max-width:420px;margin:0 auto;}
.record-item{background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px 14px;margin-bottom:8px;font-size:13px;display:flex;justify-content:space-between;}
.empty{text-align:center;padding:30px 20px;color:var(--muted);font-size:14px;}
@media(max-width:900px){.two-col{grid-template-columns:1fr;}}
@media print{.sidebar,.topbar-right,.quick-links{display:none!important;}.main{margin-left:0;}}
</style>
</head>
<body>
<div class="sidebar">
  <div class="sidebar-logo">
    <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
    <h2>🚛 Budget<span style="color:#f5a623">Trucker</span></h2>
  </div>
  <nav>
    <a href="dashboard.php" class="active"><span class="icon">📊</span> Dashboard</a>
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php"><span class="icon">📤</span> Expenses</a>
    <a href="budget.php"><span class="icon">📋</span> Budget</a>
    <a href="reports.php"><span class="icon">📈</span> Reports</a>
    <a href="route.php"><span class="icon">🗺️</span> Routes</a>
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
    <h1>📊 Dashboard</h1>
    <div class="topbar-right">
      <select class="date-filter" id="dateFilter">
        <option value="all">All Time</option>
        <option value="today">Today</option>
        <option value="week">This Week</option>
        <option value="month" selected>This Month</option>
      </select>
      <button class="btn-icon" id="printBtn">🖨️ Export / Print</button>
      <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
    </div>
  </div>
  <div class="content">

    <div class="welcome-banner">
      <div>
        <h2 id="welcomeMsg">Welcome back!</h2>
        <p>Here's how your trucking business is doing.</p>
      </div>
      <span style="font-size:46px;opacity:0.35;">🚛</span>
    </div>

    <div class="summary-grid">
      <div class="sum-box green"><div class="s-label">Total Income</div><div class="s-val" id="incVal">0</div></div>
      <div class="sum-box red"><div class="s-label">Total Expenses</div><div class="s-val" id="expVal">0</div></div>
      <div class="sum-box"><div class="s-label">Profit / Loss</div><div class="s-val" id="profVal">0</div></div>
      <div class="sum-box orange"><div class="s-label">Budget Remaining</div><div class="s-val" id="budVal">0</div></div>
      <div class="sum-box blue"><div class="s-label">Top Expense Category</div><div class="s-val" id="topCatVal" style="font-size:18px;">-</div><div class="s-sub" id="topCatSub"></div></div>
      <div class="sum-box blue"><div class="s-label">Fuel Efficiency</div><div class="s-val" id="fuelEffVal">N/A</div><div class="s-sub">km per liter</div></div>
    </div>

    <div class="card">
      <h3>📊 Budget Progress</h3>
      <div class="progress-track"><div class="progress-fill" id="budBar"></div></div>
      <div class="progress-text" id="budLabel">Loading...</div>
    </div>

    <div class="two-col">
      <div class="card">
        <h3>📈 Income vs Expenses</h3>
        <canvas id="trendChart" height="120"></canvas>
      </div>

      <div class="card">
        <h3>⚡ Quick Links</h3>
        <div class="quick-links">
          <a href="income.php">💰 Add Income</a>
          <a href="expense.php">📤 Add Expense</a>
          <a href="fuel.php">⛽ Log Fuel</a>
<a href="admin-notifications.php" class="active"><span class="icon">📢</span> Admin Broadcast</a>
          <a href="route.php">🗺️ Add Trip</a>
          <a href="reports.php">📊 View Reports</a>
          <a href="budget.php">📋 Set Budget</a>
        </div>
        <h3 style="margin-top:18px;">🗺️ Recent Trips</h3>
        <div id="tripList"><div class="empty">No trips yet.</div></div>
      </div>
    </div>

    <div class="card">
      <h3>🥧 Expense Breakdown</h3>
      <div class="pie-wrap"><canvas id="pieChart" height="220"></canvas></div>
    </div>

    <div class="card">
      <h3>🕒 Recent Activity</h3>
      <div id="recentList"><div class="empty">No activity yet.</div></div>
    </div>

  </div>
</div>

<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
document.getElementById('welcomeMsg').textContent='Welcome back, '+u+'!';

let currency='KSh';
let trendChartInst=null, pieChartInst=null;

function fetchSettings(){
  return fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;}});
}

function inRange(dateStr,range){
  if(range==='all') return true;
  let d=new Date(dateStr), now=new Date();
  if(range==='today'){
    return d.toDateString()===now.toDateString();
  }
  if(range==='week'){
    let start=new Date(now); start.setDate(now.getDate()-now.getDay());
    start.setHours(0,0,0,0);
    return d>=start;
  }
  if(range==='month'){
    return d.getMonth()===now.getMonth() && d.getFullYear()===now.getFullYear();
  }
  return true;
}

let rawData={incomes:[],expenses:[],budget:0,trips:[],fuels:[]};

function load(){
  Promise.all([
    fetch('api/incomes.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/expenses.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/budget.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/trips.php',{credentials:'same-origin'}).then(r=>r.json()),
    fetch('api/fuels.php',{credentials:'same-origin'}).then(r=>r.json())
  ]).then(([incRes,expRes,budRes,tripRes,fuelRes])=>{
    rawData.incomes=incRes.data||[];
    rawData.expenses=expRes.data||[];
    rawData.budget=budRes.budget||0;
    rawData.trips=tripRes.data||[];
    rawData.fuels=fuelRes.data||[];
    render();
  });
}

function render(){
  let range=document.getElementById('dateFilter').value;
  let incomes=rawData.incomes.filter(i=>inRange(i.date,range));
  let expenses=rawData.expenses.filter(e=>inRange(e.date,range));
  let trips=rawData.trips.filter(t=>inRange(t.date,range));
  let fuels=rawData.fuels.filter(f=>inRange(f.date,range));
  let budget=rawData.budget;

  let totalInc=incomes.reduce((s,i)=>s+parseFloat(i.amount),0);
  let totalExp=expenses.reduce((s,i)=>s+parseFloat(i.amount),0);
  let profit=totalInc-totalExp;
  let remaining=budget-totalExp;

  document.getElementById('incVal').textContent=currency+' '+totalInc.toLocaleString();
  document.getElementById('expVal').textContent=currency+' '+totalExp.toLocaleString();
  document.getElementById('profVal').textContent=currency+' '+profit.toLocaleString();
  document.getElementById('profVal').style.color=profit<0?'var(--danger)':'var(--success)';
  document.getElementById('budVal').textContent=currency+' '+remaining.toLocaleString();

  if(trendChartInst) trendChartInst.destroy();
  trendChartInst=new Chart(document.getElementById('trendChart'),{
    type:'bar',
    data:{labels:['Income','Expenses','Profit/Loss'],datasets:[{data:[totalInc,totalExp,profit],backgroundColor:['#27ae60','#e74c3c',profit<0?'#e74c3c':'#1a2e4a']}]},
    options:{plugins:{legend:{display:false}}}
  });

  let budPct=budget>0?Math.min((totalExp/budget)*100,100):0;
  let budBar=document.getElementById('budBar');
  let budLabel=document.getElementById('budLabel');
  budBar.style.width=budPct+'%';
  budLabel.textContent=currency+' '+totalExp.toLocaleString()+' of '+currency+' '+budget.toLocaleString()+' spent ('+Math.round(budPct)+'%)';
  if(budPct>=100){budBar.style.background='var(--danger)';}
  else if(budPct>=80){budBar.style.background='var(--warning-color)';}
  else{budBar.style.background='var(--success)';}

  let cats={};
  expenses.forEach(e=>{cats[e.category]=(cats[e.category]||0)+parseFloat(e.amount);});
  let pieLabels=Object.keys(cats);
  let pieData=Object.values(cats);
  let pieColors=['#1a2e4a','#f5a623','#27ae60','#e74c3c','#f39c12','#9b59b6','#3498db'];

  if(pieLabels.length){
    let topIdx=pieData.indexOf(Math.max(...pieData));
    document.getElementById('topCatVal').textContent=pieLabels[topIdx];
    let pct=totalExp>0?Math.round((pieData[topIdx]/totalExp)*100):0;
    document.getElementById('topCatSub').textContent=currency+' '+pieData[topIdx].toLocaleString()+' ('+pct+'% of spend)';
  } else {
    document.getElementById('topCatVal').textContent='-';
    document.getElementById('topCatSub').textContent='No expenses yet';
  }

  if(pieChartInst) pieChartInst.destroy();
  if(pieLabels.length){
    pieChartInst=new Chart(document.getElementById('pieChart'),{
      type:'doughnut',
      data:{labels:pieLabels,datasets:[{data:pieData,backgroundColor:pieColors.slice(0,pieLabels.length),borderWidth:0}]},
      options:{plugins:{legend:{position:'bottom',labels:{padding:12,usePointStyle:true,pointStyle:'circle'}}}}
    });
  }

  // Fuel efficiency: total trip distance / total fuel liters logged in range
  let totalDistance=trips.reduce((s,t)=>s+parseFloat(t.distance||0),0);
  let totalLiters=fuels.reduce((s,f)=>s+parseFloat(f.liters||f.litres||f.quantity||0),0);
  if(totalLiters>0){
    document.getElementById('fuelEffVal').textContent=(totalDistance/totalLiters).toFixed(2);
  } else {
    document.getElementById('fuelEffVal').textContent='N/A';
  }

  let tripList=document.getElementById('tripList');
  let recentTrips=trips.slice(0,4);
  if(!recentTrips.length){tripList.innerHTML='<div class="empty">No trips logged yet.</div>';}
  else{tripList.innerHTML=recentTrips.map(t=>`<div class="record-item"><span>🗺️ ${t.origin} → ${t.destination}</span><span>${parseFloat(t.distance)} KM · ${currency} ${parseFloat(t.trip_cost).toLocaleString()}</span></div>`).join('');}

  let activity=[
    ...incomes.map(i=>({label:'💰 '+i.category,amount:'+'+currency+' '+parseFloat(i.amount).toLocaleString(),date:i.date})),
    ...expenses.map(e=>({label:'📤 '+e.category,amount:'-'+currency+' '+parseFloat(e.amount).toLocaleString(),date:e.date})),
    ...trips.map(t=>({label:'🗺️ '+t.origin+' → '+t.destination,amount:currency+' '+parseFloat(t.trip_cost).toLocaleString(),date:t.date})),
    ...fuels.map(f=>({label:'⛽ '+f.trip,amount:currency+' '+parseFloat(f.total_cost).toLocaleString(),date:f.date}))
  ].sort((a,b)=>new Date(b.date)-new Date(a.date)).slice(0,10);

  let list=document.getElementById('recentList');
  if(!activity.length){list.innerHTML='<div class="empty">No activity yet.</div>';return;}
  list.innerHTML=activity.map(a=>`<div class="record-item"><span>${a.label}</span><span>${a.amount} · ${a.date}</span></div>`).join('');
}

document.getElementById('dateFilter').addEventListener('change',render);
document.getElementById('printBtn').addEventListener('click',()=>window.print());

fetchSettings().then(load);
</script>
</body>
</html>