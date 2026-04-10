<?php
require_once 'config/oauth_setup.php';

// Backend verification logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_token'])) {
    $idToken = $_POST['id_token'];
    
    // In a real application with Backend Server, we'd use kreait/firebase-php to verify.
    // For this assignment, we do a basic curl to Google's tokeninfo endpoint to verify the ID Token.
    $ch = curl_init('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (isset($data['email'])) {
        echo "<html><head><title>Success</title><style>body { font-family: sans-serif; text-align: center; margin-top: 50px; background: #18181b; color: white;} a{color: #60a5fa}</style></head><body>";
        echo "<h1>Firebase Backend Login Successful</h1>";
        echo "<p>Backend Server accurately verified token for: " . htmlspecialchars($data['email']) . "</p>";
        echo "<br><a href='login.php'>Go back to login</a>";
        echo "</body></html>";
    } else {
        echo "Error verifying Firebase token in Backend Server.";
    }
    exit;
}

// Frontend logic (HTML + JS)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Firebase Auth Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #09090b; color: white; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .container { text-align: center; background: #18181b; padding: 40px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05); }
        button { padding: 12px 20px; margin: 10px; border-radius: 8px; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.3s }
        #google-signin-btn { background: #3b82f6; color: white; }
        #google-signin-btn:hover { background: #2563eb; }
        #backend-form button { background: #10b981; color: white; }
        #backend-form button:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="container" id="login-container">
        <h2>Firebase Login Module</h2>
        <p style="color: #94a3b8; font-size: 14px; max-width: 400px; margin-bottom:20px;">
           This page demonstrates both <b>without backend server</b> (Frontend SDK only) and <b>with backend server</b> (passing generated tokens to backend verification).
        </p>

        <button id="google-signin-btn">1. Sign in with Frontend SDK</button>
        <p id="frontend-status" style="margin-top: 15px; color:#34d399;"></p>
        
        <form id="backend-form" method="POST" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #333;">
            <input type="hidden" name="id_token" id="id_token_input">
            <button type="submit">2. Verify Token With Backend Server</button>
        </form>
        <br><br><a href="login.php" style="color:#60a5fa; text-decoration:none;">&larr; Back to login</a>
    </div>

    <!-- Firebase JS SDK -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "<?php echo $_ENV['FIREBASE_API_KEY'] ?? ''; ?>",
            authDomain: "<?php echo $_ENV['FIREBASE_AUTH_DOMAIN'] ?? ''; ?>",
            projectId: "<?php echo $_ENV['FIREBASE_PROJECT_ID'] ?? ''; ?>",
            storageBucket: "<?php echo $_ENV['FIREBASE_STORAGE_BUCKET'] ?? ''; ?>",
            messagingSenderId: "<?php echo $_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? ''; ?>",
            appId: "<?php echo $_ENV['FIREBASE_APP_ID'] ?? ''; ?>"
        };

        let app;
        try {
            app = initializeApp(firebaseConfig);
        } catch (e) {
            document.getElementById('frontend-status').innerText = "Keys not configured in .env!";
            document.getElementById('frontend-status').style.color = "#f87171";
        }
        
        if (app) {
            const auth = getAuth(app);
            const provider = new GoogleAuthProvider();

            document.getElementById('google-signin-btn').addEventListener('click', () => {
                document.getElementById('frontend-status').innerText = "Processing...";
                
                signInWithPopup(auth, provider)
                    .then((result) => {
                        const user = result.user;
                        document.getElementById('frontend-status').innerText = "✅ Frontend Login Success! Logged in as: " + user.email;
                        
                        user.getIdToken().then((idToken) => {
                            document.getElementById('id_token_input').value = idToken;
                            document.getElementById('backend-form').style.display = 'block';
                        });
                    }).catch((error) => {
                        console.error("Error signing in: ", error);
                        document.getElementById('frontend-status').innerText = "❌ Error: " + error.message;
                        document.getElementById('frontend-status').style.color = "#f87171";
                    });
            });
        }
    </script>
</body>
</html>
