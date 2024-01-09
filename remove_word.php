<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);

    if(!$_SESSION['userObject']){
        session_start();
    }

    include('functions.php');
    
    if(!$userObject && $_SESSION['userObject']){
        $userObject = $_SESSION['userObject'];
    }
    if(!$userObject){
        print "No user object";
        exit;
    }
    removeUserWord((int)$userObject["id"], (int)$_POST["wordId"]);
?>