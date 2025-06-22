<?php
global $_SESSION;

$KESZ_UGYES_VAGY = translate("kesz_ugyes_vagy");

if (!$userObject) {
    include_once('index.php');
    exit;
}
$ext = getLangExtByLangId($userObject['nyelv']);
$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

$defaultDirection = 0;
$showNumber = 0;

$levels = getLevelList($userObject['nyelv']);
$selectedLevel = isset($_REQUEST['selectedLevel']) ? $_REQUEST['selectedLevel'] : (isset($_SESSION['selectedLevel']) ? $_SESSION['selectedLevel'] : null);
$selLevel = isset($_REQUEST['selectedLevel']) ? $_REQUEST['selectedLevel'] : (isset($_SESSION['selectedLevel2']) ? $_SESSION['selectedLevel2'] : null);
$clickSource = isset($_REQUEST['clickSource']) ? $_REQUEST['clickSource'] : (isset($_SESSION['clickSource']) ? $_SESSION['clickSource'] : null);
$_SESSION['clickSource'] = $clickSource;

// Initialize filter with proper checks
$filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : (isset($_SESSION['intelligentFilterWord']) ? $_SESSION['intelligentFilterWord'] : '');
$filterChanged = !isset($_SESSION['intelligentFilterWord']) || $filter != $_SESSION['intelligentFilterWord'];
$_SESSION['intelligentFilterWord'] = $filter;

$GLOBALS['isAndroid'] = false;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (stripos($ua, 'android') !== false) { // && stripos($ua,'mobile') !== false) {
    $GLOBALS['isAndroid'] = true;
}

$questionedlineFontSize = 'font-size:20pt';
$questionedlineFontSize2 = 'font-size:10pt';
$solutionlineFontSize = 'font-size:30pt';
$ArrowFontSize = 'font-size:40pt';
$nemtudtamFontSize = 'font-size:20pt;color:white;';
$MiddleHeight = '100px';

// ha mondatokat gyakorlok
if ($selLevel == 'list2' || $levels[$selLevel][1] == 2) {
    $isSentence = true;
} else {
    $isSentence = false;
}

$userHits = getUserWordHitByDay($userObject);
$seconds = 0;

