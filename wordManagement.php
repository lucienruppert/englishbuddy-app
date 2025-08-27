<?php

include_once('functions.php');

// Initialize request variables
if (!isset($_POST['actionType'])) {
    $_POST['actionType'] = '';
}
if (!isset($_REQUEST['wordIdToEdit'])) {
    $_REQUEST['wordIdToEdit'] = 0;
}
if (!isset($_REQUEST['homeWorkOrder'])) {
    $_REQUEST['homeWorkOrder'] = 0;
}

// Initialize additional request variables to prevent undefined array key warnings
$_REQUEST['dictionaryShow'] = isset($_REQUEST['dictionaryShow']) ? $_REQUEST['dictionaryShow'] : '';
$_REQUEST['kitolto'] = isset($_REQUEST['kitolto']) ? $_REQUEST['kitolto'] : '';
$_REQUEST['orderLang'] = isset($_REQUEST['orderLang']) ? $_REQUEST['orderLang'] : '';
$_REQUEST['dictionaryUser'] = isset($_REQUEST['dictionaryUser']) ? (int)$_REQUEST['dictionaryUser'] : 0;
$_REQUEST['autorefresh'] = isset($_REQUEST['autorefresh']) ? $_REQUEST['autorefresh'] : '';
$_REQUEST['dictionaryLevel'] = isset($_REQUEST['dictionaryLevel']) ? (int)$_REQUEST['dictionaryLevel'] : -1;

if (!$userObject) {
    include_once('index.php');
    exit;
}
$userHasAccess = (in_array((int)$userObject['status'], array(4, 5, 6)));

$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
$cel_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['nyelv']);

if ($_POST['actionType'] == 'store') {
    if ((int)$userObject['id'] == 4) {
        $userId = 1;
    } else {
        $userId = (int)$userObject['id'];
    }

    if ($userHasAccess && (int)$_REQUEST['dictionaryUser'] > 0) {
        $userId = (int)$_REQUEST['dictionaryUser'];
    }

    $level = 0;
    $category = null;
    if (isset($_POST['levelSelection']) && (int)$_POST['levelSelection'] >= 0) {
        $level = (int)$_POST['levelSelection'];
    } else if (isset($_POST['levelSelection2']) && (int)$_POST['levelSelection2'] >= 0) {
        $level = (int)$_POST['levelSelection2'];
        $category = isset($_POST['categorySelection']) ? $_POST['categorySelection'] : null;
    }
    if (!checkWord(
        isset($_POST['recordId']) ? (int)$_POST['recordId'] : 0,
        isset($_POST['hunWord']) ? $_POST['hunWord'] : '',
        $_SESSION['userObject']['nyelv'],
        isset($_POST['foreignWord']) ? $_POST['foreignWord'] : ''
    )) {
        if ($_REQUEST['kitolto']) {
            $level = 0;
        }
        if (!storeWord(
            isset($_POST['recordId']) ? (int)$_POST['recordId'] : 0,
            isset($_POST['hunWord']) ? $_POST['hunWord'] : '',
            $_SESSION['userObject']['nyelv'],
            isset($_POST['foreignWord']) ? $_POST['foreignWord'] : '',
            isset($_POST['foreignComm']) ? $_POST['foreignComm'] : '',
            isset($_POST['sourceComm']) ? $_POST['sourceComm'] : '',
            $level,
            $userId,
            $category,
            $_REQUEST['kitolto']
        )) {
            print "<script>alert('" . translate("word_save_error") . "')</script>";
        } else {
            $_REQUEST['wordIdToEdit'] = 0;
        }
    } else {
        print "<script>alert('" . translate('word_exists_in_dictionary') . "')</script>";
    }
} else if ($_POST['actionType'] == 'delete') {
    $deleteReturn = deleteWord(
        isset($_POST['recordId']) ? (int)$_POST['recordId'] : 0,
        $_SESSION['userObject']['nyelv'],
        $_SESSION['userObject']['forras_nyelv'],
        ($_SESSION['userObject']['status'] != 6 && $_SESSION['userObject']['status'] != 5)
    );
    if ($deleteReturn === -1) {
        print "<script>alert('" . translate('word_delete_error') . "')</script>";
    } else if ($deleteReturn === 0) {
        print "<script>alert('" . translate('word_exists_in_other_lang') . "')</script>";
    } else {
        $_REQUEST['wordIdToEdit'] = 0;
    }
}

