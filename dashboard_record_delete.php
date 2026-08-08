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

    // only delete if order belongs to user AND is Pending
    $query = mysqli_query($conn,"
        DELETE FROM orders 
        WHERE order_id = '$order_id' 
        AND user_id = '$user_id'
        AND status = 'Pending'
    ");

    if($query){
        header("Location: dashboard.php?msg=order_cancelled");
        exit();
    } else {
        echo "Failed to cancel order.";
    }
} else {
    echo "Invalid request.";
}
?>