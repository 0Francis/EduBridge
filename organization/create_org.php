<?php
require_once '../../config.php';
require_once '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo = getDBConnection();
  $stmt = $pdo->prepare("
    INSERT INTO organizations (org_name, email, password, phone, address, org_type)
    VALUES (?, ?, ?, ?, ?, ?)
  ");
  $stmt->execute([
    $_POST['org_name'],
    $_POST['email'],
    password_hash($_POST['password'], PASSWORD_DEFAULT),
    $_POST['phone'],
    $_POST['address'],
    $_POST['org_type']
  ]);
  header("Location: ../frontend/dashboard.html?success=1");
  exit;
}
?>
