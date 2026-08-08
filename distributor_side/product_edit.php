<?php
include("connection.php");

if(!isset($_GET['id'])){
    die("Product ID Missing!");
}

$id = $_GET['id'];

/* ================= PRODUCT DATA ================= */
$product = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM products WHERE product_id='$id'
"));

/* ================= CATEGORY LIST ================= */
$cats = mysqli_query($conn,"SELECT * FROM categories");

/* ================= VENDOR LIST ================= */
$vendors = mysqli_query($conn,"SELECT * FROM vendors");

/* ================= LATEST PURCHASE ================= */
$purchase = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM purchases 
WHERE product_id='$id'
ORDER BY purchase_id DESC 
LIMIT 1
"));

/* ================= UPDATE ================= */
if(isset($_POST['update'])) {

    $cat = $_POST['category_id'];
    $vendor = $_POST['vendor_id'];
    $name = $_POST['product_name'];
    $price = $_POST['price']; // selling price
    $purchase_price = $_POST['purchase_price']; // ✅ NEW (IMPORTANT)
    $qty = $_POST['quantity'];
    $desc = $_POST['description'];

    /* ========= UPDATE PRODUCT ========= */
    if($_FILES['image']['name'] != "") {

        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp,"uploads/$img");

        mysqli_query($conn,"
            UPDATE products SET
            category_id='$cat',
            product_name='$name',
            price='$price',
            quantity='$qty',
            description='$desc',
            image='$img'
            WHERE product_id='$id'
        ");

    } else {

        mysqli_query($conn,"
            UPDATE products SET
            category_id='$cat',
            product_name='$name',
            price='$price',
            quantity='$qty',
            description='$desc'
            WHERE product_id='$id'
        ");
    }

    /* ========= INSERT PURCHASE (FIXED) ========= */
    mysqli_query($conn,"
        INSERT INTO purchases 
        (product_id, vendor_id, purchase_price, quantity, image)
        VALUES
        ('$id','$vendor','$purchase_price','$qty','{$product['image']}')
    ");

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link rel="stylesheet" href="products.css">
<style> .admin-container{
        width: 80%;
        margin-left:10%;
        padding: 20px;
    }
</style>
</head>

<body>

<div class="admin-container">

<div class="topbar">
<h2>Edit Product</h2>
</div>

<!-- ================= FORM ================= -->
<form method="POST" enctype="multipart/form-data" class="card">

<h3>Edit Product</h3>

<!-- CATEGORY -->
<select name="category_id" required>
<option value="">Select Category</option>
<?php while($c = mysqli_fetch_assoc($cats)) { ?>
<option value="<?= $c['category_id'] ?>"
<?= ($c['category_id']==$product['category_id'])?'selected':'' ?>>
<?= $c['category_name'] ?>
</option>
<?php } ?>
</select>

<!-- VENDOR -->
<select name="vendor_id" required>
<option value="">Select Vendor</option>
<?php while($v = mysqli_fetch_assoc($vendors)) { ?>
<option value="<?= $v['vendor_id'] ?>"
<?= ($purchase && $purchase['vendor_id']==$v['vendor_id'])?'selected':'' ?>>
<?= $v['vendor_name'] ?>
</option>
<?php } ?>
</select>

<!-- PRODUCT NAME -->
<input type="text" name="product_name"
value="<?= $product['product_name'] ?>" 
placeholder="Product Name" required>

<!-- SELLING PRICE -->
<input type="number" name="price"
value="<?= $product['price'] ?>" 
placeholder="Selling Price" required>

<!-- 🔥 PURCHASE PRICE (NEW FIELD) -->
<input type="number" name="purchase_price"
value="<?= ($purchase) ? $purchase['purchase_price'] : '' ?>"
placeholder="Purchase Price" required>

<!-- QUANTITY -->
<input type="number" name="quantity"
value="<?= $product['quantity'] ?>" 
placeholder="Quantity" required>

<!-- DESCRIPTION -->
<textarea name="description" placeholder="Description"><?= $product['description'] ?></textarea>

<!-- IMAGE -->
<img src="uploads/<?= $product['image'] ?>" width="70"><br><br>
<input type="file" name="image">

<!-- BUTTON -->
<button type="submit" name="update">Update Product</button>

</form>

</div>
</div>

</body>
</html>