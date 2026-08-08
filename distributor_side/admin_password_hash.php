<?php
echo password_hash("ihsan12345", PASSWORD_BCRYPT);
?>

<!-- This page is only used for to make admin hash password(encrypted password). 
How to use: change the password in this page here. then Run on Browser like this 
localhost/project/distributor_side/admin_password_hash.php
You will get hash password (encrypted password) then copy this hash password and past into password column of admin table  -->