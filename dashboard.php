<?php
session_start();

// Ensure the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Secure Portal</title>
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
            flex-direction: column;
            align-items: center;
            color: #fff;
            padding: 50px 20px;
        }

        .header {
            width: 100%;
            max-width: 900px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logout-btn {
            padding: 10px 20px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .content {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            text-align: center;
            animation: fadeIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes fadeIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .welcome-text {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .welcome-subtext {
            font-size: 18px;
            color: #94a3b8;
            margin-bottom: 40px;
        }

        .actions {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            width: 250px;
            text-decoration: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .action-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #60a5fa;
        }

        .action-card p {
            font-size: 14px;
            color: #94a3b8;
        }

        .action-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
            border-color: #60a5fa;
            box-shadow: 0 10px 25px rgba(96, 165, 250, 0.2);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Secure Portal</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="content">
        <h2 class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <p class="welcome-subtext">You have successfully logged in using your MongoDB account.</p>

        <div class="actions">
            <a href="manage_users.php" class="action-card">
                <h3>Manage Users</h3>
                <p>View, update, and delete user accounts securely.</p>
            </a>
            <!-- Additional features can go here -->
        </div>
    </div>
</body>
</html>
