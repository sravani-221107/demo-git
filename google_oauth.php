<?php
require_once 'config/oauth_setup.php';

session_start();

$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri(getRedirectUri('/google_oauth.php'));
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if(!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        
        // Authentication success
        echo "<html><head><title>Success</title><style>body { font-family: sans-serif; text-align: center; margin-top: 50px; background: #18181b; color: white;} a{color: #60a5fa}</style></head><body>";
        echo "<h1>Google Login Successful</h1>";
        echo "<p>Welcome, " . htmlspecialchars($name) . " (" . htmlspecialchars($email) . ")</p>";
        echo "<br><a href='login.php'>Go back to login</a>";
        echo "</body></html>";
        exit;
    } else {
        echo "Error during Google OAuth.";
        exit;
    }
}

// Redirect to Google if not handling a callback
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit;
