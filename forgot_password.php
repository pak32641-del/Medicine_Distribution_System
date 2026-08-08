<?php
session_start();
include("connection.php");
$message = "";

if(isset($_POST['reset'])){
    
    $email = $_POST['email'];
    $newpass = $_POST['password'];

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)==1){

        $hashPass = password_hash($newpass, PASSWORD_BCRYPT);

        

        mysqli_query($conn,"UPDATE users SET password='$hashPass' WHERE email='$email'");

        $message = "Password Reset Successful! Please Login.";
        header("Location: login.php");
        exit();
    }
    else{
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="login signup.css">
</head>

<body>
<div class="container">
<form class="form-box" method="POST">

<h2>Reset Password</h2>

<p style="color:red;"><?php echo $message; ?></p>

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>New Password</label>
<input type="password" name="password" required>
</div>

<button type="submit" name="reset" class="btn">Reset Password</button>

<p class="link">
Back to Login?
<a href="login.php">Login</a>
</p>

</form>
</div>
</body>
</html>