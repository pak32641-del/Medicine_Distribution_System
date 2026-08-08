<?php
include("connection.php");
session_start();

// ===== Get Contact Info (Create If Not Exists) =====
$check = mysqli_query($conn,"SELECT * FROM contact_info LIMIT 1");

if(mysqli_num_rows($check) == 0){
    mysqli_query($conn,"
        INSERT INTO contact_info
        (company_name, owners, phone, Whatsapp, email, address, working_hours, updated_at)
        VALUES ('','','','','','','', NOW())
    ");
    $check = mysqli_query($conn,"SELECT * FROM contact_info LIMIT 1");
}

$data = mysqli_fetch_assoc($check);

// ===== Update Contact Info =====
if(isset($_POST['update'])){
    
    $company_name = $_POST['company_name'];
    $owners       = $_POST['owners'];
    $phone        = $_POST['phone'];
    $whatsapp     = $_POST['whatsapp'];
    $email        = $_POST['email'];
    $address      = $_POST['address'];
    $working      = $_POST['working_hours'];

    mysqli_query($conn,"
        UPDATE contact_info SET
        company_name  = '$company_name',
        owners        = '$owners',
        phone         = '$phone',
        Whatsapp      = '$whatsapp',
        email         = '$email',
        address       = '$address',
        working_hours = '$working',
        updated_at    = NOW()
        WHERE contact_id = '".$data['contact_id']."'
    ");

    echo "<script>alert('Contact information updated successfully!');</script>";
    echo "<script>window.location.href='admin_contact_update.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Contact Information</title>

<style>
body{
  font-family: Arial;
  background:#f4f6f9;
}

.container{
  width:55%;
  margin:40px auto;
  background:white;
  padding:25px;
  border-radius:10px;
  box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
  text-align:center;
  margin-bottom:25px;
  color:#009688;
}

form input, textarea{
  width:100%;
  padding:10px;
  margin:8px 0 18px 0;
  border-radius:6px;
  border:1px solid #ccc;
}

button{
  width:100%;
  padding:10px;
  background:#009688;
  color:white;
  border:none;
  border-radius:6px;
  font-size:16px;
  cursor:pointer;
}

button:hover{
  background:#00796b;
}
</style>

</head>

<body>

<div class="container">
<h2>Update Contact Information</h2>

<form method="POST">

<input type="text" name="company_name" 
placeholder="Company Name" 
value="<?= $data['company_name']; ?>" required>

<input type="text" name="owners" 
placeholder="Registered Owners" 
value="<?= $data['owners']; ?>" required>

<input type="text" name="phone" 
placeholder="Phone" 
value="<?= $data['phone']; ?>" required>

<input type="text" name="whatsapp" 
placeholder="WhatsApp" 
value="<?= $data['whatsapp']; ?>" required>

<input type="email" name="email" 
placeholder="Email" 
value="<?= $data['email']; ?>" required>

<textarea name="address" rows="3" placeholder="Address" required><?= $data['address']; ?></textarea>

<input type="text" name="working_hours" 
placeholder="Working Hours" 
value="<?= $data['working_hours']; ?>" required>

<button type="submit" name="update">Update Info</button>

</form>

</div>

</body>
</html>