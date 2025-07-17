<?php
session_start();
include('functions.php');

if (!isset($_SESSION['userObject'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'No user session']);
    exit;
}

$userObject = $_SESSION['userObject'];
if (!$userObject) {
    header('Content-Type: application/json');
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
