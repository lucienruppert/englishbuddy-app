<?php
include_once('functions.php');

if(!$userObject){
    include_once('index.php');
    exit;
}
?>
<html>
<body>
<input type='button' name='orderButton' value='Váltás' onclick="
if(document.forms[0].orderLang.value == 'hun'){
    document.forms[0].orderLang.value='foreign';
}
else{
    document.forms[0].orderLang.value='hun';
}
document.forms[0].submit();
">&nbsp;&nbsp;

<input type='button' name='showButton' value='Kijelzés' onclick="
this.form.dictionaryShow.value = 1 - this.form.dictionaryShow.value;
document.forms[0].submit();
">&nbsp;&nbsp;

<input type='hidden' name='dictionaryShow' value=<?php print "'{$_REQUEST['dictionaryShow']}'"; ?>>

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
        if($_REQUEST['dictionaryShow'] == 1 || $words[$i]['word_foreign']){
            print "<tr><td>{$words[$i]['word_{$forras_nyelv_ext}']}</td><td>{$words[$i]['word_foreign']}</td></tr>";
        }
    }
}
else{
    for($i = 0; $i < count($words); $i++){
        if($_REQUEST['dictionaryShow'] == 1 || $words[$i]["word_{$forras_nyelv_ext}"]){
            print "<tr><td>{$words[$i]['word_foreign']}</td><td>{$words[$i]['word_{$forras_nyelv_ext}']}</td></tr>";
        }
    }
}
?>
</table></div>
</body>
<>/html
?>