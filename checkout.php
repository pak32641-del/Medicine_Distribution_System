<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $user_id      = $_SESSION['user_id'];
    $full_name    = $_POST['full_name'];
    $email        = $_POST['email'];
    $phone        = $_POST['phone'];
    $address      = $_POST['address'];
    $zip          = $_POST['zip'];
    $payment_type = $_POST['payment_type'];
    $total_amount = floatval($_POST['total_amount']);
    $order_date   = date('Y-m-d H:i:s');
    $status       = "Pending";

    // ✅ INSERT ORDER
    $stmt = $conn->prepare("
        INSERT INTO orders 
        (user_id, customer_name, email, phone, total_amount, status, order_date, payment_type, address, zip) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("isssdsssss",
        $user_id,
        $full_name,
        $email,
        $phone,
        $total_amount,
        $status,
        $order_date,
        $payment_type,
        $address,
        $zip
    );

    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // ✅ INSERT ORDER ITEMS
    $cart = json_decode($_POST['cart'], true);

    foreach ($cart as $item) {

        $product_id = intval($item['id']);
        $price      = floatval($item['price']);
        $qty        = intval($item['qty']);

        if ($product_id <= 0) continue;

        // Insert order item
        // Product Name
$product_name = $item['name'];

// Insert order item
$stmt2 = $conn->prepare("
    INSERT INTO order_items 
    (order_id, product_id, product_name, price, quantity)
    VALUES (?, ?, ?, ?, ?)
");

$stmt2->bind_param(
    "iisdi",
    $order_id,
    $product_id,
    $product_name,
    $price,
    $qty
);
        $stmt2->execute();
        $stmt2->close();

        // Update stock
        $update = $conn->prepare("
            UPDATE products SET quantity = quantity - ? WHERE product_id = ?
        ");
        $update->bind_param("ii", $qty, $product_id);
        $update->execute();
        $update->close();
    }

    echo "<script>
        localStorage.removeItem('cart');
        localStorage.removeItem('checkoutCart');
        alert('Order placed successfully!');
        window.location.href='cart.php';
    </script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout | IA Medicines</title>
<link rel="stylesheet" href="checkout.css">
</head>

<body>

<?php include("menu.php"); ?>

<section class="checkout-container">
<h1>Checkout</h1>

<form method="POST">

  <input type="hidden" name="total_amount" id="total_amount">
  <input type="hidden" name="cart" id="cart_data">

  <label>Full Name:</label>
  <input type="text" name="full_name" required>

  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Phone:</label>
  <input type="text" name="phone" required>

  <label>Address:</label>
  <textarea name="address" required></textarea>

  <label>ZIP:</label>
  <input type="text" name="zip" required>

  <label>Payment Method:</label>
  <select name="payment_type" required>
    <option value="Cash on Delivery">Cash on Delivery</option>
  </select>

  <br><br>
  <button type="submit" name="submit">Submit Order</button>

</form>
</section>
<script>
let checkoutCart = JSON.parse(localStorage.getItem("checkoutCart")) || [];

if (checkoutCart.length === 0) {
  alert("Cart is empty! Redirecting to shop.");
  window.location.href = "index.php";
}

let total = 0;

checkoutCart.forEach(item => {
  let price = parseFloat(item.price) || 0;
  let qty   = parseInt(item.qty) || 1;
  total += price * qty;
});

// Send to backend
document.getElementById("total_amount").value = total.toFixed(2);
document.getElementById("cart_data").value = JSON.stringify(checkoutCart);
</script>

</body>
</html>