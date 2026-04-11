<?php
session_start();
include "db.php";

// Ensure the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
$msgType = "";

// Handle Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    try {
        $id = new MongoDB\BSON\ObjectId($_POST['user_id']);
        $result = $db->users->deleteOne(['_id' => $id]);
        
        if ($result->getDeletedCount() > 0) {
            $msg = "User deleted successfully.";
            $msgType = "success";
            // If the user deleted themselves, log them out
            if ($_POST['user_id'] == $_SESSION['user_id']) {
                header("Location: logout.php");
                exit();
            }
        } else {
            $msg = "Failed to delete user.";
            $msgType = "error";
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
        $msgType = "error";
    }
}

// Handle Update User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['user_id'];
    $newName = trim($_POST['name']);
    $newEmail = trim(strtolower($_POST['email']));
    
    try {
        $objectId = new MongoDB\BSON\ObjectId($id);
        
        // Check if the new email already exists for another user
        $existing = $db->users->findOne(['email' => $newEmail, '_id' => ['$ne' => $objectId]]);
        if ($existing) {
            $msg = "Email is already taken by another user.";
            $msgType = "error";
        } else {
            $result = $db->users->updateOne(
                ['_id' => $objectId],
                ['$set' => ['name' => $newName, 'email' => $newEmail]]
            );
            
            if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
                $msg = "User updated successfully.";
                $msgType = "success";
                
                // Update session if it's the current user
                if ($id == $_SESSION['user_id']) {
                    $_SESSION['user_name'] = ucwords($newName);
                    $_SESSION['user_email'] = $newEmail;
                }
            } else {
                $msg = "No changes made or update failed.";
                $msgType = "error";
            }
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
        $msgType = "error";
    }
}

// Fetch all users
$users = [];
try {
    $cursor = $db->users->find([], ['sort' => ['created_at' => -1]]);
    foreach ($cursor as $document) {
        $users[] = $document;
    }
} catch (Exception $e) {
    $msg = "Error fetching users: " . $e->getMessage();
    $msgType = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Secure Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            color: #f8fafc;
            padding: 50px 20px;
        }

        .header {
            width: 100%;
            max-width: 1000px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links a {
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .message {
            width: 100%;
            max-width: 1000px;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 15px;
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

        .table-container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        th {
            background: rgba(0, 0, 0, 0.2);
            color: #94a3b8;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .action-form {
            display: inline-flex;
            gap: 10px;
            align-items: center;
        }
        
        .inline-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            outline: none;
            width: 150px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .inline-input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 10px rgba(96, 165, 250, 0.2);
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-update {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
            margin-right: 15px;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }
        
        .current-user-badge {
            font-size: 11px;
            background: rgba(96, 165, 250, 0.2);
            color: #60a5fa;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Manage Users</h1>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <?php if ($msg != ""): ?>
        <div class="message <?php echo $msgType; ?>">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($users)): ?>
                    <tr><td colspan="3" style="text-align: center;">No users found.</td></tr>
                <?php else: ?>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="avatar"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></div>
                                    <form method="POST" class="action-form" style="margin: 0;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="user_id" value="<?php echo $user['_id']; ?>">
                                        <input type="text" name="name" class="inline-input" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                        <?php if ((string)$user['_id'] == $_SESSION['user_id']): ?>
                                            <span class="current-user-badge">You</span>
                                        <?php endif; ?>
                            </td>
                            <td>
                                        <input type="email" name="email" class="inline-input" style="width: 200px;" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </td>
                            <td>
                                        <button type="submit" class="btn btn-update">Update</button>
                                    </form>
                                    
                                    <form method="POST" style="display:inline-block; margin-left: 10px;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="user_id" value="<?php echo $user['_id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
