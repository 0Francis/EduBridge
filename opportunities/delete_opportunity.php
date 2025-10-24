<?php
require_once '../Databases/databse.php';

if (isset($_GET['id'])) {
  $stmt = $conn->prepare("DELETE FROM opportunities WHERE id=?");
  $stmt->execute([$_GET['id']]);
  header('Location: view_opportunities.php');
}
?>
