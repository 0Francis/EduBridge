<?php
// Debug: Show current directory and check files
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "    <title>Database Setup - EduBridge</title>";
echo "    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "</head>";
echo "<body>";
echo "    <div class='container mt-5'>";
echo "        <h1>🛠️ EduBridge Database Setup</h1>";

// First, let's check if config.php exists and can be loaded
$configPath = __DIR__ . '/../config.php';
echo "<p>Looking for config at: " . $configPath . "</p>";

if (!file_exists($configPath)) {
    die("<div class='alert alert-danger'>❌ Config file not found at: " . $configPath . "</div>");
}

echo "<div class='alert alert-success'>✅ Config file found</div>";

// Load config
$config = require $configPath;
echo "<pre>Config contents: ";
print_r($config);
echo "</pre>";

if (!isset($config['db'])) {
    die("<div class='alert alert-danger'>❌ 'db' key not found in config</div>");
}

echo "<div class='alert alert-success'>✅ Config loaded successfully</div>";

try {
    // Connect to database
    require_once __DIR__ . '/../classes/Database.php';
    $database = new Database($config['db']);
    $pdo = $database->getPdo();
    
    echo "<div class='alert alert-success'>✅ Connected to database successfully</div>";
    
    // Read and execute SQL file
    $sqlFile = __DIR__ . '/../database.sql';
    if (!file_exists($sqlFile)) {
        die("<div class='alert alert-danger'>❌ SQL file not found: $sqlFile</div>");
    }
    
    $sql = file_get_contents($sqlFile);
    $pdo->exec($sql);
    
    echo "<div class='alert alert-success'>✅ Database tables created successfully!</div>";
    
    // Show created tables
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' ORDER BY table_name");
    $tables = $stmt->fetchAll();
    
    echo "<h3>📊 Created Tables:</h3>";
    echo "<ul class='list-group'>";
    foreach ($tables as $table) {
        echo "<li class='list-group-item'>" . $table['table_name'] . "</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "    </div>";
echo "</body>";
echo "</html>";
?>
