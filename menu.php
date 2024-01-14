<?php
    include_once('functions.php');

    $GLOBALS['isAndroid'] = false;
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
        $GLOBALS['isAndroid'] = true;
    }
    if($isAndroid){
        //$androidText = "EZ ANDROID!";
        $homeFontSize = 'font-size:10pt';
        $homePosition = 'position:absolute;top:12px;left:50%;margin-left:-398px';
        $logoutPosition = 'position:absolute;top:12px;left:50%;margin-left:315px';
        $quickLearningPosition = 'position:absolute;top:0px;left:50%;margin-left:0px';
       }
    else{
        //$androidText = "EZ NEM ANDROID!";
        $homeFontSize = 'font-size:10pt';
        $homePosition = 'position:absolute;top:12px;left:50%;margin-left:-398px';
        $timePosition = 'position:absolute;top:10px;left:50%;margin-left:240px';
        $statsPosition = 'position:absolute;top:10px;left:50%;margin-left:150px';
        $logoutPosition = 'position:absolute;top:12px;left:50%;margin-left:315px';
        $quickLearningPosition = 'position:absolute;top:0px;left:50%;margin-left:0px';
    }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<style>
body{
	margin:0;
	padding:0;
    }
img{
	border:none;
    }

#ragozas{
            position:absolute;top:44px;left:50%;margin-left:-190px;}
#spec_chars_ajax{
            position:absolute;top:44px;left:50%;margin-left:-130px;}
#abctable{
            position:absolute;top:25px;left:50%;margin-left:-290px;visibility:hidden;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;}
#kiejtestable{
            position:absolute;top:25px;left:50%;margin-left:-500px;visibility:hidden;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;}
#nevmasoktable{
            position:absolute;top:25px;left:50%;margin-left:-472px;visibility:hidden;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;}
#menu{
            position:absolute;top:10px;left:50%;margin-left:-300px;}
#stats{
            position:absolute;top:4px;left:50%;margin-left:160px;}
.smallerCell{
            color:#d8d8d8;}
.meaningCell{
            font-style:italic;}
.meaningA{
            font-size:15px;font-family:arial;}
.meaningLevel2Cell{
            font-weight:normal;}
.meaningLevel2A{
            font-weight:normal;font-size:15px;font-family:arial;}
#upperRowDiv{
    position:absolute;width:800px;top:0px;left:50%;margin-left:-335px;
}
#szorendtable{
            position:absolute;overflow:auto;top:25px;left:50%;margin-left:-472px;display:none;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;border:1px solid grey;}
#szorendtable2{
            position:absolute;overflow:auto;height:390px;top:25px;left:50%;margin-left:-472px;display:none;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;}
#arrow_balra{
            position:absolute;top:15px;left:50%;margin-left:-183px;}
#arrow_jobbra{
            position:absolute;top:15px;left:50%;margin-left:105px;}
#nyelvtansorminta{
            position:absolute;top:42px;left:50%;margin-left:-97px;}
#time{
            position:absolute;top:4px;left:50%;margin-left:-35px;}
#tanitvanyok{
            position:absolute;top:12px;left:50%;margin-left:200px;}
#finance{
            position:absolute;top:12px;left:50%;margin-left:100px;}
#logout{
            position:absolute;top:12px;left:50%;margin-left:315px;}
#ruleDiv{
            position:absolute;overflow:auto;height:400px;width:830px;top:65px;left:50%;margin-left:-415px;display:none;background-color:white;z-index:10;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;border:1px solid grey;}
#clientDiv{
            position:absolute;top:35px;left:50%;margin-left:-405px;display:none;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;border:1px solid grey;}
#financeDiv{
            position:absolute;top:35px;left:50%;margin-left:-405px;display:none;background-color:white;
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0, 0, 0); 
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:100;padding:5px;border:1px solid grey;
            }
#igeragozasDiv{
            position:absolute;overflow:auto;height:420px;top:25px;left:50%;margin-left:-405px;display:none;background-color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;border:1px solid grey;}
#ajaxMeaningSearch{
            position:absolute;top:35px;left:50%;margin-left:-400px;}
#moreMeaningDiv{
            position:absolute;overflow:auto;top:30px;background:<?php print "'" . $globalcolor . "'"; ?>;color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;
            <?php
            if($isAndroid) {
				print "height:400px;";
			}
            else {
                print "width:500px;";
                print "left:50%;margin-left:-400px;height:400px;";
            }
            ?>
}
.btnAjaxDivSave{
    border:1px solid grey;
    background:white;
    cursor:pointer;
    <?php
    if($isAndroid) {
        //print "font-size:20pt; padding: 1px 20px;";
		print "font-size:10pt; padding: 1px 20px;";
    }
    else {
        print "padding: 1px 3px;";
    }
    ?>
}
#ajaxSearchOutput{
            position:absolute;overflow:auto;top:8px;left:50%;margin-left:-200px;width:100px;height:22px;text-align:center;background:<?php print "'" . $globalcolor . "'"; ?>;color:white;
            filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;}
