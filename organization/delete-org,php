<?php
require_once '../../config.php';
require_once '../../db.php';
session_start();

$pdo = getDBConnection();
$stmt = $pdo->prepare("DELETE FROM organizations WHERE org_id=?");
$stmt->execute([$_SESSION['org_id']]);
session_destroy();

header("Location: ../../index.html?deleted=1");
exit;
?>
