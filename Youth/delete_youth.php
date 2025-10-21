<?php
require_once '../database/database.php';

$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        
        $check_sql = "SELECT * FROM youths WHERE id = ?";
        $check_stmt = $db->conn->prepare($check_sql);
        $check_stmt->execute([$id]);
        $youth = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($youth) {
        
            $sql = "DELETE FROM youths WHERE id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->execute([$id]);
            
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