<?php
// Force UTF-8 output for all browsers
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}
if (!$_SESSION['userObject']) {
    session_start();
}

include_once('functions.php');

if (!$userObject) {
    include_once('index.php');
    exit;
}

$userHasAccess = ((int)$userObject['id'] == 1 || (int)$userObject['status'] == 5 || (int)$userObject['status'] == 6);

// Initialize isRuleEdit
$_REQUEST['isRuleEdit'] = $_REQUEST['isRuleEdit'] ?? '';

if (isset($_POST['storeRule']) && $_POST['storeRule']) {
    setLevelComment($_POST['selectedLevel'], $_POST['txtRule'], $userObject['nyelv']);
    $_REQUEST['isRuleEdit'] = '';
}

$text = getLevelComment($_REQUEST['selectedLevel'], $userObject['nyelv'], false);
$level = getLevelList($userObject['nyelv']);

$levels = array();
$levelIndex = 0;
$bontasLimit = 10;

$i = 1;
foreach ($level as $key => $value) {
    if (in_array($value[1], array(1, 2, 3)) && $key > 0) {
        if (!in_array($value[1], array(1, 2))) {
            if ($_REQUEST['selectedLevel'] == $key) {
                break;
            }
            $i++;
        }
    }
}
$title = $i . '. ' . mb_convert_encoding($level[$_REQUEST['selectedLevel']][0], 'UTF-8', 'auto');

if (!$text) {
    $text = "Nincs szöveg";
}

// Output meta charset for UTF-8
echo "<head><meta charset=\"utf-8\"></head>\n";
?>
<style>
    .envelopeTable table {
        font-size: inherit;
    }
</style>
<form name='ruleForm' action='main.php' id='ruleForm' method='post'>
    <input type='hidden' name='content' value='showRule'>
    <?php

    print "<table width='800px' border='0' cellspacing='0' cellpadding='0'>
            <tr>
                <td align='left' valign='middle' width='70px' style='background-color:orange;'><span id=\"prevLevelSpan\" style='background-color:orange;font-size:40pt;font-weight:bold;color:white;cursor:pointer' onclick=\"event.stopPropagation();location.href='main.php?content=changeLevelPage&direction=prev&selectedLevel=' + document.forms['ruleForm'].selectedLevel.value + '&source=' + document.forms['ruleForm'].source.value;\">&nbsp;&laquo;</span></td>
                <td style='background-color:orange;font-size:20pt;color:white;' height='50' align='center'>{$title}</td>
                <td align='right' valign='middle' width='70px' style='background-color:orange;'><span id=\"nextLevelSpan\" style='background-color:orange;font-size:40pt;font-weight:bold;color:white;cursor:pointer' onclick=\"event.stopPropagation();location.href='main.php?content=changeLevelPage&direction=next&selectedLevel=' + document.forms['ruleForm'].selectedLevel.value + '&source=' + document.forms['ruleForm'].source.value;\">&raquo;&nbsp;</span></td>
            </tr>
            <tr>
                <td height='25' colspan='3'></td>
            </tr>
            </table>
            <table width='800px' border='0' class='envelopeTable'>
            <tr>
                <td width='100'></td>
                <td align='left' valign='top' style='font-size:12pt;color:white;background-color:#003366;' height='300'>";
    if ($userHasAccess) {
        if (!isset($_REQUEST['isRuleEdit']) || empty($_REQUEST['isRuleEdit'])) {
            print "<span style='background-color:#003366;display:block;padding:10px;border-radius:6px;' onclick=\"document.forms['ruleForm'].isRuleEdit.value=1; document.forms['ruleForm'].submit();\">{$text}</span>";
        } else {
            $text = str_replace("<br>", chr(13) . chr(10), $text);
            print "<div style='background-color:#003366;padding:10px;border-radius:6px;'><textarea name='txtRule' style='color:white;background-color:#003366;' rows=15 cols=100>{$text}</textarea></div>";
            print "<br><input type='submit' value='Rögzít'>";
            print "<input type='hidden' name='storeRule' value='1'>";
        }
    } else {
        print "<span style='background-color:#003366;display:block;padding:10px;border-radius:6px;'><div style='position:absolute;top:50;left:0;width:100%;height:100%;'></div>{$text}</span>";
    }

    print "</td><td width='100'></td>
            </tr>
        </table>";
    print "<script>selectedLevel = '{$_REQUEST['selectedLevel']}';";
    if (!isPrevArrow($_REQUEST['selectedLevel'], $userObject, false) || $_REQUEST['source'] != 'tananyag') {
        print "\ndocument.getElementById('prevLevelSpan').innerHTML = '';";
    }
    if (!isNextArrow($_REQUEST['selectedLevel'], $userObject, false) || $_REQUEST['source'] != 'tananyag') {
        print "\ndocument.getElementById('nextLevelSpan').innerHTML = '';";
    }
    print "</script>";

    print "<input type='hidden' name='selectedLevel' value='{$_REQUEST['selectedLevel']}'>";
    print "<input type='hidden' name='isRuleEdit' value='{$_REQUEST['isRuleEdit']}'>";
    print "<input type='hidden' name='source' value='{$_REQUEST['source']}'>";
    ?>


</form>