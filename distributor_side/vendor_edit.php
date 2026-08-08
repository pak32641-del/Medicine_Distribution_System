<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Page background */
body {
    background: #f4f6f9;
}

/* Center container */
form {
    background: #fff;
    width: 100%;
    max-width: 450px;

    margin: 80px auto;
    padding: 25px;

    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* Inputs */
form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;

    border: 1px solid #ddd;
    border-radius: 6px;

    outline: none;
    transition: 0.3s;
}

/* Focus effect */
form input:focus {
    border-color: #009688;
}

/* Button */
form button {
    width: 100%;
    padding: 10px;

    background: #009688;
    color: #fff;

    border: none;
    border-radius: 6px;

    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

form button:hover {
    background: #00796b;
}

/* Optional heading style (if you add h2) */
h2 {
    text-align: center;
    color: #009688;
    margin-top: 30px;
    font-size: 24px;
    font-weight: bold;
}


</style>
<?php
include("connection.php");

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM vendors WHERE vendor_id='$id'");
$v = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $name = $_POST['vendor_name'];
    $address = $_POST['vendor_address'];
    $phone = $_POST['vendor_phone'];

    mysqli_query($conn, "
        UPDATE vendors 
        SET vendor_name='$name',
            vendor_address='$address',
            vendor_phone='$phone'
        WHERE vendor_id='$id'
    ");

    header("Location: vendors.php");
}
?>

<form method="POST">

<input type="text" name="vendor_name" value="<?= $v['vendor_name'] ?>">
<input type="text" name="vendor_address" value="<?= $v['vendor_address'] ?>">
<input type="text" name="vendor_phone" value="<?= $v['vendor_phone'] ?>">

<button name="update">Update</button>

</form>