<?php
if (!$_SESSION['userObject']) {
    session_start();
}

include('functions.php');

if (!$userObject) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'No user object']);
    exit;
}
$wordId = (int)$_POST["wordId"];
$userId = (int)$userObject["id"];
$userWordId = getUserWordId($wordId, $userId);

$result = markUserWord($wordId, (int)$userWordId, $userId, true);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
