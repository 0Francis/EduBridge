<?php
$page_title = "Dashboard";
include 'header.php';
?>

<div class="card shadow p-4">
  <h3>Welcome to your Dashboard</h3>
  <p class="mb-4">This is your main control panel where you can view and manage your account details.</p>
  <hr>
  <p><strong>User:</strong> <?php echo isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Guest'; ?></p>
  <p><strong>Email:</strong> <?php echo isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : 'Not logged in'; ?></p>
</div>

<?php include 'footer.php'; ?>
