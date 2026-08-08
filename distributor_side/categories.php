<?php
include("connection.php");
$result = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Category Management</title>
  <link rel="stylesheet" href="categories.css">
</head>
<body>
<?php
    include("admin_menu.php");
    ?>

<!-- Main Content -->
<div class="main-content">

<div class="topbar">
  <h2>Category Management</h2>
</div>

<!-- Add Category -->
<form action="category_save.php" method="POST" enctype="multipart/form-data" class="card">
  <h3>Add New Category</h3>

  <input type="text" name="category_name" placeholder="Category Name" required>
  

  <label>Category Image</label>
  <input type="file" name="image" required>

  <button type="submit">Add Category</button>
</form>

<br>

<!-- Category List -->
<table class="data-table">
<tr>
  <th>ID</th>
  <th>Image</th>
  <th>Name</th>
  <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['category_id'] ?></td>
  <td>
    <img src="uploads/<?= $row['image'] ?>" width="60">
  </td>
  <td><?= $row['category_name'] ?></td>
  <td>
    <a style="background-color: hsl(204, 46%, 98%);" href="category_edit.php?id=<?= $row['category_id'] ?>">Edit</a> |
    <a href="category_delete.php?id=<?= $row['category_id'] ?>"
       onclick="return confirm('Delete this category?')">Delete</a>
  </td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>