<?php
require_once '../Databases/databse.php';
session_start();

// Assuming the org is logged in and org_id is in session
$org_id = $_SESSION['org_id'] ?? 1; // fallback for testing

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $skills = trim($_POST['skills_required']);
    $duration = trim($_POST['duration']);
    $deadline = $_POST['deadline'];
    $location = trim($_POST['location']);
    $category = $_POST['category'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO opportunities (org_id, title, description, skills_required, duration, deadline, location, category, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Open')
        ");
        $stmt->execute([$org_id, $title, $desc, $skills, $duration, $deadline, $location, $category]);
        echo "<script>alert('✅ Opportunity created successfully!'); window.location='../frontend/list.html';</script>";
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>

