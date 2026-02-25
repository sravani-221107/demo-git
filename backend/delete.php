<?php
require '../config/db.php';

$email = $_POST['email'];

$db->users->deleteOne(['email' => $email]);

echo "User Deleted Successfully";
?>