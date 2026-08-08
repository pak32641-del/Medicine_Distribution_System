<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background: #f4f6f9;
  color: #333;
}

/* ===== Hamburger (mobile only) ===== */
.hamburger-admin {
  display: none;
  position: fixed;
  top: 12px;
  left: 12px;
  z-index: 999;
  background: #009688;
  border: none;
  border-radius: 6px;
  padding: 8px 10px;
  cursor: pointer;
  flex-direction: column;
  gap: 5px;
}

.hamburger-admin span {
  display: block;
  width: 22px;
  height: 3px;
  background: #fff;
  border-radius: 3px;
}

/* ===== Overlay (mobile) ===== */
.sidebar-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.4);
  z-index: 99;
}

.sidebar-overlay.open {
  display: block;
}

/* ===== Sidebar ===== */
.sidebar {
  width: 230px;
  background: #009688;
  color: #fff;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  overflow-y: auto;
  padding-top: 15px;
  z-index: 100;
  transition: transform 0.3s ease;
}

.sidebar h1 {
  text-align: center;
  font-size: 22px;
  color: #fff;
}

.sidebar h2 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 15px;
  padding: 0 10px;
  color: #e0f2f1;
}

.sidebar ul {
  list-style: none;
  padding-bottom: 20px;
}

.sidebar ul li {
  margin: 5px 0;
}

.sidebar ul li a {
  display: block;
  padding: 11px 20px;
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  transition: 0.3s;
  background: #2adcf0;
  margin: 0 20px;
  border-radius: 5px;
  text-align: center;
}

.sidebar ul li a:hover,
.sidebar ul li a.active {
  background: #00796b;
  border-left: 4px solid #fff;
}

#logout {
  background: #e53935;
  margin: 15px;
  text-align: center;
  border-radius: 5px;
}

#logout:hover {
  background: #dc0c09;
  border-left: 4px solid white;
}

/* ===== Main Content offset ===== */
.main-content {
  margin-left: 230px;
  transition: margin-left 0.3s ease;
}

/* =============================================
   RESPONSIVE
============================================= */
@media (max-width: 768px) {

  /* Show hamburger */
  .hamburger-admin {
    display: flex;
  }

  /* Hide sidebar off-screen by default */
  .sidebar {
    transform: translateX(-100%);
  }

  /* Show sidebar when open */
  .sidebar.open {
    transform: translateX(0);
  }

  /* Main content takes full width */
  .main-content {
    margin-left: 0;
    padding-top: 55px; /* space for hamburger button */
  }
}
</style>

<!-- Hamburger Button (mobile only) -->
<button class="hamburger-admin" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
  <span></span>
  <span></span>
  <span></span>
</button>

<!-- Overlay (closes sidebar when tapped outside) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="adminSidebar">
  <h1>IA</h1>
  <h2>Medicine Distributor</h2>
  <ul>
    <li><a href="admin_home.php"           class="<?= ($current_page=='admin_home.php')           ? 'active':'' ?>">Dashboard</a></li>
    <li><a href="categories.php"           class="<?= ($current_page=='categories.php')           ? 'active':'' ?>">Categories</a></li>
    <li><a href="vendors.php"              class="<?= ($current_page=='vendors.php')              ? 'active':'' ?>">Vendors</a></li>
    <li><a href="purchase_history.php"     class="<?= ($current_page=='purchase_history.php')     ? 'active':'' ?>">Purchase History</a></li>
    <li><a href="products.php"             class="<?= ($current_page=='products.php')             ? 'active':'' ?>">Products</a></li>
    <li><a href="orders.php"               class="<?= ($current_page=='orders.php')               ? 'active':'' ?>">Orders</a></li>
    <li><a href="reports.php"              class="<?= ($current_page=='reports.php')              ? 'active':'' ?>">Reports</a></li>
    <li><a href="feedback_admin.php"       class="<?= ($current_page=='feedback_admin.php')       ? 'active':'' ?>">Feedback</a></li>
    <li><a href="admin_contact_update.php" class="<?= ($current_page=='admin_contact_update.php') ? 'active':'' ?>">Contact Info</a></li>
    <li><a href="admin_logout.php" id="logout">Logout</a></li>
  </ul>
</aside>

<script>
function toggleSidebar() {
  document.getElementById("adminSidebar").classList.toggle("open");
  document.getElementById("sidebarOverlay").classList.toggle("open");
}
</script>