//print "SESSIONDIRECTION: " . $_SESSION['wordLearning_direction'];
if ($_REQUEST['store'] == 1) {
    if ($_SESSION['wordLearning_direction'] == 1) {
        $hunWord = $_REQUEST['sentenceHun'];
        $forWord = $_REQUEST['sentence']; //$_SESSION['wordLearning_words_simple'][0]['word_'. $ext];
    } else {
        $forWord = $_REQUEST['sentence'];
        $hunWord = $_REQUEST['sentenceHun']; //$_SESSION['wordLearning_words_groupby'][0]['word_hun'];
    }
    if ((int)$userObject['id'] == 1) {
        $userId = 4;
    } else {
        $userId = (int)$userObject['id'];
    }

    if (!checkWord(0, $hunWord, $_SESSION['userObject']['nyelv'], $forWord)) {
        if (!storeWord(0, $hunWord, $_SESSION['userObject']['nyelv'], $forWord, '', '', 0, $userId, 0)) {
            print "<script>alert('R�gz�t�s nem siker�lt!')</script>";
        }
    } else {
        print "<script>alert('Ez a sz� m�r megtal�lhat� a tud�st�rban, onnan kimentheted a sz�t�radba!')</script>";
    }
    if ($_SESSION['wordLearning_direction'] == 1) {
        //$words = $_SESSION['wordLearning_words_simple'];
    } else {
        $words = $_SESSION['wordLearning_words_groupby'];
    }
    if (count($words) == 0) {
        $showNumber = $KESZ_UGYES_VAGY;
    } else {
        $showNumber = count($words);
    }
} else if (($_REQUEST['selectedLevel'] > 0
        || in_array($_REQUEST['selectedLevel'], array('list1', 'list2'))
        || startsWith($_REQUEST['selectedLevel'], 'listFract_')
        || $_REQUEST['selectedLevel'] == 'listAll'
        || $_REQUEST['selectedLevel'] == 'mumus'
        || $_REQUEST['selectedLevel'] == 'tananyagAll'
        || $_REQUEST['againPractise']) && (!$_REQUEST['isOtherPackage'] || !$_SESSION['cbMultiPractice'])
) {
    if (in_array($_REQUEST['selectedLevel'], array('list1', 'list2')) || startsWith($_REQUEST['selectedLevel'], 'listFract_') || $_REQUEST['selectedLevel'] == 'listAll' || $_REQUEST['selectedLevel'] == 'mumus' || $_REQUEST['selectedLevel'] == 'tananyagAll') {
        $_SESSION['selectedLevel2'] = $_REQUEST['selectedLevel'];
    } else if ($_REQUEST['selectedLevel'] > 0) {
        $_SESSION['selectedLevel2'] = $_REQUEST['selectedLevel'];
        $_SESSION['wordLearning_level_rule'] = getLevelComment($selectedLevel, $userObject['nyelv'], false);
    } else {
        $selectedLevel = $_SESSION['selectedLevel2'];
    }

    if ($_REQUEST['source']) {
        $_SESSION['source'] = $_REQUEST['source'];
    } else {
        $_REQUEST['source'] = $_SESSION['source'];
    }
    if ($clickSource == 'sentencePractice2') {
        $count = 10;
    } else {
        $count = 300;
    }
    if ($_REQUEST['againPractise']) {
        $wordsGroupBy = $_SESSION['origChosenWords'];
    } else {
        $records = getFirstNWordsByLevelGroupBy($count, $selectedLevel, $ext, $userObject, $_SESSION['source']);
        if ($_SESSION['source'] == "alapSzo") {
            $wordsGroupBy = $records;
        } else {
            $wordsGroupBy = array();
            foreach ($records as $record) {
                if (count($record) > 1) {
                    for ($i = 1; $i < count($record); $i++) {
                        $record[0]['word_' . $ext] .= " / " . $record[$i]['word_' . $ext];
                        $record[0]['pronunc_' . $ext] .= " / " . $record[$i]['pronunc_' . $ext];
                        $record[0]['comment_' . $ext] .= " / " . $record[$i]['comment_' . $ext];
                    }
                }
                $wordsGroupBy[] = $record[0];
            }
        }
        $_SESSION['origChosenWords'] = $wordsGroupBy;
    }
    $words = $wordsGroupBy;

    if (count($words) > 0) {
        $userHits = incUserWordHitByDay($userObject);
    }

    if (defined("DEBUG")) {
        deb($words);
    }

    if (count($words) == 0) {
        $showNumber = $KESZ_UGYES_VAGY;
        if (startsWith($_SESSION['selectedLevel2'], 'listFract_') && $_SESSION['learningStartTime'] > 0) {
            $seconds = time() - $_SESSION['learningStartTime'];
            $package = (int)substr($_SESSION['selectedLevel2'], 10);
            $tipus = ($_SESSION['source'] == 'szo' ? 1 : ($_SESSION['source'] == 'mondat' ? 2 : ($_SESSION['source'] == 'szomondat' ? 3 : ($_SESSION['source'] == 'alapSzo' ? 4 :
                0))));
            setWordRecordIf($userObject, $tipus, $package, $seconds);
            $_SESSION['learningStartTime'] = 0;
        }
    } else {
        $showNumber = count($words);
        $_SESSION['wordLearning_words_groupby'] = $wordsGroupBy;
        if ($_REQUEST['selectedLevel'] > 0 || in_array($_REQUEST['selectedLevel'], array('list1', 'list2')) || startsWith($_REQUEST['selectedLevel'], 'listFract_')) {
            $_SESSION['wordLearning_direction'] = $defaultDirection;
        }
    }
    if (!$_REQUEST['againPractise'])
        $_SESSION['cbMultiPractice'] = null;
} else if ($clickSource == 'intelligent' && $filterChanged) {
    if ($_REQUEST['source']) {
        $_SESSION['source'] = $_REQUEST['source'];
    } else {
        $_REQUEST['source'] = $_SESSION['source'];
    }
    if ($_REQUEST['againPractise']) {
        $wordsGroupBy = $_SESSION['origChosenWords'];
    } else {
        $wordsGroupBy = getIntelligentFilteredWords($_REQUEST['filter']);
        $_SESSION['intelligentFilterWord'] = $_REQUEST['filter'];
        $_SESSION['origChosenWords'] = $wordsGroupBy;
    }
    $words = $wordsGroupBy;

    if (count($words) > 0) {
        $userHits = incUserWordHitByDay($userObject);
    }

    if (count($words) == 0) {
        $showNumber = $KESZ_UGYES_VAGY;
    } else {
        $showNumber = count($words);
        $_SESSION['wordLearning_words_groupby'] = $wordsGroupBy;
    }
    $_SESSION['cbMultiPractice'] = null;
} else if ($_REQUEST['actionType'] == 'multiPractice' || ($_REQUEST['isOtherPackage'] && $_SESSION['cbMultiPractice'])) {
    // ennyi sz�t vesz�nk el� minden kateg�ri�b�l
    $COUNT = 6;

    if (!$_REQUEST['isOtherPackage'])
        $_SESSION['cbMultiPractice'] = $_REQUEST['cbMultiPractice'];

    if ($_REQUEST['source']) {
        $_SESSION['source'] = $_REQUEST['source'];
    } else {
        $_REQUEST['source'] = $_SESSION['source'];
    }
    $count = 10;
    if ($_REQUEST['againPractise']) {
        $wordsGroupBy = $_SESSION['origChosenWords'];
    } else {
        $records = getFirstNWordsForMultiplePractice($COUNT, $_SESSION['cbMultiPractice'], $ext);
        $wordsGroupBy = array();
        foreach ($records as $record) {
            if (count($record) > 1) {
                for ($i = 1; $i < count($record); $i++) {
                    $record[0]['word_' . $ext] .= " / " . $record[$i]['word_' . $ext];
                    $record[0]['pronunc_' . $ext] .= " / " . $record[$i]['pronunc_' . $ext];
                    $record[0]['comment_' . $ext] .= " / " . $record[$i]['comment_' . $ext];
                }
            }
            $wordsGroupBy[] = $record[0];
        }
        $_SESSION['origChosenWords'] = $wordsGroupBy;
    }
    $words = $wordsGroupBy;
    if (count($words) > 0) {
        $userHits = incUserWordHitByDay($userObject);
    }

    if (count($words) == 0) {
        $showNumber = $KESZ_UGYES_VAGY;
    } else {
        $showNumber = count($words);
        $_SESSION['wordLearning_words_groupby'] = $wordsGroupBy;
        $_SESSION['wordLearning_direction'] = $defaultDirection;
    }
} else if (is_array($_SESSION['wordLearning_words_groupby'])) {
    if ($_REQUEST['inbetween'] == 1) {
        if ($_SESSION['wordLearning_direction'] != 1) {
            $current_word = array_shift($_SESSION['wordLearning_words_groupby']);
            if ($_REQUEST['stillPract'] == 1) {
                $_SESSION['wordLearning_words_groupby'][] = $current_word;
            }
        }
    } else if ($_REQUEST['directionChange'] == 1) {
        $_SESSION['wordLearning_direction'] = 1 - $_SESSION['wordLearning_direction'];
    }

    if ($_SESSION['wordLearning_direction'] != 1) {
        $words = $_SESSION['wordLearning_words_groupby'];
    }
    if ($_REQUEST['inbetween'] == 1 && count($words) > 0) {
        $userHits = incUserWordHitByDay($userObject);
    }

    if (count($words) == 0) {
        $showNumber = $KESZ_UGYES_VAGY;
        if (startsWith($_SESSION['selectedLevel2'], 'listFract_') && $_SESSION['learningStartTime'] > 0) {
            $seconds = time() - $_SESSION['learningStartTime'];
            $package = (int)substr($_SESSION['selectedLevel2'], 10);
            $tipus = ($_SESSION['source'] == 'szo' ? 1 : ($_SESSION['source'] == 'mondat' ? 2 : ($_SESSION['source'] == 'alapSzo' ? 4 : 0)));
            setWordRecordIf($userObject, $tipus, $package, $seconds);
            $_SESSION['learningStartTime'] = 0;
        }
    } else {
        $showNumber = count($words);
    }
} else {
    $_SESSION['cbMultiPractice'] = null;
}

