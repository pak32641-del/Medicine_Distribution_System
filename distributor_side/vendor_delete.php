<?php
include("connection.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM vendors WHERE vendor_id='$id'");

header("Location: vendors.php");
?>