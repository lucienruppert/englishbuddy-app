<?php

if(!$_SESSION['userObject']){
    session_start();
}

include_once('functions.php');

if(!$userObject){
    include_once('index.php');
    exit;
}

print "<table width=100%><tr><td align=center>";

$chosenWords = $_SESSION['chosenWords'];
$currentWords = $_SESSION['currentWords'];
settype($currentWords, array());

$stayHere = false;
$inputClass = 'notselected';

// ha most választottunk menübõl, akkor ürítjük a szólistát
if($_GET['actionType'] || $_POST['subActionType'] == 'selectChange'){
    $chosenWords = array();
    $currentWords = array();
}
else if($_POST['answerWord'] and strtolower($_POST['answerWord']) == strtolower($_POST['translatedWord']) and count($currentWords) > 0){
    $hitWord = array_pop($currentWords);
    if(!$_REQUEST['goodSeries'] and !$_REQUEST['badSeries']){
        setHit($hitWord['id']);
        $_REQUEST['goodSeries'] = 1;
        reset($currentWords);
        for($i = 0; $i < count($_REQUEST['goodSeries']); $i++){
            $currentWords[] = $hitWord;
        }
    }
    else if(!$_REQUEST['goodSeries'] and $_REQUEST['badSeries']){
        $_REQUEST['badSeries']--;
    }
    else if($_REQUEST['goodSeries'] and !$_REQUEST['badSeries']){
        $_REQUEST['goodSeries']--;
    }
    else{
        $_REQUEST['goodSeries'] = $_REQUEST['badSeries'] = 0;
    }
    if($_REQUEST['goodSeries'] > 0){
        $wordValue = $_POST['translatedWord'];
        $readonly = 'readonly';
        $inputClass = 'goodselected';
    }
    $stayHere = true;
    $goodAnswer = true;
}
else if($_POST['actionType'] && $_POST['actionFrame'] != 'wordList'){
    $stayHere = true;
    $badAnswer = true;
    $_REQUEST['goodSeries'] = 0;
    $_REQUEST['badSeries'] = 3;
    $hitWord = array_pop($currentWords);
    for($i = 0; $i <= $_REQUEST['badSeries']; $i++){
        $currentWords[] = $hitWord;
    }
    $wordValue = $_POST['translatedWord'];
    $readonly = 'readonly';
    $inputClass = 'selected';
}
else{
    $key = array_keys($currentWords);
    $currentWord = $currentWords[count($currentWords) - 1];
}

if($stayHere){
    $currentWord = $currentWords[count($currentWords) - 1];
}
else{
    $wordValue = '';
    $readonly = '';
}

if(count($currentWords) == 0){
    if(!$_REQUEST['level']){
        $_REQUEST['level'] = 9;
    }
    $wordRecords = getWords(5, $_REQUEST['level'], $chosenWords);
    $currentWords = array();
    for($i = 0; $i < count($wordRecords); $i++){
        $chosenWords[] = $wordRecords[$i]['id'];
        $currentWords[] = $wordRecords[$i];
    }
}
$currentWord = $currentWords[count($currentWords) - 1];
$optionArray = array(
    '1' => 'FÕNEVEK',
    '9' => 'SZEMÉLYES V. KÉRDÕNÉVMÁSOK',
    '5' => 'IGÉK (szótári alak)',
    '4' => 'IGÉK (ragozott)',
    '6' => 'ELÖLJÁRÓSZAVAK ÉS RAGOZÁSUK',
    '11' => 'SZÁMOK (alap)',
    '7' => 'SZÁMOK',
    '2' => 'MELLÉKNEVEK',
    '3' => 'HATÁROZÓ-, MUTATÓSZÓK ÉS EGYÉB'/*,

    '8' => 'EGYSZERÛ MONDATOK'*/
);

print "<select name='levelSelection' onchange=\"document.forms[0].subActionType.value='selectChange';document.forms[0].level.value=this.value;document.forms[0].selectedIndex.value=this.selectedIndex;document.forms[0].submit();\">";
$i = 0;
foreach($optionArray as $key => $value){
    if($i == $_REQUEST['selectedIndex']){
        $selected = 'selected';
    }
    else{
        $selected = '';
    }
    print "<option value='{$key}' $selected>$value";
    $i++;
}
print "</select><br><br>";

print "\n<span style='font-weight:bold;font-size:32px'>{$currentWord['word_hun']}</span><br><br>";
print "\n<input type='text' class='$inputClass' name='answerWord' value='$wordValue' $readonly>";
print "\n<input type='hidden' name='translatedWord' value='{$currentWord['word_foreign']}'>";
print "\n<input type='hidden' name='level' value='{$_REQUEST['level']}'>";
print "\n<input type='hidden' name='selectedIndex' value='{$_REQUEST['selectedIndex']}'>";
print "\n<input type='hidden' name='subActionType' value=''>";
print "\n<input type='hidden' name='goodSeries' value='{$_REQUEST['goodSeries']}'>";
print "\n<input type='hidden' name='badSeries' value='{$_REQUEST['badSeries']}'>";

$_SESSION['chosenWords'] = $chosenWords;
$_SESSION['currentWords'] = $currentWords;


print "<script>
    document.forms[0].answerWord.focus();
    document.forms[0].actionType.value = 'wordLearning';
</script>";

print "</td></tr></table>";

?>