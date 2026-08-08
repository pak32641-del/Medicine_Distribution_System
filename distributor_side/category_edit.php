<?php
include("connection.php");

if(!isset($_GET['id'])){
    die("Category ID Missing!");
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM categories WHERE category_id=$id");
$row = mysqli_fetch_assoc($result);

if(!$row){
    die("Category Not Found!");
}

if(isset($_POST['submit'])){

    $id = $_POST['id'];
    $name = $_POST['category_name'];

    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp,"uploads/".$image);

        mysqli_query($conn,"
            UPDATE categories 
            SET category_name='$name',
                image='$image'
            WHERE category_id=$id
        ");
    } else {
        mysqli_query($conn,"
            UPDATE categories 
            SET category_name='$name'
            WHERE category_id=$id
        ");
    }

    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Category</title>
<link rel="stylesheet" href="categories.css">
<style>
    .admin-container{
        width: 80%;
        margin-left:10%;
        padding: 20px;
    }
</style>
</head>

<body>

<div class="admin-container">


<div class="topbar">
  <h2>Edit Category</h2>
</div>

<form method="POST" enctype="multipart/form-data" class="card">

<h3>Update Category</h3>

<input type="hidden" name="id" value="<?= $row['category_id'] ?>">

<label>Category Name</label>
<input type="text" name="category_name" value="<?= $row['category_name'] ?>" required>

<label>Current Image</label><br><br>
<img src="uploads/<?= $row['image'] ?>" width="120" style="border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.2);"><br><br>

<label>Upload New Image (Optional)</label>
<input type="file" name="image">

<button type="submit" name="submit">Update Category</button>

</form>

</div>
</div>

</body>
</html>