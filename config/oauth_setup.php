<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Helper to return relative path for redirect URLs
function getRedirectUri($path) {
    $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost/web_technology', '/');
    return $baseUrl . '/' . ltrim($path, '/');
}
