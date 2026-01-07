<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

session_start();
include_once(__DIR__ . '/../includes/apiInit.php');
$GLOBALS['userObject'] = $_SESSION['userObject'];

$userHasAccess = (in_array((int)$GLOBALS['userObject']['status'], array(4, 5, 6)));

$wordId = (int)$_POST['wordId'];
$userWordId = (int)$_POST['userWordId'];
$isChecked = ($_POST['isChecked'] == 'true' ? true : false);

if ($userHasAccess) {
    $gotUserId = (int)$_POST['userId'];
    $gotUserObject = getUserObjById($gotUserId);
    $userId = $gotUserObject['id'];
} else {
    $userId = $GLOBALS['userObject']['id'];
}

//    $userObject = $GLOBALS['userObject'];

markUserWord($wordId, $userWordId, $userId, $isChecked);

if ($_REQUEST['getMeaning']) {
    $record = getWordMeaningAjaxObject($userObject, $_REQUEST['txt'], $_REQUEST['lang']);
    $record = array_utf8_encode_recursive($record);
    print json_encode($record);
} else if ($_REQUEST['setUserWord']) {
    $result = array('result' => 0);
    $word = $_REQUEST['word'];
    if (!$userObject['id']) {
        $result['result'] = 0;
    } else {
        if ($_REQUEST['dictionaryUser'] > 0) {
            setUserWord(getUserObjById((int)$_REQUEST['dictionaryUser']), $word, $_REQUEST['lang']);
        } else {
            setUserWord(getUserObjById($userObject['id']), $word, $_REQUEST['lang']);
        }
        $result['result'] = 1;
    }
    print json_encode($result);
} else if ($_REQUEST['getLevel']) {
    $list = getLevelList($userObject['nyelv']);
    $text = getLevelComment($_REQUEST['selectedLevel'], $userObject['nyelv'], false);
    if (!$text) {
        $text = "Nincs sz�veg";
    }
    $record = array_utf8_encode_recursive(array('title' => $list[$_REQUEST['selectedLevel']][0], 'text' => $text, 'id' => $_REQUEST['selectedLevel'], 'sorsz' => $_REQUEST['sorsz']));
    print json_encode($record);
} else if ($_REQUEST['setUserTime']) {
    print json_encode(true);
}
