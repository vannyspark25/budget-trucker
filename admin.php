<?php
require __DIR__.'/require-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<title>Admin Panel - Budget Trucker</title>

<link rel="stylesheet" href="css/shared.css">
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        <h2>🚛 Admin</h2>
        <p>Budget Trucker</p>
    </div>

    <div class="menu">
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="route.php">🛣 Routes</a>
        <a href="income.php">💰 Income</a>
        <a href="expense.php">💸 Expenses</a>
        <a href="reports.php">📈 Reports</a>
        <a href="galary.php">🖼 Gallery</a>
        <a href="admin.php">👥 Users</a>
        <a href="settings.php">⚙ Settings</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h1>Admin Dashboard</h1>
        <p>Manage your entire Budget Trucker system.</p>
    </div>

    <!-- STATISTICS -->
    <div class="stats">

        <div class="card">
            <h3>Total Income</h3>
            <p>$24,500</p>
        </div>

        <div class="card">
            <h3>Total Expenses</h3>
            <p>$8,200</p>
        </div>

        <div class="card">
            <h3>Routes</h3>
            <p>58</p>
        </div>

        <div class="card">
            <h3>Users</h3>
            <p>12</p>
        </div>

    </div>

    <!-- RECENT RECORDS -->
    <div class="table-box">

        <h2>Recent Activities</h2>
        <br>

        <table>

            <tr>
                <th>ID</th>
                <th>Activity</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>001</td>
                <td>Added Route</td>
                <td>2026-06-20</td>
                <td>
                    <button class="btn edit">Edit</button>
                    <button class="btn delete">Delete</button>
                </td>
            </tr>

            <tr>
                <td>002</td>
                <td>Added Expense</td>
                <td>2026-06-20</td>
                <td>
                    <button class="btn edit">Edit</button>
                    <button class="btn delete">Delete</button>
                </td>
            </tr>

            <tr>
                <td>003</td>
                <td>Uploaded Gallery Image</td>
                <td>2026-06-19</td>
                <td>
                    <button class="btn edit">Edit</button>
                    <button class="btn delete">Delete</button>
                </td>
            </tr>

        </table>

    </div>

</div>

</body>
</html>