<?php
error_reporting(0); // Suppress all errors for AJAX response
session_start();
include('functions.php');

// Make sure no output has been sent yet
if (headers_sent($filename, $linenum)) {
    error_log("Headers already sent in $filename on line $linenum");
}

// Ensure we're only outputting JSON
ob_clean(); // Clear any output buffering
header('Content-Type: application/json');

if (!isset($_SESSION['userObject'])) {
    echo json_encode(['success' => false, 'error' => 'No user session']);
    exit;
}

$userObject = $_SESSION['userObject'];
if (!$userObject) {
    echo json_encode(['success' => false, 'error' => 'No user object']);
    exit;
}

$wordId = (int)$_POST["wordId"];
$userId = (int)$userObject["id"];
$userWordId = getUserWordId($wordId, $userId);

// Call markUserWord without assigning its return value
markUserWord($wordId, (int)$userWordId, $userId, true);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