// Initialize $wordRecord with default values first
$wordRecord = array(
    'id' => '',
    'word_foreign' => '',
    'comment_foreign' => '',
    "word_{$forras_nyelv_ext}" => '',
    "comment_{$forras_nyelv_ext}" => '',
    'level' => 0,  // Initialize level with default value
    'category' => 0
);

// Then override with actual values if editing an existing word
if ($_REQUEST['wordIdToEdit'] > 0) {
    $wordRecord = array_merge($wordRecord, getWord((int)$_REQUEST['wordIdToEdit'], $_SESSION['userObject']['nyelv']));
}

$nyelvText = ucfirst(translate(getLangExtByLangId($userObject['nyelv'])));
$forrasNyelvText = ucfirst(translate(getLangExtByLangId($userObject['forras_nyelv'])));

print "<div style='border-left: 2px solid white; border-right: 2px solid white; border-bottom: 2px solid white; border-radius: 8px; padding: 20px; margin: 20px;'>";
print "<form id='wordManagement' name='wordManagement' method='post'>";
print "<input type='hidden' name='userId' value='" . (isset($_POST['userId']) ? htmlspecialchars($_POST['userId']) : '') . "'>";
print "<input type='hidden' name='recordId' value='" . $wordRecord['id'] . "'>";
print "<input type='hidden' name='homeWorkOrder' value='" . (isset($_POST['homeWorkOrder']) ? (int)$_POST['homeWorkOrder'] : 0) . "'>";
print "<table class='word-management' width='100%' style='border: 1px solid" . $highlight . ";margin-top:36px;' align=left><tr><td  style='border: 1px solid' align='center' valign='top'><table>";

$forWord = $wordRecord['word_foreign'];
if ($userObject['nyelv'] == 2) {
    if (!$forWord) {
        $forWord = "&iquest;&iexcl;&ntilde;";
    }
}

$sourceWord = $wordRecord["word_{$forras_nyelv_ext}"];
if ($userObject['forras_nyelv'] == 2) {
    if (!$sourceWord) {
        $sourceWord = "&iquest;&iexcl;&ntilde;";
    }
}

$hideStyle = '';
if (!$userHasAccess) {
    $hideStyle = "style='display:none'";
}
$readonly = '';
if (isset($_REQUEST['kitolto']) && $_REQUEST['kitolto']) {
    $readonly = 'readonly';
}

print "\n<tr><td style='font-size:0.8rem;color:white;'>" . $nyelvText . "</td><td><textarea name='foreignWord' style='color:white' rows='4' cols='29'>" . htmlspecialchars($forWord) . "</textarea></td></tr>";
print "\n<tr $hideStyle><td style='font-size:0.8rem;color:white;'>" . translate("cel_komment") . "</td><td><input type='text' size='35' name='foreignComm' value='" . htmlspecialchars($wordRecord['comment_foreign']) . "'></td></tr>";
print "\n<tr><td style='font-size:0.8rem;color:white;'>{$forrasNyelvText}</td><td><textarea name='hunWord' style='color:white' rows='4' cols='29' $readonly>" . htmlspecialchars($sourceWord) . "</textarea></td></tr>";
print "\n<tr $hideStyle><td style='font-size:0.8rem;color:white;'>" . translate("forras_komment") . "</td><td><input type='text' size='35' name='sourceComm' value='" . htmlspecialchars($wordRecord["comment_{$forras_nyelv_ext}"]) . "'></td></tr>";

if ($userHasAccess) {
    $optionArray = getLevelList($userObject['nyelv']);
    $countOptionList = getWordCountList($userObject['nyelv']);
}

print "<tr><td align=left style='vertical-align:top'><input type='button' name='store' value='" . translate('rogzit') . "' onclick=\"
    if(document.forms['wordManagement'].hunWord.value == '' || document.forms['wordManagement'].foreignWord.value == ''){
        alert('" . translate('both_field_required') . "');
        return false;
    }
    /* A 2. r�sz az�rt >0, mert ha fel�l Level0 van kiv�lasztva, alul meg valami m�s, akkor is menteni kell, �s az als�t kell figyelembe venni */
    console.log(document.forms['wordManagement'].levelSelection);
    if(document.forms['wordManagement'].levelSelection && document.forms['wordManagement'].levelSelection.value != -1 && document.forms['wordManagement'].levelSelection2.value > 0){
        alert('Csak egy level-t valaszthatsz ki!');
        return false;
    }
    document.forms['wordManagement'].actionType.value='store';
    document.forms['wordManagement'].submit();\"></td>";