print "
<script type='text/javascript'>
$(document).ready(function () {
";

print "
        $('#ajaxMeaningSearch').hide();
        $('#nyelvtansorminta').hide();
    ";

if ($_SESSION['source'] == 'alapSzo' || $_SESSION['source'] == 'szo') {
    print "
        $('#nyelvtansorminta').hide();
    ";
}

print "
    });
    </script>
    ";

?>
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css">
<style>
    div.ui-tooltip {
        max-width: 500px;
        white-space: pre-line;
    }

    #quickLearning {
        width: 100vw;
    }

    /* 
    #quickLearning * {
        border: 1px solid red;
    } */
</style>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#jelentesSpan, #origSpan").dblclick(function() {
            var text = "";
            if (document.selection) { //IE
                text = document.selection.createRange().text;
            } else {
                text = window.getSelection().toString();
            }
            if (text.trim()) {
                $("#ajaxSearchInput").val(text.trim());
                $("#ajaxSearchInput").trigger('keyup');
            }
        });

        $("#txtIntelligent").click(function(event) {
            event.stopPropagation();
        });

        $("#txtIntelligent").change(function() {
            location.href = 'main.php?content=wordLearning_quick&packageStart=1&source=mondat&clickSource=intelligent&filter=' + escape($(this).val());
        });
        $("#kikerdezo_info").tooltip({
            position: {
                my: "center+10 top-5",
                at: "center bottom"
            },
            content: function() {
                return $(this).attr("title");
            }
        });

    });

    function doOnClickBody() {
        if (!$('#jelentesSpan').is(':visible')) {
            $('#jelentesSpan').show();
            $('#elsoBetuSpan').hide();
        } else {
            location.href = 'main.php?content=wordLearning_quick&inbetween=1';
        }
    }

    var clearbox = new Array(); // global variable
    clearbox[0] = 0;
    clearbox[1] = 0;

    function clearit(obj, num) {
        if (clearbox[num] == 0) {
            obj.value = "";
            clearbox[num] = 1;
        }
    }

    document.onclick = doOnClickBody;
    if (document.getElementById('userHitSpan') != null) {
        document.getElementById('userHitSpan').innerHTML = <?php print $userHits; ?>
    }

    function betu1_Click() {
        if (jelentes.length == 0 || $("#jelentesSpan").is(":visible")) {
            return;
        }
        $("#elsoBetuSpan").show();
        var character = jelentes[0];
        jelentes = jelentes.substring(1);
        $("#elsoBetuSpan").text($("#elsoBetuSpan").text() + character);
    }
