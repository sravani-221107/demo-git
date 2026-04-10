<?php
session_start();
require '../config/db.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
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
}
?>


<!DOCTYPE html>
<html>
<body>
    <form action="login.php" method="POST">
    <input type="email" name="email" required placeholder="email">
    <input type="password" name="password" required placeholder="password">
    <button type="submit">Login</button>
</form>
    
</body>
</html>