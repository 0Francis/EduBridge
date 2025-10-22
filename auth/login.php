<?php
$page_title = "Login";
include 'header.php';
?>

<div class="d-flex align-items-center justify-content-center vh-75">
  <div class="card shadow p-4" style="width: 25rem;">
    <h3 class="text-center mb-4">Login</h3>
    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <div class="text-center mt-3">
        <a href="forgotpassword.php">Forgot Password?</a>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