</script>

<?php
print "<div name='quickLearning' id='quickLearning' style=" . $quickLearningStyle . ">";
print "<table width='100%' cellspacing=0 cellpadding=0>";

$isArrowsHidden = $clickSource == 'wordPractice'
    || $clickSource == 'basicWordPractice'
    || $clickSource == 'sentencePractice'
    || $clickSource == 'wordSentencePractice'
    || $clickSource == 'intelligent';

if ($isArrowsHidden)
    $style = "display:none;";
else
    $style = "";

print "<tr>";

print "<td width='20px' align='left' valign='middle' style='background-color:$colorValue;'>
            <span id=\"prevLevelSpan\" style='background-color:$colorValue;$ArrowFontSize;font-weight:bold;color:white;cursor:pointer;$style' onclick=\"
                event.stopPropagation();
                location.href='main.php?content=changeLevelPage&direction=prev&selectedLevel=' + selectedLevel + '&source=' + source + '&clickSource=" . $_REQUEST['clickSource'] . "';
            \">&nbsp;&laquo;</span>
        </td>";
print "<td  colspan='3' align='center' height='50' valign='center' style='font-size:20pt;color:white;background-color:$colorValue'>";
if ($clickSource == "intelligent") {
    print "<input type='text'  size='15' style='border:1px solid #ffffff;background:grey;color:#ffffff;font-size:16pt' id='txtIntelligent' value='" . htmlentities($filter, ENT_QUOTES) . "'>";
} else {
    if (in_array($_SESSION['selectedLevel2'], array('list1', 'list2'))) {
        print "�sszes";
    }
    if (startsWith($_SESSION['selectedLevel2'], 'listFract_')) {
        $i = (int)substr($_SESSION['selectedLevel2'], 10);
        if ($_SESSION['source'] == 'szo' || $_SESSION['source'] == 'alapSzo') {
            $mult = $GLOBALS['szoPackageSize'];
        } else {
            $mult = $GLOBALS['mondatPackageSize'];
        }
        $text = (($i - 1) * $mult + 1) . " - " . ($i * $mult);
        // ez azt írja ki, hogy 1860-1870
        //print $text;
        // ez azt írja ki, hogy 187, mint kint a csomag száma
        print $i . ". " .  translate("csomag");
    } else if ($_SESSION['cbMultiPractice']) {
    } else {
        print $levels[$_SESSION['selectedLevel2']][0];
    }
}
print "</td>";
print "<td width='20px' align='right' valign='middle' style='background-color:$colorValue;'>
            <span id=\"nextLevelSpan\" style='background-color:$colorValue;$ArrowFontSize;font-weight:bold;color:white;cursor:pointer;$style' onclick=\"
                event.stopPropagation();
                location.href='main.php?content=changeLevelPage&direction=next&selectedLevel=' + selectedLevel + '&source=' + source + '&clickSource=" . $_REQUEST['clickSource'] . "';
            \">&raquo;&nbsp;</span>
        </td>";
