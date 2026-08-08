<?php
session_start();
include("connection.php");

$query = isset($_GET['query']) ? $_GET['query'] : "";

$query = mysqli_real_escape_string($conn,$query);

// Find Category
$catQuery = mysqli_query($conn,"
SELECT * FROM categories 
WHERE category_name LIKE '%$query%'
LIMIT 1
");

$category = mysqli_fetch_assoc($catQuery);

// Find Products (match name or description)
$productQuery = mysqli_query($conn,"
SELECT p.*, c.category_name 
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
WHERE p.product_name LIKE '%$query%'
OR c.category_name LIKE '%$query%'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Results</title>
<link rel="stylesheet" href="product.css">
</head>

<body>

<?php include("menu.php"); ?>

<section class="product-list">
<h1>Search Results</h1>
<p>Showing results for: <b><?= $query ?></b></p>

<div class="product-grid">

<?php 
if(mysqli_num_rows($productQuery) > 0){
while($p = mysqli_fetch_assoc($productQuery)) { 
$stock = $p['quantity'];
?>

<div class="product-card">

<img src="distributor_side/uploads/<?= $p['image'] ?>" width="100%">

<h3><?= $p['product_name'] ?></h3>
<p><?= $p['description'] ?></p>

<span class="price">PKR <?= $p['price'] ?></span>

<?php if($stock > 0){ ?>

<p style="color:green;font-weight:bold;">
  <span style="color:black;">In stock:</span> Available
</p>
<?php } else { ?>
<p style="color:red;font-weight:bold;">
  <span style="color:black;">In stock:</span> Out of stock
</p>
<?php } ?>

<div class="buttons">
<?php if($stock > 0){ ?>
<button onclick="addToCart(
'<?= $p['product_name'] ?>',
<?= $p['price'] ?>,
'distributor_side/uploads/<?= $p['image'] ?>'
)">
Add to Cart
</button>
<?php } else { ?>
<button disabled style="background:#999">
Out of Stock
</button>
<?php } ?>
</div>

</div>

<?php } } else { ?>
<h2>No products or categories found.</h2>
<?php } ?>

</div>
</section>

<footer>
<p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

<script src="product.js"></script>
</body>
</html>