#ajaxTable #ajaxTableFirstTd{
    display:none;    
}
</style>
<link rel="stylesheet" type='text/css' href='style.css'>
<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/hoverIntent.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        if (typeof($('ul.sf-menu').superfish) == "function") {
            $('ul.sf-menu').superfish();
        }
    });

    var dictionaryUser = 0;
</script>

<?php
    if($userObject['id'] == 1){
      $wordManagementText = "Sz�t�r";
    }
    else{
      $wordManagementText = "Bevitel";
    }
?>

<div id='home' style=<?php echo "\"{$homePosition}\"" ?>>
<a style=<?php echo "\"{$homeFontSize}\"" ?> href="index.php"><font color=<?php print "'" . $globalcolor . "'"; ?>><b><u><?php print translate('fooldal'); ?></u></b></a>
</div>

<div id='stats' style=<?php echo "\"{$statsPosition}\"" ?>>
<table border='0' width='150px'><tr><td align='right' style=<?php print "'font-size:14;color:" . $globalcolor . ";'"; ?>><b><?php print (getUserWordHitByDay($userObject)); ?></td></tr></table>
</div>
<!--
<div id='time' style=<?php echo "\"{$timePosition}\"" ?>>
<table border='0'><tr><td align='right'><b><span style='font-size:14;color:#A05A36;'><b><?php print getUsedTime($userObject['id']); ?></span></td></tr></table>
</div>
--->
<?php

//if($userObject['id'] == 1 || $userObject['id'] == 4){
//?>
<?php
/*
    <div id='arrow_balra'>
    <span id="prevLevelSpan" style='font-size:80;font-weight:bold;color:#41B8F2;cursor:pointer' onclick="event.stopPropagation();location.href='main.php?content=changeLevelPage&direction=prev&selectedLevel=' + selectedLevel + '&source=' + source;">&larr;</span>
    </div>

    <div id='arrow_jobbra'>
    <span id="nextLevelSpan" style='font-size:80;font-weight:bold;color:#41B8F2;cursor:pointer' onclick="event.stopPropagation();location.href='main.php?content=changeLevelPage&direction=next&selectedLevel=' + selectedLevel + '&source=' + source;">&rarr;</span>
    </div>
*/
?>
<?php
//}
//?>

<!--
<div id='menu' align='left'>
    <?php if($userObject['id'] == 1){ ?>
    &nbsp;<a href='#' onclick="document.onclick=null;location.href='main.php?content=igeragozas'"><font color=#8D38C9>a.</a>
    &nbsp;<a href='#' onclick="document.onclick=null;location.href='main.php?content=sentenceLearning'"><font color=#8D38C9>b.</a>
    &nbsp;<a href='#' onclick="document.onclick=null;location.href='main.php?content=createSentences'"><font color=#8D38C9>c.</a>
 <? } ?>
</div>
-->
<script>
    var selectedLevel = <?php print "'" . ($_REQUEST['selectedLevel'] ? $_REQUEST['selectedLevel'] : -1) . "'"; ?>;
    var source = <?php
        print "'";
        print $_REQUEST['source'] ? $_REQUEST['source'] : ($_SESSION['source'] ? $_SESSION['source'] : '');
        print "'";  ?>;
    var ragozasWord = '';
</script>

<?php include("ajaxSearch.php"); ?>

<?php if($userObject['nyelv'] == 2 || $userObject['forras_nyelv'] == 2){ ?>
    <div id='ragozas'><a href='#' onclick="window.open('http://www.wordreference.com/conj/ESverbs.aspx?v=' + ragozasWord,'Ragoz�s','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')"><font color='white'><?php print translate('ragozas'); ?></a></div>
    <div id='spec_chars_ajax'><a href='#' onclick="document.getElementById('ajaxSearchInput').value += '&#241;';"><font color='white'>&ntilde;</a></div>
<?php
    }

    // itt rakjuk ki a fels� sor linkjeit a hozz�juk tartoz� div-ekkel egy�tt

    $upperRowObject = getUpperRowObject();
    print "<div id='upperRowDiv'><table border='0' cellpadding='8' style='border: 0px solid #f2f2f2;background-color:#f2f2f2;' onclick='event.stopPropagation();'><tr>";
    if(is_array($upperRowObject) && !in_array($userObject["status"], array(1, 2))){
        foreach($upperRowObject as $currentItem){
            if(!array_key_exists($userObject['nyelv'], $currentItem['langs']) || !array_key_exists($userObject['forras_nyelv'], $currentItem['langs'][$userObject['nyelv']])) continue;

            $content = str_replace('{include_file}', file_get_contents($currentItem['langs'][$userObject['nyelv']][$userObject['forras_nyelv']]), $currentItem['content']);
            print $content/* . '&nbsp;&nbsp;'*/;
        }
    }
    print "</tr></table></div>";