print "</tr>";
/*
print "<tr><td align='center' height='20'><p>";
if($_REQUEST['selectedLevel'] > 0 || in_array($_REQUEST['selectedLevel'], array('list1', 'list2')) || $_REQUEST['againPractise']){
    print "<a href='#' onclick=\"
         document.onclick=null;
         location.href='main.php?content=wordLearning_quick&directionChange=1';\"><b>Ford�tva k�rdezzen!</a>";
}
print "</td></tr>";
*/
print "<tr>
        <td></td>
        <td colspan='3' align='center' valign='center' height='40' style='font-size:16pt;color:c8c8c8;background-color:;'><B>
        " . $showNumber . "</td>
        <td></td>
        </tr>
        <tr><td height='80'></td><td align='center' valign='top' colspan='3'>";

$wordAdd_hun = '';
$wordAdd_foreign = '';
$title_hun = '';
$title_foreign = '';

if ($words[0]['pronunc_' . $ext] && trim($words[0]['pronunc_' . $ext]) != '/') {
    $pieces = explode("/", trim($words[0]['pronunc_' . $ext]));
    $needTo = false;
    foreach ($pieces as $piece) {
        if (trim($piece) != '') {
            $needTo = true;
            break;
        }
    }
    if ($needTo) {
        $wordAdd_foreign = '*';
        $titleText = $words[0]['pronunc_' . $ext];
        $title_foreign = "({$titleText})";
    }
}

