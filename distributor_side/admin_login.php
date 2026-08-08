<?php
session_start();
include("connection.php");

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    $query = mysqli_query($conn,"
    SELECT * FROM admin
    WHERE email='$email'
    ");

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);

        if(password_verify($pass, $admin['password'])){

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];

            header("Location: admin_home.php");
            exit();

        }else{

            $msg = "Invalid Password!";
        }

    }else{

        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<link rel="stylesheet" href="admin_sign_in.css">

</head>

<body>

<div class="auth-container">

<h2>Admin Login</h2>

<?php
if(isset($msg)){
    echo "<p>$msg</p>";
}
?>

<form method="post">

<input type="email"
name="email"
placeholder="Enter Email"
required>

<br><br>

<input type="password"
name="password"
placeholder="Enter Password"
required>

<br><br>

<button type="submit" name="login">
Login
</button>

</form>

</div>

</body>
</html>
