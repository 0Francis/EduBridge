<?php
require_once '../Database/database.php';

$db = new Database();

// Sample test data for youthprofiles
$testYouths = [
    [
        'fullname' => 'John Mwangi',
        'dateofbirth' => '2000-05-15',
        'educationlevel' => 'University',
        'interests' => 'Programming, Sports',
        'availability' => 'Full-time',
        'bio' => 'Computer science student'
    ],
    [
        'fullname' => 'Mary Wanjiku',
        'dateofbirth' => '2002-08-22',
        'educationlevel' => 'Secondary',
        'interests' => 'Art, Music',
        'availability' => 'Part-time',
        'bio' => 'High school student'
    ],
    [
        'fullname' => 'James Omondi',
        'dateofbirth' => '1999-12-10',
        'educationlevel' => 'Vocational',
        'interests' => 'Mechanics, Engineering',
        'availability' => 'Full-time',
        'bio' => 'Vocational training graduate'
    ]
];

foreach ($testYouths as $youth) {
    try {
        // First create user
        $username = strtolower(str_replace(' ', '.', $youth['fullname'])) . rand(100, 999);
        $tempPassword = password_hash('password', PASSWORD_DEFAULT);
        
        $userSql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'Youth')";
        $userStmt = $db->conn->prepare($userSql);
        $userStmt->execute([$username, $tempPassword]);
        $userid = $db->conn->lastInsertId();

        // Then create youth profile
        $sql = "INSERT INTO youthprofiles (youthid, fullname, dateofbirth, educationlevel, interests, availability, bio) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->conn->prepare($sql);
        $stmt->execute([
            $userid,
            $youth['fullname'],
            $youth['dateofbirth'],
            $youth['educationlevel'],
            $youth['interests'],
            $youth['availability'],
            $youth['bio']
        ]);
        
    } catch(PDOException $e) {
        echo "Error inserting " . $youth['fullname'] . ": " . $e->getMessage() . "<br>";
    }
}

echo "Test data inserted successfully! <a href='youth_dashboard.php'>Go to Dashboard</a>";
?>