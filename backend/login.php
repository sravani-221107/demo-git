<?php
session_start();
require '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$user = $db->users->findOne(['email' => $email]);

if(!$user){
    die("User not found");
}

if(password_verify($password, $user['password'])){
    $_SESSION['user'] = $user['name'];
    header("Location: ../public/dashboard.php");
} else {
    echo "Invalid password";
}
?>