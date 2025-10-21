<?php
require_once '../database/database.php';

if ($_POST) {
    $db = new Database();
    
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $education_level = $_POST['education_level'];
    $email = $_POST['email'];

    try {
        $sql = "INSERT INTO youths (name, date_of_birth, gender, phone_number, education_level, email) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->conn->prepare($sql);
        $stmt->execute([$name, $date_of_birth, $gender, $phone_number, $education_level, $email]);
        
        echo "Youth profile created successfully!";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

