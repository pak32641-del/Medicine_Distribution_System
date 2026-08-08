<?php
include("connection.php");

// ADD VENDOR
if (isset($_POST['add_vendor'])) {

    $name = $_POST['vendor_name'];
    $address = $_POST['vendor_address'];
    $phone = $_POST['vendor_phone'];

    mysqli_query($conn, "
        INSERT INTO vendors (vendor_name, vendor_address, vendor_phone)
        VALUES ('$name','$address','$phone')
    ");

    header("Location: vendors.php");
    exit();
}

// FETCH VENDORS
$vendors = mysqli_query($conn, "SELECT * FROM vendors ORDER BY vendor_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Management</title>
<link rel="stylesheet" href="vendors.css">
</head>

<body>
 <?php
    include("admin_menu.php");
    ?>

<!-- Main Content -->
<div class="main-content">

<div class="topbar">
  <h2>Vendor Management</h2>
</div>

<!-- ADD FORM -->
<form method="POST" class="card">

<h3>Add New Vendor</h3>

<input type="text" name="vendor_name" placeholder="Vendor Name" required>

<input type="text" name="vendor_address" placeholder="Vendor Address" required>

<input type="text" name="vendor_phone" placeholder="Vendor Phone" required>

<button type="submit" name="add_vendor">Save Vendor</button>

</form>

<br>

<!-- TABLE -->
<table class="data-table">

<tr>
<th>ID</th>
<th>Name</th>
<th>Address</th>
<th>Phone</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($v = mysqli_fetch_assoc($vendors)) { ?>

<tr>
<td><?= $v['vendor_id'] ?></td>
<td><?= $v['vendor_name'] ?></td>
<td><?= $v['vendor_address'] ?></td>
<td><?= $v['vendor_phone'] ?></td>
<td><?= $v['created_at'] ?></td>

<td>
    <a href="vendor_edit.php?id=<?= $v['vendor_id'] ?>">Edit</a> |
    <a href="vendor_delete.php?id=<?= $v['vendor_id'] ?>"
       onclick="return confirm('Delete this vendor?')">
       Delete
    </a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>