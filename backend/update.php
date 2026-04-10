<?php
require '../config/db.php';

// 1. Only run this if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Check if the keys actually exist before using them
    if (isset($_POST['email']) && isset($_POST['name'])) {
        $email = $_POST['email'];
        $newName = $_POST['name'];

        // 3. Fixed the MongoDB update syntax
        $result = $db->users->updateOne(
            ['email' => $email],         // Find the user by email
            ['$set' => ['name' => $newName]] // Set the new name
        );

        if ($result->getModifiedCount() > 0) {
            echo "User Updated Successfully";
        } else {
            echo "No changes made or user not found.";
        }
    }
} else {
    echo "Please submit the update form.";
}
?>