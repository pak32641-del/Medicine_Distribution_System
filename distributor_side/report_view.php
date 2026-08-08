<?php
include("connection.php");

if(!isset($_GET['id'])){
    die("Order ID Missing!");
}

$order_id = $_GET['id'];

// ===== FETCH ORDER INFO =====
$orderQuery = mysqli_query($conn,"
SELECT * FROM orders WHERE order_id = '$order_id'
");

if(mysqli_num_rows($orderQuery) == 0){
    die("Order Not Found!");
}

$order = mysqli_fetch_assoc($orderQuery);

// ===== FETCH ORDER ITEMS + PRODUCT NAME + PURCHASE PRICE =====
$itemQuery = mysqli_query($conn,"
SELECT 
    oi.*,
    p.product_name,

    (
        SELECT pu.purchase_price
        FROM purchases pu
        WHERE pu.product_id = oi.product_id
        ORDER BY pu.purchase_id DESC
        LIMIT 1
    ) AS purchase_price

FROM order_items oi

LEFT JOIN products p 
    ON oi.product_id = p.product_id

WHERE oi.order_id = '$order_id'
");

$calculatedTotal = 0;
$totalProfit = 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>Order Details Report</title>
<link rel="stylesheet" href="reports.css">
</head>

<body>

<div class="main-content">

<div class="topbar">
  <h2>Order Details - #<?= $order['order_id'] ?></h2>
  <button onclick="window.print()">Print</button>
</div>

<div class="card">
<h3>Customer & Order Information</h3>

<p><strong>Customer Name:</strong> <?= $order['customer_name'] ?></p>
<p><strong>Email:</strong> <?= $order['email'] ?></p>
<p><strong>Phone:</strong> <?= $order['phone'] ?></p>
<p><strong>Address:</strong> <?= $order['address'] ?> (<?= $order['zip'] ?>)</p>

<p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
<p><strong>Payment Type:</strong> <?= $order['payment_type'] ?></p>

<p>
<strong>Status:</strong> 
<span class="status <?= strtolower($order['status']); ?>">
<?= $order['status'] ?>
</span>
</p>

</div>

<h3>Ordered Products</h3>

<table class="data-table">
<tr>
  <th>Product</th>
  <th>Selling Price</th>
  <th>Purchase Price</th>
  <th>Qty</th>
  <th>Total</th>
  <th>Profit</th>
</tr>

<?php while($item = mysqli_fetch_assoc($itemQuery)) { 

    $purchase_price = $item['purchase_price'] ?? 0;

    $rowTotal = $item['price'] * $item['quantity'];
    $profitRow = ($item['price'] - $purchase_price) * $item['quantity'];

    $calculatedTotal += $rowTotal;
    $totalProfit += $profitRow;
?>

<tr>
  <td><?= $item['product_name'] ?></td>
  <td><?= $item['price'] ?></td>
  <td><?= $purchase_price ?></td>
  <td><?= $item['quantity'] ?></td>
  <td><?= $rowTotal ?></td>
  <td><?= $profitRow ?></td>
</tr>

<?php } ?>

</table>

<div class="card">
<h3>Summary</h3>

<p><strong>Total Sales:</strong> PKR <?= $calculatedTotal ?></p>
<p><strong>Total Profit:</strong> PKR <?= $totalProfit ?></p>
</div>

</div>
</body>
</html>