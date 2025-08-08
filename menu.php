<?php
include_once('functions.php');

$GLOBALS['isAndroid'] = false;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (stripos($ua, 'android') !== false) { // && stripos($ua,'mobile') !== false) {
  $GLOBALS['isAndroid'] = true;
}
$homePosition = 'position:absolute;top:12px;left:50%;margin-left:-398px';
$timePosition = 'position:absolute;top:10px;left:50%;margin-left:240px';
$statsPosition = 'position:absolute;top:10px;left:50%;margin-left:150px';
$logoutPosition = 'position:absolute;top:12px;left:50%;margin-left:315px';
$quickLearningStyle = 'position:absolute;top:0px;';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
  <meta charset="UTF-8">
  <?php
  include_once('style-menu.php');
  include_once('style-navigation.php');
  ?>
  <link rel="stylesheet" type="text/css" href="css/superfish.css" />
</head>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/hoverIntent.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    if (typeof($('ul.sf-menu').superfish) == "function") {
      $('ul.sf-menu').superfish();
    }
  });

  var dictionaryUser = 0;
</script>

<?php
if ($userObject['id'] == 1) {
  $wordManagementText = "Szotar";
} else {
  $wordManagementText = "Bevitel";
}
?>

<div class="navigation-menu">
  <a href="index.php" class="home mobile-menu"><?php print translate('fooldal'); ?></a>
  <?php
  $upperRowObject = getLinksForPractice();
  if (is_array($upperRowObject) && !in_array($userObject["status"], array(1, 2))) {
    foreach ($upperRowObject as $currentItem) {
      if (!array_key_exists($userObject['nyelv'], $currentItem['langs']) || !array_key_exists($userObject['forras_nyelv'], $currentItem['langs'][$userObject['nyelv']])) continue;

      $content = str_replace('{include_file}', file_get_contents($currentItem['langs'][$userObject['nyelv']][$userObject['forras_nyelv']]), $currentItem['content']);
      print $content;
    }
  }
  ?>

  <!-- <div id='stats' style=<?php echo "\"{$statsPosition}\"" ?>>
    <table border='0' width='150px'>
      <tr>
        <td align='right' style=<?php print "'font-size:14;color:" . $globalcolor . ";'"; ?>><b><?php print(getUserWordHitByDay($userObject)); ?></td>
      </tr>
    </table>
  </div> -->
  <script>
    var selectedLevel = <?php print "'" . (isset($_REQUEST['selectedLevel']) ? $_REQUEST['selectedLevel'] : -1) . "'"; ?>;
    var source = <?php
                  print "'";
                  print isset($_REQUEST['source']) ? $_REQUEST['source'] : (isset($_SESSION['source']) ? $_SESSION['source'] : '');
                  print "'";  ?>;
    var ragozasWord = '';
  </script>

  <?php if ($_REQUEST['content'] !== 'wordLearning_quick') {
    include("ajaxSearch.php");
  } ?>

  <?php if ($userObject['nyelv'] == 2 || $userObject['forras_nyelv'] == 2) { ?>
    <div id='ragozas'><a href='#' onclick="window.open('http://www.wordreference.com/conj/ESverbs.aspx?v=' + ragozasWord,'Ragoz�s','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')">
        <font color='white'><?php print translate('ragozas'); ?>
      </a></div>
    <div id='spec_chars_ajax'><a href='#' onclick="document.getElementById('ajaxSearchInput').value += '&#241;';">
        <font color='white'>&ntilde;
      </a></div>
  <?php
  }
  ?>
</div>

<?php if (in_array($userObject['status'], array(5, 6)) && $_REQUEST['content'] != 'wordLearning_quick') { ?>
  <div id='tanitvanyok'>
    <!-- <a href='#' class="admin-info-board" onclick="
      event.stopPropagation();
      if(document.getElementById('clientDiv').style.display == 'none'){
        document.getElementById('clientDiv').style.display = 'block';
        document.getElementById('financeDiv').style.display = 'none';
        document.getElementById('mainDiv').style.display = 'none';
      }
      else{
        document.getElementById('clientDiv').style.display = 'none';
        document.getElementById('mainDiv').style.display = 'block';
      } "><?php print translate('tanulok'); ?></a> -->
  </div>
<?php } ?>

<?php if (in_array($userObject['status'], array(5, 6)) && $_REQUEST['content'] != 'wordLearning_quick') { ?>
  <div id='finance'>
    <!-- <a href='#' class="admin-info-board" onclick="
      event.stopPropagation();
      if(document.getElementById('financeDiv').style.display == 'none'){
        document.getElementById('financeDiv').style.display = 'block';
        document.getElementById('clientDiv').style.display = 'none';
        document.getElementById('mainDiv').style.display = 'none';
      }
      else{
        document.getElementById('financeDiv').style.display = 'none';
        document.getElementById('mainDiv').style.display = 'block';
      } "><?php print translate('tandijak'); ?></a> -->
  </div>
<?php } ?>