if ($words[0]['comment_' . $forras_nyelv_ext]) {
    $wordAdd_hun = '*';
    $titleText = $words[0]['comment_' . $forras_nyelv_ext];
    //$title_hun = "title='{$titleText}, " . $levels[$words[0]['level']][0] . "'";
    $title_hun = "(" . $levels[$words[0]['level']][0] . ", {$titleText})";
} else {
    $title_hun = "" . $levels[$words[0]['level']][0] . "";
}

if ($_SESSION['wordLearning_direction'] == 1) {
    $word1 = $words[0]['word_' . $ext];
    $word2 = $words[0]["word_{$forras_nyelv_ext}"];
    $title1 = $title_foreign;
    $title2 = $title_hun;
    $audio_word = $words[0]["word_{$forras_nyelv_ext}"];
    $isNeedAudioPart = ($levels[$words[0]["level"]][1] == 1) && ($forras_nyelv_ext == "angol");
} else {
    $word2 = $words[0]['word_' . $ext];
    $word1 = $words[0]["word_{$forras_nyelv_ext}"];
    $title1 = $title_hun;
    $title2 = $title_foreign;
    $audio_word = $words[0]['word_' . $ext];
    $isNeedAudioPart = ($levels[$words[0]["level"]][1] == 1) && ($ext == "angol");
}
if (($showNumber == $KESZ_UGYES_VAGY) && $seconds > 0) {
    print "<span id='origSpan' style='font-size:20pt;color:$highlight;' title=\"$title1\" onclick=\"event.stopPropagation();\">{$seconds} " . translate('masodperc') . "</span>";
} else {
    print "
        <span id='origSpan' style='$questionedlineFontSize;color:$highlight;' onclick=\"event.stopPropagation();\">{$word1}</span>
    ";
    if ($title1 != "()" && !$_SESSION['cbMultiPractice']) {
        print "
            <div style='$questionedlineFontSize2;'><br><font color='$globalcolor'>$title1</font></div>
        ";
    }
}
print "</td><td></td></tr><tr><td height='$MiddleHeight' colspan='5' align='center' valign='center'>";
print "<script>var jelentes = \"{$word2}\";</script>";
?>
<script>
    function mumus2_Click() {
        $.post("mumus_store.php", {
            wordId: <?php print "\"{$words[0]['id']}\""; ?>
        }, function() {
            location.href = 'main.php?content=wordLearning_quick&inbetween=1';
        });
    }

    function remove_Click() {
        $.post("remove_word.php", {
            wordId: <?php print "\"{$words[0]['id']}\""; ?>
        }, function() {
            location.href = 'main.php?content=wordLearning_quick&inbetween=1';
        });
    }
</script>


<?php
// Initialize audio_part variable
$audio_part = '';

print "<span id='elsoBetuSpan' style='display:none;$solutionlineFontSize;color:$globalcolor;' onclick=\"event.stopPropagation();\"></span>";
print "<span id='jelentesSpan' style='display:none;$solutionlineFontSize;color:$globalcolor;' onclick=\"event.stopPropagation();\">{$word2} {$title2}{$audio_part}</span>";
print "</td></tr>";

