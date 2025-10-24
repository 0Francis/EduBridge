<?php
require_once '../Databases/databse.php';
session_start();

$org_id = $_SESSION['org_id'] ?? 1; // for demo

$stmt = $conn->prepare("SELECT * FROM opportunities WHERE org_id = ? ORDER BY created_at DESC");
$stmt->execute([$org_id]);

$opps = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($opps);
?>