<?php
if (!isset($_REQUEST['sourcePage'])) {
  $_REQUEST['sourcePage'] = '';
}

if ($_REQUEST['sourcePage'] == 'clients') {
  $clientStyleText = "style='display:block'";
  $mainStyleText = "style='display:none'";
  $financeStyleText = "style='display:none'";
} else if ($_REQUEST['sourcePage'] == 'finance') {
  $clientStyleText = "style='display:none'";
  $mainStyleText = "style='display:none'";
  $financeStyleText = "style='display:block'";
} else {
  $clientStyleText = "style='display:none'";
  $mainStyleText = "style='display:block'";
  $financeStyleText = "style='display:none'";
}

//    if(in_array($userObject['status'], array(5, 6))){
if (in_array($userObject['status'], array(5, 6))) {
  print "\n<div id='clientDiv' {$clientStyleText}>\n";
  $formAction = "main.php?content=" . $_REQUEST['content'];
  include('clients.php');
  print "\n</div>";
}
if (in_array($userObject['status'], array(5, 6))) {
  print "\n<div id='financeDiv' {$financeStyleText}>\n";
  $formAction = "main.php?content=" . $_REQUEST['content'];
  include('finance.php');
  print "\n</div>";
}

if ($_REQUEST['content'] == "wordLearning_quick") {
  $style = "style='display:none'";
} else
  $style = "";
?>

<div id='nyelvtansorminta' <?php print $style; ?>>
  <?php
  $list = getLevelList($userObject['nyelv']);
  $levels = array();
  $levelIndex = 0;
  $bontasLimit = 10;
  $isLevelMaxed = ($userObject['max_level'] == 0);

  // Initialize first level
  $levels[$levelIndex] = array();

  foreach ($list as $key => $value) {
    if (in_array($value[1], array(1, 2, 3)) && $key > 0) {
      if (!in_array($value[1], array(1, 2))) {
        if (count($levels[$levelIndex]) >= $bontasLimit) {
          $levelIndex++;
          $levels[$levelIndex] = array(); // Initialize new level
        }
        $levels[$levelIndex][] = array($key, $value[0], $isLevelMaxed);
      }
      if ($userObject['max_level'] == $key) {
        $isLevelMaxed = true;
      }
    }
  }
  print "\n<ul class=\"sf-menu\">";
  $i = 1;
  foreach ($levels as $key => $level) {
    print "\n<li>";
    print "\n<a href=\"#\" onclick=\"event.stopPropagation();\">" . ($key * 10 + 1) . " - " . ($key * 10 + $bontasLimit) . "</a>";
    print "\n<ul>";
    foreach ($level as $sublevel) {
      print "\n<li><a href=\"#\" ";
      if (!$sublevel[2]) {
        $styleText = "style=\"color:#fff\"";
        print "onclick=\"
                        event.stopPropagation();
                        if(document.getElementById('ruleId').value == '{$sublevel[0]}'){
                            document.getElementById('ruleDiv').style.display = 'none';
                            document.getElementById('ruleId').value = '';
                        }
                        else{
                            getLevelInfo('{$sublevel[0]}', {$i});
                        }
                \"";
      } else {
        $styleText = "style=\"color:#aaa\"";
      }
      print " {$styleText}>" . ($i++) . ". {$sublevel[1]}</a></li>";
      /*
            if($sublevel[0] == $userObject['max_level']){
                $isUserLevelGood = false;
            }
            */
    }
    print "\n</ul>";
  }
  print "\n</ul>";
  ?>
</div>

<div id='ruleDiv' onclick="event.stopPropagation();this.style.display='none'">
  <input type='hidden' name='ruleId' id='ruleId' value=''>
  <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color:#334155;'>
    <tr>
      <td style='background-color:<?php print $highlight ?>;' height='50' align='center' colspan='3'><span id='ruleTitleSpan' style='font-size:20pt;color:white;'></span></td>
    </tr>
    <tr>
      <td height='50' colspan='3'></td>
    </tr>
    <tr>
      <td width='100'></td>
      <td align='left' valign='top' style='background-color:#334155;color:white;font-size:12pt;' height='300'>
        <span id='ruleTextContainer' style='display:block;background-color:#334155;color:white;'></span>
      </td>
      <td width='100'></td>
    </tr>
  </table>
</div>

