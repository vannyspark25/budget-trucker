<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Budget Trucker - Login</title>
<link rel="stylesheet" href="css/shared.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="panel-left">

    <div class="logo-box">
        <img src="logo.png" alt="Budget Trucker Logo">
    </div>

    <h1>Budget<span>Trucker</span> System</h1>
    <p>Complete financial management for trucking businesses.</p>
    <div class="features">
      <div class="feat"><div class="feat-icon">💰</div>Income & Expense Tracking</div>
      <div class="feat"><div class="feat-icon">⛽</div>Fuel Monitoring</div>
      <div class="feat"><div class="feat-icon">🚛</div>Route Management</div>
      <div class="feat"><div class="feat-icon">📊</div>Reports & Analytics</div>
    </div>
  </div>
  <div class="panel-right">
    <h2>Welcome Back</h2>
    <p class="sub">Sign in to manage your trucking finances</p>
    <div class="tabs">
      <div class="tab active" onclick="switchTab('login')">Login</div>
      <div class="tab" onclick="switchTab('register')">Create Account</div>
    </div>

    <div class="form-section active" id="loginForm">
      <div class="form-group">
        <label>Username</label>
        <input id="loginUser" placeholder="Enter your username">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input id="loginPass" type="password" placeholder="Enter your password">
      </div>
      <button class="btn btn-primary" onclick="login()">Sign In →</button>
      <div class="msg" id="loginMsg"></div>
    </div>

    <div class="form-section" id="registerForm">
      <div class="form-group">
        <label>Username</label>
        <input id="regUser" placeholder="Choose a username">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input id="regPass" type="password" placeholder="Choose a password">
      </div>
      <button class="btn btn-primary" onclick="register()">Create Account →</button>
      <div class="msg" id="regMsg"></div>
    </div>
  </div>
</div>

<script>
function switchTab(tab){
  document.querySelectorAll('.tab').forEach((t,i)=>{t.classList.toggle('active',i===(tab==='login'?0:1));});
  document.getElementById('loginForm').classList.toggle('active',tab==='login');
  document.getElementById('registerForm').classList.toggle('active',tab==='register');
}
function showMsg(id,text,type){
  let el=document.getElementById(id);
  el.textContent=text;el.className='msg '+type;el.style.display='block';
}
async function register(){
  let user=document.getElementById('regUser').value.trim();
  let pass=document.getElementById('regPass').value.trim();
  if(!user||!pass){showMsg('regMsg','Please fill in all fields.','error');return;}
  let response=await fetch('auth.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'register',username:user,password:pass})});
  let data=await response.json();
  showMsg('regMsg',data.message,data.success?'success':'error');
  if(data.success){setTimeout(()=>switchTab('login'),1500);}
}
async function login(){
  let user=document.getElementById('loginUser').value.trim();
  let pass=document.getElementById('loginPass').value.trim();
  if(!user||!pass){showMsg('loginMsg','Please enter your credentials.','error');return;}
  let response=await fetch('auth.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'login',username:user,password:pass})});
  let data=await response.json();
  showMsg('loginMsg',data.message,data.success?'success':'error');
  if(data.success){setTimeout(()=>{window.location.href='dashboard.php';},900);}
}
</script>
</body>
</html>
