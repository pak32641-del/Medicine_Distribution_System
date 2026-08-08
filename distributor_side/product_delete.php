<?php
include("connection.php");

$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM products WHERE product_id='$id'");

header("Location: products.php");
?>