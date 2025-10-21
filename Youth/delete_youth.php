<?php
require_once '../Database/database.php';

$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Check if youth exists
        $check_sql = "SELECT * FROM youthprofiles WHERE youthid = ?";
        $check_stmt = $db->conn->prepare($check_sql);
        $check_stmt->execute([$id]);
        $youth = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($youth) {
            // Delete from youthprofiles table
            $sql = "DELETE FROM youthprofiles WHERE youthid = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->execute([$id]);
            
            // Also delete from users table
            $user_sql = "DELETE FROM users WHERE userid = ?";
            $user_stmt = $db->conn->prepare($user_sql);
            $user_stmt->execute([$id]);
            
            echo "Youth profile deleted successfully!";
        } else {
            echo "Youth profile not found!";
        }
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    header("refresh:2;url=youth_list.php");
}
?>