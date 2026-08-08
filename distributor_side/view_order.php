<?php

include("connection.php");

$id = $_GET['id'];

// Get order details
$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders WHERE order_id = $id
"));

// ✅ FETCH ORDER ITEMS
$items = mysqli_query($conn,"
SELECT * FROM order_items
WHERE order_id = $id
");

// Calculate total
$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(price * quantity) AS grand_total 
FROM order_items 
WHERE order_id = $id
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>View Order</title>
<link rel="stylesheet" href="view_order.css">
</head>

<body>

<div class="main-content">

<h2>Order #<?= $order['order_id'] ?></h2>

<p><b>Customer:</b> <?= $order['customer_name'] ?></p>
<p><b>Email:</b> <?= $order['email'] ?></p>
<p><b>Phone:</b> <?= $order['phone'] ?></p>
<p><b>Address:</b> <?= $order['address'] ?></p>
<p><b>Status:</b> <?= $order['status'] ?></p>
<p><b>Date:</b> <?= $order['order_date'] ?></p>

<table class="data-table">

<tr>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
</tr>

<?php while($row=mysqli_fetch_assoc($items)): ?>

<tr>

<td>
<?= $row['product_name'] ??
 'Deleted Product' ?>
</td>

<td><?= $row['price'] ?></td>

<td><?= $row['quantity'] ?></td>

<td><?= $row['price'] * $row['quantity'] ?></td>

</tr>

<?php endwhile; ?>

</table>

<h3>Total Bill: PKR <?= $total['grand_total'] ?></h3>

</div>

</body>
</html>