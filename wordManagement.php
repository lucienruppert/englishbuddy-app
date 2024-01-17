<?php

include_once('functions.php');

if(!$userObject){
    include_once('index.php');
    exit;
}
$userHasAccess = (in_array((int)$userObject['status'], array(4, 5, 6)));

$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
$cel_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['nyelv']);

if($_POST['actionType'] == 'store'){
    if((int)$userObject['id'] == 4){
        $userId = 1;
    }
    else{
        $userId = (int)$userObject['id'];
    }

    if($userHasAccess && (int)$_REQUEST['dictionaryUser'] > 0){
        $userId = (int)$_REQUEST['dictionaryUser'];
    }

    $level = 0;
    $category = null;
    if((int)$_POST['levelSelection'] >= 0){
        $level = (int)$_POST['levelSelection'];
    }
    else if((int)$_POST['levelSelection2'] >= 0){
        $level = (int)$_POST['levelSelection2'];
        $category = $_POST['categorySelection'];
    }
    if(!checkWord((int)$_POST['recordId'], $_POST['hunWord'], $_SESSION['userObject']['nyelv'], $_POST['foreignWord'])){
        if($_REQUEST['kitolto']){
            $level = 0;
        }
        if(!storeWord((int)$_POST['recordId'], $_POST['hunWord'], $_SESSION['userObject']['nyelv'], $_POST['foreignWord'], $_POST['foreignComm'], $_POST['sourceComm'], $level, $userId, $category, $_REQUEST['kitolto'])){
            print "<script>alert('" . translate("word_save_error") . "')</script>";
        }
        else{
            $_REQUEST['wordIdToEdit'] = 0;
        }
    }
    else{
        print "<script>alert('" . translate('word_exists_in_dictionary') . "')</script>";
    }
}
else if($_POST['actionType'] == 'delete'){
    $deleteReturn = deleteWord((int)$_POST['recordId'], $_SESSION['userObject']['nyelv'], $_SESSION['userObject']['forras_nyelv'], ($_SESSION['userObject']['status'] != 6 && $_SESSION['userObject']['status'] != 5));
    if($deleteReturn === -1){
        print "<script>alert('" . translate('word_delete_error') . "')</script>";
    }
    else if($deleteReturn === 0){
        print "<script>alert('" . translate('word_exists_in_other_lang') . "')</script>";
    }
    else{
        $_REQUEST['wordIdToEdit'] = 0;
    }
}

if($_REQUEST['wordIdToEdit'] > 0){
    $wordRecord = getWord((int)$_REQUEST['wordIdToEdit'], $_SESSION['userObject']['nyelv']);
}

if(!isset($_POST['homeWorkOrder'])){
    $_REQUEST['homeWorkOrder'] = $_POST['homeWorkOrder'] = 1;
}

?>
<script>

$(document).ready(function () {
    $('.cbMark').change(function () {
        var wid = $(this).data('wid');
        var uwid = $(this).data('uwid');
        var userid = $(this).data('user');
        $.post(
            "markWordForUser.php",
            {
                wordId: wid,
                userWordId: uwid,
                isChecked: $(this).is(":checked"),
                userId: userid
            },
            function(data,status){
                location.reload();
            }
        ).fail(function() {
            alert( "Hiba t�rt�nt!" );
        });
    });
});

function wordLink(id, sorszam)
{
    document.forms['wordManagement'].action += "#link" + sorszam;
    document.forms['wordManagement'].wordIdToEdit.value = id;
    document.forms['wordManagement'].submit();
}
</script>
<?php
$nyelvText = ucfirst(translate(getLangExtByLangId($userObject['nyelv'])));
$forrasNyelvText = ucfirst(translate(getLangExtByLangId($userObject['forras_nyelv'])));

print "<form id='wordManagement' name='wordManagement' method='post'>";
print "<input type='hidden' name='userId' value='{$_POST['userId']}'>";
print "<input type='hidden' name='recordId' value='" . $wordRecord['id'] . "'>";
print "<input type='hidden' name='homeWorkOrder' value='" . (int)$_POST['homeWorkOrder'] . "'>";
print "<table class='word-management' width='100%' style='border: 1px solid;margin-top:36px;' align=left><tr><td  style='border: 1px solid' align='center' valign='top'><table>";

$forWord = $wordRecord['word_foreign'];
if($userObject['nyelv'] == 2){
    if(!$forWord){
        $forWord = "&iquest;&iexcl;&ntilde;";
    }
}

