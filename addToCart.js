function updateCartCount(){
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let totalQty = 0;

  cart.forEach(item => {
    totalQty += parseInt(item.qty) || 0;
  });

  document.getElementById("cartCount").innerText = totalQty;
}

// ✅ CORRECT: Add to Cart function
// Use this in index.php / product_detail.php
// Make sure product_id, name, price, image are passed correctly

function addToCart(product_id, name, price, image) {

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Check if product already in cart
  let existing = cart.find(item => item.id == product_id);

  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({
      id:    product_id,   // ✅ THIS IS THE KEY FIX — must be 'id'
      name:  name,
      price: price,
      image: image,
      qty:   1
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  alert(name + " added to cart!");
}

updateCartCount();
// ✅ Example: how to call it from a button in PHP loop:
/*
<button onclick="addToCart(
  <?= $p['product_id'] ?>,
  '<?= addslashes($p['product_name']) ?>',
  <?= $p['price'] ?>,
  'uploads/<?= $p['image'] ?>'
)">
  Add to Cart
</button>
*/