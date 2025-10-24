<?php
require_once '../../config.php';
require_once '../../db.php';
session_start();

$pdo = getDBConnection();
$org_id = $_SESSION['org_id'];

$stmt = $pdo->prepare("SELECT * FROM organizations WHERE org_id = ?");
$stmt->execute([$org_id]);
$org = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($org);
?>
