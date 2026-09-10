<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Expenses - Budget Trucker</title>
<style>:root{--navy:#1a2e4a;--navy-dark:#111e30;--navy-mid:#243c5e;--accent:#f5a623;--accent-dark:#d4891a;--success:#27ae60;--danger:#e74c3c;--warning-color:#f39c12;--bg:#eef1f6;--card:#ffffff;--text:#1a2e4a;--muted:#6b7a8d;--border:#dce3ef;--sidebar-w:260px;}
*{margin:0;padding:0;box-sizing:border-box;}
body{
  font-family:'Segoe UI',Arial,sans-serif;
  background:linear-gradient(135deg,#0f0f0f 0%, #1c1c1c 60%, #d4a017 100%);
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:20px;
}
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
.empty .empty-icon{font-size:36px;margin-bottom:8px;}
/* HERO SECTION */
.hero-section{
    height:250px;
    background:url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1400&q=80') center center/cover no-repeat;
    border-radius:15px;
    overflow:hidden;
    margin-bottom:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.12);
}

.hero-overlay{
    width:100%;
    height:100%;
    background:rgba(192,57,43,.75);
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:35px;
}

.hero-overlay h2{
    color:#fff;
    font-size:34px;
    margin-bottom:10px;
}

.hero-overlay p{
    color:#fff;
    max-width:700px;
    line-height:1.7;
}

/* IMAGE INFO SECTION */
.info-section{
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

.info-section img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.info-content{
    padding:25px;
}

.info-content h3{
    color:var(--danger);
    margin-bottom:10px;
}

.info-content p{
    color:var(--muted);
    line-height:1.8;
}

@media(max-width:768px){
    .info-section{
        grid-template-columns:1fr;
    }

    .hero-section{
        height:200px;
    }

    .hero-overlay h2{
        font-size:28px;
    }
}
</style>
</head>
<body>
<div class="sidebar">
  <div class="sidebar-logo"><h2>🚛 Budget<span style="color:#f5a623">Trucker</span></h2></div>
  <nav>
    <a href="dashboard.php"><span class="icon">📊</span> Dashboard</a>
    <a href="income.php"><span class="icon">💰</span> Income</a>
    <a href="expense.php" class="active"><span class="icon">📤</span> Expenses</a>
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
    <h1>📤 Expense Tracking</h1>
    <div class="user-chip"><div class="avatar" id="av">U</div><span id="uname">User</span></div>
  </div>
  <div class="content">
<!-- HERO SECTION -->
<div class="hero-section">
    <div class="hero-overlay">
        <h2>📤 Expense Management</h2>
        <p>
            Track every business expense, monitor spending habits,
            and maintain better financial control for your trucking operations.
        </p>
    </div>
</div>

<!-- INFORMATION SECTION -->
<div class="info-section">

    <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=600&q=80" alt="Expense Tracking">

    <div class="info-content">
        <h3>💡 Why Track Expenses?</h3>

        <p>
            Recording expenses helps you understand where your money goes.
            Whether it is fuel, maintenance, driver allowances, or other costs,
            keeping accurate records improves budgeting, reduces wasteful spending,
            and increases profitability.
        </p>

        <p>
            Budget Trucker automatically stores your expense records and makes
            it easier to generate reports and monitor financial performance.
        </p>
    </div>

</div>
    <div class="two-col" style="margin-bottom:20px;">
      <div class="card">
        <h3>➕ Add Expense</h3>
        <div class="form-group"><label>Amount</label><input type="number" id="amount" placeholder="e.g. 2000"></div>
        <div class="form-group"><label>Category</label>
          <select id="category">
            <option value="Fuel">Fuel</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Driver Allowance">Driver Allowance</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group"><label>Description</label><input type="text" id="description" placeholder="Optional notes"></div>
        <button class="btn btn-primary" onclick="addExpense()">📤 Save Expense</button>
      </div>
      <div>
        <div class="total-box" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
          <div><div class="total-label">Total Expenses</div><div class="total-value" id="totalDisp">KSh 0</div></div>
          <span style="font-size:40px;opacity:0.3;">📤</span>
        </div>
        <div class="card" style="margin-bottom:0;">
          <h3>📋 Expense History</h3>
          <div id="expenseList"><div class="empty"><div class="empty-icon">📤</div>No expense records yet.</div></div>
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
let expenses=[];
let editingId=null;
function fetchSettings(){
  fetch('api/settings.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){currency=d.currency;render();}});
}
function fetchExpenses(){
  fetch('api/expenses.php',{credentials:'same-origin'}).then(r=>r.json()).then(d=>{if(d.success){expenses=d.data;render();}});
}
function addExpense(){
  let amount=document.getElementById('amount').value;
  let category=document.getElementById('category').value;
  let description=document.getElementById('description').value;
  if(!amount||Number(amount)<=0){alert('Enter a valid amount');return;}
  fetch('api/expenses.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({amount:Number(amount),category,description})}).then(r=>r.json()).then(d=>{
    if(d.success){
      if(editingId){
        fetch('api/expenses.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id:editingId})});
        editingId=null;
      }
      document.getElementById('amount').value='';
      document.getElementById('description').value='';
      fetchExpenses();
    }
  });
}
function editExpense(id){
  let exp=expenses.find(e=>e.id===id);
  if(!exp)return;
  editingId=id;
  document.getElementById('amount').value=exp.amount;
  document.getElementById('category').value=exp.category;
  document.getElementById('description').value=exp.description;
}
function deleteExpense(id){
  if(!confirm('Delete this expense?'))return;
  fetch('api/expenses.php',{method:'DELETE',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify({id})}).then(()=>fetchExpenses());
}
function render(){
  let total=expenses.reduce((s,i)=>s+i.amount,0);
  document.getElementById('totalDisp').textContent=currency+' '+total.toLocaleString();
  let list=document.getElementById('expenseList');
  if(!expenses.length){list.innerHTML='<div class="empty"><div class="empty-icon">📤</div>No expense records yet.</div>';return;}
  list.innerHTML=expenses.slice().reverse().map((exp,ri)=>{
    let index=expenses.length-1-ri;
    return `<div class="record-item expense-item">
      <div class="record-title">${exp.category}</div>
      <div class="record-amount expense-amt">-${currency} ${Number(exp.amount).toLocaleString()}</div>
      <div class="record-meta">${exp.description||'—'} &nbsp;·&nbsp; ${exp.date}</div>
      <div class="btn-row">
        <button class="btn btn-warning btn-sm" onclick="editExpense(${exp.id})">✏️ Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteExpense(${exp.id})">🗑️ Delete</button>
      </div>
    </div>`;
  }).join('');
}
fetchSettings();
fetchExpenses();
</script>
</body>
</html>