<?php
function getLinksForPractice()
{

  /*if(!$GLOBALS['isAndroid'])*/ {

    $obj['igeragozas']['content'] = "<div id='igeragozas'>
           <a href='#' onclick=\"
            event.stopPropagation();
            if(document.getElementById('igeragozasDiv').style.display == 'none'){
                document.getElementById('igeragozasDiv').style.display = 'block';
                document.getElementById('mainDiv').style.display = 'none';
            }
            else{
                document.getElementById('igeragozasDiv').style.display = 'none';
                document.getElementById('mainDiv').style.display = 'block';
            }\" style=\"font-weight:normal;\">" . translate('igeragozas') . "</a>
            <div id='igeragozasDiv' style='display:none;' onclick=\"event.stopPropagation();this.style.display = 'none';\">{include_file}</div>
            </div>";

    // az elso index a celnyelv, a masodik a forrasnyelv
    $obj['igeragozas']['langs'][2][0] = 'verbos.html';
    $obj['igeragozas']['langs'][2][1] = 'verbos_eng.php';

    $obj['igeragozas']['langs'][3][0] = 'conjugation_arab3.php';

    $obj['abc']['content'] = "<td id='abc'><a href='#' style=\"font-weight:normal;\" onmouseover=\"document.getElementById('abctable').style.visibility = 'visible';\" onmouseout=\"document.getElementById('abctable').style.visibility = 'hidden';\">" . translate('abece') . "</a>
                                    <div id='abctable'>{include_file}</div></td>";

    $obj['abc']['langs'][2][0] = 'abc.html';
    $obj['abc']['langs'][2][1] = 'abc.html';

    $obj['kiejtes']['content'] = "<td id='kiejtes'><a href='#' style=\"font-weight:normal;\" onmouseover=\"document.getElementById('kiejtestable').style.visibility = 'visible';\" onmouseout=\"document.getElementById('kiejtestable').style.visibility = 'hidden';\">" . translate('kiejtes') . "</a>
                                        <div id='kiejtestable'>{include_file}</div></td>";

    $obj['kiejtes']['langs'][2][0] = 'kiejtes.html';
    $obj['kiejtes']['langs'][2][1] = 'kiejtes.html';

    $obj['kiejtes']['langs'][3][0] = 'hardsounds_arab.php';

    $obj['szorend']['content'] = "<td id='szorend' style=\"font-weight:normal;\"><a href='#' onclick=\"
                                                event.stopPropagation();
                                                if(document.getElementById('szorendtable').style.display == 'none'){
                                                    document.getElementById('szorendtable').style.display = 'block';
                                                }
                                                else{
                                                    document.getElementById('szorendtable').style.display = 'none';
                                                }
                                                \">" . translate('szorend') . "</a>
                                            <div id='szorendtable' style='display:none' onclick=\"event.stopPropagation();this.style.display = 'none';\">{include_file}</div></td>";

    $obj['szorend']['langs'][2][0] = 'szorend_sp.html';
    $obj['szorend']['langs'][2][1] = 'szorend_sp.html';

    $obj['szorend2']['content'] = "<td id='szorend2' style=\"font-weight:normal;\"><a href='#' class='hide-on-mobile'  style=\"margin-left:30px;\" onmouseover=\"document.getElementById('szorendtable2').style.display = 'block';\"
                                                    onmouseout=\"document.getElementById('szorendtable2').style.display = 'none';\"
                                                \">" . translate('szorend2') . "</a>
                                            <div id='szorendtable2'>{include_file}</div></td>";
    $obj['szorend2']['langs'][1][0] = 'szorend.html';
    $obj['szorend2']['langs'][1][2] = 'szorend_esp.html';

    $obj['szorend2']['langs'][4][0] = 'szorend_ger.html';

    $obj['nevmasok']['content'] = "<td id='nevmasok'><a href='#' class='hide-on-mobile' style=\"font-weight:normal;margin-left:30px;\" onmouseover=\"document.getElementById('nevmasoktable').style.visibility = 'visible';\" onmouseout=\"document.getElementById('nevmasoktable').style.visibility = 'hidden';\">" . translate('nevmasok') . "</a>
                                        <div id='nevmasoktable' class='hide-on-mobile'>{include_file}</div></td>";
    $obj['nevmasok']['langs'][1][0] = 'nevmasok_eng.html';
    $obj['nevmasok']['langs'][1][2] = 'nevmasok_eng_esp.html';
    $obj['nevmasok']['langs'][2][0] = 'nevmasok.html';
    $obj['nevmasok']['langs'][2][1] = 'nevmasok.html';
    $obj['nevmasok']['langs'][3][0] = 'nevmasok_arab.php';
    $obj['nevmasok']['langs'][4][0] = 'nevmasok_ger.html';

    $obj['rendhagyo']['content'] = "<td id='nevmasok''><a href='http://www.englishpage.com/irregularverbs/irregularverbs.html' class='hide-on-mobile' style=\"font-weight:normal;margin-left:30px;\" target='_blank'  >" . translate('rendhagyo_igek') . "</a></td>";
    $obj['rendhagyo']['langs'][1][0] = 'nevmasok_eng.html';
    $obj['rendhagyo']['langs'][1][2] = 'nevmasok_eng_esp.html';
  }

  return $obj;
}

?>