<?php
    if(!$_SESSION['userObject']){
        session_start();
    }

    include('functions.php');

    if(!$userObject){
        exit;
    }
    $wordId = (int)$_POST["wordId"];
    $userId = (int)$userObject["id"];
    $userWordId = getUserWordId($wordId, $userId);

    markUserWord($wordId, (int)$userWordId, $userId, true);
?>