$sourceWord = $wordRecord["word_{$forras_nyelv_ext}"];
if($userObject['forras_nyelv'] == 2){
    if(!$sourceWord){
        $sourceWord = "&iquest;&iexcl;&ntilde;";
    }
}

$hideStyle = '';
if(!$userHasAccess){
    $hideStyle = "style='display:none'";
}
$readonly = '';
if($_REQUEST['kitolto']){
    $readonly = 'readonly';
}

print "\n<tr><td><b>" . $nyelvText . ": </td><td><textarea name='foreignWord' rows='4' cols='37'>" . $forWord . "</textarea></td></tr>";
print "\n<tr $hideStyle><td><b>" . translate("cel_komment") . ": </td><td><input type='text' size='38' name='foreignComm' value='" . $wordRecord['comment_foreign'] . "'></td></tr>";
print "\n<tr><td><b>{$forrasNyelvText}: </td><td><textarea name='hunWord' rows='4' cols='37' $readonly>" . $sourceWord . "</textarea></td></tr>";
print "\n<tr $hideStyle><td><b>" . translate("forras_komment") . ": </td><td><input type='text' size='38' name='sourceComm' value='" . $wordRecord["comment_{$forras_nyelv_ext}"] . "'></td></tr>";

if($userHasAccess){
    $optionArray = getLevelList($userObject['nyelv']);
    $countOptionList = getWordCountList($userObject['nyelv']);
}

print "<tr><td align=left style='vertical-align:top'><input type='button' name='store' value='" . translate('rogzit') . "' onclick=\"
    if(document.forms['wordManagement'].hunWord.value == '' || document.forms['wordManagement'].foreignWord.value == ''){
        alert('" . translate('both_field_required') . "');
        return false;
    }
    /* A 2. r�sz az�rt >0, mert ha fel�l Level0 van kiv�lasztva, alul meg valami m�s, akkor is menteni kell, �s az als�t kell figyelembe venni */
    if(document.forms['wordManagement'].levelSelection && document.forms['wordManagement'].levelSelection.value != -1 && document.forms['wordManagement'].levelSelection2.value > 0){
        alert('Csak egy level-t v�laszthatsz ki!');
        return false;
    }
    document.forms['wordManagement'].actionType.value='store';
    document.forms['wordManagement'].submit();\"></td>";
if($userHasAccess){
    print "<td align='right'><select name='levelSelection2'>";
    print "<option value='-1'>";
    foreach($optionArray as $key => $value){
        if($value[1] != 1){
            continue;
        }
        if($key == $wordRecord['level']){
            $selected = 'selected';
        }
        else{
            $selected = '';
        }
        if($key > 0){
            //print "<option value='{$key}' $selected>(" . (int)$countOptionList[$key] . ") {$value[0]} ";
            print "<option value='{$key}' $selected> {$value[0]} - " . (int)$countOptionList[$key] . " ";
        }
        else{
            print "<option value='{$key}' $selected>{$value[0]}";
        }
    }
    print "</select>
    <select id='categorySelection' name='categorySelection'>
        <option value=''></option>
        <option value='1' " . ($wordRecord['category'] == 1 ? 'selected' : '') . ">alap</option>
        <option value='2' " . ($wordRecord['category'] == 2 ? 'selected' : '') . ">v�laszt�kos</option>
        <option value='3' " . ($wordRecord['category'] == 3 ? 'selected' : '') . ">ritka</option>
    </select>
    </td>";

    print "</tr>";

    print "<tr><td align=left style='vertical-align:bottom'><input type='button' name='store' value='Delete' onclick=\"
        document.forms['wordManagement'].actionType.value='delete';
        document.forms['wordManagement'].submit();\"></td>

    <td align='right'><select name='levelSelection' size='12'>";
    print "<option value='-1' selected>";
    foreach($optionArray as $key => $value){
        if($value[1] != 2){
            continue;
        }
        if($key == $wordRecord['level']){
            $selected = 'selected';
        }
        else{
            $selected = '';
        }
        print "<option value='{$key}' $selected>{$value[0]} - " . (int)$countOptionList[$key] . "";
    }
    print "</select></td></tr>";
}
print "</table></td><td valign='top'>";

