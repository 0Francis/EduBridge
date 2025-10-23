<?php
require_once '../Databases/database.php';

class YouthReader {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    public function getAllYouths() {
        $sql = "SELECT * FROM youth ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getYouthById($id) {
        $sql = "SELECT * FROM youth WHERE youth_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$youthReader = new YouthReader();
$allYouths = $youthReader->getAllYouths();

echo "<h2>All Youth Profiles</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Date of Birth</th><th>Gender</th><th>Phone</th><th>Education Level</th><th>Email</th><th>Skills</th><th>Bio</th><th>Date Joined</th><th>Actions</th></tr>";

foreach ($allYouths as $youth) {
    echo "<tr>";
    echo "<td>{$youth['youth_id']}</td>";
    echo "<td>{$youth['name']}</td>";
    echo "<td>{$youth['dob']}</td>";
    echo "<td>{$youth['gender']}</td>";
    echo "<td>{$youth['phone_no']}</td>";
    echo "<td>{$youth['education_level']}</td>";
    echo "<td>{$youth['email']}</td>";
    echo "<td>{$youth['skills']}</td>";
    echo "<td>{$youth['bio']}</td>";
    echo "<td>{$youth['date_joined']}</td>";
    echo "<td>
            <a href='update_youth.php?id={$youth['youth_id']}'>Edit</a> | 
            <a href='delete_youth.php?id={$youth['youth_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>