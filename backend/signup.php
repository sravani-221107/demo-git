<?php
require '../config/db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if(empty($name) || empty($email) || empty($password)){
    die("All fields required");
}

if(strlen($password) < 6){
    die("Password must be at least 6 characters");
}

$existingUser = $db->users->findOne(['email' => $email]);

if($existingUser){
    die("Email already exists");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$result = $db->users->insertOne([
    'name' => $name,
    'email' => $email,
    'password' => $hashedPassword
]);

echo "Signup successful!";
?>