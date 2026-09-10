<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Reports - Budget Trucker</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root{
  --navy:#1a2e4a;
  --navy-dark:#111e30;
  --navy-mid:#243c5e;
  --accent:#f5a623;
  --success:#27ae60;
  --danger:#e74c3c;
  --warning-color:#f39c12;
  --bg: linear-gradient(135deg, #e9eef5 0%, #f7f9fc 100%);
  --card:#ffffff;
  --text:#1a2e4a;
  --muted:#6b7a8d;
  --border:#dce3ef;
  --sidebar-w:260px;
}

*{margin:0;padding:0;box-sizing:border-box;}

body{
  font-family:'Segoe UI',Arial,sans-serif;
  background:var(--bg);
  color:var(--text);
}

/* SIDEBAR */
.sidebar{
  width:var(--sidebar-w);
  height:100vh;
  background:linear-gradient(180deg,var(--navy-dark) 0%,var(--navy) 100%);
  position:fixed;
  top:0;
  left:0;
  display:flex;
  flex-direction:column;
  overflow-y:auto;
  z-index:100;
}

.sidebar-logo{
  padding:20px 20px 18px;
  border-bottom:1px solid rgba(255,255,255,0.08);
  display:flex;
  align-items:center;
  gap:10px;
}
.sidebar-logo img{width:36px;height:36px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;}

.sidebar-logo h2{
  color:#fff;
  font-size:17px;
  font-weight:700;
  display:flex;
  align-items:center;
  gap:8px;
}

.sidebar nav{flex:1;padding:14px 0;}

.sidebar a{
  display:flex;
  align-items:center;
  gap:11px;
  color:rgba(255,255,255,0.72);
  text-decoration:none;
  padding:12px 22px;
  font-size:14px;
  font-weight:500;
  border-left:3px solid transparent;
  transition:all 0.18s;
}

.sidebar a:hover,
.sidebar a.active{
  color:#fff;
  background:rgba(255,255,255,0.08);
  border-left-color:var(--accent);
}

.sidebar a .icon{font-size:16px;width:20px;text-align:center;}

.sidebar-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,0.08);}
.sidebar-footer a{display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.5);text-decoration:none;font-size:13px;padding:8px 0;}
.sidebar-footer a:hover{color:var(--danger);background:none;border-left-color:transparent;}

/* MAIN */
.main{
  margin-left:var(--sidebar-w);
  min-height:100vh;
}

/* TOPBAR */
.topbar{
  background:#fff;
  padding:16px 28px;
  border-bottom:1px solid var(--border);
  display:flex;
  justify-content:space-between;
  align-items:center;
  position:sticky;
  top:0;
  z-index:50;
  gap:16px;
  flex-wrap:wrap;
}
.topbar h1{font-size:20px;font-weight:700;color:var(--navy);}
.topbar-right{display:flex;align-items:center;gap:12px;flex-wrap:wrap;}

.date-filter{padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-weight:600;color:var(--navy);background:#f8fafc;cursor:pointer;}

.user-chip{
  display:flex;
  align-items:center;
  gap:8px;
  background:var(--bg);
  border-radius:20px;
  padding:6px 14px 6px 8px;
  font-size:13px;
  font-weight:600;
  color:var(--navy);
}

.avatar{
  width:30px;height:30px;
  background:var(--navy);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  font-size:12px;
  font-weight:700;
}

/* CONTENT */
.content{padding:28px;}

/* IMAGE BANNER */
.banner-card{
  position:relative;
  overflow:hidden;
  border-radius:14px;
  margin-bottom:20px;
}

.banner-card img{
  width:100%;
  height:220px;
  object-fit:cover;
  filter:brightness(55%);
}

.banner-text{
  position:absolute;
  top:50%;
  left:30px;
  transform:translateY(-50%);
  color:#fff;
}

.banner-text h2{
  font-size:26px;
  margin-bottom:6px;
}

/* SUMMARY */
.summary-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
  gap:16px;
  margin-bottom:20px;
}

.sum-box{
  background:linear-gradient(135deg,var(--navy),var(--navy-mid));
  color:#fff;
  border-radius:12px;
  padding:20px;
  text-align:center;
}