print "<tr><td></td>";
if ($showNumber != $KESZ_UGYES_VAGY) {
    for ($i = 0; $i < 100; $i++) {
        $nbspk .= '&nbsp;';
    }
    print "<td align='center' valign='center'>";
    print "<table><tr>";
    print "\n<td align='center' valign='center' style='background-color:$colorValue;padding:10px 10px;cursor:pointer;width:150px;height:70px;border-radius:20px;border: 5px solid " . $dark . "' onclick=\"event.stopPropagation();betu1_Click();\"><span style=" . $nemtudtamFontSize . ">" . translate('betu1') . "</span></td>";
    print "\n<td align='center' valign='center' style='background-color:$globalcolor;padding:10px 10px;cursor:pointer;border-radius:20px;width:150px;border: 5px solid " . $dark . "' onclick=\"event.stopPropagation();location.href='main.php?content=wordLearning_quick&inbetween=1&stillPract=1';\"><span style=" . $nemtudtamFontSize . ">" . translate('nem_tudtam') . "</span></td>";
    if ($clickSource != "sentencePractice" && $clickSource != "basicWordPractice" && $clickSource != "sentencePractice2" && $clickSource != "intelligent") {
        print "\n<td align='center' valign='center' class='show-button' style='background-color:$colorValue;padding:10px 10px;cursor:pointer;width:150px;border-radius:20px;border: 5px solid " . $dark . "' onclick=\"event.stopPropagation();mumus2_Click();\"><span style=" . $nemtudtamFontSize . ">" . translate('mumus2') . "</span></td>";
        print "\n<td align='center' valign='center' class='show-button' style='background-color:$colorValue;padding:10px 10px;cursor:pointer;width:150px;border-radius:20px;border: 5px solid " . $dark . "' onclick=\"event.stopPropagation();remove_Click();\"><span style=" . $nemtudtamFontSize . ">" . translate('remove') . "</span></td>";
    }
    print "</tr>";
    print "</table>";
    print "</td>";
} else {
    print "<td align='center' valign='center' style='background-color:$globalcolor;padding-top:10px;padding-bottom:10px;' onclick=\"event.stopPropagation();\">";
    if ($clickSource != "intelligent")
        print "\n<a href='#' style=" . $nemtudtamFontSize . " onclick=\"event.stopPropagation(); location.href='main.php?content=wordLearning_quick&againPractise=1&packageStart=1';\">" . translate("meg_egyszer") . "</a><br><br>";
    if ($clickSource == 'basicWordPractice') {
        $countBasicWords = getBasicWordCount($userObject);
        $packageRecordsBasicWords = getPackageRecords($userObject, 4);
        $partRowNumber = (int)($countBasicWords / $GLOBALS['szoPackageSize']);
        if ($partRowNumber * $GLOBALS['szoPackageSize'] < $countBasicWords) {
            $partRowNumber++;
        }
        $forSortArray = array();
        for ($i = 1; $i <= $partRowNumber; $i++) {
            if (('listFract_' . $i) == $selLevel)
                continue;

            $forSortArray[] = array(
                'ido' => $packageRecordsBasicWords[$i]['best_time'] > 0 ? $packageRecordsBasicWords[$i]['best_time'] : 999999,
                'szam' => $i
            );
        }
        $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);
        $newSelectedLevel = (int)$forSortArray[0]['szam'];
        print "\n<br><a href='#' style=" . $nemtudtamFontSize . " onclick=\"event.stopPropagation(); location.href='main.php?content=wordLearning_quick&packageStart=1&selectedLevel=listFract_{$newSelectedLevel}&source=alapSzo&clickSource={$clickSource}';\">" . translate('masik_csomag') . "</a>";
    } else {
        if (startsWith($_SESSION['selectedLevel2'], 'listFract_') && $_SESSION["source"] == "szo" && $clickSource == "wordPractice") {
            $goodLevelArray = array();
            foreach ($levels as $key => $value) {
                if ($value[1] == 1 && $key != 0) {
                    $goodLevelArray[] = $key;
                }
            }
            $countWords = getOwnWordCount($userObject, $goodLevelArray);
            $packageRecordsWords = getPackageRecords($userObject, 1);
            $partRowNumber = (int)($countWords / $GLOBALS['szoPackageSize']);
            if ($partRowNumber * $GLOBALS['szoPackageSize'] < $countWords) {
                $partRowNumber++;
            }
            $forSortArray = array();
            for ($i = 1; $i <= $partRowNumber; $i++) {
                if (('listFract_' . $i) == $selLevel)
                    continue;

                $forSortArray[] = array(
                    'ido' => $packageRecordsWords[$i]['best_time'] > 0 ? $packageRecordsWords[$i]['best_time'] : 999999,
                    'szam' => $i
                );
            }
            $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);
            //deb($forSortArray);
            $newSelectedLevel = 'listFract_' . (int)$forSortArray[0]['szam'];
        } else if (startsWith($_SESSION['selectedLevel2'], 'listFract_') && $_SESSION["source"] == "mondat" && $clickSource == "sentencePractice") {
            $goodLevelArray = array();
            foreach ($levels as $key => $value) {
                if ($value[1] == 2 && $key != 0) {
                    $goodLevelArray[] = $key;
                }
            }
            $countWords = getOwnWordCount($userObject, $goodLevelArray);
            $packageRecordsWords = getPackageRecords($userObject, 2);
            $partRowNumber = (int)($countWords / $GLOBALS['mondatPackageSize']);
            if ($partRowNumber * $GLOBALS['mondatPackageSize'] < $countWords) {
                $partRowNumber++;
            }
            $forSortArray = array();
            for ($i = 1; $i <= $partRowNumber; $i++) {
                if (('listFract_' . $i) == $selLevel)
                    continue;

                $forSortArray[] = array(
                    'ido' => $packageRecordsWords[$i]['best_time'] > 0 ? $packageRecordsWords[$i]['best_time'] : 999999,
                    'szam' => $i
                );
            }
            $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);
            $newSelectedLevel = 'listFract_' . (int)$forSortArray[0]['szam'];
        } else if (startsWith($_SESSION['selectedLevel2'], 'listFract_')) {
            $newSelectedLevel = 'listFract_' . (int)(substr($_SESSION['selectedLevel2'], 10) + 1);
        } else {
            $newSelectedLevel = (int)($_SESSION['selectedLevel2']);
        }
        if ($clickSource != "intelligent")
            print "\n<br><a href='#' style=" . $nemtudtamFontSize . " onclick=\"event.stopPropagation(); location.href='main.php?content=wordLearning_quick&packageStart=1&selectedLevel={$newSelectedLevel}&source={$_SESSION['source']}&clickSource={$clickSource}&isOtherPackage=1';\">" . translate('masik_csomag') . "</a><br><br>";
    }
    print "</td><td></td>";
}
print "</tr>";
print "</table>";

