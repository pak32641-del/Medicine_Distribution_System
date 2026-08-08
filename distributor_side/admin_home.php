<?php  
session_start();  
if(!isset($_SESSION['admin_id'])){  
  header("Location: admin_login.php");  
  exit();  
}  
?>  
  
<?php  
include("connection.php");  
  
// ===== FETCH COUNTS ===== //  
$categoryCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories"))['total'];  
$productCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];  
$orderCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];  
$pendingOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE status='Pending'"))['total'];  
$completedOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE status='Completed'"))['total'];  
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM orders WHERE status='Completed'"))['total'];  
$vendorCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM vendors"))['total'];  
// NEW: Low Stock Products (quantity < 10)
$lowStockCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products WHERE quantity < 50"))['total'];  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Distributor Dashboard | Home</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <?php
    include("admin_menu.php");
    ?>

  <!-- ===== Main Content ===== -->
  <main class="main-content">
    <header class="topbar">
      <h2>Distributor Dashboard</h2>
    </header>

    <section class="dashboard-cards">
      <div class="card">
        <a href="categories.php">
        <h3><?= $categoryCount ?></h3>
        <p>Total Categories</p>
        </a>
      </div>
      <div class="card">
        <a href="products.php">
        <h3><?= $productCount ?></h3>
        <p>Total Products</p>
        </a>
      </div>
      <div class="card">
        <a href="orders.php">
        <h3><?= $orderCount ?></h3>
        <p>Total Orders</p>
        </a>
      </div>
      <div class="card">
        <a href="orders.php? status=Pending">
        <h3><?= $pendingOrders ?></h3>
        <p>Pending Orders</p>
        </a>
      </div>
      <div class="card">
        <a href="orders.php? status=Completed">
        <h3><?= $completedOrders ?></h3>
        <p>Completed Orders</p>
        </a>
      </div>
      <div class="card">
        <a href="reports.php">
        <h3>PKR <?= number_format($totalSales ?? 0) ?></h3>
        <p>Total Sales</p>
        </a>
      </div>
      <div class="card">  
        <a href="vendors.php">
        <h3><?= $vendorCount ?></h3>  
        <p>Total Vendors</p> 
        </a> 
      </div>  
      <div class="card">  
        <a href="products.php? filter=low_stock">
       <h3><?= $lowStockCount ?></h3>  
       <p>Low Stock Items</p> 
       </a> 
      </div>
    </section>
  </main>
</div>

</body>
</html>