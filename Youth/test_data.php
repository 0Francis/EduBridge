<?php
require_once '../database/database.php';

$db = new Database();

// Sample test data
$testYouths = [
    [
        'name' => 'John Mwangi',
        'date_of_birth' => '2000-05-15',
        'gender' => 'Male',
        'phone_number' => '0712345678',
        'education_level' => 'University',
        'email' => 'john.mwangi@example.com'
    ],
    [
        'name' => 'Mary Wanjiku',
        'date_of_birth' => '2002-08-22',
        'gender' => 'Female',
        'phone_number' => '0723456789',
        'education_level' => 'Secondary',
        'email' => 'mary.wanjiku@example.com'
    ],
    [
        'name' => 'James Omondi',
        'date_of_birth' => '1999-12-10',
        'gender' => 'Male',
        'phone_number' => '0734567890',
        'education_level' => 'Vocational',
        'email' => 'james.omondi@example.com'
    ]
];

foreach ($testYouths as $youth) {
    $sql = "INSERT INTO youths (name, date_of_birth, gender, phone_number, education_level, email) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->conn->prepare($sql);
    $stmt->execute([
        $youth['name'],
        $youth['date_of_birth'],
        $youth['gender'],
        $youth['phone_number'],
        $youth['education_level'],
        $youth['email']
    ]);
}

echo "Test data inserted successfully! <a href='youth_dashboard.php'>Go to Dashboard</a>";
?>