if ($userHasAccess) {
    print "<td align='right'><select name='levelSelection2' style='color:white;background-color: $dark ;'>";
    print "<option value='-1'>";
    foreach ($optionArray as $key => $value) {
        if ($value[1] != 1) {
            continue;
        }
        if ($key == $wordRecord['level']) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        if ($key > 0) {
            //print "<option value='{$key}' $selected>(" . (int)$countOptionList[$key] . ") {$value[0]} ";
            print "<option value='{$key}' $selected> {$value[0]} - " . (int)$countOptionList[$key] . " ";
        } else {
            print "<option value='{$key}' $selected>{$value[0]}";
        }
    }
    print "</select>
    <select id='categorySelection' name='categorySelection' style='color:white;background-color:" . $dark . ";'>
        <option value=''></option>
        <option value='1' " . ($wordRecord['category'] == 1 ? 'selected' : '') . ">basic</option>
        <option value='2' " . ($wordRecord['category'] == 2 ? 'selected' : '') . ">sophisticated</option>
        <option value='3' " . ($wordRecord['category'] == 3 ? 'selected' : '') . ">rare</option>
    </select>
    </td>";

    print "</tr>";

    print "<tr><td align=left style='vertical-align:bottom'><input type='button' name='store' value='Delete' onclick=\"
        document.forms['wordManagement'].actionType.value='delete';
        document.forms['wordManagement'].submit();\"></td>

    <td align='right'><select name='levelSelection' size='12' style='color:white;background-color:" . $dark . ";'>";
    print "<option value='-1' selected>";
    foreach ($optionArray as $key => $value) {
        if ($value[1] != 2) {
            continue;
        }
        if ($key == $wordRecord['level']) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        print "<option value='{$key}' $selected>{$value[0]} - " . (int)$countOptionList[$key] . "";
    }
    print "</select></td></tr>";
}
print "</table></td><td valign='top'>";

?>
<script type="text/javascript">
    function wordLink(wordId, count) {
        document.forms['wordManagement'].wordIdToEdit.value = wordId;
        document.forms['wordManagement'].submit();
    }
</script>
<?php

if (!$_REQUEST['dictionaryShow']) {
    $_REQUEST['dictionaryShow'] = ($_REQUEST['kitolto'] ? 1 : ($userHasAccess ? 4 : 2));
}
$dictionaryShowSelected = array();
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 1 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 2 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 3 ? 'selected' : '');
$dictionaryShowSelected[] = ($_REQUEST['dictionaryShow'] == 4 ? 'selected' : '');

if ($_REQUEST['dictionaryShow'] != 2 && $_REQUEST['dictionaryShow'] != 4) {
    $_REQUEST['dictionaryUser'] = 0;
}
if (!$_REQUEST['orderLang']) {
    $_REQUEST['orderLang'] = 'foreign';
}

$wordUsers = getWordUsers($_SESSION['userObject']);

/* Sz�t�r r�sz */
print "<table width='400' align='center' style='border: 1px solid #334155; border-collapse: collapse;'><tr>";

