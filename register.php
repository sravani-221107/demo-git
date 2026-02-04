<?php
include "connect.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //string functions
    $name=trim($name);//to remove spaces we use trim
    $email=trim($email);
    $password=trim($password);

    //validate length
    if(strlen($name)<3){
        die("Name must contain atleast 3 characters");
    }
    if(strlen($password)<8){
        die('password must be atleast 8 charcters');
    }
    //format input
    $name=ucwords(strtolower($name));
    $email=strtolower($email);
    //insert into database
    $query = "INSERT INTO users (name, email, password)
              VALUES ('$name', '$email', '$password')";

    mysqli_query($conn, $query);

    echo "Registration successful";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>User Registration</h2>
<form action="register.php" method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit" name="register">Register</button>
</form>
</body>
</html>







































