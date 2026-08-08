<?php
include("connection.php");

$month = date("m");
$year = date("Y");

// ===== FETCH ORDERS =====
$result = mysqli_query($conn,"
SELECT * FROM orders 
WHERE status='Completed'
AND MONTH(order_date)='$month' 
AND YEAR(order_date)='$year'
");

// ===== TOTAL SALES & ORDERS =====
$totalQuery = mysqli_query($conn,"
SELECT COUNT(order_id) as total_orders,
SUM(total_amount) as total_sales
FROM orders
WHERE status='Completed'
AND MONTH(order_date)='$month'
AND YEAR(order_date)='$year'
");

$summary = mysqli_fetch_assoc($totalQuery);

// ===== TOTAL PROFIT (FINAL FIXED) =====
$profitQuery = mysqli_query($conn,"
SELECT 
SUM(
    (oi.price - IFNULL(pu.purchase_price,0)) * oi.quantity
) AS total_profit

FROM order_items oi

JOIN orders o 
    ON o.order_id = oi.order_id

LEFT JOIN purchases pu 
    ON pu.purchase_id = (
        SELECT MAX(purchase_id)
        FROM purchases 
        WHERE product_id = oi.product_id
    )

WHERE MONTH(o.order_date) = '$month'
AND YEAR(o.order_date) = '$year'
AND o.status='Completed'
");

$profitData = mysqli_fetch_assoc($profitQuery);
$profit = $profitData['total_profit'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Monthly Report</title>
<link rel="stylesheet" href="reports.css">
</head>

<body>

<div class="main-content">

<div class="topbar">
  <h2>Monthly Sales Report (<?= date('F Y'); ?>)</h2>
  <button onclick="window.print()">Print Report</button>
</div>

<div class="report-summary">
  <p><strong>Total Completed Orders:</strong> <?= $summary['total_orders'] ?? 0 ?></p>
  <p><strong>Total Sales:</strong> PKR <?= $summary['total_sales'] ?? 0 ?></p>
  <p><strong>Total Profit:</strong> PKR <?= $profit ?></p>
</div>

<table class="data-table">
<tr>
  <th>Order ID</th>
  <th>Customer</th>
  <th>Total</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['order_id'] ?></td>
  <td><?= $row['customer_name'] ?></td>
  <td><?= $row['total_amount'] ?></td>
  <td><?= $row['status'] ?></td>
  <td>
    <a href="report_view.php?id=<?= $row['order_id'] ?>" class="view-btn">
      View Details
    </a>
  </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>