if (!$userHasAccess) {
?>
    <td><input type='textbox' name='txtListFilter' id='txtListFilter' size='17'></td>
<?php } ?>
<td width='75'>
    <input type='button' name='orderButton' value=<?php

                                                    if ($_REQUEST['orderLang'] == 'foreign') {
                                                        print "'{$nyelvText} &rarr; {$forrasNyelvText}'";
                                                    } else {
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

if ($userHasAccess) { ?>
    <td>
        <select style='width:120px;color:white;background-color:<?php print $dark ?>;' name='dictionaryShow' onchange='this.form.submit();'>
            <option value='1' <?php print $dictionaryShowSelected[0]; ?>>Not filled out
            <option value='2' <?php print $dictionaryShowSelected[1]; ?>>All
            <option value='3' <?php print $dictionaryShowSelected[2]; ?>>Without levels
            <option value='4' <?php print $dictionaryShowSelected[3]; ?>>Your own
        </select>
    </td>
<?php
    if ($_REQUEST['kitolto']) {
        print "<input type='hidden' name='kitolto' value='1'>";
    }
} else {
    if ($_REQUEST['kitolto']) {
        print "<input type='hidden' name='dictionaryShow' value='1'>
                    <input type='hidden' name='kitolto' value='1'>";
    } else
        print "<input type='hidden' name='dictionaryShow' value='2'>";
}
?>

<input type='hidden' name='orderLang' value=<?php print "'{$_REQUEST['orderLang']}'"; ?>>


<td><input type='button' value=<?php print "'" . translate('frissit') . "'"; ?> onclick=" document.forms['wordManagement'].submit()">
</td>
<td><input type='button' value=<?php print "'" . translate('sorrend') . "'"; ?> onclick="document.forms['wordManagement'].homeWorkOrder.value = 1 - document.forms['wordManagement'].homeWorkOrder.value;document.forms['wordManagement'].submit()"></td>
<!--<td align='right'><span id='hfCountSpan' style='font-size:14pt;color:#1568A2'></span><span id='wordCountSpan' style='font-size:14pt'></span></td>-->
</tr>
<tr>
    <?php

    if ($userHasAccess && ($_REQUEST['dictionaryShow'] == 2 || $_REQUEST['dictionaryShow'] == 4)) {
        print "\n<td colspan='5' style='white-space: nowrap'>";
        print "\n<select style='color:white;background-color:" . $dark . ";' name='dictionaryUser' onchange='this.form.submit();'>";
        print "\n<option value='0'>";
        foreach ($wordUsers as $user) {
            if ($user['nyelv'] != $userObject['nyelv']) {
                continue;
            }
            if ($user['status'] == 1 || $user['status'] == 2) {
                continue;
            }
            if ((int)$user['user_id'] == (int)$_REQUEST['dictionaryUser']) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            print "\n<option value='{$user['user_id']}' $selected>{$user['vezeteknev']} {$user['keresztnev']} ({$user['num']})";
        }
        print "\n</select>";
        if ($_REQUEST['autorefresh']) {
            $checked = 'checked';
            print "<script>setTimeout( \"document.forms['wordManagement'].submit()\", 5 * 1000 );</script>";
        } else {
            $checked = '';
        }
        if ((int)$_REQUEST['dictionaryUser'] > 0) {
            print "<input type='checkbox' name='autorefresh' value='1' onchange='this.form.submit();' $checked>";
        }
        if (!$_REQUEST['dictionaryUser'] && $_REQUEST['dictionaryShow'] != 4) {
            print "\n<select name='dictionaryLevel' onchange='this.form.submit();' style='width:140px'>";
            print "\n<option value='-1'>";
            foreach ($optionArray as $key => $value) {
                if ($value[1] != 1 || $key == 0) {
                    continue;
                }
                if ($key == (int)$_REQUEST['dictionaryLevel']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $count = isset($countOptionList[$key]) ? (int)$countOptionList[$key] : 0;
                print "<option value='{$key}' $selected>{$value[0]} (" . $count . ")";
            }
            foreach ($optionArray as $key => $value) {
                if ($value[1] != 2 || $key == 0) {
                    continue;
                }
                if ($key == (int)$_REQUEST['dictionaryLevel']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $count = isset($countOptionList[$key]) ? (int)$countOptionList[$key] : 0;
                print "<option value='{$key}' $selected>{$value[0]} (" . $count . ")";
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
        if ($_REQUEST['dictionaryShow'] == 1 && $_REQUEST['kitolto']) {
            $words = getAllWordsWithLevelExceptions(array(-1), $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv'], true);
            $langArray = getLangArray();
            foreach ($langArray as $lang) {
                $_levelList[$lang] = getLevelList($lang);
            }
            for ($i = 0; $i < count($words); $i++) {
                $isGood = false;
                foreach ($_levelList as $lang => $levelArray) {
                    $levelKey = $words[$i]["level_{$lang}"];
                    if (
                        isset($levelArray[$levelKey]) &&
                        is_array($levelArray[$levelKey]) &&
                        isset($levelArray[$levelKey][1]) &&
                        ($levelArray[$levelKey][1] == 2 || $levelArray[$levelKey][1] == 0)
                    ) {
                        $isGood = true;
                        break;
                    }
                }
                if (!$isGood)
                    continue;
                $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                if ($_REQUEST['orderLang'] == 'hun') {
                    if ($forrasWord && $forrasWord != '...' && (!$words[$i]['word_foreign'] || $words[$i]['word_foreign'] == '...')) {
                        print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link1_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td></tr>";
                        $wordCount++;
                    }
                } else {
                    if ($forrasWord && $forrasWord != '...' && (!$words[$i]['word_foreign'] || $words[$i]['word_foreign'] == '...')) {
                        print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link2_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td></tr>";
                        $wordCount++;
                    }
                }
            }
        }
        // level n�lk�liek
        else if ($_REQUEST['dictionaryShow'] == 3) {
            $exceptionArray = array(-1);
            $words = getAllWordsWithLevelExceptions($exceptionArray, $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv'], false, true);
            $levelList = getLevelList($cel_nyelv_ext);
            for ($i = 0; $i < count($words); $i++) {
                if ($words[$i]['level'] != 0 && array_key_exists($words[$i]['level'], $levelList)) {
                    continue;
                }
                $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                if ($_REQUEST['orderLang'] == 'hun') {
                    print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link1_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td></tr>";
                    $wordCount++;
                } else {
                    print "\n<tr><td style='vertical-align:top'><a name='link{$wordCount}' id ='link2_{$wordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$wordCount});\">{$forrasWord}</a></td></tr>";
                    $wordCount++;
                }
            }
        } else if ($_REQUEST['dictionaryShow'] == 2 || ($_REQUEST['dictionaryShow'] == 4 && $_REQUEST['dictionaryUser'] > 0)) {
            $homeWorks = getHomeWorks($_SESSION['userObject'], $_REQUEST['dictionaryUser'], (int)$_REQUEST['homeWorkOrder']);
            for ($i = 0; $i < count($homeWorks); $i++) {
                $forrasWord = $homeWorks[$i]["word_{$forras_nyelv_ext}"];
                if (($homeWorks[$i]['user_id'] == $userObject['id'] || $userHasAccess)
                    && ($userHasAccess && $homeWorks[$i]['word_foreign']
                        || $forrasWord)
                    && $_REQUEST['dictionaryLevel'] <= 0
                ) {
                    $title = '';
                    if ($homeWorks[$i]['pronunc_foreign'] || $homeWorks[$i]['comment_foreign']) {
                        $titleText = $homeWorks[$i]['pronunc_foreign'];
                        if ($homeWorks[$i]['comment_foreign']) {
                            $titleText .= " (" . $homeWorks[$i]['comment_foreign'] . ")";
                        }
                        $title = "title='{$titleText}'";
                        $homeWork1 = '<u>' . $homeWorks[$i]['word_foreign'] . '</u>';
                    } else {
                        $homeWork1 = $homeWorks[$i]['word_foreign'];
                    }

                    $title2 = '';
                    if ($homeWorks[$i]["comment_{$forras_nyelv_ext}"]) {
                        $titleText2 = $homeWorks[$i]["comment_{$forras_nyelv_ext}"];
                        $title2 = "title='{$titleText2}'";
                        $homeWork2 = '<u>' . $forrasWord . '</u>';
                    } else {
                        $homeWork2 = $forrasWord;
                    }

                    if ($_REQUEST['orderLang'] == 'hun') {
                        print "\n<tr><td style='vertical-align:top' $title2><a name='link{$hfCount}' id ='link3_{$hfCount}' href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$highlight'>{$homeWork2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$highlight'>{$homeWork1}</a></td></tr>";
                    } else {
                        print "\n<tr><td style='vertical-align:top' $title><a name='link{$hfCount}' id ='link3_{$hfCount}' href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$highlight'>{$homeWork1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$homeWorks[$i]['id'] . ", {$hfCount});\" style='color:$highlight'>{$homeWork2}</a></td></tr>";
                    }
                    $hfCount++;
                }
            }
            // ha tan�r vagy admin
            if ($userHasAccess) {
                // ha nincs emberre lesz�rve
                if (!$_REQUEST['dictionaryUser']) {
                    $words = getAllWordsWithLevelExceptions($exceptionArray, $_REQUEST['orderLang'], $_SESSION['userObject']['nyelv']);
                    // 1-es level�ek
                    for ($i = 0; $i < count($words); $i++) {
                        $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                        if (
                            $forrasWord &&
                            $words[$i]['word_foreign'] &&
                            isset($optionArray[$words[$i]['level']]) &&
                            $optionArray[$words[$i]['level']][1] == 1 &&
                            ($_REQUEST['dictionaryLevel'] <= 0 || $_REQUEST['dictionaryLevel'] == $words[$i]['level'])
                        ) {
                            $allWordCount = $wordCount + $hfCount;
                            $title = '';
                            if ($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']) {
                                $titleText = $words[$i]['pronunc_foreign'];
                                if ($words[$i]['comment_foreign']) {
                                    $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                                }
                                $title = "title='{$titleText}'";
                                $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                            } else {
                                $word1 = $words[$i]['word_foreign'];
                            }

                            $title2 = '';
                            if ($words[$i]["comment_{$forras_nyelv_ext}"]) {
                                $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                                $title2 = "title='{$titleText2}'";
                                $word2 = '<u>' . $forrasWord . '</u>';
                            } else {
                                $word2 = $forrasWord;
                            }

                            if ($userHasAccess) {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top' $title2><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word1}</a></td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top' $title><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\">{$word2}</a></td></tr>";
                                }
                            } else {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top' $title2>{$word2}</td><td style='vertical-align:top' $title>{$word1}</td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top' $title>{$word1}</td><td style='vertical-align:top' $title2>{$word2}</td></tr>";
                                }
                            }
                            $wordCount++;
                        }
                    }
                    // 2-es level�ek
                    for ($i = 0; $i < count($words); $i++) {
                        $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                        if (
                            $forrasWord &&
                            $words[$i]['word_foreign'] &&
                            isset($optionArray[$words[$i]['level']]) &&
                            $optionArray[$words[$i]['level']][1] == 2 &&
                            ($_REQUEST['dictionaryLevel'] <= 0 || $_REQUEST['dictionaryLevel'] == $words[$i]['level'])
                        ) {
                            $allWordCount = $wordCount + $hfCount;
                            if ($userHasAccess) {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top'><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$forrasWord}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$words[$i]['word_foreign']}</a></td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top'><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$words[$i]['word_foreign']}</a></td><td style='vertical-align:top'><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$forrasWord}</a></td></tr>";
                                }
                            } else {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top;color:white'>{$forrasWord}</td><td style='vertical-align:top;color:white'>{$words[$i]['word_foreign']}</td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top;color:white'>{$words[$i]['word_foreign']}</td><td style='vertical-align:top;color:white'>{$forrasWord}</td></tr>";
                                }
                            }
                            $wordCount++;
                        }
                    }
                } else {
                    $words = getUserWords(getUserObjById($_REQUEST['dictionaryUser']), 1, $_REQUEST['orderLang'], true);
                    for ($i = 0; $i < count($words); $i++) {
                        $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                        if ($forrasWord && $words[$i]['word_foreign']) {
                            $allWordCount = $wordCount + $hfCount;
                            $title = '';
                            if ($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']) {
                                $titleText = $words[$i]['pronunc_foreign'];
                                if ($words[$i]['comment_foreign']) {
                                    $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                                }
                                $title = "title='{$titleText}'";
                                $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                            } else {
                                $word1 = $words[$i]['word_foreign'];
                            }

                            $title2 = '';
                            if ($words[$i]["comment_{$forras_nyelv_ext}"]) {
                                $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                                $title2 = "title='{$titleText2}'";
                                $word2 = '<u>' . $forrasWord . '</u>';
                            } else {
                                $word2 = $forrasWord;
                            }

                            if ($userHasAccess) {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top' $title2><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$word2}</a></td><td style='vertical-align:top' $title><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$word1}</a></td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' data-user='" . (int)$_REQUEST['dictionaryUser'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top' $title><a name='link{$allWordCount}' href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$word1}</a></td><td style='vertical-align:top' $title2><a href='#' onclick=\"wordLink(" . (int)$words[$i]['id'] . ", {$allWordCount});\" style='color:white'>{$word2}</a></td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' data-user='" . (int)$_REQUEST['dictionaryUser'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                                }
                            } else {
                                if ($_REQUEST['orderLang'] == 'hun') {
                                    print "\n<tr><td style='vertical-align:top;color:white' $title2>{$word2}</td><td style='vertical-align:top;color:white' $title>{$word1}</td></tr>";
                                } else {
                                    print "\n<tr><td style='vertical-align:top;color:white' $title>{$word1}</td><td style='vertical-align:top;color:white' $title2>{$word2}</td></tr>";
                                }
                            }
                            $wordCount++;
                        }
                    }
                }
            } else if (!$userHasAccess) {
                $words = getUserWords($userObject, 1, $_REQUEST['orderLang'], true);
                for ($i = 0; $i < count($words); $i++) {
                    $forrasWord = $words[$i]["word_{$forras_nyelv_ext}"];
                    if ($forrasWord && $words[$i]['word_foreign']) {
                        $title = '';
                        if ($words[$i]['pronunc_foreign'] || $words[$i]['comment_foreign']) {
                            $titleText = $words[$i]['pronunc_foreign'];
                            if ($words[$i]['comment_foreign']) {
                                $titleText .= " (" . $words[$i]['comment_foreign'] . ")";
                            }
                            $title = "title='{$titleText}'";
                            $word1 = '<u>' . $words[$i]['word_foreign'] . '</u>';
                            $pronLinkWord = $words[$i]['word_foreign'];
                        } else {
                            $word1 = $words[$i]['word_foreign'];
                            $pronLinkWord = $word1;
                        }

                        $title2 = '';
                        if ($words[$i]["comment_{$forras_nyelv_ext}"]) {
                            $titleText2 = $words[$i]["comment_{$forras_nyelv_ext}"];
                            $title2 = "title='{$titleText2}'";
                            $word2 = '<u>' . $forrasWord . '</u>';
                        } else {
                            $word2 = $forrasWord;
                        }
                        /*
print "Nyelv: ". deb($userObject['nyelv']);
print "Orderlang: ". deb($userObject['orderLang']);
*/
                        if ($_REQUEST['orderLang'] == 'hun') {
                            print "\n<tr><td style='vertical-align:top' $title2>{$word2}</td><td style='vertical-align:top' $title>{$word1}</td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                        } else {
                            print "\n<tr><td style='vertical-align:top' $title>{$word1}</td><td style='vertical-align:top' $title2>{$word2}</td><td><input type='checkbox' class='cbMark' data-wid='" . (int)$words[$i]['id'] . "' data-uwid='" . (int)$words[$i]['uw_id'] . "' " . ($words[$i]['my_is_marked'] == 1 ? "checked" : "") . "></td></tr>";
                        }
                        $wordCount++;
                    }
                }
            }
        }
        ?>
    </table>
