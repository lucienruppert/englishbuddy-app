<?php
session_start();
include_once(__DIR__ . '/../includes/apiInit.php');
header('Content-Type: application/json; charset=utf-8');

if (!$userObject)
    $userObject = $_SESSION['userObject'];
$_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

if ($_REQUEST['getMeaning']) {
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
    if (!$userObject) {
        $userObject["forras_nyelv"] = 0;
        $userObject["nyelv"] = 1;
        $GLOBALS["userObject"] = $userObject;
    } else {
        $GLOBALS["userObject"] = $userObject;
    }

    $list = getLevelList($userObject['nyelv']);

    $selectedLevel = (int)$_REQUEST['selectedLevel'];

    $text = getLevelComment($_REQUEST['selectedLevel'], $userObject['nyelv'], true);

    if (!$text) {
        $text = "Nincs szöveg";
    }

    $title = isset($list[$selectedLevel][0]) ? $list[$selectedLevel][0] : 'Unknown';

    $record = array_utf8_encode_recursive(array('title' => $title, 'text' => $text, 'id' => $_REQUEST['selectedLevel'], 'sorsz' => $_REQUEST['sorsz']));

    print json_encode($record, JSON_UNESCAPED_UNICODE);
} else if ($_REQUEST['setUserTime']) {
    print json_encode(true);
}
