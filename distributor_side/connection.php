<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "medicine_distributor_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if(!$conn){
  die("Database Connection Failed: " . mysqli_connect_error());
}

date_default_timezone_set("Asia/Karachi");
?>
