<?php
session_start();
include("connection.php");

// Fetch Categories
$cats = mysqli_query($conn,"SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Online Med Distributor | Home</title>
  <link rel="stylesheet" href="home.css" />
   <link rel="stylesheet" href="categories.css" />
</head>
<body>
  <!-- ====== Header / Navbar ====== -->
 
  <?php
    include("menu.php");
    ?>

  <!-- ====== Hero Section ====== -->
  <section class="hero">
    <h1>WELCOME TO Online Medicine Distribution Management system</h1>
    <p>Browse All Categories and Order Multiple Products in One Go</p>
    <div class="banner">
      <img src="banner.jpg" alt="banner image">
    </div>
  </section>

  <!-- ====== Featured Section ====== -->
  <section >
    <h2>Popular Categories</h2>

    <div class="category-grid">

  <?php 
  if(mysqli_num_rows($cats) > 0){
    while($c = mysqli_fetch_assoc($cats)){ ?>

      <div class="category-card" 
        onclick="openCategory('product_category.php?id=<?= $c['category_id']; ?>')">

        <img src="distributor_side/uploads/<?= $c['image']; ?>" 
             alt="<?= $c['category_name']; ?>" />

        <h3><?= $c['category_name']; ?></h3>
      </div>

  <?php } } else { ?>
      <p style="text-align:center;">No Categories Found</p>
  <?php } ?>

  </div>
  </section>

  <!-- ====== Footer ====== -->
  <footer>
     <p>© 2025 IA Medicine Distributor. All rights reserved.</p>
  </footer>
  <script>
function openCategory(page){
  window.location.href = page;
}
</script>
</body>
</html>