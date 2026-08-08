<?php
session_start();
include("connection.php");

if(!isset($_GET['id'])){
  die("Category not found");
}

$cat_id = $_GET['id'];

// Get Category Name
$cquery = mysqli_query($conn,"
  SELECT category_name FROM categories WHERE category_id='$cat_id' LIMIT 1
");
$cat = mysqli_fetch_assoc($cquery);
$category_name = $cat['category_name'];

// Get Products
$products = mysqli_query($conn,"
  SELECT * FROM products WHERE category_id='$cat_id'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $category_name ?></title>
<link rel="stylesheet" href="product.css">
</head>

<body>

<?php include("menu.php"); ?>

<section class="product-list">

<h1><?= $category_name ?></h1>
<p>Browse medicines in <?= $category_name ?> category</p>

<div class="product-grid">

<?php 
if(mysqli_num_rows($products) > 0){
while($p = mysqli_fetch_assoc($products)){ 
$stock = $p['quantity'];
?>

<div class="product-card">

<img src="distributor_side/uploads/<?= $p['image'] ?>" 
alt="<?= $p['product_name'] ?>">

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
'<?= $p['product_id'] ?>',
'<?= htmlspecialchars($p['product_name'], ENT_QUOTES) ?>',
'<?= $p['price'] ?>',
'distributor_side/uploads/<?= $p['image'] ?>'
)">
Add to Cart
</button>
<?php } else { ?>
<button disabled style="background:#999;cursor:not-allowed;">
Out of Stock
</button>
<?php } ?>
</div>

</div>

<?php } } else { ?>
<p style="text-align:center">No Products Found</p>
<?php } ?>

</div>

</section>

<footer>
<p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

</body>
<script src="addToCart.js"></script>
</html>