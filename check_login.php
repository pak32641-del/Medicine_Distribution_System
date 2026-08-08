This is check_login.php page:
<?php
session_start();

if(isset($_SESSION['user_id'])){
    echo "LOGGED_IN";
} else {
    echo "NOT_LOGGED_IN";
}
?>
