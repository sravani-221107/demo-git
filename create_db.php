<?php
require_once __DIR__ . '/vendor/autoload.php';

$mongoUri = 'mongodb://127.0.0.1:27017';
$mongoDbName = 'web_technology_db';

try {
    $mongoClient = new MongoDB\Client($mongoUri);
    $db = $mongoClient->$mongoDbName;
    
    // Insert a dummy document to force the database and collection to materialize
    $collection = $db->users;
    $collection->insertOne([
        'name' => 'Demo User',
        'email' => 'demo@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
    
    echo "Dummy user inserted successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
