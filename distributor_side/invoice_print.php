<?php
include("connection.php");

$order_id = $_GET['order_id'];

// Fetch order
$order = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM orders WHERE order_id='$order_id'")
);

// Fetch order items
$items = mysqli_query(
  $conn,
  "SELECT * FROM order_items 
 
   WHERE order_items.order_id='$order_id'"
);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Invoice #<?= $order_id ?></title>

  <style>
    body {
      font-family: Poppins, sans-serif;
      background: #fff;
      padding: 30px;
    }

    .invoice {
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
      padding: 25px;
    }

    h2 {
      text-align: center;
      color: #009688;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ccc;
      
      
    }

    th, td {
      padding: 10px;
      text-align: left;
      
    }

    .total {
      text-align: right;
      margin-top: 20px;
      font-size: 18px;
    }

    .btns {
      text-align: center;
      margin-top: 30px;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-size: 15px;
      border-radius: 5px;
    }

    .print {
      background: #009688;
      color: white;
    }

    .back {
      background: #009688;
      color: white;
      margin-left: 10px;
    }

    @media print {
      .btns {
        display: none;
      }
    }
  </style>
</head>

<body>

<div class="invoice">
  <h2>Invoice</h2>

  <p><strong>Order ID:</strong> <?= $order_id ?></p>
  <p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
<p><strong>Name:</strong>  <?= $order['customer_name' ]?></p>
<p><strong>Phone:</strong>  <?= $order['phone' ]?></p>
<p><strong>Address:</strong> <?= $order['address' ]?></p>
  <table>
    <tr>
      <th>Product</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Total</th>
    </tr>

    <?php $grand = 0; ?>
    <?php while($row = mysqli_fetch_assoc($items)): ?>
    <?php $total = $row['price'] * $row['quantity']; ?>
    <?php $grand += $total; ?>

    <tr>
      <td><?= $row['product_id'] ?></td>
      <td><?= $row['price'] ?></td>
      <td><?= $row['quantity'] ?></td>
      <td><?= $total ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <div class="total">
    <strong>Grand Total: PKR <?= $grand ?></strong>
  </div>

  <!-- ===== Buttons ONLY for Invoice Page ===== -->
  <div class="btns">
    <button class="btn print" onclick="window.print()">Print</button>
    <button class="btn back"   onclick="goback()"class="back-btn">Back</button>

  </div>

</div>
<script>
    function goback() {
        window.location.href="orders.php";
    }
    </script>
</body>

</html>