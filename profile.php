<?php
session_start();
include("connection.php");

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Fetch user info from database
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile | MedStore</title>
<link rel="stylesheet" href="profile.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.profile-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 25px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: white;
}

.profile-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #009688;
}

.profile-info p {
    font-size: 18px;
    margin-bottom: 15px;
}

.profile-info strong {
    color: #555;
}

</style>

</head>
<body>

<?php include("menu.php"); ?>

<section class="profile-container">
    <h2>My Profile</h2>
    
    <div class="profile-info">
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

</section>

</body>
</html>

