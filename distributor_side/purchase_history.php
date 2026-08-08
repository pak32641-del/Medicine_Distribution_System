<?php
include("connection.php");

$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

/*
  STEP 1: ONLY UNIQUE VENDORS SHOW
*/
$sql = "
SELECT 
    v.vendor_id,
    v.vendor_name,
    v.vendor_phone,
    v.vendor_address,
    COUNT(pu.purchase_id) AS total_orders,
    SUM(pu.purchase_price * pu.quantity) AS total_amount,
    MAX(pu.created_at) AS last_purchase_date
FROM vendors v
LEFT JOIN purchases pu 
    ON v.vendor_id = pu.vendor_id
GROUP BY v.vendor_id
";

if(!empty($search)){
    $sql .= " HAVING 
        v.vendor_name LIKE '%$search%'
    ";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Purchase Summary</title>
<link rel="stylesheet" href="products.css">
</head>

<body>
<?php
    include("admin_menu.php");
    ?>

<!-- MAIN -->
<div class="main-content">

<div class="topbar">
<h2>Vendor Purchase Summary</h2>
</div>

<form method="GET" class="card">
<h3>Search Vendor</h3>

<input type="text" name="search" placeholder="Vendor Name" value="<?= htmlspecialchars($search) ?>">

<button type="submit">Search</button>
<a href="purchase_history.php">Reset</a>

<button type="button" onclick="window.print()">Print</button>

</form>

<br>
<div class="table-wrapper">  
<table class="data-table">

<tr>
<th>Vendor ID</th>
<th>Vendor Name</th>
<th>Phone</th>
<th>Total Orders</th>
<th>Total Amount</th>
<th>Last Purchase</th>
<th>Action</th>
</tr>

<?php
if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<td data-label="ID"><?= $row['vendor_id'] ?></td>
<td data-label="Vendor"><?= $row['vendor_name'] ?></td>
<td data-label="Vendor Phone"><?= $row['vendor_phone'] ?></td>
<td data-label="Total Orders"><?= $row['total_orders'] ?? 0 ?></td>
<td data-label="Total Amount"><?= $row['total_amount'] ?? 0 ?></td>
<td data-label="Purchase Date"><?= $row['last_purchase_date'] ? date("d M Y", strtotime($row['last_purchase_date'])) : '-' ?></td>

<td>
<a href="purchase_history_report.php?vendor_id=<?= $row['vendor_id'] ?>">
View Report
</a>
</td>

</tr>

<?php } } else { ?>

<tr>
<td colspan="7" style="text-align:center;">No Vendors Found</td>
</tr>

<?php } ?>

</table>
</div>

</div>
</div>

</body>
</html>