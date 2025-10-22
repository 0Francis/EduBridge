<?php
$page_title = "Change Password";
include 'header.php';
?>

<div class="d-flex align-items-center justify-content-center vh-75">
  <div class="card shadow p-4" style="width: 25rem;">
    <h4 class="text-center mb-4">Change Password</h4>
    <form action="changepassword.php" method="POST">
      <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Update Password</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
