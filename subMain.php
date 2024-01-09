<?php

if(!$_SESSION['userObject']){
    session_start();
}

include_once('functions.php');

if(!$userObject){
    include_once('index.php');
    exit;
}

switch($_REQUEST['actionType']){
    case 'wordLearning':
        $includeFile = 'wordLearning.php';
        break;
    case 'createSentences':
        $includeFile = 'createSentences.php';
        break;
    case 'sentenceLearning':
        $includeFile = 'sentenceLearning.php';
        break;
    case 'igeragozas':
        $includeFile = 'igeragozas.php';
        break;
    case 'wordManagement':
        $includeFile = 'wordManagement.php';
        break;
    default:
        $includeFile = $_REQUEST['actionType'] . '.php';
        break;
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text-html; charset=iso-8859-2">
<link rel=stylesheet type='text/css' href='baseStyle.css'>
</head>
<body>
<form method='POST' action='subMain.php'>
<table width='100%'><tr><td width='80%'>

<?php include_once($includeFile); ?>

</td><td width='20%'>
<input type='button' name='orderButton' value='Váltás' onclick="
if(document.forms[0].orderLang.value == 'hun'){
    document.forms[0].orderLang.value='foreign';
}
else{
    document.forms[0].orderLang.value='hun';
}
document.forms[0].actionFrame.value='wordList';
document.forms[0].submit();
">&nbsp;&nbsp;
<span style='font-size:14pt'><?php print getWordCount(); ?></span>
<div id='allWords' style='width:250;height:550;overflow:auto;scrollbar-track-color:white;scrollbar-face-color:silver;scrollbar-highlight-color:black;scrollbar-shadow-color:gray'><table>
<?php
if(!$_REQUEST['orderLang']){
    $_REQUEST['orderLang'] = 'hun';
}
$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
$words = getAllWordsWithLevelExceptions(array(8), $_REQUEST['orderLang']);
if($_REQUEST['orderLang'] == 'hun'){
    for($i = 0; $i < count($words); $i++){
        print "<tr><td>{$words[$i]['word_{$forras_nyelv_ext}']}</td><td>{$words[$i]['word_foreign']}</td></tr>";
    }
}
else{
    for($i = 0; $i < count($words); $i++){
        print "<tr><td>{$words[$i]['word_foreign']}</td><td>{$words[$i]['word_{$forras_nyelv_ext}']}</td></tr>";
    }
}
?>
</table></div></td></tr></table>

<?php print "<input type='hidden' name='actionType' value='{$_REQUEST['actionType']}'>"; ?>
<?php print "<input type='hidden' name='actionFrame' value=''>"; ?>
<?php print "<input type='hidden' name='orderLang' value='{$_REQUEST['orderLang']}'>"; ?>
</form>
</body>
</html>