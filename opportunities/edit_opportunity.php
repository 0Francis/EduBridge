<?php
include 'db_connect.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE id=?");
$stmt->execute([$id]);
$opp = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $loc = $_POST['location'];
  $deadline = $_POST['deadline'];

  $stmt = $conn->prepare("UPDATE opportunities SET title=?, description=?, location=?, deadline=? WHERE id=?");
  $stmt->execute([$title, $desc, $loc, $deadline, $id]);

  echo "<script>alert('Updated successfully!'); window.location='view_opportunities.php';</script>";
}
?>

<form method="POST" class="p-4">
  <input name="title" value="<?= $opp['title'] ?>" class="form-control mb-2">
  <textarea name="description" class="form-control mb-2"><?= $opp['description'] ?></textarea>
  <input name="location" value="<?= $opp['location'] ?>" class="form-control mb-2">
  <input type="date" name="deadline" value="<?= $opp['deadline'] ?>" class="form-control mb-2">
  <button class="btn btn-primary">Update</button>
</form>
