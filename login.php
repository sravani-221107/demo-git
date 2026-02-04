<?php
include "connect.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //clean input
    $email=trim($email);
    $password=trim($password);
    //case handling
    $email=strtolower($email);
    //database check
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "Login successful";
    } else {
        echo "Invalid email or password";
    }
    //string comparision
    if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
    if(strcmp($row['password'],$password)==0){
        echo "Login successful";
    }
    else{
        print"password does not match";
    }
}
    else{
        print"invalid email";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>User Login</h2>

<form action="login.php" method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

</body>
</html>














































