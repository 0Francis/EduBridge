<?php
require_once '../Databases/Database.php';

class YouthController {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    public function createYouth($data) {
        $sql = "INSERT INTO youth (name, dob, gender, phone_no, education_level, email, skills, bio) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['dob'],
            $data['gender'],
            $data['phone_no'],
            $data['education_level'],
            $data['email'],
            $data['skills'],
            $data['bio']
        ]);
    }
    
    public function getYouth($id) {
        $sql = "SELECT * FROM youth WHERE youth_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllYouths() {
        $sql = "SELECT * FROM youth ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateYouth($id, $data) {
        $sql = "UPDATE youth 
                SET name = ?, dob = ?, gender = ?, phone_no = ?, 
                    education_level = ?, email = ?, skills = ?, bio = ?
                WHERE youth_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['dob'],
            $data['gender'],
            $data['phone_no'],
            $data['education_level'],
            $data['email'],
            $data['skills'],
            $data['bio'],
            $id
        ]);
    }
    
    public function deleteYouth($id) {
        $sql = "DELETE FROM youth WHERE youth_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>