</div>
<?php
print "</td></tr></table>";
print "\n<input type='hidden' name='actionType' value=''>";
print "\n<input type='hidden' name='content' value='wordManagement'>";
print "\n<input type='hidden' name='wordIdToEdit' value='" . $_REQUEST['wordIdToEdit'] . "'>";
print "</form>";
print "</div>";

//if(!$userHasAccess){
$wordCount = $hfCount;
//}

if (!$userHasAccess) {
?>
    <script>
        $('#txtListFilter').keyup(function() {
            var valThis = $(this).val().toLowerCase();
            $('.allWordsTable tr').each(function() {
                var text1 = $(this).find('td:eq(0)').text().toLowerCase();
                var text2 = $(this).find('td:eq(1)').text().toLowerCase();
                (text1.indexOf(valThis) >= 0 || text2.indexOf(valThis) >= 0) ? $(this).show(): $(this).hide();
            });
        });
    </script>
<?php
}

//print "<script>document.getElementById('wordCountSpan').innerHTML = '{$wordCount}';";
if (($_REQUEST['dictionaryShow'] == 2 || $_REQUEST['dictionaryShow'] == 4) && $userHasAccess && $_REQUEST['dictionaryUser']) {
    print "<script>";
    print "dictionaryUser = " . $_REQUEST['dictionaryUser'] . ';';
    print "</script>";
}

?>