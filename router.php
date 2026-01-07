<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple router for PHP development server
$request_uri = $_SERVER["REQUEST_URI"];

// Remove query string from URI for file checking
$uri_without_query = preg_replace('/\?.*/', '', $request_uri);
$requested_file = __DIR__ . $uri_without_query;

// If the request is for a directory, try to serve index.php
if (is_dir($requested_file)) {
  $requested_file = $requested_file . '/index.php';
}

// If it's a real file or directory, serve it
if (file_exists($requested_file)) {
  return false;
}

// Otherwise, route to pages/index.php
// Change to pages directory so relative paths work correctly
chdir(__DIR__ . '/pages');
require __DIR__ . '/pages/index.php';
