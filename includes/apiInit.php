<?php
// Lightweight initialization for API/AJAX endpoints
// Does NOT set HTML headers, does NOT include functions.php directly
// Only provides database connection and user object

// Set character encoding without setting Content-Type header
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.cookie_lifetime', 0);
  ini_set('session.gc_maxlifetime', 3600);
  session_start();
}

// Load database connection and user authentication
include_once(__DIR__ . '/functions_userObj.php');

// Get user object from session
$userObject = isset($_SESSION['userObject']) ? $_SESSION['userObject'] : null;
$GLOBALS['userObject'] = $userObject;

// Load functions needed by API endpoints
include_once(__DIR__ . '/functions.php');

// Update session timing if user is logged in
if ($userObject) {
  $_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);
}
