<?php
require_once '../Databases/databse.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM opportunities WHERE opportunity_id = ?");
        $stmt->execute([$id]);
        echo "<script>alert('🗑️ Opportunity deleted successfully!'); window.location='../frontend/list.html';</script>";
    } catch (PDOException $e) {
        echo "❌ Error deleting: " . $e->getMessage();
    }
}
?>

