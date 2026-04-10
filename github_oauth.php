<?php
require_once 'config/oauth_setup.php';

session_start();

$client_id = $_ENV['GITHUB_CLIENT_ID'] ?? '';
$client_secret = $_ENV['GITHUB_CLIENT_SECRET'] ?? '';
$redirect_uri = getRedirectUri('/github_oauth.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Exchange code for access token
    $ch = curl_init('https://github.com/login/oauth/access_token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    ));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (isset($data['access_token'])) {
        $access_token = $data['access_token'];
        
        // Fetch user data
        $ch2 = curl_init('https://api.github.com/user');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token,
            'User-Agent: Web-Technology-App'
        ));
        
        $user_data_json = curl_exec($ch2);
        curl_close($ch2);
        
        $user_data = json_decode($user_data_json, true);
        
        echo "<html><head><title>Success</title><style>body { font-family: sans-serif; text-align: center; margin-top: 50px; background: #18181b; color: white;} a{color: #60a5fa}</style></head><body>";
        echo "<h1>GitHub Login Successful</h1>";
        echo "<p>Welcome, " . htmlspecialchars($user_data['login'] ?? 'GitHub User') . "</p>";
        echo "<br><a href='login.php'>Go back to login</a>";
        echo "</body></html>";
        exit;
    } else {
        echo "Error fetching access token.";
        exit;
    }
}

// Redirect to GitHub
$url = "https://github.com/login/oauth/authorize?client_id=" . urlencode($client_id) . "&redirect_uri=" . urlencode($redirect_uri) . "&scope=user:email";
header('Location: ' . $url);
exit;
