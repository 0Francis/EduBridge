<?php
$page_title = "Reset Password";
include 'header.php';
?>

<div class="d-flex align-items-center justify-content-center vh-75">
  <div class="card shadow p-4" style="width: 25rem;">
    <h4 class="text-center mb-4">Reset Password</h4>
    <form action="resetpassword.php" method="POST">
      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Reset Password</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
