<?php
session_start();
include("connection.php");

if(!isset($_GET['id'])){
  header("Location: dashboard.php");
  exit();
}

$id = $_GET['id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM orders WHERE order_id = $id"));

$items = mysqli_query($conn,
"SELECT * FROM order_items WHERE order_id = $id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Details</title>
<link rel="stylesheet" href="dashboard.css">
</head>

<body>

<?php include("menu.php"); ?>

<section class="order-details">

<h2>Order #<?= $order['order_id'] ?></h2>

<p><b>Customer:</b> <?= $order['customer_name'] ?></p>
<p><b>Date:</b> <?= $order['order_date'] ?></p>
<p><b>Status:</b> <?= $order['status'] ?></p>
<p><b>Payment:</b> <?= $order['payment_type'] ?></p>
<p><b>Address:</b> <?= $order['address'] ?></p>
<p><b>ZIP:</b> <?= $order['zip'] ?></p>

<table class="order-table">
<tr>
  <th>Product</th>
  <th>Price</th>
  <th>Qty</th>
  <th>Total</th>
</tr>

<?php
$grandTotal = 0;
while($r = mysqli_fetch_assoc($items)){
$t = $r['price'] * $r['quantity'];
$grandTotal += $t;
?>
<tr>
<td><?= $r['product_name'] ?></td>
<td><?= $r['price'] ?></td>
<td><?= $r['quantity'] ?></td>
<td><?= $t ?></td>
</tr>
<?php } ?>
</table>

<h3>Total Bill: PKR <?= $grandTotal ?></h3>

</section>

<footer>
<p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

</body>
</html>