<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cart</title>
<link rel="stylesheet" href="cart.css">
</head>

<body>

<?php include("menu.php"); ?>

<section class="cart-container">
  <h1>Your Shopping Cart</h1>

  <table class="cart-table">
    <thead>
      <tr>
        <th></th>
        <th>Product Name</th>
        <th>Unit Price (PKR)</th>
        <th>Quantity</th>
        <th>Amount (PKR)</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="cartItems"></tbody>
  </table>

  <div class="cart-summary">
    <h3>Total Amount</h3>
    <p>PKR <span id="cartTotal">0</span></p>
    <button class="checkout-btn" onclick="placeOrder()">Place Order</button>
  </div>
</section>

<footer>
  <p>© 2025 IA Medicines Distributor. All rights reserved.</p>
</footer>

<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function loadCart() {
  let cartItems = document.getElementById("cartItems");
  let cartTotal = 0;
  cartItems.innerHTML = "";

  if (cart.length === 0) {
    cartItems.innerHTML = `<tr><td colspan="6" style="text-align:center;">Your cart is empty.</td></tr>`;
    document.getElementById("cartTotal").innerText = "0.00";
    return;
  }

  cart.forEach((item, index) => {
    let price = parseFloat(item.price) || 0;
    let qty   = parseInt(item.qty)   || 1;
    let total = price * qty;
    cartTotal += total;

    // ✅ FIX: use item.image directly (already a full path from product page)
    cartItems.innerHTML += `
      <tr>
        <td><img src="${item.image}" width="50"></td>
        <td>${item.name}</td>
        <td>${price.toFixed(2)}</td>
        <td>
          <input id="qty-${index}" type="number" value="${qty}" min="1"
            onchange="updateQty(${index}, this.value)">
        </td>
        <td>${total.toFixed(2)}</td>
        <td>
          <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
        </td>
      </tr>
    `;
  });

  document.getElementById("cartTotal").innerText = cartTotal.toFixed(2);
}

function updateQty(index, value) {
  value = parseInt(value);
  if (value < 1 || isNaN(value)) value = 1;
  cart[index].qty = value;
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function placeOrder() {
  if (cart.length === 0) {
    alert("Your cart is empty!");
    return;
  }

  fetch("check_stock.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(cart)
  })
  .then(res => res.json())
  .then(data => {
    if (data.problem) {
      data.items.forEach(item => {
        if (item.problem) {
          let input = document.getElementById("qty-" + item.index);
          input.value = item.available;
          input.style.color = "red";
          input.style.fontWeight = "bold";
        }
      });
      alert("Some items exceed available stock. Please check quantities in red.");
      return;
    }

    <?php if(isset($_SESSION['user_id'])): ?>
      localStorage.setItem("checkoutCart", JSON.stringify(cart));
      window.location.href = "checkout.php";
    <?php else: ?>
      alert("Please login to continue!");
      window.location.href = "login.php";
    <?php endif; ?>
  })
  .catch(err => {
    console.error("Stock check failed:", err);
    alert("Something went wrong. Please try again.");
  });
}

window.onload = loadCart;
</script>

</body>
</html>