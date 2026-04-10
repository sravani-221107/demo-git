<?php
include "db.php";
$msg = "";
$msgType = "";

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
        //string comparision
        $row=mysqli_fetch_assoc($result);
        if(strcmp($row['password'],$password)==0){
            $msg = "Login successful! Welcome back.";
            $msgType = "success";
        }
        else{
            $msg = "Password does not match!";
            $msgType = "error";
        }
    } else {
        $msg = "Invalid email or password!";
        $msgType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Secure Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #09090b, #18181b, #27272a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 450px;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes fadeIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 35px;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            outline: none;
            border-radius: 12px;
            color: #f8fafc;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: #94a3b8;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #60a5fa;
            box-shadow: 0 0 15px rgba(96, 165, 250, 0.2);
            transform: translateY(-2px);
        }

        button {
            width: 100%;
            padding: 16px;
            margin-top: 10px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(59, 130, 246, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .auth-links {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: #94a3b8;
        }

        .auth-links a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            margin-left: 5px;
        }

        .auth-links a:hover {
            color: #93c5fd;
            text-shadow: 0 0 10px rgba(147, 197, 253, 0.5);
        }

        .message {
            text-align: center;
            margin-bottom: 25px;
            padding: 14px;
            border-radius: 10px;
            font-size: 15px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .error {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Decorative glowing orbs */
        .orb-1, .orb-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }

        .separator {
            margin: 25px 0;
            text-align: center;
            position: relative;
        }

        .separator:before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 1;
        }

        .separator span {
            background: #1e1e21; /* Matches dark theme roughly */
            padding: 0 15px;
            color: #94a3b8;
            font-size: 14px;
            position: relative;
            z-index: 2;
        }

        .social-login {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-btn img {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .social-btn.google-btn:hover { border-color: #ea4335; }
        .social-btn.github-btn:hover { border-color: #f0f6fc; }
        .social-btn.firebase-btn:hover { border-color: #ffca28; }

        .orb-1 {
            width: 300px;
            height: 300px;
            background: rgba(59, 130, 246, 0.3);
            top: -100px;
            right: -100px; /* changed side for variety */
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: rgba(139, 92, 246, 0.2);
            bottom: -150px;
            left: -100px; /* changed side for variety */
        }
    </style>
</head>
<body>
    <div class="orb-1"></div>
    <div class="orb-2"></div>

    <div class="container">
        <h2>Welcome Back</h2>
        
        <?php if ($msg != ""): ?>
            <div class="message <?php echo $msgType; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required autocomplete="off">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login">Sign In</button>
        </form>

        <div class="separator"><span>Or continue with</span></div>

        <div class="social-login">
            <a href="google_oauth.php" class="social-btn google-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google"> Google
            </a>
            <a href="github_oauth.php" class="social-btn github-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg" alt="GitHub"> GitHub
            </a>
            <a href="firebase_auth.php" class="social-btn firebase-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/37/Firebase_Logo.svg" alt="Firebase"> Firebase
            </a>
        </div>

        <div class="auth-links">
            <p>Don't have an account?<a href="register.php">Register now</a></p>
        </div>
    </div>
</body>
</html>
