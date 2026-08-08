<?php
include("connection.php");
$message = "";

if(isset($_POST['register'])){

    $name     = $_POST['full_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    // Check if email already exists
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    
    if(mysqli_num_rows($check) > 0){
        $message = "Account already exists! Please login.";
    } 
    else {
        $hashPass = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(full_name,email,phone,password,created_at)
                  VALUES('$name','$email','$phone','$hashPass',NOW())";

        if(mysqli_query($conn,$query)){
            $message = "Account Created Successfully!";
            header("Location: login.php");
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
<link rel="stylesheet" href="login signup.css">
</head>

<body>
<div class="container">
<form class="form-box" method="POST">

<h2>Create Account</h2>

<p style="color:red;"><?php echo $message; ?></p>

<div class="input-group">
<label>Full Name</label>
<input type="text" name="full_name" required>
</div>

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>Phone</label>
<input type="text" name="phone" required>
</div>

<div class="input-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<button type="submit" name="register" class="btn">Sign Up</button>

<p class="link">
Already have an account?
<a href="login.php">Login</a>
</p>

</form>
</div>
</body>
</html>