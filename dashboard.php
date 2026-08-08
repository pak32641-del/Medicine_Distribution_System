<?php
session_start();
include("connection.php");

// If user not logged in redirect
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Get user orders (do not show deleted)
$orders = mysqli_query($conn,"
  SELECT * FROM orders
  WHERE user_id = '$user_id'
  AND user_deleted = 0
  ORDER BY order_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Dashboard</title>
<link rel="stylesheet" href="dashboard.css" />
</head>

<body>

<?php include("menu.php"); ?>

<section class="dashboard-container">
  <h1>My Orders</h1>
  <p>Track your order history and status.</p>

  <table class="order-table">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Total (PKR)</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Action</th>
        <th>Edit</th>
        <th>Remove</th>
      </tr>
    </thead>

<tbody>

<?php 
if(mysqli_num_rows($orders) > 0){
while($row = mysqli_fetch_assoc($orders)){ ?>
<tr>

<td>#<?= $row['order_id'] ?></td>
<td><?= $row['order_date'] ?></td>
<td><?= $row['total_amount'] ?></td>

<td>
<span class="status <?= strtolower($row['status']); ?>">
<?= $row['status'] ?>
</span>
</td>

<td><?= $row['payment_type'] ?></td>

<td>
<a class="view-btn" href="dashboard_details.php?id=<?= $row['order_id'] ?>">
View
</a>
</td>

<!-- EDIT BUTTON ADDED -->
<td>
<?php if($row['status'] == "Pending"){ ?>
<a class="edit-btn"
href="dashboard_record_edit.php?id=<?= $row['order_id'] ?>">
Edit
</a>
<?php } else { ?>
<span style="color:gray;">Not Allowed</span>
<?php } ?>
</td>

<td>

<?php if($row['status'] == "Pending"){ ?>
<a class="delete-btn"
href="dashboard_record_delete.php?id=<?= $row['order_id'] ?>"
onclick="return confirm('Cancel order?')">
Delete
</a>

<?php } else { ?>
<a class="delete-btn"
href="dashboard_deleterecord_userside.php?id=<?= $row['order_id'] ?>"
onclick="return confirm('Delete order record?')">
Delete
</a>
<?php } ?>

</td>

</tr>

<?php } } else { ?>
<tr>
<td colspan="8" style="text-align:center;">
No orders found yet.
</td>
</tr>
<?php } ?>

</tbody>
</table>

</section>

<footer>
<p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

</body>
</html>