<?php
include("connection.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM categories WHERE category_id=$id");

header("Location: categories.php");
?>