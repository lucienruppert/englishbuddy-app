<?php
session_start();
include_once('functions.php');
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
ini_set('display_errors', 0);

$debug_log = '/tmp/meaningSearch_debug.log';
file_put_contents($debug_log, "\n=== REQUEST AT " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
file_put_contents($debug_log, "REQUEST: " . json_encode($_REQUEST) . "\n", FILE_APPEND);

if (!$userObject)
    $userObject = $_SESSION['userObject'];
file_put_contents($debug_log, "userObject after session check: " . json_encode($userObject) . "\n", FILE_APPEND);
$_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

if ($_REQUEST['getMeaning']) {
    file_put_contents($debug_log, "getMeaning request received\n", FILE_APPEND);
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
    file_put_contents($debug_log, "setUserWord request received\n", FILE_APPEND);
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
    file_put_contents($debug_log, "getLevel request received. selectedLevel=" . $_REQUEST['selectedLevel'] . "\n", FILE_APPEND);
    file_put_contents($debug_log, "userObject before init: " . json_encode($userObject) . "\n", FILE_APPEND);

    if (!$userObject) {
        file_put_contents($debug_log, "userObject is empty, initializing with defaults\n", FILE_APPEND);
        $userObject["forras_nyelv"] = 0;
        $userObject["nyelv"] = 1;
        $GLOBALS["userObject"] = $userObject;
    } else {
        file_put_contents($debug_log, "userObject exists, just setting GLOBALS\n", FILE_APPEND);
        $GLOBALS["userObject"] = $userObject;
    }

    file_put_contents($debug_log, "userObject after init: " . json_encode($userObject) . "\n", FILE_APPEND);
    file_put_contents($debug_log, "GLOBALS userObject: " . json_encode($GLOBALS['userObject']) . "\n", FILE_APPEND);

    $list = getLevelList($userObject['nyelv']);
    file_put_contents($debug_log, "getLevelList returned " . count((array)$list) . " levels\n", FILE_APPEND);

    $selectedLevel = (int)$_REQUEST['selectedLevel'];
    file_put_contents($debug_log, "selectedLevel (int): " . $selectedLevel . "\n", FILE_APPEND);
    file_put_contents($debug_log, "Level exists in list: " . (isset($list[$selectedLevel]) ? 'YES' : 'NO') . "\n", FILE_APPEND);

    $text = getLevelComment($_REQUEST['selectedLevel'], $userObject['nyelv'], true);
    file_put_contents($debug_log, "getLevelComment returned: " . ($text ? "TEXT" : "NULL") . "\n", FILE_APPEND);

    if (!$text) {
        $text = "Nincs szöveg";
    }

    $title = isset($list[$selectedLevel][0]) ? $list[$selectedLevel][0] : 'Unknown';
    file_put_contents($debug_log, "title = " . $title . "\n", FILE_APPEND);

    $record = array_utf8_encode_recursive(array('title' => $title, 'text' => $text, 'id' => $_REQUEST['selectedLevel'], 'sorsz' => $_REQUEST['sorsz']));
    file_put_contents($debug_log, "Final record: " . json_encode($record) . "\n", FILE_APPEND);

    print json_encode($record, JSON_UNESCAPED_UNICODE);
} else if ($_REQUEST['setUserTime']) {
    print json_encode(true);
}
