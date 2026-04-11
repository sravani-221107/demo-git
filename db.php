<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mongoUri = $_ENV['MONGODB_URI'] ?? 'mongodb://127.0.0.1:27017';
$mongoDbName = $_ENV['MONGODB_DB'] ?? 'web_technology_db';

try {
    $mongoClient = new MongoDB\Client($mongoUri);
    // Select the database
    $db = $mongoClient->$mongoDbName;
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>