<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="aboutus.css" />
</head>
<body>

  <!-- ====== Header / Navbar ====== -->
  <?php
    include("menu.php");
    ?>


  <!-- ====== About Us Section ====== -->
  <section class="about">
    <h1>Online Medicine Distribution Management System</h1>
    <p class="subtitle">
      Trusted Online Medicine Distribution Platform: Safe, Fast & Reliable
    </p>

    <div class="about-content">
      <p>
        Online Medicine Distribution Management System provide a modern digital solution for medicine distribution in Pakistan.
        With secure ordering, real-time stock updates, and user dashboards — IA Medicine Distributor
        ensures smooth communication between distributors and buyers.
      </p>
<br>
      <p>
        Online Medicine Distribution Management System make the medicine supply process simpler, faster, and more transparent.
        Our platform connects pharmacies and medical stores with authorized medicine 
        distributor,ensuring timely delivery, accurate inventory control, and 
        reliable ordering services.
      </p>
    </div>
  </section>

  <!-- ====== Mission & Vision ====== -->
  <section class="mission-vision">
    <div class="box">
      <h2>Our Mission</h2>
      <p>
        To provide a fast, secure, and efficient digital medicine distribution 
        that empowers pharmacies and saves time for healthcare providers.
      </p>
    </div>
  </section>

 
  <footer>
     <p>© 2025 IA Medicine Distributor. All rights reserved.</p>
  </footer>

</body>
</html>