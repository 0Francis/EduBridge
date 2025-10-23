<?php
require_once '../Databases/database.php';

if ($_POST) {
    $db = new Database();
    
    $fullname = $_POST['fullname'];
    $dateofbirth = $_POST['dateofbirth'];
    $educationlevel = $_POST['educationlevel'];
    $interests = $_POST['interests'] ?? '';
    $availability = $_POST['availability'] ?? '';
    $bio = $_POST['bio'] ?? '';

    try {
        // First create a user record (required by foreign key)
        $userSql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'Youth')";
        $userStmt = $db->conn->prepare($userSql);
        $username = strtolower(str_replace(' ', '.', $fullname)) . rand(100, 999);
        $tempPassword = password_hash('password', PASSWORD_DEFAULT); // Temporary password
        $userStmt->execute([$username, $tempPassword]);
        $userid = $db->conn->lastInsertId();

        // Then create youth profile
        $sql = "INSERT INTO youthprofiles (youthid, fullname, dateofbirth, educationlevel, interests, availability, bio) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->conn->prepare($sql);
        $stmt->execute([$userid, $fullname, $dateofbirth, $educationlevel, $interests, $availability, $bio]);
        
        echo "Youth profile created successfully! User ID: " . $userid;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Add this form for testing -->
<form method="POST" action="">
    <h2>Create Youth Profile</h2>
    
    <label>Full Name:</label>
    <input type="text" name="fullname" required>
    
    <label>Date of Birth:</label>
    <input type="date" name="dateofbirth" required>
    
    <label>Education Level:</label>
    <select name="educationlevel" required>
        <option value="Primary">Primary</option>
        <option value="Secondary">Secondary</option>
        <option value="University">University</option>
        <option value="Vocational">Vocational</option>
    </select>
    
    <label>Interests:</label>
    <textarea name="interests"></textarea>
    
    <label>Availability:</label>
    <input type="text" name="availability" placeholder="e.g., Full-time, Part-time">
    
    <label>Bio:</label>
    <textarea name="bio"></textarea>
    
    <button type="submit">Create Profile</button>
</form>