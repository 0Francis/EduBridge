<?php
require_once '../Databases/databse.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo = getDBConnection();
  $stmt = $pdo->prepare("
    UPDATE organizations
    SET org_name=?, phone=?, address=?, org_type=?
    WHERE org_id=?
  ");
  $stmt->execute([
    $_POST['org_name'],
    $_POST['phone'],
    $_POST['address'],
    $_POST['org_type'],
    $_SESSION['org_id']
  ]);
  header("Location: ../frontend/dashboard.html?updated=1");
  exit;
}
?>
