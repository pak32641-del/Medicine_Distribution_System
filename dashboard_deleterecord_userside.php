<?php
session_start();
include("connection.php");

// check login
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['id'])){
    $order_id = $_GET['id'];

    // user can only delete own records (soft/hard delete)
    $query = mysqli_query($conn,"
        UPDATE orders 
        SET user_deleted = 1 
        WHERE order_id = '$order_id' 
        AND user_id = '$user_id'
    ");

    if($query){
        header("Location: dashboard.php?msg=order_deleted");
        exit();
    } else {
        echo "Failed to delete record.";
    }
} else {
    echo "Invalid request.";
}
?>