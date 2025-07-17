<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

if (!$_SESSION['userObject']) {
    session_start();
}

include('functions.php');

if (!$userObject && $_SESSION['userObject']) {
    $userObject = $_SESSION['userObject'];
}
if (!$userObject) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'No user object']);
    exit;
}
removeUserWord((int)$userObject["id"], (int)$_POST["wordId"]);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
