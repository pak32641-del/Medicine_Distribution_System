<?php
include("connection.php");

$statusFilter = "";
$statusTitle = "Order Management";

// ===== DASHBOARD FILTER =====
if(isset($_GET['status'])){

    if($_GET['status'] == "Pending"){
        $statusFilter = "WHERE o.status='Pending'";
        $statusTitle = "Pending Orders";
    }

    if($_GET['status'] == "Completed"){
        $statusFilter = "WHERE o.status='Completed'";
        $statusTitle = "Completed Orders";
    }
}

// ===== FETCH ORDERS =====
$orders = mysqli_query($conn,"
SELECT o.*,
       (SELECT SUM(price * quantity) 
        FROM order_items 
        WHERE order_id = o.order_id) AS real_total
FROM orders o
$statusFilter
ORDER BY o.order_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Management</title>
<link rel="stylesheet" href="orders.css">
</head>

<body>

<?php include("admin_menu.php"); ?>

<main class="main-content">

<div class="topbar">
<h2><?= $statusTitle ?></h2>
</div>

<table class="data-table">
<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Status</th>
<th>Date</th>
<th>Address</th>
<th>ZIP</th>
<th>Payment</th>
<th>Action</th>
<th>Print</th>
</tr>
</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($orders)) { ?>
<tr>

<td>#<?= $row['order_id'] ?></td>
<td><?= $row['customer_name'] ?></td>

<td>
<form action="update_order_status.php" method="POST">
<input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">

<select name="status" onchange="this.form.submit()">
<option value="Pending" <?= $row['status']=="Pending"?"selected":"" ?>>Pending</option>
<option value="Completed" <?= $row['status']=="Completed"?"selected":"" ?>>Completed</option>
<option value="Cancelled" <?= $row['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
</select>

</form>
</td>

<td><?= $row['order_date'] ?></td>
<td><?= $row['address'] ?? 'N/A' ?></td>
<td><?= $row['zip'] ?? 'N/A' ?></td>
<td><?= $row['payment_type'] ?></td>

<td>
<a class="view-btn" href="view_order.php?id=<?= $row['order_id'] ?>">View</a>
<a class="delete-btn" onclick="return confirm('Delete order?')" href="delete_order.php?id=<?= $row['order_id'] ?>">Delete</a>
</td>

<td>
<a class="print-btn" target="_blank" href="invoice_print.php?order_id=<?= $row['order_id'] ?>">🖨 Print</a>
</td>

</tr>
<?php } ?>

</tbody>
</table>

</main>

</body>
</html>