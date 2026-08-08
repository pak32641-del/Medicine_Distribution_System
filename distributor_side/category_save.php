<?php
include("connection.php");

$name = $_POST['category_name'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "uploads/".$image);

mysqli_query($conn,
  "INSERT INTO categories (category_name, image)
   VALUES ('$name','$image')"
);

header("Location: categories.php");
?>