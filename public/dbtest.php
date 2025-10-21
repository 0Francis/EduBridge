<?php
// Load config using correct path
$config = require __DIR__ . '/../config.php';

// Check if config loaded correctly
if (!isset($config['db'])) {
    die("Config loaded but 'db' section is missing. Check config.php structure.");
}

require_once __DIR__ . '/../classes/Database.php';

try {
    $database = new Database($config['db']);
    $pdo = $database->getPdo();
    
    // Test connection
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $result = $stmt->fetch();
    
    echo "<h1 style='color: green;'>✅ Database Connection SUCCESSFUL!</h1>";
    echo "<p>PostgreSQL Server Time: " . $result['current_time'] . "</p>";
    echo "<p>Database Name: edubridge</p>";
    
} catch (Exception $e) {
    echo "<h1 style='color: red;'>❌ Database Connection FAILED</h1>";
    echo "<pre>Error: " . $e->getMessage() . "</pre>";
    
    // Show connection details (without password)
    echo "<h3>Connection Details:</h3>";
    echo "<p>Host: " . $config['db']['host'] . "</p>";
    echo "<p>Port: " . $config['db']['port'] . "</p>";
    echo "<p>Database: " . $config['db']['dbname'] . "</p>";
    echo "<p>User: " . $config['db']['user'] . "</p>";
}
?>
