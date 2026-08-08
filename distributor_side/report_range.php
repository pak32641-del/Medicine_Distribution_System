<?php
include("connection.php");

$result = [];
$summary = [];
$profit = 0;

if(isset($_POST['filter'])){
  $from = $_POST['from_date'];
  $to = $_POST['to_date'];

  // ===== FETCH ORDERS =====
  $result = mysqli_query($conn,"
  SELECT * FROM orders 
  WHERE status='Completed'
  AND DATE(order_date) BETWEEN '$from' AND '$to'
  ");

  // ===== TOTAL ORDERS + SALES =====
  $totalQuery = mysqli_query($conn,"
  SELECT COUNT(order_id) as total_orders,
  SUM(total_amount) as total_sales
  FROM orders
  WHERE status='Completed'
  AND DATE(order_date) BETWEEN '$from' AND '$to'
  ");

  $summary = mysqli_fetch_assoc($totalQuery);

  // ===== TOTAL PROFIT (FINAL FIXED) =====
  $profitQuery = mysqli_query($conn,"
    SELECT SUM((oi.price - IFNULL(pu.purchase_price,0)) * oi.quantity) AS total_profit
    FROM order_items oi

    JOIN orders o 
        ON oi.order_id = o.order_id

    LEFT JOIN purchases pu 
        ON pu.purchase_id = (
            SELECT MAX(purchase_id)
            FROM purchases 
            WHERE product_id = oi.product_id
        )

    WHERE DATE(o.order_date) BETWEEN '$from' AND '$to'
    AND o.status='Completed'
  ");

  $profitData = mysqli_fetch_assoc($profitQuery);
  $profit = $profitData['total_profit'] ?? 0;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Date Range Report</title>
<link rel="stylesheet" href="reports.css">
<style>

/* ==== Labels ==== */
.card label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    color: #555;
}

/* ==== Inputs ==== */
.card input[type="date"] {
    width: 97%;
    padding: 8px 10px;
    margin-bottom: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* ==== Button ==== */
.card button {
    background: #009688;
    border: none;
    padding: 10px 18px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: #fff;
    transition: 0.3s;
}

.card button:hover {
    background: #04766aff;
}

.main-content button {
    background: #009688;
    border: none;
    padding: 10px 18px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: #fff;
    transition: 0.3s;
    margin-bottom:3px;
}

.main-content button:hover {
    background: #04766aff;
}

</style>
</head>

<body>

<div class="main-content">

<div class="topbar">
  <h2>Date Range Sales Report</h2>
</div>

<form method="POST" class="card">
  <h3>Select Date Range</h3>

  <label><strong>From:</strong></label>
  <input type="date" name="from_date" required>

  <label><strong>To:</strong></label>
  <input type="date" name="to_date" required>

  <button type="submit" name="filter">Filter</button>
</form>

<br>

<?php if($result && mysqli_num_rows($result)>0) { ?>

<div class="report-summary">
  <p><strong>Total Completed Orders:</strong> <?= $summary['total_orders'] ?? 0 ?></p>
  <p><strong>Total Sales:</strong> PKR <?= $summary['total_sales'] ?? 0 ?></p>
  <p><strong>Total Profit:</strong> PKR <?= $profit ?></p>
</div>

<button onclick="window.print()">Print Report</button>

<table class="data-table">
<tr>
  <th>Order ID</th>
  <th>Customer</th>
  <th>Total</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $r['order_id'] ?></td>
  <td><?= $r['customer_name'] ?></td>
  <td><?= $r['total_amount'] ?></td>
  <td><?= $r['status'] ?></td>
  <td>
    <a href="report_view.php?id=<?= $r['order_id'] ?>" class="view-btn">
      View Details
    </a>
  </td>
</tr>
<?php } ?>
</table>

<?php } ?>

</div>
</body>
</html>