<?php
include 'Database.php';
$stmt = $conn->query("SELECT * FROM opportunities ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Opportunities</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <h2>Posted Opportunities</h2>
  <a href="opportunity_form.html" class="btn btn-success mb-3">+ New Opportunity</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th><th>Title</th><th>Location</th><th>Deadline</th><th>Action</th>
    </tr>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['location']) ?></td>
        <td><?= $r['deadline'] ?></td>
        <td>
          <a href="edit_opportunity.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_opportunity.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
