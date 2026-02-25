<?php
require '../config/db.php';

$email = $_POST['email'];
$newName = $_POST['name'];

$result = $db->users->updateOne(
    ['email' => $email],
    ['$set' => ['name' => $newName]]
);

echo "User Updated Successfully";
?>