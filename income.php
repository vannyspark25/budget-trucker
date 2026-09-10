<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Income - Budget Trucker</title>
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
.toolbar{display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
.toolbar input,.toolbar select{width:auto;flex:1;min-width:110px;padding:9px 12px;font-size:13px;}
.cat-bar-wrap{margin-bottom:10px;}
.cat-bar-label{display:flex;justify-content:space-between;font-size:12px;color:var(--navy);font-weight:600;margin-bottom:4px;}
.cat-bar-track{background:#eef1f6;border-radius:6px;height:9px;overflow:hidden;}
.cat-bar-fill{height:100%;background:var(--success);border-radius:6px;}
/* Income Image Section */
.income-image-section{
    display:grid;
    grid-template-columns:350px 1fr;
    gap:20px;
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    border:1px solid var(--border);
    margin-bottom:25px;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
}

.income-image-section img.banner{
    width:100%;
    height:250px;
    object-fit:cover;
}

.income-info{
    padding:25px;
}

.income-info h3{
    color:var(--success);
    margin-bottom:12px;
    font-size:22px;
}

.income-info p{
    color:var(--muted);
    line-height:1.8;
    margin-bottom:10px;
}

@media(max-width:768px){
    .income-image-section{
        grid-template-columns:1fr;
    }

    .income-image-section img.banner{
        height:200px;
    }
}
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
    <a href="income.php" class="active"><span class="icon">💰</span> Income</a>
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
    <h1>💰 Income Management</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
<!-- Income Image Section -->
<div class="income-image-section">

    <img class="banner" src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80" alt="Income Management">

    <div class="income-info">
        <h3>💰 Income Tracking</h3>

        <p>
            Manage and monitor all trucking income in one place.
            Record trip payments, salaries, bonuses, and other earnings
            to keep your finances organized.
        </p>

        <p>
            Accurate income tracking helps you measure profitability,
            prepare reports, and make informed business decisions.
        </p>

        <p>
            Every income record is securely stored and can be reviewed
            at any time through your Budget Trucker dashboard.
        </p>
    </div>

</div>

    <div class="two-col" style="margin-bottom:20px;align-items:start;">
      <div>
        <div class="card">
          <h3 id="formTitle">➕ Add Income</h3>
          <div class="form-group"><label>Amount</label><input type="number" id="amount" placeholder="e.g. 5000"></div>
          <div class="form-group"><label>Category</label>
            <select id="category">
              <option value="Trip Payment">Trip Payment</option>
              <option value="Salary">Salary</option>
              <option value="Bonus">Bonus</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="form-group"><label>Description</label><input type="text" id="description" placeholder="Optional notes"></div>
          <div class="btn-row">
            <button class="btn btn-primary" id="saveBtn" onclick="addIncome()">💰 Save Income</button>
            <button class="btn btn-outline" id="cancelBtn" onclick="cancelEdit()" style="display:none;">✖ Cancel</button>
          </div>
        </div>

        <div class="card">
          <h3>🏷️ Income by Category</h3>
          <div id="catBreakdown"><div class="empty">No data yet.</div></div>
        </div>

        <div class="card" style="margin-bottom:0;">
          <h3>📈 Monthly Trend</h3>
          <canvas id="trendChart" height="160"></canvas>
        </div>
      </div>

      <div>
        <div class="total-box">
          <div><div class="total-label">Total Income</div><div class="total-value" id="totalDisp">KSh 0</div></div>
          <span style="font-size:40px;opacity:0.3;">💰</span>
        </div>
        <div class="card" style="margin-bottom:0;">
          <h3>📋 Income History
            <button class="btn btn-outline btn-sm" style="width:auto;margin-top:0;" onclick="exportCSV()">⬇️ Export CSV</button>
          </h3>
          <div class="toolbar">
            <input type="text" id="searchBox" placeholder="🔍 Search description...">
            <select id="catFilter"><option value="">All Categories</option></select>
            <select id="sortBy">
              <option value="newest">Newest First</option>
              <option value="oldest">Oldest First</option>
              <option value="highest">Highest Amount</option>
              <option value="lowest">Lowest Amount</option>
            </select>
          </div>
          <div id="incomeList"><div class="empty"><div class="empty-icon">💰</div>No income records yet.</div></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
let u='<?php echo htmlspecialchars($_SESSION['loggedInUser'] ?? 'User'); ?>';
document.getElementById('uname').textContent=u;
document.getElementById('av').textContent=u.charAt(0).toUpperCase();
let currency='KSh';
let incomes=[];
let editingId=null;
let trendChartInst=null;

function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;render();}});
}
function fetchIncomes(){
  fetch('api/incomes.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){incomes=d.data;render();}});
}
function addIncome(){
  let amount=document.getElementById('amount').value;
  let category=document.getElementById('category').value;
  let description=document.getElementById('description').value;
  if(!amount||Number(amount)<=0){alert('Enter a valid amount');return;}
  fetch('api/incomes.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({amount:Number(amount),category,description})}).then(r=>r.json()).then(d=>{
    if(d.success){
      if(editingId){
        fetch('api/incomes.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id:editingId})}).then(()=>{
          editingId=null;
          resetForm();
          fetchIncomes();
        });
      } else {
        resetForm();
        fetchIncomes();
      }
    }
  });
}
function resetForm(){
  document.getElementById('amount').value='';
  document.getElementById('description').value='';
  document.getElementById('category').value='Trip Payment';
  document.getElementById('formTitle').textContent='➕ Add Income';
  document.getElementById('saveBtn').textContent='💰 Save Income';
  document.getElementById('cancelBtn').style.display='none';
}
function editIncome(id){
  let inc=incomes.find(i=>i.id===id);
  if(!inc)return;
  editingId=id;
  document.getElementById('amount').value=inc.amount;
  document.getElementById('category').value=inc.category;
  document.getElementById('description').value=inc.description;
  document.getElementById('formTitle').textContent='✏️ Edit Income';
  document.getElementById('saveBtn').textContent='💾 Update Income';
  document.getElementById('cancelBtn').style.display='block';
  window.scrollTo({top:0,behavior:'smooth'});
}
function cancelEdit(){
  editingId=null;
  resetForm();
}
function deleteIncome(id){
  if(!confirm('Delete this income record?'))return;
  fetch('api/incomes.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchIncomes());
}

function exportCSV(){
  if(!incomes.length){alert('No income records to export.');return;}
  let rows=[['Date','Category','Amount','Description']];
  incomes.forEach(i=>rows.push([i.date,i.category,i.amount,(i.description||'').replace(/,/g,';')]));
  let csv=rows.map(r=>r.join(',')).join('\n');
  let blob=new Blob([csv],{type:'text/csv'});
  let a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='income_records.csv';
  a.click();
}

function populateCategoryFilter(){
  let sel=document.getElementById('catFilter');
  let current=sel.value;
  let cats=[...new Set(incomes.map(i=>i.category))];
  sel.innerHTML='<option value="">All Categories</option>'+cats.map(c=>`<option value="${c}">${c}</option>`).join('');
  sel.value=current;
}

function getFiltered(){
  let search=document.getElementById('searchBox').value.toLowerCase();
  let cat=document.getElementById('catFilter').value;
  let sort=document.getElementById('sortBy').value;
  let list=incomes.filter(i=>{
    let matchesSearch=!search||(i.description||'').toLowerCase().includes(search)||i.category.toLowerCase().includes(search);
    let matchesCat=!cat||i.category===cat;
    return matchesSearch&&matchesCat;
  });
  if(sort==='newest')list.sort((a,b)=>new Date(b.date)-new Date(a.date));
  else if(sort==='oldest')list.sort((a,b)=>new Date(a.date)-new Date(b.date));
  else if(sort==='highest')list.sort((a,b)=>b.amount-a.amount);
  else if(sort==='lowest')list.sort((a,b)=>a.amount-b.amount);
  return list;
}

function renderCategoryBreakdown(){
  let cats={};
  incomes.forEach(i=>{cats[i.category]=(cats[i.category]||0)+Number(i.amount);});
  let total=Object.values(cats).reduce((s,v)=>s+v,0);
  let wrap=document.getElementById('catBreakdown');
  let entries=Object.entries(cats).sort((a,b)=>b[1]-a[1]);
  if(!entries.length){wrap.innerHTML='<div class="empty">No data yet.</div>';return;}
  wrap.innerHTML=entries.map(([cat,amt])=>{
    let pct=total>0?Math.round((amt/total)*100):0;
    return `<div class="cat-bar-wrap">
      <div class="cat-bar-label"><span>${cat}</span><span>${currency} ${amt.toLocaleString()} (${pct}%)</span></div>
      <div class="cat-bar-track"><div class="cat-bar-fill" style="width:${pct}%"></div></div>
    </div>`;
  }).join('');
}

function renderTrendChart(){
  let months=[];
  let now=new Date();
  for(let i=5;i>=0;i--){
    let d=new Date(now.getFullYear(),now.getMonth()-i,1);
    months.push({label:d.toLocaleString('default',{month:'short',year:'2-digit'}),y:d.getFullYear(),m:d.getMonth()});
  }
  let totals=months.map(mo=>incomes.filter(i=>{let d=new Date(i.date);return d.getFullYear()===mo.y&&d.getMonth()===mo.m;}).reduce((s,i)=>s+Number(i.amount),0));
  if(trendChartInst)trendChartInst.destroy();
  trendChartInst=new Chart(document.getElementById('trendChart'),{
    type:'line',
    data:{labels:months.map(m=>m.label),datasets:[{label:'Income',data:totals,borderColor:'#27ae60',backgroundColor:'rgba(39,174,96,0.12)',fill:true,tension:0.3}]},
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
  });
}

function render(){
  let total=incomes.reduce((s,i)=>s+Number(i.amount),0);
  document.getElementById('totalDisp').textContent=currency+' '+total.toLocaleString();
  populateCategoryFilter();
  renderCategoryBreakdown();
  renderTrendChart();

  let filtered=getFiltered();
  let list=document.getElementById('incomeList');
  if(!incomes.length){list.innerHTML='<div class="empty"><div class="empty-icon">💰</div>No income records yet.</div>';return;}
  if(!filtered.length){list.innerHTML='<div class="empty"><div class="empty-icon">🔍</div>No records match your filters.</div>';return;}
  list.innerHTML=filtered.map(inc=>{
    return `<div class="record-item income-item">
      <div class="record-title">${inc.category}</div>
      <div class="record-amount income-amt">+${currency} ${Number(inc.amount).toLocaleString()}</div>
      <div class="record-meta">${inc.description||'—'} &nbsp;·&nbsp; ${inc.date}</div>
      <div class="btn-row">
        <button class="btn btn-warning btn-sm" onclick="editIncome(${inc.id})">✏️ Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteIncome(${inc.id})">🗑️ Delete</button>
      </div>
    </div>`;
  }).join('');
}

document.getElementById('searchBox').addEventListener('input',render);
document.getElementById('catFilter').addEventListener('change',render);
document.getElementById('sortBy').addEventListener('change',render);

fetchSettings();
fetchIncomes();
</script>
</body>
</html>