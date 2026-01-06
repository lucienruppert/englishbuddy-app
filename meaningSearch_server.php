<?php
session_start();
include_once('functions.php');
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
ini_set('display_errors', 0);

error_log("meaningSearch_server.php REQUEST: " . json_encode($_REQUEST));

if (!$userObject)
    $userObject = $_SESSION['userObject'];
error_log("userObject after session check: " . json_encode($userObject));
$_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

if ($_REQUEST['getMeaning']) {
    error_log("getMeaning request received");
    if (!$userObject) {
        $userObject["forras_nyelv"] = (int)$_REQUEST['lang'];
        if ($userObject["forras_nyelv"] == 0)
            $userObject["nyelv"] = 1;
        else if ($userObject["forras_nyelv"] == 1)
            $userObject["nyelv"] = 2;
        else if ($userObject["forras_nyelv"] == 2)
            $userObject["nyelv"] = 1;
        $_REQUEST['lang'] = $userObject["nyelv"];
        $GLOBALS["userObject"] = $userObject;
    }
    $record = getWordMeaningAjaxObject($userObject, $_REQUEST['txt'], $_REQUEST['lang']);
    $record = array_utf8_encode_recursive($record);
    print json_encode($record);
} else if ($_REQUEST['setUserWord']) {
    error_log("setUserWord request received");
    $result = array('result' => 0);
    $word = $_REQUEST['word'];
    $id = (int)$_REQUEST['id'];
    if (!$userObject['id']) {
        $result['result'] = 666;
    } else {
        if ($_REQUEST['dictionaryUser'] > 0) {
            if ($id > 0 && !$word)
                setUserWordById(getUserObjById((int)$_REQUEST['dictionaryUser']), $id);
            else
                setUserWord(getUserObjById((int)$_REQUEST['dictionaryUser']), $word, $_REQUEST['lang']);
        } else {
            if ($id > 0 && !$word)
                setUserWordById(getUserObjById($userObject['id']), $id);
            else
                setUserWord(getUserObjById($userObject['id']), $word, $_REQUEST['lang']);
        }
        $result['result'] = 1;
    }
    print json_encode($result);
} else if ($_REQUEST['getLevel']) {
    error_log("getLevel request received. selectedLevel=" . $_REQUEST['selectedLevel']);
    error_log("userObject before init: " . json_encode($userObject));

    if (!$userObject) {
        error_log("userObject is empty, initializing with defaults");
        $userObject["forras_nyelv"] = 0;
        $userObject["nyelv"] = 1;
        $GLOBALS["userObject"] = $userObject;
    } else {
        error_log("userObject exists, just setting GLOBALS");
        $GLOBALS["userObject"] = $userObject;
    }

    error_log("userObject after init: " . json_encode($userObject));
    error_log("GLOBALS userObject: " . json_encode($GLOBALS['userObject']));

    $list = getLevelList($userObject['nyelv']);
    error_log("getLevelList returned " . count((array)$list) . " levels");

    $selectedLevel = (int)$_REQUEST['selectedLevel'];
    error_log("selectedLevel (int): " . $selectedLevel);
    error_log("Level exists in list: " . (isset($list[$selectedLevel]) ? 'YES' : 'NO'));

    $text = getLevelComment($_REQUEST['selectedLevel'], $userObject['nyelv'], true);
    error_log("getLevelComment returned: " . ($text ? "TEXT" : "NULL"));

    if (!$text) {
        $text = "Nincs szöveg";
    }

    $title = isset($list[$selectedLevel][0]) ? $list[$selectedLevel][0] : 'Unknown';
    error_log("title = " . $title);

    $record = array_utf8_encode_recursive(array('title' => $title, 'text' => $text, 'id' => $_REQUEST['selectedLevel'], 'sorsz' => $_REQUEST['sorsz']));
    error_log("Final record: " . json_encode($record));

    print json_encode($record, JSON_UNESCAPED_UNICODE);
} else if ($_REQUEST['setUserTime']) {
    print json_encode(true);
}
