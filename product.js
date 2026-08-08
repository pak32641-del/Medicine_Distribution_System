function updateCartCount(){
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let totalQty = 0;

  cart.forEach(item => {
    totalQty += parseInt(item.qty) || 0;
  });

  document.getElementById("cartCount").innerText = totalQty;
}

function addToCart(id, name, price, image) {

  price = parseFloat(price); // ✅ FIX (NaN issue solve)

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  let existing = cart.find(item => item.id == id);

  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({
      id: id,          // ✅ important for DB
      name: name,      // ✅ show in cart
      price: price,
      qty: 1,
      image: image
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));

  updateCartCount();
  alert(name + " added to cart!");
}

updateCartCount();