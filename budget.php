<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Budget - Budget Trucker</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
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
.btn-outline{background:#fff;color:var(--navy);border:1.5px solid var(--border);}
.btn-outline:hover{border-color:var(--navy);}
.btn-sm{padding:7px 12px;font-size:12px;width:auto;}
.btn-row{display:flex;gap:8px;margin-top:10px;}
.btn-row .btn{flex:1;margin-top:0;}
.preset-row{display:flex;gap:8px;margin-top:8px;flex-wrap:wrap;}
.preset-row button{flex:1;min-width:80px;padding:8px;border:1.5px solid var(--border);background:#f8fafc;border-radius:8px;font-size:12px;font-weight:600;color:var(--navy);cursor:pointer;}
.preset-row button:hover{background:var(--navy);color:#fff;border-color:var(--navy);}
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
.progress-wrap{background:#e8edf5;border-radius:20px;overflow:hidden;height:22px;margin-top:12px;}
.progress-bar{height:100%;background:var(--success);border-radius:20px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;transition:width 0.5s ease;min-width:30px;}
.summary-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:14px;}
.summary-row:last-child{border-bottom:none;}
.summary-row strong{color:var(--navy);}
.pace-box{margin-top:14px;padding:14px;border-radius:10px;font-size:13px;font-weight:600;}
.pace-ok{background:#eafaf1;color:var(--success);border:1px solid #c8ecd9;}
.pace-warn{background:#fef9ec;color:var(--warning-color);border:1px solid #fde8a3;}
.pace-bad{background:#fdecea;color:var(--danger);border:1px solid #f5c6c3;}
.cat-budget-row{display:grid;grid-template-columns:1fr 110px;gap:8px;align-items:center;margin-bottom:10px;}
.cat-budget-row label{font-size:13px;font-weight:600;color:var(--navy);}
.cat-progress-item{margin-bottom:12px;}
.cat-progress-label{display:flex;justify-content:space-between;font-size:12px;font-weight:600;color:var(--navy);margin-bottom:4px;}
.cat-progress-track{background:#eef1f6;border-radius:6px;height:9px;overflow:hidden;}
.cat-progress-fill{height:100%;border-radius:6px;}
.history-row{display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid var(--border);}
.history-row:last-child{border-bottom:none;}
/* Budget Image Section */
.budget-image-section{
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

.budget-image-section img{
    width:100%;
    height:250px;
    object-fit:cover;
}

.budget-info{
    padding:25px;
}

.budget-info h3{
    color:var(--navy);
    margin-bottom:12px;
    font-size:22px;
}

.budget-info p{
    color:var(--muted);
    line-height:1.8;
    margin-bottom:10px;
}

@media(max-width:768px){
    .budget-image-section{
        grid-template-columns:1fr;
    }

    .budget-image-section img{
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
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php"><span class="icon">📤</span> Expenses</a>
    <a href="budget.php" class="active"><span class="icon">📋</span> Budget</a>
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
    <h1>📋 Budget Management</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
<!-- Budget Image Section -->
<div class="budget-image-section">

    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80" alt="Budget Planning">

    <div class="budget-info">
        <h3>📋 Smart Budget Planning</h3>

        <p>
            Set spending limits and monitor your trucking expenses in real time.
            A well-managed budget helps control fuel costs, maintenance expenses,
            and operational spending.
        </p>

        <p>
            Budget Trucker automatically compares your expenses against your
            budget and alerts you when you are approaching your spending limit.
        </p>

        <p>
            Stay profitable, avoid overspending, and make better financial
            decisions with accurate budget tracking.
        </p>

    </div>

</div>
    <div class="two-col">
      <div>
        <div class="card">
          <h3>💼 Set Budget</h3>
          <div class="form-group"><label>Monthly / Trip Budget</label><input type="number" id="budgetInput" placeholder="Enter budget amount"></div>
          <button class="btn btn-primary" onclick="setBudget()">💾 Save Budget</button>
          <div class="preset-row">
            <button onclick="quickSet(10000)">+10,000</button>
            <button onclick="quickSet(25000)">+25,000</button>
            <button onclick="quickSet(50000)">+50,000</button>
            <button onclick="quickSet(100000)">+100,000</button>
          </div>
        </div>

        <div class="card">
          <h3>🏷️ Category Budgets</h3>
          <div id="catBudgetForm"><div class="empty">Add some expenses first to set category budgets.</div></div>
          <button class="btn btn-success" id="saveCatBtn" onclick="saveCategoryBudgets()" style="display:none;">💾 Save Category Budgets</button>
        </div>

        <div class="card" style="margin-bottom:0;">
          <h3>🕒 Budget History</h3>
          <div id="historyList"><div class="empty">No budget changes logged yet.</div></div>
        </div>
      </div>

      <div>
        <div class="card">
          <h3>📊 Budget Overview</h3>
          <div class="summary-row"><span>Budget Set</span><strong id="budgetDisp">KSh 0</strong></div>
          <div class="summary-row"><span>Total Expenses</span><strong id="expDisp" style="color:var(--danger)">KSh 0</strong></div>
          <div class="summary-row"><span>Remaining</span><strong id="remDisp" style="color:var(--success)">KSh 0</strong></div>
          <div class="progress-wrap"><div class="progress-bar" id="progBar" style="width:0%">0%</div></div>
          <div id="alertBox" style="margin-top:12px;"></div>
          <div id="paceBox" class="pace-box" style="display:none;"></div>
        </div>

        <div class="card">
          <h3>🥧 Budget vs Spent</h3>
          <canvas id="budgetChart" height="200"></canvas>
        </div>

        <div class="card" style="margin-bottom:0;">
          <h3>🏷️ Category Spend vs Targets</h3>
          <div id="catProgress"><div class="empty">No category budgets set yet.</div></div>
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
let budget=0;
let expenses=[];
let budgetChartInst=null;
const CAT_BUDGET_KEY='bt_category_budgets';
const HISTORY_KEY='bt_budget_history';

function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;}});
}
function fetchBudget(){
  fetch('api/budget.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){budget=d.budget;updateUI();}});
}
function fetchExpenses(){
  fetch('api/expenses.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){expenses=d.data;updateUI();}});
}

function logHistory(amount){
  let hist=JSON.parse(localStorage.getItem(HISTORY_KEY)||'[]');
  hist.unshift({amount,date:new Date().toISOString()});
  hist=hist.slice(0,8);
  localStorage.setItem(HISTORY_KEY,JSON.stringify(hist));
  renderHistory();
}
function renderHistory(){
  let hist=JSON.parse(localStorage.getItem(HISTORY_KEY)||'[]');
  let wrap=document.getElementById('historyList');
  if(!hist.length){wrap.innerHTML='<div class="empty">No budget changes logged yet.</div>';return;}
  wrap.innerHTML=hist.map(h=>{
    let d=new Date(h.date);
    return `<div class="history-row"><span>${d.toLocaleDateString()} ${d.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'})}</span><strong>${currency} ${Number(h.amount).toLocaleString()}</strong></div>`;
  }).join('');
}

function setBudget(){
  let val=Number(document.getElementById('budgetInput').value);
  if(val<=0){alert('Enter a valid budget amount');return;}
  budget=val;
  fetch('api/budget.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({amount:val})}).then(()=>{updateUI();logHistory(val);});
  document.getElementById('budgetInput').value='';
}
function quickSet(amount){
  document.getElementById('budgetInput').value=amount;
}

function getCategoryBudgets(){
  return JSON.parse(localStorage.getItem(CAT_BUDGET_KEY)||'{}');
}
function renderCategoryForm(){
  let cats=[...new Set(expenses.map(e=>e.category))];
  let saved=getCategoryBudgets();
  let form=document.getElementById('catBudgetForm');
  let saveBtn=document.getElementById('saveCatBtn');
  if(!cats.length){form.innerHTML='<div class="empty">Add some expenses first to set category budgets.</div>';saveBtn.style.display='none';return;}
  saveBtn.style.display='block';
  form.innerHTML=cats.map(c=>`<div class="cat-budget-row"><label>${c}</label><input type="number" data-cat="${c}" class="catBudgetInput" placeholder="0" value="${saved[c]||''}"></div>`).join('');
}
function saveCategoryBudgets(){
  let inputs=document.querySelectorAll('.catBudgetInput');
  let data={};
  inputs.forEach(i=>{if(i.value)data[i.dataset.cat]=Number(i.value);});
  localStorage.setItem(CAT_BUDGET_KEY,JSON.stringify(data));
  renderCategoryProgress();
  alert('Category budgets saved.');
}
function renderCategoryProgress(){
  let saved=getCategoryBudgets();
  let cats={};
  expenses.forEach(e=>{cats[e.category]=(cats[e.category]||0)+Number(e.amount);});
  let wrap=document.getElementById('catProgress');
  let entries=Object.keys(saved).filter(c=>saved[c]>0);
  if(!entries.length){wrap.innerHTML='<div class="empty">No category budgets set yet.</div>';return;}
  wrap.innerHTML=entries.map(c=>{
    let spent=cats[c]||0;
    let target=saved[c];
    let pct=target>0?Math.min((spent/target)*100,100):0;
    let color=spent>target?'var(--danger)':(pct>=80?'var(--warning-color)':'var(--success)');
    return `<div class="cat-progress-item">
      <div class="cat-progress-label"><span>${c}</span><span>${currency} ${spent.toLocaleString()} / ${currency} ${target.toLocaleString()}</span></div>
      <div class="cat-progress-track"><div class="cat-progress-fill" style="width:${pct}%;background:${color}"></div></div>
    </div>`;
  }).join('');
}

function renderBudgetChart(totalExp,remaining){
  if(budgetChartInst)budgetChartInst.destroy();
  let spent=Math.min(totalExp,budget>0?budget:totalExp);
  let over=Math.max(totalExp-budget,0);
  let rem=Math.max(remaining,0);
  let data=budget>0?[spent,rem,over].filter((v,i)=>i!==2||v>0):[totalExp];
  let labels=budget>0?['Spent','Remaining','Over Budget'].filter((l,i)=>i!==2||over>0):['Total Spent'];
  let colors=budget>0?['#1a2e4a','#27ae60','#e74c3c'].filter((c,i)=>i!==2||over>0):['#e74c3c'];
  budgetChartInst=new Chart(document.getElementById('budgetChart'),{
    type:'doughnut',
    data:{labels,datasets:[{data,backgroundColor:colors,borderWidth:0}]},
    options:{plugins:{legend:{position:'bottom',labels:{usePointStyle:true,pointStyle:'circle'}}}}
  });
}

function renderPace(totalExp){
  let box=document.getElementById('paceBox');
  if(budget<=0){box.style.display='none';return;}
  let now=new Date();
  let dayOfMonth=now.getDate();
  let daysInMonth=new Date(now.getFullYear(),now.getMonth()+1,0).getDate();
  let monthExp=expenses.filter(e=>{let d=new Date(e.date);return d.getMonth()===now.getMonth()&&d.getFullYear()===now.getFullYear();}).reduce((s,e)=>s+Number(e.amount),0);
  let dailyAvg=monthExp/dayOfMonth;
  let projected=dailyAvg*daysInMonth;
  box.style.display='block';
  let pctOfBudget=Math.round((projected/budget)*100);
  if(projected>budget){
    box.className='pace-box pace-bad';
    box.innerHTML=`📉 At your current pace, you're projected to spend ${currency} ${Math.round(projected).toLocaleString()} this month — ${pctOfBudget}% of budget (over by ${currency} ${Math.round(projected-budget).toLocaleString()}).`;
  } else if(pctOfBudget>=80){
    box.className='pace-box pace-warn';
    box.innerHTML=`⚠️ Projected month-end spend: ${currency} ${Math.round(projected).toLocaleString()} (${pctOfBudget}% of budget). Keep an eye on it.`;
  } else {
    box.className='pace-box pace-ok';
    box.innerHTML=`✅ On track. Projected month-end spend: ${currency} ${Math.round(projected).toLocaleString()} (${pctOfBudget}% of budget).`;
  }
}

function updateUI(){
  let totalExp=expenses.reduce((s,e)=>s+Number(e.amount),0);
  let remaining=budget-totalExp;
  let pct=budget>0?Math.min((totalExp/budget)*100,100):0;
  document.getElementById('budgetDisp').textContent=currency+' '+budget.toLocaleString();
  document.getElementById('expDisp').textContent=currency+' '+totalExp.toLocaleString();
  document.getElementById('remDisp').textContent=currency+' '+remaining.toLocaleString();
  document.getElementById('remDisp').style.color=remaining<0?'var(--danger)':'var(--success)';
  let bar=document.getElementById('progBar');
  bar.style.width=pct+'%';
  bar.textContent=Math.floor(pct)+'%';
  let box=document.getElementById('alertBox');
  if(totalExp>budget&&budget>0){
    bar.style.background='var(--danger)';
    box.innerHTML='<div style="background:#fdecea;color:var(--danger);border:1px solid #f5c6c3;padding:12px;border-radius:8px;font-weight:600;">⚠️ Budget limit exceeded!</div>';
  } else if(pct>=80&&budget>0){
    bar.style.background='var(--warning-color)';
    box.innerHTML='<div style="background:#fef9ec;color:var(--warning-color);border:1px solid #fde8a3;padding:12px;border-radius:8px;font-weight:600;">⚠️ You are close to your budget limit.</div>';
  } else {
    bar.style.background='var(--success)';
    box.innerHTML='';
  }
  renderBudgetChart(totalExp,remaining);
  renderPace(totalExp);
  renderCategoryForm();
  renderCategoryProgress();
}

renderHistory();
fetchSettings();
fetchBudget();
fetchExpenses();
</script>
</body>
</html>