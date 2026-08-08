<?php
include("connection.php");

if(!isset($_GET['vendor_id'])){
    die("Vendor not found");
}

$vendor_id = $_GET['vendor_id'];

/*
  VENDOR DETAILS
*/
$vendor = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM vendors WHERE vendor_id='$vendor_id'
"));

/*
  FULL PURCHASE DETAILS
*/
$sql = "
SELECT 
    pu.purchase_id,
    p.product_name,
    pu.purchase_price,
    pu.quantity,
    (pu.purchase_price * pu.quantity) AS total,
    pu.created_at
FROM purchases pu
INNER JOIN products p 
    ON pu.product_id = p.product_id
WHERE pu.vendor_id='$vendor_id'
ORDER BY pu.purchase_id DESC
";

$result = mysqli_query($conn, $sql);

/*
  TOTAL
*/
$totalSum = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Report</title>
<link rel="stylesheet" href="products.css">
<style>
    .admin-container{
        width: 80%;
        margin-left:10%;
        padding: 20px;
    }
     button {
  display: inline-block;
  background: #1976d2;
  color: #fff;
  padding: 10px 15px;
  border-radius: 5px;
  text-decoration: none;
  margin-top: 10px;
  border:0px;
}
button:hover {
  background: #0b5cac;
}
</style>
</head>

<body>

<div class="admin-container">

<div class="topbar">
<h2>Vendor Full Report</h2>
</div>

<button onclick="window.print()">Print</button>

<div class="card">
<h3>Vendor Info</h3>
<p><b>Name:</b> <?= $vendor['vendor_name'] ?></p>
<p><b>Phone:</b> <?= $vendor['vendor_phone'] ?></p>
<p><b>Address:</b> <?= $vendor['vendor_address'] ?></p>
</div>

<table class="data-table">

<tr>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){
$totalSum += $row['total'];
?>

<tr>
<td data-label="Name"><?= $row['product_name'] ?></td>
<td data-label="Purchase Price"><?= $row['purchase_price'] ?></td>
<td data-label="Qty"><?= $row['quantity'] ?></td>
<td data-label="Total"><?= $row['total'] ?></td>
<td data-label="Date"><?= date("d M Y", strtotime($row['created_at'])) ?></td>
</tr>

<?php } ?>

<tr>
<td colspan="3"><b>Grand Total</b></td>
<td colspan="2"><b><?= $totalSum ?></b></td>
</tr>

</table>

</div>
</div>

</body>
</html>