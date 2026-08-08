<?php
session_start();
include("connection.php");

$successMsg = "";

// Check login
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $userQuery = mysqli_query($conn,"
        SELECT full_name, email FROM users WHERE user_id='$user_id' LIMIT 1
    ");
    $user = mysqli_fetch_assoc($userQuery);

    $nameValue = $user['full_name'];
    $emailValue = $user['email'];
}else{
    $user_id = NULL;
    $nameValue = "";
    $emailValue = "";
}

// Submit Feedback
if(isset($_POST['submit']) && $user_id != NULL){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);

    $query = "INSERT INTO feedback(user_id,name,email,remarks,created_at)
              VALUES('$user_id','$name','$email','$remarks',NOW())";

    if(mysqli_query($conn,$query)){
        $successMsg = "Thank you! Your feedback has been submitted successfully.";
    }else{
        $successMsg = "Failed to submit feedback!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback | MedStore</title>
  <link rel="stylesheet" href="feedback.css" />
</head>

<body>

<!-- ====== Header / Navbar ====== -->
<?php include("menu.php"); ?>

<!-- ====== Feedback Section ====== -->
<section class="feedback-container">

  <h1>Your Feedback</h1>
  <p>Your experience helps us improve our services.</p>

  <?php if($successMsg != ""): ?>
      <p class="success-msg"><?php echo $successMsg; ?></p>
  <?php endif; ?>

  <?php if($user_id == NULL){ ?>
        <p style="color:black; font-size:18px; font-weight:bold;">
            Please login first to submit feedback.
        </p>

        <a href="login.php" 
           style="background:#009688;color:#fff;padding:8px 15px;
                  border-radius:5px;text-decoration:none;">
            Login Now
        </a>

  <?php } else { ?>

  <form method="POST">

      <div class="form-group">
        <label>Full Name</label>
        <input type="text" 
               name="name" 
               value="<?php echo $nameValue; ?>" 
               required>
      </div>

      <div class="form-group">
        <label>Email Address</label>
        <input type="email" 
               name="email" 
               value="<?php echo $emailValue; ?>" 
               required>
      </div>

      <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" 
                  placeholder="Write your feedback..." 
                  required></textarea>
      </div>

      <button type="submit" name="submit" class="submit-btn">
        Submit Feedback
      </button>

  </form>

  <?php } ?>

</section>

<!-- ====== Footer ====== -->
<footer>
  <p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

</body>
</html>