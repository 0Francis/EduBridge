<?php
$page_title = "Forgot Password";
include 'header.php';
?>

<div class="d-flex align-items-center justify-content-center vh-75">
  <div class="card shadow p-4" style="width: 25rem;">
    <h4 class="text-center mb-4">Forgot Password</h4>
    <form action="forgotpassword.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Enter your email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
      <div class="text-center mt-3">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
