<?php    
if(session_status() === PHP_SESSION_NONE){    
    session_start();    
}    
$current_page = basename($_SERVER['PHP_SELF']);     
?>  

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<style>
* {    
    margin: 0;    
    padding: 0;    
    box-sizing: border-box;    
    font-family: 'Segoe UI', Arial, sans-serif;    
}

/* ================= HEADER ================= */
header {  
    background: linear-gradient(90deg, #009688, #00796b);
    color: #fff;  
    padding: 5px 20px;  
    position: relative;  
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}  

/* Top row */
.nav-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* LOGO (more professional look) */
.logo {
    font-size: 25px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* ================= HAMBURGER ================= */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    background: none;
    border: none;
}

.hamburger span {
    width: 26px;
    height: 3px;
    background: #fff;
    border-radius: 3px;
    transition: 0.3s;
}

/* ================= NAV MENU (SAME ROW) ================= */
.nav-menu {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
    gap: 15px;
    flex-wrap: wrap;
}

/* NAV LINKS */
nav ul {
    list-style: none;
    display: flex;
    gap: 10px;
    align-items: center;
}

nav a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    padding: 6px 10px;
    border-radius: 4px;
    transition: 0.3s;
}

nav a:hover,
nav a.active {
    background: rgba(255,255,255,0.15);
}

/* ================= RIGHT SIDE ================= */
.nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom:8px;
}

/* SEARCH (modern look) */
.nav-search {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    height: 34px;
}

.nav-search input {
    border: none;
    padding: 6px 10px;
    outline: none;
    width: 160px;
    font-size: 14px;
}

.nav-search button {
    border: none;
    background: #fff;
    cursor: pointer;
    padding: 6px 10px;
}

/* CART */
.cart-btn {
    background: #fff;
    color: #009688;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    height: 34px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: 0.3s;
}

.cart-btn:hover {
    background: #e0f2f1;
}

#cartCount {
    background: #e53935;
    color: #fff;
    padding: 3px 7px;
    border-radius: 50%;
    font-size: 12px;
    font-weight: bold;
}

/* BUTTON */
.btn {
    background: #fff;
    color: #009688;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    height: 34px;
    display: flex;
    align-items: center;
}

/* ACCOUNT */
.account-dropdown {
    position: relative;
}

.account-btn {
    background: #fff;
    color: #009688;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    height: 34px;
}

/* DROPDOWN */
.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: #fff;
    min-width: 140px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    border-radius: 8px;
    overflow: hidden;
    z-index: 100;
}

.dropdown-content a {
    display: block;
    padding: 10px;
    color: #009688;
    text-decoration: none;
    font-weight: 500;
}

.dropdown-content a:hover {
    background: #e0f2f1;
}

.account-dropdown:hover .dropdown-content {
    display: block;
}

/* ================= RESPONSIVE (UNCHANGED LOGIC) ================= */
@media (max-width: 768px) {

.hamburger {
    display: flex;
}

.nav-menu {
    display: none;
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
    margin-top: 12px;
    width: 100%;
}

.nav-menu.open {
    display: flex;
}

nav ul {
    flex-direction: column;
    width: 100%;
    gap: 8px;
}

nav a {
    width: 100%;
    padding: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.nav-right {
    width: 100%;
    flex-direction: column;
    align-items: stretch;
}

.nav-search {
    width: 100%;
}

.nav-search input {
    width: 100%;
}

.cart-btn,
.btn,
.account-btn {
    width: 100%;
    justify-content: center;
}

.dropdown-content {
    position: static;
    width: 100%;
    box-shadow: none;
}

}
</style>

</head>

<body>

<header>

<div class="nav-top">
    <div class="logo">💊 IA</div>

    <button class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>

<div class="nav-menu" id="navMenu">

    <nav>
        <ul>
            <li><a href="home.php" class="<?= ($current_page=='home.php')?'active':'' ?>">Home</a></li>
            <li><a href="categories.php" class="<?= ($current_page=='categories.php')?'active':'' ?>">Categories</a></li>
            <li><a href="dashboard.php" class="<?= ($current_page=='dashboard.php')?'active':'' ?>">Dashboard</a></li>
            <li><a href="feedback.php" class="<?= ($current_page=='feedback.php')?'active':'' ?>">Feedback</a></li>
            <li><a href="aboutus.php" class="<?= ($current_page=='aboutus.php')?'active':'' ?>">About Us</a></li>
            <li><a href="contact.php" class="<?= ($current_page=='contact.php')?'active':'' ?>">Contact</a></li>
        </ul>
    </nav>

    <div class="nav-right">

        <div class="nav-search">
            <input type="text" id="searchInput" placeholder="Search medicine...">
            <button onclick="searchMedicine()">🔍</button>
        </div>

        <a href="cart.php" class="cart-btn">🛒 <span id="cartCount">0</span></a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="account-dropdown">
                <button class="account-btn"><?= $_SESSION['user_name'] ?> ▼</button>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="signup.php" class="btn">Create Account</a>
        <?php endif; ?>

    </div>

</div>

</header>
<script src="menu.js"></script>
<script src="product.js"></script>

<script>
function toggleMenu(){
    document.getElementById("navMenu").classList.toggle("open");
}
</script>

</body>
</html>