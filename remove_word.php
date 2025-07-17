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
removeUserWord((int)$userObject["id"], (int)$_POST["wordId"]);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