if(!$_REQUEST['dictionaryShow']){
    $_REQUEST['dictionaryShow'] = ($_REQUEST['kitolto'] ? 1 : ($userHasAccess ? 4 : 2));
}
$dictionaryShowSelected = array();
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 1 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 2 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 3 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 4 ? 'selected' : '');

if($_REQUEST['dictionaryShow'] != 2 && $_REQUEST['dictionaryShow'] != 4){
    $_REQUEST['dictionaryUser'] = 0;
}
if(!$_REQUEST['orderLang']){
    $_REQUEST['orderLang'] = 'foreign';
}

$wordUsers = getWordUsers($_SESSION['userObject']);

/* Sz�t�r r�sz */
print "<table width='400' align='center' style='border: 1px solid'><tr>";

if(!$userHasAccess){
?>
<td><input type='textbox' name='txtListFilter' id='txtListFilter' size='17'></td>
<?php } ?>
<td width='75'>
<input type='button' name='orderButton' value=

<?php

    if($_REQUEST['orderLang'] == 'foreign'){
        print "'{$nyelvText} &rarr; {$forrasNyelvText}'";
    }
    else{
        print "'{$forrasNyelvText} &rarr; {$nyelvText}'";
    }

?> onclick="
if(this.form.orderLang.value == 'foreign'){
    this.form.orderLang.value='hun';
}
else{
    this.form.orderLang.value='foreign';
}
this.form.submit();
">
</td>
<?php

    if($userHasAccess){ ?>
    <td>
    <select style='width:120px' name='dictionaryShow' onchange='this.form.submit();'>
        <option value='1' <?php print $dictionaryShowSelected[0]; ?>>Kit�ltetlen
        <option value='2' <?php print $dictionaryShowSelected[1]; ?>>Minden
        <option value='3' <?php print $dictionaryShowSelected[2]; ?>>Level n�lk�liek
        <option value='4' <?php print $dictionaryShowSelected[3]; ?>>Saj�t
    </select>
    </td>
<?php 
        if($_REQUEST['kitolto']){
            print "<input type='hidden' name='kitolto' value='1'>";
        }
    } else {
        if($_REQUEST['kitolto']){
            print "<input type='hidden' name='dictionaryShow' value='1'>
                    <input type='hidden' name='kitolto' value='1'>";
        }
        else
            print "<input type='hidden' name='dictionaryShow' value='2'>";
    }
    ?>

<input type='hidden' name='orderLang' value=<?php print "'{$_REQUEST['orderLang']}'"; ?>>


<td><input type='button' value=<?php print "'" . translate('frissit') . "'"; ?> onclick="document.forms['wordManagement'].submit()"></td>
<td><input type='button' value=<?php print "'" . translate('sorrend') . "'"; ?> onclick="document.forms['wordManagement'].homeWorkOrder.value = 1 - document.forms['wordManagement'].homeWorkOrder.value;document.forms['wordManagement'].submit()"></td>
<!--<td align='right'><span id='hfCountSpan' style='font-size:14pt;color:#1568A2'></span><span id='wordCountSpan' style='font-size:14pt'></span></td>-->
</tr>
<tr>
<?php

if($userHasAccess && ($_REQUEST['dictionaryShow'] == 2 || $_REQUEST['dictionaryShow'] == 4)){
    print "\n<td colspan='5' style='white-space: nowrap'>";
    print "\n<select name='dictionaryUser' onchange='this.form.submit();'>";
    print "\n<option value='0'>";
    foreach($wordUsers as $user){
        if($user['nyelv'] != $userObject['nyelv']){
            continue;
        }
        if($user['status'] == 1 || $user['status'] == 2){
            continue;
        }
        if((int)$user['user_id'] == (int)$_REQUEST['dictionaryUser']){
            $selected = 'selected';
        }
        else{
            $selected = '';
        }
        print "\n<option value='{$user['user_id']}' $selected>{$user['vezeteknev']} {$user['keresztnev']} ({$user['num']})";
    }
    print "\n</select>";
    if($_REQUEST['autorefresh']){
        $checked = 'checked';
        print "<script>setTimeout( \"document.forms['wordManagement'].submit()\", 5 * 1000 );</script>";
    }
    else{
        $checked = '';
    }
    if((int)$_REQUEST['dictionaryUser'] > 0){
        print "<input type='checkbox' name='autorefresh' value='1' onchange='this.form.submit();' $checked>";
    }
    if(!$_REQUEST['dictionaryUser'] && $_REQUEST['dictionaryShow'] != 4){
        print "\n<select name='dictionaryLevel' onchange='this.form.submit();' style='width:140px'>";
        print "\n<option value='-1'>";
        foreach($optionArray as $key => $value){
            if($value[1] != 1 || $key == 0){
                continue;
            }
            if($key == (int)$_REQUEST['dictionaryLevel']){
                $selected = 'selected';
            }
            else{
                $selected = '';
            }
            print "<option value='{$key}' $selected>{$value[0]} (" . (int)$countOptionList[$key] . ")";
        }
        foreach($optionArray as $key => $value){
            if($value[1] != 2 || $key == 0){
                continue;
            }
            if($key == (int)$_REQUEST['dictionaryLevel']){
                $selected = 'selected';
            }
            else{
                $selected = '';
            }
            print "<option value='{$key}' $selected>{$value[0]} (" . (int)$countOptionList[$key] . ")";
        }
        print "\n</select>";
    }

    print "</td>";
}
?>

