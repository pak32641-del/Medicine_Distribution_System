<?php
session_start();
include("connection.php");

if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}

$id = $_GET['id'];

// ===== ORDER =====
$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders WHERE order_id='$id'
"));

// ===== ORDER ITEMS =====
$items = mysqli_query($conn,"
SELECT * FROM order_items WHERE order_id='$id'
");

// ===== UPDATE DATA =====
if(isset($_POST['update'])){

    $customer_name = $_POST['customer_name'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];

    mysqli_query($conn,"
        UPDATE orders 
        SET customer_name='$customer_name',
            address='$address',
            zip='$zip'
        WHERE order_id='$id'
    ");

    foreach($_POST['qty'] as $item_id => $qty){

        mysqli_query($conn,"
            UPDATE order_items 
            SET quantity='$qty'
            WHERE item_id='$item_id'
        ");
    }

    echo "<script>
        alert('Order updated successfully');
        window.location='dashboard.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Order</title>

<style>

/* ===== RESET ===== */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

body{
  background:#f4f6f9;
  color:#333;
}

/* ===== MAIN CONTENT ===== */
.main-content{
  width:80%;
  margin-left:10%;
  padding:20px;
}

/* ===== PAGE TITLE ===== */
.main-content h2{
  background:#fff;
  padding:15px;
  border-radius:8px;
  margin-bottom:20px;
  box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

/* ===== CARD ===== */
.card{
  background:#fff;
  padding:20px;
  border-radius:10px;
  box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

/* ===== LABELS ===== */
.card label{
  display:block;
  margin-bottom:6px;
  font-size:14px;
  color:#555;
  font-weight:500;
}

/* ===== INPUTS ===== */
.card input[type="text"],
.card input[type="number"]{
  width:100%;
  padding:10px;
  margin-bottom:15px;
  border:1px solid #ddd;
  border-radius:5px;
  outline:none;
  font-size:14px;
}

.card input[type="text"]:focus,
.card input[type="number"]:focus{
  border-color:#009688;
}

/* ===== SUB TITLE ===== */
.card h3{
  margin-top:10px;
  margin-bottom:15px;
  color:#333;
}

/* ===== TABLE ===== */
.data-table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  overflow:hidden;
  margin-bottom:20px;
}

.data-table th{
  background:#009688;
  color:#fff;
  padding:12px;
  text-align:center;
}

.data-table td{
  padding:10px;
  border-bottom:1px solid #eee;
  text-align:center;
}

.data-table tr:hover{
  background:#f1f1f1;
}

/* ===== BUTTON ===== */
.card button{
  background:#009688;
  color:#fff;
  border:none;
  padding:10px 18px;
  border-radius:5px;
  cursor:pointer;
  font-size:14px;
  transition:0.3s;
  margin-left:45%;

.card button:hover{
  background:#00796b;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .main-content {
    width: 100%;
    margin-left: 0;
  }
}


</style>

</head>

<body>


<div class="main-content">

<h2>Edit Order #<?= $order['order_id'] ?></h2>

<form method="POST" class="card">

    <label>Customer Name</label>
    <input type="text" name="customer_name" value="<?= $order['customer_name'] ?>" required>

    <label>Address</label>
    <input type="text" name="address" value="<?= $order['address'] ?>" required>

    <label>ZIP</label>
    <input type="text" name="zip" value="<?= $order['zip'] ?>" required>

    <h3>Products</h3>

    <table class="data-table">
        <tr>
            <th>Product</th>
            <th>Qty</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($items)) { ?>
        <tr>
            <td><?= $row['product_name'] ?></td>
            <td>
                <input type="number" name="qty[<?= $row['item_id'] ?>]" value="<?= $row['quantity'] ?>" min="1">
            </td>
        </tr>
        <?php } ?>

    </table>

    <button type="submit" name="update">
        Update Order
    </button>

</form>

</div>

</body>
</html>