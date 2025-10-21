<?php
require_once '../database/database.php';

class YouthReader {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    
    public function getAllYouths() {
        $sql = "SELECT * FROM youths ORDER BY created_at DESC";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getYouthById($id) {
        $sql = "SELECT * FROM youths WHERE id = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


$youthReader = new YouthReader();
$allYouths = $youthReader->getAllYouths();


echo "<h2>All Youth Profiles</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Education</th><th>Actions</th></tr>";

foreach ($allYouths as $youth) {
    echo "<tr>";
    echo "<td>{$youth['id']}</td>";
    echo "<td>{$youth['name']}</td>";
    echo "<td>{$youth['email']}</td>";
    echo "<td>{$youth['phone_number']}</td>";
    echo "<td>{$youth['education_level']}</td>";
    echo "<td>
            <a href='update_youth.php?id={$youth['id']}'>Edit</a> | 
            <a href='delete_youth.php?id={$youth['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>