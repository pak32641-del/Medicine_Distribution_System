<?php
include("connection.php");

// Fetch All Feedback with User Info (Optional Join)
$feedback = mysqli_query($conn,"
SELECT f.*, u.full_name 
FROM feedback f
LEFT JOIN users u ON f.user_id = u.user_id
ORDER BY f.feedback_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Feedback Management</title>
<link rel="stylesheet" href="feedback_admin.css">
</head>

<body>
<?php
    include("admin_menu.php");
    ?>
<!-- ===== Main Content ===== -->
<main class="main-content">

<div class="topbar">
  <h2>Customer Feedback</h2>
</div>

<table class="data-table">
<thead>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>Remarks</th>
  <th>Date</th>
  <th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = mysqli_fetch_assoc($feedback)) { ?>
<tr>
  <td>#<?= $row['feedback_id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['remarks'] ?></td>
  <td><?= $row['created_at'] ?></td>

  <td>
    <a href="delete_feedback.php?id=<?= $row['feedback_id'] ?>"
       class="delete-btn"
       onclick="return confirm('Delete this feedback?')">
       Delete
    </a>
  </td>

</tr>
<?php } ?>
</tbody>
</table>

</main>
</div>

</body>
</html>