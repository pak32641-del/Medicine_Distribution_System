<?php
include("connection.php");

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM feedback WHERE feedback_id = $id");

header("Location: feedback_admin.php");
exit();
?>