</tr>
</table>
<div id='allWords' style='width:405;height:360;overflow:auto;scrollbar-track-color:white;scrollbar-face-color:silver;scrollbar-highlight-color:black;scrollbar-shadow-color:gray'>
<table style='width:380' align='center' border='0' cellspacing='10' class='allWordsTable'>
<?php
$exceptionArray = array(0);

$wordCount = 0;
$hfCount = 0;
if($_REQUEST['dictionaryShow'] == 1 && $_REQUEST['kitolto']){
    $words = getAllWordsWithLevelExceptions(array(-1), $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv'], true);
    $langArray = getLangArray();
    foreach($langArray as $lang){
        $_levelList[$lang] = getLevelList($lang);
    }
    for($i = 0; $i < count($words); $i++){
        $isGood = false;
        foreach($_levelList as $lang => $levelArray){
            if($levelArray[$words[$i]["level_{$lang}"]][1] == 2 || $levelArray[$words[$i]["level_{$lang}"]][1] == 0){
                $isGood = true;
                break;
            }
        }
        if(!$isGood)
            continue;
        $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
        if($_REQUEST['orderLang'] == 'hun'){
            if($forrasWord && $forrasWord != '...' && (!$words[$i]['word_foreign'] || $words[$i]['word_foreign'] == '...')){
                print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link1_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td></tr>";
                $wordCount++;
            }
        }
        else{
            if($forrasWord && $forrasWord != '...' && (!$words[$i]['word_foreign'] || $words[$i]['word_foreign'] == '...')){
                print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link2_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td></tr>";
                $wordCount++;
            }
        }
    }
}
// level n�lk�liek
else if($_REQUEST['dictionaryShow'] == 3){
    $exceptionArray = array(-1);
    $words = getAllWordsWithLevelExceptions($exceptionArray, $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv'], false, true);
    $levelList = getLevelList($cel_nyelv_ext);
    for($i = 0; $i < count($words); $i++){
        if($words[$i]['level'] != 0 && array_key_exists($words[$i]['level'], $levelList)){
            continue;
        }
        $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
        if($_REQUEST['orderLang'] == 'hun'){
            print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link1_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td></tr>";
            $wordCount++;
        }
        else{
            print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link2_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td></tr>";
            $wordCount++;
        }
    }
}
else if($_REQUEST['dictionaryShow'] == 2 || ($_REQUEST['dictionaryShow'] == 4 && $_REQUEST['dictionaryUser'] > 0)){
    $homeWorks = getHomeWorks($_SESSION['userObject'], $_REQUEST['dictionaryUser'], (int)$_REQUEST['homeWorkOrder']);
    for($i = 0; $i < count($homeWorks); $i++){
        $forrasWord = $homeWorks[$i]["word_{$forras_nyelv_ext}"];
        if(($homeWorks[$i]['user_id'] == $userObject['id'] || $userHasAccess)
            && ($userHasAccess && $homeWorks[$i]['word_foreign']
                || $forrasWord)
            && $_REQUEST['dictionaryLevel'] <= 0)
        {
            $title = '';
            if($homeWorks[$i]['pronunc_foreign'] || $homeWorks[$i]['comment_foreign']){
                $titleText = $homeWorks[$i]['pronunc_foreign'];
                if($homeWorks[$i]['comment_foreign']){
                    $titleText .= " (" . $homeWorks[$i]['comment_foreign'] . ")";
                }
                $title = "title='{$titleText}'";
                $homeWork1 = '<u>' . $homeWorks[$i]['word_foreign'] . '</u>';
            }
            else{
                $homeWork1 = $homeWorks[$i]['word_foreign'];
            }

            $title2 = '';
            if($homeWorks[$i]["comment_{$forras_nyelv_ext}"]){
                $titleText2 = $homeWorks[$i]["comment_{$forras_nyelv_ext}"];
                $title2 = "title='{$titleText2}'";
                $homeWork2 = '<u>' . $forrasWord . '</u>';
            }
            else{
                $homeWork2 = $forrasWord;
            }

            if($_REQUEST['orderLang'] == 'hun'){
                print "\n<tr><td style='vertical-align:top' $title2><a name='link{$hfCount}' id ='link3_{$hfCount}' href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$globalcolor'>{$homeWork2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$globalcolor'>{$homeWork1}</a></td></tr>";
            }
            else{
                print "\n<tr><td style='vertical-align:top' $title><a name='link{$hfCount}' id ='link3_{$hfCount}' href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$globalcolor'>{$homeWork1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$globalcolor'>{$homeWork2}</a></td></tr>";
            }
            $hfCount++;
        }
    }
    // ha tan�r vagy admin
    if($userHasAccess){
        // ha nincs emberre lesz�rve
        if(!$_REQUEST['dictionaryUser']){
            $words = getAllWordsWithLevelExceptions($exceptionArray, $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv']);
            // 1-es level�ek
            for($i = 0; $i < count($words); $i++){
                $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                if($forrasWord && $words[$i]['word_foreign'] && $optionArray[$words[$i]['level']][1] == 1 && ($_REQUEST['dictionaryLevel'] <= 0 || $_REQUEST['dictionaryLevel'] == $words[$i]['level'])){
                    $allWordCount = $wordCount + $hfCount;
                    $title = '';
                    if($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']){
                        $titleText = $words[$i]['pronunc_foreign'];
                        if($words[$i]['comment_foreign']){
                            $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                        }
                        $title = "title='{$titleText}'";
                        $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                    }
                    else{
                        $word1 = $words[$i]['word_foreign'];
                    }

                    $title2 = '';
                    if($words[$i]["comment_{$forras_nyelv_ext}"]){
                        $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                        $title2 = "title='{$titleText2}'";
                        $word2 = '<u>' . $forrasWord . '</u>';
                    }
                    else{
                        $word2 = $forrasWord;
                    }

                    if($userHasAccess){
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top' $title2><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word1}</a></td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top' $title><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word2}</a></td></tr>";
                        }
                    }
                    else{
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top' $title2>{$word2}</td><td style='vertical-align:top' $title>{$word1}</td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top' $title>{$word1}</td><td style='vertical-align:top' $title2>{$word2}</td></tr>";
                        }
                    }
                    $wordCount++;
                }
            }
            // 2-es level�ek
            for($i = 0; $i < count($words); $i++){
                $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                if($forrasWord && $words[$i]['word_foreign'] && $optionArray[$words[$i]['level']][1] == 2 && ($_REQUEST['dictionaryLevel'] <= 0 || $_REQUEST['dictionaryLevel'] == $words[$i]['level'])){
                    $allWordCount = $wordCount + $hfCount;
                    if($userHasAccess){
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top'><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$words[$i]['word_foreign']}</a></td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top'><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$forrasWord}</a></td></tr>";
                        }
                    }
                    else{
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top;color:black'>{$forrasWord}</td><td style='vertical-align:top;color:black'>{$words[$i]['word_foreign']}</td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top;color:black'>{$words[$i]['word_foreign']}</td><td style='vertical-align:top;color:black'>{$forrasWord}</td></tr>";
                        }
                    }
                    $wordCount++;
                }
            }
        }
        else{
            $words = getUserWords(getUserObjById($_REQUEST['dictionaryUser']), 1, $_REQUEST['orderLang'], true);
            for($i = 0; $i < count($words); $i++){
                $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                if($forrasWord && $words[$i]['word_foreign']){
                    $allWordCount = $wordCount + $hfCount;
                    $title = '';
                    if($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']){
                        $titleText = $words[$i]['pronunc_foreign'];
                        if($words[$i]['comment_foreign']){
                            $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                        }
                        $title = "title='{$titleText}'";
                        $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                    }
                    else{
                        $word1 = $words[$i]['word_foreign'];
                    }

                    $title2 = '';
                    if($words[$i]["comment_{$forras_nyelv_ext}"]){
                        $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                        $title2 = "title='{$titleText2}'";
                        $word2 = '<u>' . $forrasWord . '</u>';
                    }
                    else{
                        $word2 = $forrasWord;
                    }

                    if($userHasAccess){
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top' $title2><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$word2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$word1}</a></td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' data-user='" . (int)$_REQUEST['dictionaryUser'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top' $title><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$word1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:black'>{$word2}</a></td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' data-user='" . (int)$_REQUEST['dictionaryUser'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                        }
                    }
                    else{
                        if($_REQUEST['orderLang'] == 'hun'){
                            print "\n<tr><td style='vertical-align:top;color:black' $title2>{$word2}</td><td style='vertical-align:top;color:black' $title>{$word1}</td></tr>";
                        }
                        else{
                            print "\n<tr><td style='vertical-align:top;color:black' $title>{$word1}</td><td style='vertical-align:top;color:black' $title2>{$word2}</td></tr>";
                        }
                    }
                    $wordCount++;
                }
            }
        }
    }
    else if(!$userHasAccess){
        $words = getUserWords($userObject, 1, $_REQUEST['orderLang'], true);
        for($i = 0; $i < count($words); $i++){
            $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
            if($forrasWord && $words[$i]['word_foreign']){
                $title = '';
                if($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']){
                    $titleText = $words[$i]['pronunc_foreign'];
                    if($words[$i]['comment_foreign']){
                        $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                    }
                    $title = "title='{$titleText}'";
                    $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                    $pronLinkWord = $words[$i]['word_foreign'];
                }
                else{
                    $word1 = $words[$i]['word_foreign'];
                    $pronLinkWord = $word1;
                }

                $title2 = '';
                if($words[$i]["comment_{$forras_nyelv_ext}"]){
                    $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                    $title2 = "title='{$titleText2}'";
                    $word2 = '<u>' . $forrasWord . '</u>';
                }
                else{
                    $word2 = $forrasWord;
                }
/*
print "Nyelv: ". deb($userObject['nyelv']);
print "Orderlang: ". deb($userObject['orderLang']);
*/
                // angol nyelv eset�n
                if($userObject['nyelv'] == 1){
                    $pronLink = "<a href=\"http://www.howjsay.com/index.php?word=" . urlencode($pronLinkWord) . "&submit=Submit\" target='_blank'>
                                    <img src='images/speaker.jpg' alt='Pronunciation' height='10' width='10'>
                                </a>";
                }

                if($_REQUEST['orderLang'] == 'hun'){
                    print "\n<tr><td style='vertical-align:top' $title2>{$word2}</td><td style='vertical-align:top' $title>{$word1} {$pronLink}</td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                }
                else{
                    print "\n<tr><td style='vertical-align:top' $title>{$word1} {$pronLink}</td><td style='vertical-align:top' $title2>{$word2}</td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                }
                $wordCount++;
            }
        }
    }
}
?>
</table></div>
<?php
print "</td></tr></table>";
print "\n<input type='hidden' name='actionType' value=''>";
print "\n<input type='hidden' name='content' value='wordManagement'>";
print "\n<input type='hidden' name='wordIdToEdit' value='" . $_REQUEST['wordIdToEdit'] . "'>";
print "</form>";

//if(!$userHasAccess){
    $wordCount = $hfCount;
//}

if(!$userHasAccess){
?>
<script>
    $('#txtListFilter').keyup(function(){
        var valThis = $(this).val().toLowerCase();
        $('.allWordsTable tr').each(function(){
            var text1 = $(this).find('td:eq(0)').text().toLowerCase();
            var text2 = $(this).find('td:eq(1)').text().toLowerCase();
            (text1.indexOf(valThis) >= 0 || text2.indexOf(valThis) >= 0) ? $(this).show() : $(this).hide();
        });
    });
</script>
<?php
}

//print "<script>document.getElementById('wordCountSpan').innerHTML = '{$wordCount}';";
if(($_REQUEST['dictionaryShow'] == 2 || $_REQUEST['dictionaryShow'] == 4) && $userHasAccess && $_REQUEST['dictionaryUser']){
    print "<script>";
    print "dictionaryUser = " . $_REQUEST['dictionaryUser'] . ';';
    print "</script>";
}

?>