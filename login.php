<?php
session_start();
include("connection.php");

$msg = "";

if(isset($_POST['login'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($query);

    if($row && password_verify($password,$row['password'])){
        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['full_name'];

        header("Location: home.php");
        exit();
    } 
    else {
        $msg = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="login signup.css">
</head>

<body>

<div class="container">
<form class="form-box" method="POST">

<h2>Login</h2>

<p style="color:red;"><?php echo $msg; ?></p>

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<button type="submit" name="login" class="btn">Login</button>

<p class="link">
Don't have an account?
<a href="signup.php">Sign Up</a>
</p>

<p class="link">
<a href="forgot_password.php">Forgot Password?</a>
</p>

</form>
</div>
</body>
</html>