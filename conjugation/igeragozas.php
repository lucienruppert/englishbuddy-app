<?php

include_once(__DIR__ . '/../includes/functions.php');

if (!$userObject) {
    include_once('../pages/index.php');
    exit;
}

print "<table width=100%><tr><td align='center'>" . getIgeragozasTable() . "</td></tr><tr><td align=center>";

$chosenWords = $_SESSION['chosenWords'];
$currentWords = $_SESSION['currentWords'];
settype($currentWords, 'array');

$stayHere = false;
// ha most v�lasztottunk men�b�l, akkor �r�tj�k a sz�list�t
if ($_GET['actionType'] || $_POST['subActionType'] == 'selectChange') {
    $chosenWords = array();
    $currentWords = array();
} else if ($_POST['answerWord'] and strtolower($_POST['answerWord']) == strtolower($_POST['translatedWord']) and count($currentWords) > 0) {
    $hitWord = array_pop($currentWords);
    setHit($hitWord['id']);
} else if ($_POST['actionType'] && $_POST['actionFrame'] != 'wordList') {
    $stayHere = true;
    //shuffle($currentWords);
} else {
    $key = array_keys($currentWords);
    $currentWord = $currentWords[$key[count($key) - 1]];
}

$inputClass = 'notselected';
if ($stayHere) {
    $wordValue = $_POST['translatedWord'];
    $key = array_keys($currentWords);
    $currentWord = $currentWords[$key[count($key) - 1]];
    array_push($currentWords, $currentWord);
    $readonly = 'readonly';
    $inputClass = 'selected';
} else {
    $wordValue = '';
    $readonly = '';
}



if (count($currentWords) == 0) {
    if (!$_REQUEST['level']) {
        $_REQUEST['level'] = 9;
    }
    $wordRecords = getWords(5, 4, $chosenWords);
    $currentWords = array();
    for ($i = 0; $i < count($wordRecords); $i++) {
        $chosenWords[] = $wordRecords[$i]['id'];
        $currentWords[$wordRecords[$i]['id']] = $wordRecords[$i];
    }
}
$key = array_keys($currentWords);
$currentWord = $currentWords[$key[count($key) - 1]];

$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

print "\n<span style='font-weight:bold;font-size:32px'>{$currentWord['word_{$forras_nyelv_ext}']}</span><br><br>";
print "\n<input type='text' class='$inputClass' size='40' name='answerWord' value='$wordValue' $readonly>";
print "\n<input type='hidden' name='translatedWord' value='{$currentWord['word_foreign']}'>";
print "\n<input type='hidden' name='level' value='{$_REQUEST['level']}'>";
print "\n<input type='hidden' name='selectedIndex' value='{$_REQUEST['selectedIndex']}'>";
print "\n<input type='hidden' name='subActionType' value=''>";

$_SESSION['chosenWords'] = $chosenWords;
$_SESSION['currentWords'] = $currentWords;


print "<script>
    document.forms[0].answerWord.focus();
    document.forms[0].actionType.value = 'igeragozas';
</script>";

print "</td></tr></table>";
