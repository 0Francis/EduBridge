<?php
class Database {
    private $pdo;
    
    public function __construct($config) {
        // Validate config array
        if (!isset($config['host']) || !isset($config['port']) || !isset($config['dbname'])) {
            die("Invalid database configuration. Check your config.php file.");
        }
        
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getPdo() {
        return $this->pdo;
    }
}
?>