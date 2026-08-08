<!DOCTYPE html>
<html>
<head>
<title>Reports Management</title>
<link rel="stylesheet" href="admin.css">
<style>/* ===== Main Content ===== */
.main-content{
  margin-left:230px;
  padding:25px;
  width:calc(100% - 230px);
}

/* ===== Top Bar ===== */
.topbar{
  background:white;
  padding:15px;
  border-radius:6px;
  box-shadow:0 2px 6px rgba(0,0,0,0.1);
  margin-bottom:25px;
}

.topbar h2{
  color:#009688;
}

/* ===== Report Cards ===== */
.report-cards{
  display:flex;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:30px;
  justify-content:center;
  
}

.card{
  background:white;
  padding:30px;
  border-radius:8px;
  text-align:left;
  box-shadow:0 2px 6px rgba(0,0,0,0.1);
  width: 220px;
  text-decoration:none;
}

.card h3{
  color:#009688;
  font-size:21px;
}

.card p{
  color:#555;
  margin-top:8px;
  font-size:15px;
}
</style>
</head>

<body>
<?php
    include("admin_menu.php");
    ?>
<!-- Main -->
<div class="main-content">

<div class="topbar">
  <h2>Reports Management</h2>
</div>

<div class="report-cards">

<a href="report_daily.php" class="card">
  <h3>Daily Report</h3>
  <p>View Today Sales</p>
</a>

<a href="report_monthly.php" class="card">
  <h3>Monthly Report</h3>
  <p>View Monthly Sales</p>
</a>

<a href="report_yearly.php" class="card">
  <h3>Yearly Report</h3>
  <p>View Yearly Sales</p>
</a>

<a href="report_range.php" class="card">
  <h3>Date Range Report</h3>
  <p>Select Custom Dates</p>
</a>

</div>

</div>
</div>
</body>
</html>