<?php
include 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $loc = $_POST['location'];
  $deadline = $_POST['deadline'];
  $org_id = 1; // for now, hardcode your test org ID or use $_SESSION['org_id']

  $stmt = $conn->prepare("INSERT INTO opportunities (org_id, title, description, location, deadline) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$org_id, $title, $desc, $loc, $deadline]);

  echo "<script>alert('Opportunity created successfully!'); window.location='view_opportunities.php';</script>";
}