?>

<?php if(!$GLOBALS['isAndroid']){ ?>
<div id='logout' style=<?php echo "\"{$logoutPosition}\"" ?>><a href='#' style=<?php echo "\"{$homeFontSize}\"" ?> onclick="document.onclick=null;location.href='logout.php'"><font color=<?php print "'" . $globalcolor . "'"; ?>><b><u><?php print translate('kijelentkezes'); ?></u></b></a></div>
<?php  } else { ?>
	<div id='logout' style=<?php echo "\"{$logoutPosition}\"" ?>><a href='#' style=<?php echo "\"{$homeFontSize}\"" ?> onclick="document.onclick=null;location.href='logout.php'"><font color=<?php print "'" . $globalcolor . "'"; ?>><b><u><?php print translate('kijelentkezes'); ?></u></b></a></div>
<?php
}

 ?>

<?php if(in_array($userObject['status'], array(5, 6)) && $_REQUEST['content'] != 'wordLearning_quick') { ?>
    <div id='tanitvanyok'>
           <a href='#' onclick="
            event.stopPropagation();
            if(document.getElementById('clientDiv').style.display == 'none'){
                document.getElementById('clientDiv').style.display = 'block';
                document.getElementById('financeDiv').style.display = 'none';
                document.getElementById('mainDiv').style.display = 'none';
            }
            else{
                document.getElementById('clientDiv').style.display = 'none';
                document.getElementById('mainDiv').style.display = 'block';
            } "style="font-weight:bold;">t</a>
    </div>
<?php } ?>

<?php if(in_array($userObject['status'], array(5, 6)) && $_REQUEST['content'] != 'wordLearning_quick') { ?>
    <div id='finance'>
           <a href='#' onclick="
            event.stopPropagation();
            if(document.getElementById('financeDiv').style.display == 'none'){
                document.getElementById('financeDiv').style.display = 'block';
                document.getElementById('clientDiv').style.display = 'none';
                document.getElementById('mainDiv').style.display = 'none';
            }
            else{
                document.getElementById('financeDiv').style.display = 'none';
                document.getElementById('mainDiv').style.display = 'block';
            } "style="font-weight:bold;">p</a>
    </div>
<?php } ?>

<?php
    if($_REQUEST['sourcePage'] == 'clients'){
        $clientStyleText = "style='display:block'";
        $mainStyleText = "style='display:none'";
        $financeStyleText = "style='display:none'";
    }
    else if($_REQUEST['sourcePage'] == 'finance'){
        $clientStyleText = "style='display:none'";
        $mainStyleText = "style='display:none'";
        $financeStyleText = "style='display:block'";
    }
    else{
        $clientStyleText = "style='display:none'";
        $mainStyleText = "style='display:block'";
        $financeStyleText = "style='display:none'";
    }

//    if(in_array($userObject['status'], array(5, 6))){
    if(in_array($userObject['status'], array(5, 6))){
        print "\n<div id='clientDiv' {$clientStyleText}>\n";
        $formAction = "main.php?content=" . $_REQUEST['content'];
        include('clients.php');
        print "\n</div>";
    }
    if(in_array($userObject['status'], array(5, 6))){
        print "\n<div id='financeDiv' {$financeStyleText}>\n";
        $formAction = "main.php?content=" . $_REQUEST['content'];
        include('finance.php');
        print "\n</div>";
    }
    
    if($_REQUEST['content'] == "wordLearning_quick"){
        $style = "style='display:none'";
    }
    else
        $style = "";
?>

 <div id='nyelvtansorminta' <?php print $style; ?>>
 <?php
