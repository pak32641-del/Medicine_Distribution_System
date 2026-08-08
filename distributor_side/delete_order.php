<?php
include("connection.php");

if(isset($_GET['id'])) {
  $id = $_GET['id'];

  mysqli_query($conn, "DELETE FROM orders WHERE order_id='$id'");
}

header("Location: orders.php");
exit;
?>