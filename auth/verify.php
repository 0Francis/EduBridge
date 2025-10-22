<?php
$page_title = "Verify Account";
include 'header.php';
?>

<div class="d-flex align-items-center justify-content-center vh-75">
  <div class="card shadow p-4 text-center" style="width: 25rem;">
    <h4 class="mb-3">Verify Your Email</h4>
    <p>Enter the 6-digit code sent to your email address.</p>
    <form action="verify.php" method="POST">
      <div class="mb-3">
        <input type="text" name="verification_code" class="form-control text-center" maxlength="6" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Verify</button>
      <div class="mt-3">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