print "</div>";
$selectedLevel = ($selectedLevel ? $selectedLevel : $_REQUEST['selectedLevel']);
$selectedLevel = ($selectedLevel ? $selectedLevel : $_SESSION['selectedLevel2']);
$source = ($_REQUEST['source'] ? $_REQUEST['source'] : $_SESSION['source']);

print "<script>selectedLevel = '{$selectedLevel}';";

if (!isPrevArrow($selectedLevel, $userObject, ($_REQUEST['clickSource'] == "sentencePractice2")) || $source != 'tananyag') {
    print "\ndocument.getElementById('prevLevelSpan').innerHTML = '';";
}
if (!isNextArrow($selectedLevel, $userObject, ($_REQUEST['clickSource'] == "sentencePractice2")) || $source != 'tananyag') {
    print "\ndocument.getElementById('nextLevelSpan').innerHTML = '';";
}
print "</script>";


// a kikommentezés azért kellett, mert az utolsó csomagban lehet, hogy soha nincs annyi sz�, amennyi a $GLOBALS...-ban van, ez�rt annak soha nem mérték az idejét
if ($_REQUEST['packageStart'] && ((($source == 'szo' || $source == 'alapSzo') /*&& $showNumber == $GLOBALS['szoPackageSize']*/) || ($source == 'mondat' /*&& $showNumber == $GLOBALS['mondatPackageSize']*/))) {
    //print "<script>alert('learningStartTime');</script>";
    $_SESSION['learningStartTime'] = time();
}

?>