.sum-box.green{background:linear-gradient(135deg,#1e8449,#27ae60);}
.sum-box.red{background:linear-gradient(135deg,#922b21,#e74c3c);}
.sum-box.orange{background:linear-gradient(135deg,#b9770e,#f5a623);}

.sum-box .s-val{
  font-size:24px;
  font-weight:800;
  margin-top:6px;
}
.sum-box .s-change{font-size:12px;margin-top:6px;opacity:0.9;font-weight:600;}

/* CARDS (GLASS EFFECT) */
.card{
  background:rgba(255,255,255,0.85);
  backdrop-filter:blur(10px);
  border-radius:12px;
  padding:22px;
  border:1px solid var(--border);
  margin-bottom:20px;
}
.card h3{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px;}

.two-col{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:22px;
}

/* CHART */
.chart-wrap{
  max-width:600px;
  margin:auto;
}

/* TABLE */
table.report-table{width:100%;border-collapse:collapse;font-size:13px;}
table.report-table th{text-align:left;padding:10px 8px;color:var(--muted);font-size:11px;text-transform:uppercase;letter-spacing:0.5px;border-bottom:2px solid var(--border);}
table.report-table td{padding:10px 8px;border-bottom:1px solid var(--border);}
table.report-table tr:last-child td{border-bottom:none;}
.empty{text-align:center;padding:30px 20px;color:var(--muted);font-size:14px;}

/* BUTTON */
.btn{
  padding:10px 18px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-weight:600;
  font-size:13px;
}

.btn-primary{
  background:var(--navy);
  color:#fff;
}
.btn-outline{background:#fff;color:var(--navy);border:1.5px solid var(--border);}
.btn-row{display:flex;gap:10px;flex-wrap:wrap;}

@media print{.sidebar,.topbar-right,.btn-row{display:none!important;}.main{margin-left:0;}}
@media(max-width:900px){.two-col{grid-template-columns:1fr;}}
</style>
</head>

<body>

<!-- SIDEBAR -->
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
    <a class="active" href="reports.php"><span class="icon">📈</span> Reports</a>
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

<!-- MAIN -->
<div class="main">

  <!-- TOPBAR -->
  <div class="topbar">
    <h1>📈 Reports & Analytics</h1>
    <div class="topbar-right">
      <select class="date-filter" id="dateFilter">
        <option value="all">All Time</option>
        <option value="month" selected>This Month</option>
        <option value="lastmonth">Last Month</option>
        <option value="year">This Year</option>
      </select>
      <div class="user-chip">
        <div class="avatar" id="av">U</div>
        <span id="uname">User</span>
      </div>
    </div>
  </div>

  <div class="content">

   <!-- IMAGE BANNER -->
<div class="card banner-card">
  <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1200&q=80">

  <div class="banner-text">
    <h2>📊 Smart Trucking Analytics</h2>
    <p>Track income, expenses & performance in real time</p>
  </div>
</div>

<!-- DESCRIPTION UNDER IMAGE -->
<div class="card image-description">
  <h3>📌 System Overview</h3>
  <p>
    Budget Trucker is a smart financial tracking system designed for transport and logistics management.
    It helps drivers and managers monitor income, expenses, fuel usage, and profit/loss in real time.
    The system provides clear reports and visual analytics to support better financial decisions and route planning.
  </p>
</div>

    <!-- SUMMARY -->
    <div class="summary-grid">
      <div class="sum-box green">
        <div>Total Income</div>
        <div class="s-val" id="incDisp">0</div>
        <div class="s-change" id="incChange"></div>
      </div>

      <div class="sum-box red">
        <div>Total Expenses</div>
        <div class="s-val" id="expDisp">0</div>
        <div class="s-change" id="expChange"></div>
      </div>

      <div class="sum-box">
        <div>Profit / Loss</div>
        <div class="s-val" id="profDisp">0</div>
        <div class="s-change" id="profChange"></div>
      </div>

      <div class="sum-box orange">
        <div>Profit Margin</div>
        <div class="s-val" id="marginDisp">0%</div>
      </div>
    </div>

    <!-- CHARTS -->
    <div class="two-col">

      <div class="card">
        <h3>📊 Income vs Expenses</h3>
        <canvas id="barChart"></canvas>
      </div>

      <div class="card">
        <h3>🥧 Expense Breakdown</h3>
        <canvas id="pieChart"></canvas>
      </div>

    </div>

    <div class="card">
      <h3>📈 6-Month Trend</h3>
      <canvas id="trendChart" height="100"></canvas>
    </div>

    <div class="card">
      <h3>🏷️ Category Breakdown</h3>
      <table class="report-table" id="catTable">
        <thead><tr><th>Category</th><th>Amount</th><th>% of Expenses</th></tr></thead>
        <tbody id="catTableBody"><tr><td colspan="3" class="empty">No expense data yet.</td></tr></tbody>
      </table>
    </div>

    <!-- EXPORT -->
    <div class="card">
      <h3>📤 Export</h3>
      <div class="btn-row">
        <button class="btn btn-primary" onclick="window.print()">🖨️ Print / PDF</button>
        <button class="btn btn-outline" onclick="exportCSV()">⬇️ Export CSV</button>
      </div>
    </div>

  </div>
</div>

<script>
let u = '<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent = u;
document.getElementById('av').textContent = u.charAt(0);

let currency = 'KSh';
let incomes = [];
let expenses = [];
let barChartInst=null, pieChartInst=null, trendChartInst=null;

function fetchAll() {
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;}});
  Promise.all([
    fetch('api/incomes.php',{credentials:'same-origin'}),
    fetch('api/expenses.php',{credentials:'same-origin'})
  ]).then(responses=>Promise.all(responses.map(r=>r.json()))).then(results=>{
    incomes = results[0].data || [];
    expenses = results[1].data || [];
    render();
  });
}

function getPeriodBounds(range){
  let now=new Date();
  if(range==='month'){
    return {start:new Date(now.getFullYear(),now.getMonth(),1),end:new Date(now.getFullYear(),now.getMonth()+1,1),
            prevStart:new Date(now.getFullYear(),now.getMonth()-1,1),prevEnd:new Date(now.getFullYear(),now.getMonth(),1)};
  }
  if(range==='lastmonth'){
    return {start:new Date(now.getFullYear(),now.getMonth()-1,1),end:new Date(now.getFullYear(),now.getMonth(),1),
            prevStart:new Date(now.getFullYear(),now.getMonth()-2,1),prevEnd:new Date(now.getFullYear(),now.getMonth()-1,1)};
  }
  if(range==='year'){
    return {start:new Date(now.getFullYear(),0,1),end:new Date(now.getFullYear()+1,0,1),
            prevStart:new Date(now.getFullYear()-1,0,1),prevEnd:new Date(now.getFullYear(),0,1)};
  }
  return {start:new Date(0),end:new Date(8640000000000000),prevStart:null,prevEnd:null};
}

function sumInRange(arr,start,end){
  return arr.filter(x=>{let d=new Date(x.date);return d>=start&&d<end;}).reduce((s,x)=>s+Number(x.amount),0);
}
function filterInRange(arr,start,end){
  return arr.filter(x=>{let d=new Date(x.date);return d>=start&&d<end;});
}

function pctChange(curr,prev){
  if(prev===0) return curr===0?0:100;
  return ((curr-prev)/Math.abs(prev))*100;
}
function changeLabel(pct){
  if(!isFinite(pct)) return '';
  let arrow=pct>=0?'▲':'▼';
  return `${arrow} ${Math.abs(Math.round(pct))}% vs previous period`;
}

function render() {
  let range=document.getElementById('dateFilter').value;
  let {start,end,prevStart,prevEnd}=getPeriodBounds(range);

  let periodIncomes=filterInRange(incomes,start,end);
  let periodExpenses=filterInRange(expenses,start,end);

  let totalIncome = periodIncomes.reduce((s,i)=>s+Number(i.amount),0);
  let totalExpense = periodExpenses.reduce((s,i)=>s+Number(i.amount),0);
  let profit = totalIncome - totalExpense;
  let margin = totalIncome>0?Math.round((profit/totalIncome)*100):0;

  document.getElementById('incDisp').textContent = currency+" "+totalIncome.toLocaleString();
  document.getElementById('expDisp').textContent = currency+" "+totalExpense.toLocaleString();
  document.getElementById('profDisp').textContent = currency+" "+profit.toLocaleString();
  document.getElementById('marginDisp').textContent = margin+"%";

  if(prevStart){
    let prevIncome=sumInRange(incomes,prevStart,prevEnd);
    let prevExpense=sumInRange(expenses,prevStart,prevEnd);
    let prevProfit=prevIncome-prevExpense;
    document.getElementById('incChange').textContent=changeLabel(pctChange(totalIncome,prevIncome));
    document.getElementById('expChange').textContent=changeLabel(pctChange(totalExpense,prevExpense));
    document.getElementById('profChange').textContent=changeLabel(pctChange(profit,prevProfit));
  } else {
    document.getElementById('incChange').textContent='';
    document.getElementById('expChange').textContent='';
    document.getElementById('profChange').textContent='';
  }

  if(barChartInst)barChartInst.destroy();
  barChartInst=new Chart(document.getElementById('barChart'),{
    type:'bar',
    data:{
      labels:['Income','Expenses'],
      datasets:[{
        data:[totalIncome,totalExpense],
        backgroundColor:['#27ae60','#e74c3c']
      }]
    },
    options:{plugins:{legend:{display:false}}}
  });

  let cats = {};
  periodExpenses.forEach(e=>{cats[e.category]=(cats[e.category]||0)+Number(e.amount);});
  let catLabels=Object.keys(cats);
  let catValues=Object.values(cats);
  let palette=['#1a2e4a','#f5a623','#27ae60','#e74c3c','#f39c12','#9b59b6','#3498db'];

  if(pieChartInst)pieChartInst.destroy();
  if(catLabels.length){
    pieChartInst=new Chart(document.getElementById('pieChart'),{
      type:'pie',
      data:{
        labels:catLabels,
        datasets:[{
          data:catValues,
          backgroundColor:palette.slice(0,catLabels.length)
        }]
      }
    });
  }

  let tbody=document.getElementById('catTableBody');
  if(!catLabels.length){
    tbody.innerHTML='<tr><td colspan="3" class="empty">No expense data yet.</td></tr>';
  } else {
    let sorted=catLabels.map((c,i)=>({c,v:catValues[i]})).sort((a,b)=>b.v-a.v);
    tbody.innerHTML=sorted.map(row=>{
      let pct=totalExpense>0?Math.round((row.v/totalExpense)*100):0;
      return `<tr><td>${row.c}</td><td>${currency} ${row.v.toLocaleString()}</td><td>${pct}%</td></tr>`;
    }).join('');
  }

  renderTrend();
}

function renderTrend(){
  let months=[];
  let now=new Date();
  for(let i=5;i>=0;i--){
    let d=new Date(now.getFullYear(),now.getMonth()-i,1);
    months.push({label:d.toLocaleString('default',{month:'short',year:'2-digit'}),y:d.getFullYear(),m:d.getMonth()});
  }
  let incData=months.map(mo=>incomes.filter(i=>{let d=new Date(i.date);return d.getFullYear()===mo.y&&d.getMonth()===mo.m;}).reduce((s,i)=>s+Number(i.amount),0));
  let expData=months.map(mo=>expenses.filter(e=>{let d=new Date(e.date);return d.getFullYear()===mo.y&&d.getMonth()===mo.m;}).reduce((s,e)=>s+Number(e.amount),0));
  if(trendChartInst)trendChartInst.destroy();
  trendChartInst=new Chart(document.getElementById('trendChart'),{
    type:'line',
    data:{
      labels:months.map(m=>m.label),
      datasets:[
        {label:'Income',data:incData,borderColor:'#27ae60',backgroundColor:'rgba(39,174,96,0.1)',fill:true,tension:0.3},
        {label:'Expenses',data:expData,borderColor:'#e74c3c',backgroundColor:'rgba(231,76,60,0.1)',fill:true,tension:0.3}
      ]
    },
    options:{scales:{y:{beginAtZero:true}}}
  });
}

function exportCSV(){
  let rows=[['Type','Date','Category','Amount','Description']];
  incomes.forEach(i=>rows.push(['Income',i.date,i.category,i.amount,(i.description||'').replace(/,/g,';')]));
  expenses.forEach(e=>rows.push(['Expense',e.date,e.category,e.amount,(e.description||'').replace(/,/g,';')]));
  let csv=rows.map(r=>r.join(',')).join('\n');
  let blob=new Blob([csv],{type:'text/csv'});
  let a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='budget_trucker_report.csv';
  a.click();
}

document.getElementById('dateFilter').addEventListener('change',render);

fetchAll();
</script>

</body>
</html>