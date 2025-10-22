<?php

require_once __DIR__ . '/config.php';

function getDBConnection($dbname = DB_NAME) {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . $dbname . ";charset=utf8mb4";
    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function createDatabaseIfNotExists() {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
}

function initDatabase() {
    createDatabaseIfNotExists();
    $pdo = getDBConnection();

    // TABLE CREATION
    $tables = [

        "youth" => "CREATE TABLE IF NOT EXISTS youth (
            youth_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            dob DATE,
            gender VARCHAR(20),
            phone_no VARCHAR(20),
            education_level VARCHAR(100),
            email VARCHAR(150) UNIQUE NOT NULL,
            skills TEXT,
            bio TEXT,
            date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;",

        "organizations" => "CREATE TABLE IF NOT EXISTS organizations (
            org_id INT AUTO_INCREMENT PRIMARY KEY,
            org_name VARCHAR(200) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            address VARCHAR(255),
            org_type ENUM('Company', 'NGO', 'Training Center', 'Other') DEFAULT 'Other',
            verified BOOLEAN DEFAULT FALSE,
            date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;",

        "opportunities" => "CREATE TABLE IF NOT EXISTS opportunities (
            opportunity_id INT AUTO_INCREMENT PRIMARY KEY,
            org_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            skills_required TEXT,
            duration VARCHAR(100),
            deadline DATE,
            location VARCHAR(255),
            category ENUM('Internship', 'Volunteer', 'Training', 'Other') DEFAULT 'Other',
            status ENUM('Open', 'Closed') DEFAULT 'Open',
            date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (org_id) REFERENCES organizations(org_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;",

        "applications" => "CREATE TABLE IF NOT EXISTS applications (
            application_id INT AUTO_INCREMENT PRIMARY KEY,
            youth_id INT NOT NULL,
            opportunity_id INT NOT NULL,
            date_applied TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
            remarks TEXT,
            FOREIGN KEY (youth_id) REFERENCES youth(youth_id) ON DELETE CASCADE,
            FOREIGN KEY (opportunity_id) REFERENCES opportunities(opportunity_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;",

        "admins" => "CREATE TABLE IF NOT EXISTS admins (
            admin_id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(150) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('Super Admin', 'Verifier', 'Reporter') DEFAULT 'Verifier',
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;",

        "reports" => "CREATE TABLE IF NOT EXISTS reports (
            report_id INT AUTO_INCREMENT PRIMARY KEY,
            generated_by INT,
            report_type VARCHAR(100),
            content TEXT,
            date_generated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (generated_by) REFERENCES admins(admin_id) ON DELETE SET NULL
        ) ENGINE=InnoDB;"
    ];

    foreach ($tables as $sql) {
        $pdo->exec($sql);
    }

    // SAMPLE DATA INSERTION
    $stmt = $pdo->query("SELECT COUNT(*) FROM organizations");
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT INTO organizations (org_name, email, password, org_type) VALUES (?, ?, ?, ?)");
        $sampleOrgs = [
            ["Tech Innovators Ltd", "hr@techinnovators.com", password_hash("123456", PASSWORD_DEFAULT), "Company"],
            ["Youth Empower NGO", "info@youthngo.org", password_hash("123456", PASSWORD_DEFAULT), "NGO"]
        ];
        foreach ($sampleOrgs as $org) {
            $insert->execute($org);
        }
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM opportunities");
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT INTO opportunities (org_id, title, description, skills_required, duration, deadline, location, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $sampleOpps = [
            [1, "Junior Web Developer Internship", "Assist in building websites using HTML, CSS, and JS.", "HTML, CSS, JS", "3 months", "2025-12-01", "Nairobi", "Internship"],
            [2, "Community Volunteer Program", "Engage youth in community service and leadership training.", "Communication, Teamwork", "2 months", "2025-11-20", "Kisumu", "Volunteer"]
        ];
        foreach ($sampleOpps as $opp) {
            $insert->execute($opp);
        }
    }

    return true;
}

// Run initialization and show confirmation
if (initDatabase()) {
    echo "<h2 style='font-family: Arial; color: green; text-align: center;'>✅ EduBridge Database initialized successfully!</h2>";
} else {
    echo "<h2 style='font-family: Arial; color: red; text-align: center;'>❌ Database initialization failed.</h2>";
}
?>
