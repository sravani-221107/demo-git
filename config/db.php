<?php
require '../vendor/autoload.php';

$mongoUri = "mongodb://localhost:27017";

try {
    $client = new MongoDB\Client($mongoUri);
    $db = $client->userDB;
    //echo "Database connected successfully";
} 
catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>