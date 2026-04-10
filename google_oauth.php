<?php
require_once 'config/oauth_setup.php';

session_start();

$client_id = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$client_secret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirect_uri = getRedirectUri('/google_oauth.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Exchange code for access token
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ]));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (isset($data['access_token'])) {
        $access_token = $data['access_token'];
        
        // Fetch user data
        $ch2 = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token
        ]);
        
        $user_data_json = curl_exec($ch2);
        curl_close($ch2);
        
        $user_data = json_decode($user_data_json, true);
        
        echo "<html><head><title>Success</title><style>body { font-family: sans-serif; text-align: center; margin-top: 50px; background: #18181b; color: white;} a{color: #60a5fa}</style></head><body>";
        echo "<h1>Google Login Successful</h1>";
        echo "<p>Welcome, " . htmlspecialchars($user_data['name'] ?? 'Google User') . " (" . htmlspecialchars($user_data['email'] ?? '') . ")</p>";
        echo "<br><a href='login.php'>Go back to login</a>";
        echo "</body></html>";
        exit;
    } else {
        echo "Error fetching access token.";
        exit;
    }
}

// Redirect to Google
$url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online'
]);

header('Location: ' . $url);
exit;
