<?php
require_once '../Databases/databse.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['opportunity_id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $skills = $_POST['skills_required'];
    $duration = $_POST['duration'];
    $deadline = $_POST['deadline'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("
            UPDATE opportunities 
            SET title=?, description=?, skills_required=?, duration=?, deadline=?, location=?, category=?, status=? 
            WHERE opportunity_id=?
        ");
        $stmt->execute([$title, $desc, $skills, $duration, $deadline, $location, $category, $status, $id]);
        echo "<script>alert('✅ Opportunity updated successfully!'); window.location='../frontend/list.html';</script>";
    } catch (PDOException $e) {
        echo "❌ Update failed: " . $e->getMessage();
    }
}
?>
