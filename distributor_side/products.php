<?php              
include("connection.php");              

// ================= SEARCH =================              
$searchQuery = "";              
if (isset($_GET['search'])) {              
    $searchQuery = $_GET['search'];              
}      

// ================= LOW STOCK FILTER =================
$filter_low_stock = isset($_GET['filter']) && $_GET['filter'] == 'low_stock';

// ================= FETCH DATA =================              
$cats = mysqli_query($conn, "SELECT * FROM categories");              
$vendors = mysqli_query($conn, "SELECT * FROM vendors");              

// ================= PRODUCTS QUERY =================              
$products_sql = "              
SELECT         
    products.*,         
    categories.category_name,        
    vendors.vendor_name,        

    (  
        SELECT purchase_price         
        FROM purchases         
        WHERE purchases.product_id = products.product_id         
        ORDER BY purchase_id DESC         
        LIMIT 1        
    ) AS last_purchase_price,  

    (  
        SELECT created_at         
        FROM purchases         
        WHERE purchases.product_id = products.product_id         
        ORDER BY purchase_id DESC         
        LIMIT 1        
    ) AS last_purchase_date  

FROM products                  

LEFT JOIN categories         
    ON products.category_id = categories.category_id        

LEFT JOIN purchases         
    ON purchases.product_id = products.product_id        
    AND purchases.purchase_id = (        
        SELECT MAX(purchase_id)        
        FROM purchases         
        WHERE product_id = products.product_id        
    )        

LEFT JOIN vendors         
    ON purchases.vendor_id = vendors.vendor_id        
";              

// ================= FILTER (LOW STOCK + SEARCH) =================              
$whereAdded = false;

if ($filter_low_stock) {
    $products_sql .= " WHERE products.quantity < 50 ";
    $whereAdded = true;
}

if (!empty($searchQuery)) {              

    if ($whereAdded) {
        $products_sql .= " AND ";
    } else {
        $products_sql .= " WHERE ";
    }

    $products_sql .= "
    products.product_name LIKE '%$searchQuery%' OR        
    categories.category_name LIKE '%$searchQuery%' OR        
    vendors.vendor_name LIKE '%$searchQuery%'
    ";
}              

$products_sql .= " ORDER BY products.product_id DESC";              
$products = mysqli_query($conn, $products_sql);              

// ================= ADD PRODUCT =================              
if (isset($_POST['add_product'])) {  

    $cat = $_POST['category_id'];  
    $vendor_id = $_POST['vendor_id'];  
    $name = $_POST['product_name'];  
    $purchase_price = $_POST['purchase_price'];  
    $price = $_POST['price'];  
    $qty = $_POST['quantity'];  
    $desc = $_POST['description'];  

    $img = $_FILES['image']['name'];  
    $tmp = $_FILES['image']['tmp_name'];  
    move_uploaded_file($tmp, "uploads/$img");  

    $check = mysqli_query($conn, "  
        SELECT * FROM products   
        WHERE product_name='$name' AND category_id='$cat'  
        LIMIT 1  
    ");  

    if(mysqli_num_rows($check) > 0){  

        $row = mysqli_fetch_assoc($check);  
        $product_id = $row['product_id'];  

        mysqli_query($conn, "  
            UPDATE products   
            SET quantity = quantity + $qty  
            WHERE product_id = '$product_id'  
        ");  

    } else {  

        mysqli_query($conn, "  
            INSERT INTO products   
            (category_id, product_name, price, quantity, description, image)   
            VALUES   
            ('$cat','$name','$price','$qty','$desc','$img')  
        ");  

        $product_id = mysqli_insert_id($conn);  
    }  

    mysqli_query($conn, "  
        INSERT INTO purchases   
        (product_id, vendor_id, purchase_price, quantity, image)  
        VALUES  
        ('$product_id','$vendor_id','$purchase_price','$qty','$img')  
    ");  

    header("Location: products.php");  
    exit();  
}  
?>      

<!DOCTYPE html>  
<html>  
<head>  
<title>Product Management</title>  
<link rel="stylesheet" href="products.css">  
</head>  

<body>  

<?php include("admin_menu.php"); ?>  

<div class="main-content">  

<div class="topbar">  
  <h2>Product Management</h2>  
</div>  

<!-- SEARCH -->  
<form method="GET" class="card">  
<h3>Search Product</h3>  
<input type="text" name="search" placeholder="Search Product / Category / Vendor" value="<?= htmlspecialchars($searchQuery) ?>">  
<button type="submit">Search</button>  
<a href="products.php">Reset</a>  
</form>  

<!-- ADD PRODUCT -->  
<form method="POST" enctype="multipart/form-data" class="card">  

<h3>Add New Product</h3>  

<select name="category_id" required>  
<option value="">Select Category</option>  
<?php while($c = mysqli_fetch_assoc($cats)) { ?>  
<option value="<?= $c['category_id'] ?>"><?= $c['category_name'] ?></option>  
<?php } ?>  
</select>  

<select name="vendor_id" required>  
<option value="">Select Vendor</option>  
<?php while($v = mysqli_fetch_assoc($vendors)) { ?>  
<option value="<?= $v['vendor_id'] ?>"><?= $v['vendor_name'] ?></option>  
<?php } ?>  
</select>  

<input type="text" name="product_name" placeholder="Product Name" required>  
<input type="number" name="purchase_price" placeholder="Purchase Price" required>  
<input type="number" name="price" placeholder="Selling Price" required>  
<input type="number" name="quantity" placeholder="Quantity" required>  
<textarea name="description" placeholder="Description"></textarea>  
<input type="file" name="image" required>  

<button type="submit" name="add_product">Add Product</button>  

</form>  

<br>  

<div class="table-wrapper">  

<table class="data-table">  

<tr>  
<th>ID</th>  
<th>Image</th>  
<th>Name</th>  
<th>Category</th>  
<th>Vendor</th>  
<th>Purchase Price</th>  
<th>Selling Price</th>  
<th>Qty</th>  
<th>Description</th>  
<th>Purchase Date</th>  
<th>Actions</th>  
</tr>  

<?php while($p = mysqli_fetch_assoc($products)) { ?>  

<tr>  
<td><?= $p['product_id'] ?></td>  
<td><img src="uploads/<?= $p['image'] ?>" width="50"></td>  
<td><?= $p['product_name'] ?></td>  
<td><?= $p['category_name'] ?></td>  
<td><?= $p['vendor_name'] ?? 'No Vendor' ?></td>  
<td><?= $p['last_purchase_price'] ?? 'N/A' ?></td>  
<td><?= $p['price'] ?></td>  
<td>
<?= $p['quantity'] ?> 
<?php if($p['quantity'] < 50) { ?>
<span style="color:red;font-weight:bold;">Low Stock</span>
<?php } ?>
</td>  
<td><?= $p['description'] ?></td>  
<td>
<?= !empty($p['last_purchase_date']) ? date('d-m-Y h:i A', strtotime($p['last_purchase_date'])) : 'N/A' ?>
</td>  
<td>
<a href="product_edit.php?id=<?= $p['product_id'] ?>">Edit</a> |
<a href="product_delete.php?id=<?= $p['product_id'] ?>">Delete</a>
</td>  

</tr>  

<?php } ?>  

</table>  

</div>  

</div>  

</body>  
</html>