/*if(!$GLOBALS['isAndroid'])*/{
    $list = getLevelList($userObject['nyelv']);
    $levels = array();
    $levelIndex = 0;
    $bontasLimit = 10;
    $isLevelMaxed = ($userObject['max_level'] == 0);

    foreach($list as $key => $value){
        if(in_array($value[1], array(1, 2, 3)) && $key > 0){
            if(!in_array($value[1], array(1, 2))){
                if(count($levels[$levelIndex]) >= $bontasLimit){
                    $levelIndex++;
                }
                $levels[$levelIndex][] = array($key, $value[0], $isLevelMaxed);
            }
            if($userObject['max_level'] == $key){
                $isLevelMaxed = true;
            }
        }
    }
    print "\n<ul class=\"sf-menu\">";
    //$isUserLevelGood = true;
    $i = 1;
    foreach($levels as $key => $level){
        print "\n<li>";
        print "\n<a href=\"#\" onclick=\"event.stopPropagation();\">" . ($key * 10 + 1) . " - " . ($key * 10 + $bontasLimit) . "</a>";
        print "\n<ul>";
        foreach($level as $sublevel){
            print "\n<li><a href=\"#\" ";
            if(!$sublevel[2]){
                //$styleText = "style=\"color:#fff\"";
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
            }
            else{
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
    }
    /*
    print "<table border=1><tr>";
    $i = 1;
    $isUserLevelGood = true;
    foreach($list as $key => $value){
        if(in_array($value[1], array(1, 2, 3)) && $key > 0){
            if(!in_array($value[1], array(1, 2))){
                if($isUserLevelGood){
                    $styleColor = "color:$globalcolor;";
                }
                else{
                    $styleColor = "";
                }
                print "<td style='padding: 0 1px;cursor:pointer;$styleColor' title=\"" . htmlspecialchars($value[0]) . "\"";
                if($isUserLevelGood){
                    print " onclick=\"
                        event.stopPropagation();
                        if(document.getElementById('ruleId').value == '$key'){
                            document.getElementById('ruleDiv').style.display = 'none';
                            document.getElementById('ruleId').value = '';
                        }
                        else{
                            getLevelInfo('{$key}');
                        }
                    \"";
                }
                print ">" . str_pad($i++, 2, "0", STR_PAD_LEFT) . "</td>";
            }
            if($key == $userObject['max_level']){
                $isUserLevelGood = false;
            }
        }
    }
    print "</tr></table>";
    */
?>
</div>

<div id='ruleDiv' onclick="event.stopPropagation();this.style.display='none'">
    <input type='hidden' name='ruleId' id='ruleId' value=''>
    <table width='800px' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td style='background-color:grey;' height='50' align='center' colspan='3'><span id='ruleTitleSpan' style='background-color:grey;font-size:20pt;color:white;'></span></td>
        </tr>
        <tr>
            <td height='50' colspan='3'></td>
        </tr>
        <tr>
            <td width='100'></td>
            <td align='left' valign='top' style='color:black;font-size:12pt;' height='300'>
                <span id='ruleTextContainer'></span>
            </td>
            <td width='100'></td>
        </tr>
    </table>
</div>
<?php

    function getUpperRowObject()
    {

     /*if(!$GLOBALS['isAndroid'])*/{

       $obj['igeragozas']['content'] = "<td id='igeragozas'>
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
            </td>";

        // az els� index a c�lnyelv, a m�sodik a forr�snyelv
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

            $obj['szorend2']['content'] = "<td id='szorend2' style=\"font-weight:normal;\"><a href='#' onmouseover=\"document.getElementById('szorendtable2').style.display = 'block';\"
                                                    onmouseout=\"document.getElementById('szorendtable2').style.display = 'none';\"
                                                \">" . translate('szorend2') . "</a>
                                            <div id='szorendtable2'>{include_file}</div></td>";
            $obj['szorend2']['langs'][1][0] = 'szorend.html';
            $obj['szorend2']['langs'][1][2] = 'szorend_esp.html';

            $obj['szorend2']['langs'][4][0] = 'szorend_ger.html';

            $obj['nevmasok']['content'] = "<td id='nevmasok'><a href='#' style=\"font-weight:normal;\" onmouseover=\"document.getElementById('nevmasoktable').style.visibility = 'visible';\" onmouseout=\"document.getElementById('nevmasoktable').style.visibility = 'hidden';\">" . translate('nevmasok') . "</a>
                                        <div id='nevmasoktable'>{include_file}</div></td>";
            $obj['nevmasok']['langs'][1][0] = 'nevmasok_eng.html';
            $obj['nevmasok']['langs'][1][2] = 'nevmasok_eng_esp.html';
            $obj['nevmasok']['langs'][2][0] = 'nevmasok.html';
            $obj['nevmasok']['langs'][2][1] = 'nevmasok.html';
            $obj['nevmasok']['langs'][3][0] = 'nevmasok_arab.php';
            $obj['nevmasok']['langs'][4][0] = 'nevmasok_ger.html';

            $obj['rendhagyo']['content'] = "<td id='nevmasok'><a href='http://www.englishpage.com/irregularverbs/irregularverbs.html' style=\"font-weight:normal;\" target='_blank'  >" . translate('rendhagyo_igek') . "</a></td>";
            $obj['rendhagyo']['langs'][1][0] = 'nevmasok_eng.html';
            $obj['rendhagyo']['langs'][1][2] = 'nevmasok_eng_esp.html';

//            $obj['talking']['content'] = "<span id='nevmasok'><a href='http://www.frenchspanishonline.com/voice.html' style=\"font-weight:normal;\" target='_blank'  >" . translate('talking') . "</a></span>";

        }

        return $obj;
    }

?>