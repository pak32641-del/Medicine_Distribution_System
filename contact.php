<?php
session_start();
include("connection.php");

// Fetch Contact Information
$query = mysqli_query($conn,"SELECT * FROM contact_info LIMIT 1");
$contact = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | MedStore</title>
  <link rel="stylesheet" href="contact.css" />
</head>

<body>

<!-- ====== Header / Navbar ====== -->
<?php include("menu.php"); ?>

<!-- ====== Contact Section ====== -->
<section class="contact-section">
  <h1>Contact Us</h1>
  <p>If you have questions, orders, complaints, or business inquiries — contact us anytime.</p>

  <div class="contact-container">

    <!-- Distributor Contact Info -->
    <div class="contact-info">
      <h2>Contact Information</h2>

      <p><strong>Company Name:</strong>
        <?= $contact['company_name'] ?? "Not Available"; ?>
      </p>

      <p><strong>Registered Owners:</strong>
        <?= $contact['owners'] ?? "Not Available"; ?>
      </p>

      <p><strong>Address:</strong>
        <?= $contact['address'] ?? "Not Available"; ?>
      </p>

      <p><strong>Phone:</strong>
        <?= $contact['phone'] ?? "Not Available"; ?>
      </p>

      <p><strong>WhatsApp:</strong>
        <?= $contact['whatsapp'] ?? "Not Available"; ?>
      </p>

      <p><strong>Email:</strong>
        <?= $contact['email'] ?? "Not Available"; ?>
      </p>

      <p><strong>Working Hours:</strong>
        <?= $contact['working_hours'] ?? "Not Available"; ?>
      </p>

    </div>

  </div>

</section>

<!-- ====== Footer ====== -->
<footer>
  <p>© 2025 IA Medicine Distributor. All rights reserved.</p>
</footer>

</body>
</html>