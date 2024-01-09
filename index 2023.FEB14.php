<?php
    error_reporting(0);

    $defaultNyelv = 0;
    $notLoggedInMessage = "Nem vagy bel?pve!";
    $premiumUserOnlyMessage = "Csak pr?mium felhaszn?l?k sz?m?ra el?rhet?!";

    if(!$_SESSION['userObject']){
        session_start();
    }
    include_once('functions_userObj.php');
    include_once('translations_HUN.php');

    $userObject = $_SESSION['userObject'];

	 $isAndroid = 0;

	if($userObject === NULL)
	{
		$userObject = 0;
	}

    require_once('functions_userObj.php');
    if($_REQUEST['actionType'] == 'login'){
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.gc_maxlifetime', 60 * 60);
        session_start();
        if(($_GET['h'] && ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObjByHash($_GET['h'])))
            || ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObj($_REQUEST['email'], $_REQUEST['username']))){
            if($userObject['status'] == 1){
                //print "<script>alert('El?fizet?sed m?g nem ker?lt aktiv?l?sra!');</script>";
            }
            else if($userObject['program_end_date'] >= date("Y-m-d 00:00:00")){
                $GLOBALS['welcomeText'] = true;
                $GLOBALS['userObject']['forras_nyelv'] = $_SESSION['userObject']['forras_nyelv'];
            }
            else{
                print "<script>alert('El?fizet?sed lej?rt, k?rjek l?pj kapcsolatba a program ?zemeltet?j?vel!');</script>";
            }
        }
        else{
            print "<script>alert('A megadott felhaszn?l? nem l?tezik!');</script>";
        }
    }

    if(!$userObject){
        if(isset($_GET["langChange"])){
            $defaultNyelv = (int)$_GET["langChange"];
            setcookie('preflanguage', $defaultNyelv);
        }
        else if($_COOKIE['preflanguage']){
            $defaultNyelv = (int)$_COOKIE['preflanguage'];
            setcookie('preflanguage', $defaultNyelv);
        }
    }

    $GLOBALS['nyelv'] = $nyelv = $userObject ? $userObject['nyelv'] : $defaultNyelv;
    include_once('functions.php');

    if($userObject)
        $_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

    if($userObject && in_array($userObject['status'], array(4, 5, 6))){
        $isUserSuperior = true;
    }
    else{
        $isUserSuperior = false;
    }

    if($userObject){
        $list = getLevelList($userObject['nyelv']);
        $countList = getWordCountList($userObject['nyelv']);
        $packageRecords = getPackageRecords($userObject, 1);
        $packageRecordsSentences = getPackageRecords($userObject, 2);
        $packageRecordsBasicWords = getPackageRecords($userObject, 4);

        $goodLevelArray = array();
        $goodSentenceLevelArray = array();
        foreach($list as $key => $value){
            if($value[1] == 1 && $key != 0){
                $goodLevelArray[] = $key;
            }
            else if($value[1] == 2 && $key != 0){
                $goodSentenceLevelArray[] = $key;
            }
        }
        $countOwnWords = getOwnWordCount($userObject, $goodLevelArray);
        $countBasicWords = getBasicWordCount($userObject);
        $countOwnSentences = getOwnWordCount($userObject, $goodSentenceLevelArray);
    }

?>
<HTML>
<HEAD>
    <META HTTP-EQUIV='CHARSET' CONTENT='text/html; charset=ISO-8859-2'>
    <link rel="shortcut icon" type="image/x-icon" href="/images/white.ico">
    <TITLE>INGLish</TITLE>
    <link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel=stylesheet type='text/css' href='baseStyle.css'>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#ajax").tooltip({ position: { my: "left+10 bottom+15", at: "right center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#SajatSzotar").tooltip({ position: { my: "left+15 bottom-15", at: "right center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#AlapSzokincs").tooltip({ position: { my: "center+15 bottom-15", at: "right center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#NyelvtaniPeldatar").tooltip({ position: { my: "right+15 bottom-15", at: "left center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#IntelligensGyakorlo").tooltip({ position: { my: "right+24 bottom-15", at: "left center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#aTanuloszoba").tooltip({ position: { my: "left center", at: "right center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#SzorgalomMutato").tooltip({ position: { my: "right+24 bottom-20", at: "left center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#SajatSzotar_Div").tooltip({ position: { my: "right-15 bottom+160", at: "left center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#alapszokincs_Div").tooltip({ position: { my: "right-15 bottom+160", at: "left center" }, content: function() { return $( this ).attr( "title" ); } });
            $("#wordPracticeDiv td, #vocabularyDiv td, #sentencePracticeDiv2 td").each(function () {
                if($(this).children().first().is("a")){
                    $(this).css("cursor", "pointer");
                }
            });
            $("#wordPracticeDiv td, #vocabularyDiv td, #sentencePracticeDiv2 td").click(function () {
                if($(this).children().first().is("a")){
                    $(this).children().first().click();
                }
            });
        });
        notLoggedInMessage = <?php print "'" . $notLoggedInMessage . "'"; ?>;
        premiumUserOnlyMessage = <?php print "'" . $premiumUserOnlyMessage . "'"; ?>;
        nyelv = <?php print "'" . $GLOBALS['nyelv'] . "'";  ?>;
        /* IE miatt */
        if(!Array.prototype.indexOf){
            Array.prototype.indexOf=function(obj,start){
                for(var i=(start||0),j=this.length;i<j;i++){
                    if(this[i]==obj){return i;}
                }
                return -1;
            }
        }
<?php
    print "var level3Array = [];";
    $i = 0;
    foreach((array)$list as $key => $value){
        if($value[1] == 3 && $key > 0){
            print "level3Array[{$i}] = '{$key}';";
            $i++;
        }
    }
?>

    $(document).ready(function () {
        //$("#aTanuloszoba").tooltip({ position: { my: "left+15 center", at: "right center" } });
        $(".imgLangChange").click(function () {
            changeLanguage($(this).data("lang"));
        });
        $(".ajaxLangChoose").click(function () {
            $(".ajaxLangChoose").css("font-weight", "normal");
            $(this).css("font-weight", "bold");
        });
        $("#ajaxTable").css("width", "200px");
        $("#tblLogin .loginInput").hide();
    });

    // function changeLanguage(lang){
    //     location.href = "index.php?langChange=" + lang;
    // }

    // var clearbox = new Array(); // global variable
    // clearbox[0] = 0;
    // clearbox[1] = 0;
    // function clearit(obj, num) {
    //     if (clearbox[num] == 0) {
    //         obj.value = "";
    //         clearbox[num] = 1;
    //     }
    // }

    function submitToMain(content)
    {
        <?php if($userObject && $userObject['status'] != 1){ ?>
            document.forms['submitForm'].content.value = content;
            document.forms['submitForm'].submit();
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function lowerSelectOnChange(val, src, clickSource)
    {
        <?php if($userObject){ ?>
            if(level3Array.indexOf(val.toString()) > -1){
                location.href='main.php?content=showRule&selectedLevel=' + val + '&source=' + src + '&clickSource=' + clickSource;
            }
            else{
                location.href='main.php?content=wordLearning_quick&packageStart=1&selectedLevel=' + val + '&source=' + src + '&clickSource=' + clickSource;
            }
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function startPrintLevel(level){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            var level = parseInt(level, 10);
            if(isNaN(level)){
                alert('Nem tal?lom a kiv?lasztott level-t!');
                return;
            }
            window.open('printViewSent.php?wordLevel=' + level,'Sz?fajok','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes');
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function startPrintMumus(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            window.open('printViewSent.php?pkg=mumus&source=szo','Sz?fajok','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes');
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function intelligensGyakorlo(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            location.href='main.php?content=wordLearning_quick&packageStart=1&source=mondat&clickSource=intelligent';
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function peldamondatok(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            document.getElementById('sentencePracticeDiv2').style.display = 'block';
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function alapszokincs(){
        <?php if($userObject){ ?>
            document.getElementById('vocabularyDiv').style.display = 'block';
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function sajatSzavak(){
        <?php if($userObject){ ?>
            document.getElementById('wordPracticeDiv').style.display = 'block';
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function audioSzoba(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            location.href='index.php?audioszoba=1'
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function tudastar(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            document.getElementById('knowledgeBaseDiv').style.display = 'block';
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function szotarFeltoltes(){
        <?php if($userObject && $userObject['status'] != 1){ ?>
            location.href='main.php?content=wordLearning_kikerdezo&source=welcome'
        <?php } else if($userObject['status'] == 1){ ?>
            alert(premiumUserOnlyMessage);
        <?php } else { ?>
            alert(notLoggedInMessage);
        <?php } ?>
    }

    function t_Click(event){
        event.stopPropagation();
        if(document.getElementById('clientDiv').style.display == 'none'){
            document.getElementById('clientDiv').style.display = 'block';
            document.getElementById('financeDiv').style.display = 'none';
            document.getElementById('mainDiv').style.display = 'none';
        }
        else{
            document.getElementById('clientDiv').style.display = 'none';
            document.getElementById('mainDiv').style.display = 'block';
        }
    }

    function p_Click(event){
        event.stopPropagation();
        if(document.getElementById('financeDiv').style.display == 'none'){
            document.getElementById('financeDiv').style.display = 'block';
            document.getElementById('clientDiv').style.display = 'none';
            document.getElementById('mainDiv').style.display = 'none';
        }
        else{
            document.getElementById('financeDiv').style.display = 'none';
            document.getElementById('mainDiv').style.display = 'block';
        }
    }

    function goToRegistration(){
        location.href = 'subscribe.php?nyelv=' + nyelv;
    }

</script>

<style>

    input[type=checkbox] {
        zoom: 1.5;
    }

    img.imgLangChange{
        cursor:pointer !important;
    }
    .ui-tooltip {
    white-space: pre-line;
    content: function() { 
        return  $( this ).attr( "title" );
    } 
    }
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px <? print $globalcolor ?> inset;
        -webkit-text-fill-color: #FFFFFF;
    }
    #knowledgeBaseDiv {
        display:none;position:absolute;top:-200px;left:50%;margin-left:-200px;background-color:white;
        filter:alpha(opacity=100);opacity:1;z-index:99;}
    #wordPracticeDiv {
        display:none;position:absolute;top:-200px;left:50%;margin-left:-200px;background-color:white;
        filter:alpha(opacity=100);opacity:1;z-index:99;}
    #vocabularyDiv {
        display:none;position:absolute;top:-200px;left:50%;margin-left:-200px;background-color:white;
        filter:alpha(opacity=100);opacity:1;z-index:99;}
    #sentencePracticeDiv {
        display:none;position:absolute;top:-200px;left:50%;margin-left:-200px;background-color:white;
        filter:alpha(opacity=100);opacity:1;z-index:99;}
    #tblPerformance tr:first-child td {
        font-weight:bold;
        color: <? print $globalcolor ?>;
    }
    #tblPerformance td:last-child {
        text-align:right;
        padding-left: 4px;
        font-size: 10pt;
    }
    #ajaxMeaningSearch{
    }
    #moreMeaningDiv{
        position:absolute;
        overflow:auto;
        background-color: <? print $globalcolor ?>;
        color:white;
        filter:alpha(opacity=100); 
        /* IE's opacity*/
        opacity:1;
        z-index:99;
        margin-left:-250px;
        top:30px;
        left:50%;
        width:500px;
        height:400px;
    }
    .btnAjaxDivSave{
        border:1px solid grey;
        background:white;
        cursor:pointer;
        <?php
        if($isAndroid) {
            print "font-size:20pt; padding: 1px 20px;";
        }
        else {
            print "padding: 1px 3px;";
        }
        ?>
    }
    #ajaxSearchOutput{
        position:absolute;overflow:auto;top:8px;left:50%;margin-left:140px;width:100px;height:22px;text-align:center;background-color:$globalcolor;color:white;
        filter:alpha(opacity=100); opacity:1;z-index:99;
    }
    #ajaxSearchInput {
        <?php
        if($isAndroid)
            print "font-size:46pt;";
        else
            print "font-size:12pt;";
        ?>
    }
    #ajaxDiv {
        border: 0px solid black;
        position:absolute;
        left:50%;
        text-align:left;
        margin-left:-140px;
        top:0px;
        width:280px;
    }
    .fa-search{
        font-size:14pt;
    }
    .meaningCell{
                font-style:italic;}
    .meaningA{
                font-size:15px;font-family:arial;}
    .meaningLevel2Cell{
                font-weight:normal;}
    .meaningLevel2A{
                font-weight:normal;font-size:15px;font-family:arial;}
    .ajaxLangChoose{
        cursor: pointer;
        color:white;
    }
    #clientDiv{
        position:absolute;top:35px;left:50%;margin-left:-405px;display:none;background-color:white;
        filter:alpha(opacity=100); /* IE's opacity*/opacity:1;z-index:99;padding:5px;border:1px solid grey;
    }
    #financeDiv{
        position:absolute;top:35px;left:50%;margin-left:-405px;display:none;background-color:white;
        -webkit-transform: translate3d(0,0,0);
        filter:alpha(opacity=100); 
        /* IE's opacity*/
        opacity:1;
        z-index:100;
        padding:5px;
        border:1px solid grey;
    }
</style>
</HEAD>
<BODY style='margin:0px;'>

<div id='UpperDiv' style='position:relative;width:100%;'>
    <table align='center' border='0'  width='100%' valign='top' style='background:#B6000A'>
    <tr>
        <td align="right">
            <?php 
                if($userObject && in_array($userObject['status'], array(4, 5, 6))){
            ?>
                <a href='#' style='color:white;' onclick="p_Click(event)">p</a>
                &nbsp;&nbsp;
            <?php }
                if($userObject && in_array($userObject['status'], array(4, 5, 6))){
            ?>
                <a href='#' style='color:white;' onclick="t_Click(event)">t</a>
                &nbsp;&nbsp;
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan='2' align=<?php print $userObject ? "'right'" : "'center'" ?> valign='top' style=<?php print "'height:" . $TopRedHeight . ";'"; ?>>

<?php
    if($userObject){

?>

    <a href='#' style=<?php print "'font-size:" . $loginFontSize . ";color:white;margin-right: 5px;'"; ?> onclick="event.stopPropagation();location.href='index.php?usersettings=1'">
        <?php print translate('beallitasok'); ?>
    </a>
    <b>
        <a href='#' style=<?php print "'font-size:" . $loginFontSize . ";color:white;'"; ?> onclick="event.stopPropagation();location.href='logout.php'">
            <?php print translate('kijelentkezes'); ?>
        </a>
        &nbsp;&nbsp;&nbsp;
<?php
    }
    else{
?>
     <form id="formLogin" action='index.php' method='POST'>
     <table id="tblLogin" border='0' width='202' cellspacing='3'>
        <tr>
        <td align='center' style=<?php print "'white-space:nowrap;padding-top:" . $MiddlePadding . "'"; ?>>
        <?php if($isAndroid) {  ?>
        <img class="imgLangChange" data-lang="0" src='images/hun.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
        <img class="imgLangChange" data-lang="1" src='images/uk.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
        <img class="imgLangChange" data-lang="2" src='images/sp.jpg' height=<?php print $FlagHeight ?> width=<?php print $FlagWidth ?>>
        <?php   } ?>
        </td>
        </tr>

<?php /*
        <tr>
            <td valign='center' align='center' style=<?php print "'padding-top:" . $Padding . ";padding-bottom:" . $Padding . ";border:1px solid white;height:22px'"; ?>>
                <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> onclick="goToRegistration()"><?php print translate('subscribe'); ?></a>
            </td>
       </tr>
*/ ?>
        <tr>
            <td valign='center' align='center' style=<?php print "'padding-top:" . $Padding . ";padding-bottom:" . $Padding . ";border:1px solid white;height:22px'"; ?>>
                <input type='hidden' name='actionType' value='login'>
                <input style='display:none' type='submit'>
                <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> id='btnLogin' onclick="if(!$('.loginInput').is(':visible')){ $('.loginInput').show(); } else{ $('#formLogin').submit(); }">&nbsp;<?php print translate('enter'); ?>&nbsp;</a>
            </td>
       </tr>
        <tr>
            <td align='left'>
            <table border='0' align='right'>
             <tr>
                <td  align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>>Email</td>
                <td>
                <input class='loginInput' type='text' name='email' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?> onclick="event.stopPropagation();clearit(this, 0);">
                 </td>
            </tr>
            <tr>
                <td  align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>><?php print translate('subs_Jelsz?'); ?></td>
                <td>
                <input class='loginInput' type='password' name='username' id='username' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?>>
               </td>
            </tr>
            </table>
            </td>
       </tr>
     </table>
     </form>
<?php
    }
?>
  </td></tr>
</table>

</div>

<?php
    if($_REQUEST['sourcePage'] == 'clients'){
        $clientStyleText = "style='display:block'";
        $mainStyleText = "display:none;";
        $financeStyleText = "style='display:none'";
    }
    else if($_REQUEST['sourcePage'] == 'finance'){
        $clientStyleText = "style='display:none;";
        $mainStyleText = "display:none;";
        $financeStyleText = "style='display:block'";
    }
    else{
        $clientStyleText = "style='display:none'";
        $mainStyleText = "display:block;";
        $financeStyleText = "style='display:none'";
    }

    if(in_array($userObject['status'], array(5, 6))){
        print "\n<div id='clientDiv' {$clientStyleText}>\n";
        $formAction = "index.php";
        include('clients.php');
        print "\n</div>";
    }
    if(in_array($userObject['status'], array(5, 6))){
        print "\n<div id='financeDiv' {$financeStyleText}>\n";
        $formAction = "index.php";
        include('finance.php');
        print "\n</div>";
    }

//    if(in_array($userObject['status'], array(4, 5, 6))){
    if($userObject){
        if($userObject['status'] != 2 && $userObject['status'] != 1){
            $onclick1 = "\"document.getElementById('sentencePracticeDiv').style.display = 'block';\"";
            $onclick1_1 = "\"lowerSelectOnChange('listAll', 'mondat', 'sentencePractice');\"";
            $onclick2 = "\"submitToMain('wordManagementKitolto');\"";
            $onclick3 = "\"submitToMain('wordManagement');\"";
            $onclick4 = "\"lowerSelectOnChange('listAll', 'szomondat', 'wordSentencePractice');\"";
            $style = "'font-size:13pt;color:$globalcolor;'";
            $imgstyle = "'cursor:pointer;'";
        }
        else{
            $onclick1 = "\"alert('" . translate("funkcio_skype") . "')\"";
            $onclick1_1 = "\"alert('" . translate("funkcio_skype") . "')\"";
            $onclick2 = "\"alert('" . translate("funkcio_skype") . "')\"";
            $onclick3 = "\"alert('" . translate("funkcio_skype") . "')\"";
            $onclick4 = "\"alert('" . translate("funkcio_skype") . "')\"";
            $style = "'font-size:13pt;color:$globalcolor;opacity:0.4;filter:alpha(opacity=40);'";
            $imgstyle = "'cursor:pointer;opacity:0.4;filter:alpha(opacity=40);'";
        }
    }
    else{
        $onclick1 = "\"alert('" . $notLoggedInMessage . "')\"";
        $onclick1_1 = "\"alert('" . $notLoggedInMessage . "')\"";
        $onclick2 = "\"alert('" . $notLoggedInMessage . "')\"";
        $onclick3 = "\"alert('" . $notLoggedInMessage . "')\"";
        $onclick4 = "\"alert('" . $notLoggedInMessage . "')\"";
        $style = "'font-size:13pt;color:$globalcolor;opacity:0.4;filter:alpha(opacity=40);'";
        $imgstyle = "'cursor:pointer;opacity:0.4;filter:alpha(opacity=40);'";
    }
    $_SESSION['intelligentFilterWord'] = null;
?>

<div id='welcomeTextDiv' style=<?php print "'top:" . $welcomeTextTop . ";position:absolute;"; ?>>
        <table width='100%' border='0' style=<?php print "'font-size:" . $HelloFontSize . ";color:white;font-weight:plain;'"; ?>>
            <tr>
                <td align='left' style='padding-left:30px';>
                    <?php
                        if($userObject)
                            print  "<font color='white'>" . translate('szia') . "&nbsp;" . $userObject['keresztnev'] . "!&nbsp;";
                        else
                            print "";
                    ?>
                </td>
            </tr>
        </table>


</div>
<div id='ajaxDiv' style=<?php print "'font-size:16pt;color:" . $globalcolor . ";" . $mainStyleText . "'"; ?>>
<?php
    $langTitleArray = getLangTitles();
    $possibleLangs = array(0, 1, 2);
    $lang1 = $langTitleArray[$GLOBALS['nyelv']];
    for($i = 0; $i < count($possibleLangs); $i++){
        if($i == $GLOBALS['nyelv'])
            continue;
        if(!$lang2)
            $lang2 = $langTitleArray[$i];
        else
            $lang3 = $langTitleArray[$i];
    }
?>

<?php include("ajaxSearch.php"); ?>
</div>

    <?php
        if($userObject)
            $progressPct = getUserProgress($userObject, $countBasicWords, $packageRecordsBasicWords);
    ?>

<?php
    if($_REQUEST["usersettings"] == 1){
        include("usersettings.php");
        exit;
    }
    else if($_REQUEST["audioszoba"] == 1){
        include("audio.php");
        exit;
    }
?>
<?php if($isAndroid){ ?>

<div id='mainDiv' style=<?php print "'border: 0px solid black;position:absolute;top:" . $mainDivtop .";width:100%;text-align:left;" . $mainStyleText . "'"; ?>>
<?php if($userObject){ ?>
<table border='0' width='100%' align='left' valign='top' cellpadding='60' cellspacing='40'>
<tr><td align='center' style=<?php print "'background:" . $globalcolor . ";'" ?>><a href='#' style='color:white;font-size:50pt;' onclick="sajatSzavak();"><b><? print translate("increasevocabulary_android"); ?></a></td></tr>
<tr><td align='center' style=<?php print "'background:" . $globalcolor . ";'" ?>><a href='#' style='color:white;font-size:50pt;' onclick="alapszokincs();"><b><? print translate("basicvocabulary_android"); ?></a></td></tr>
<tr><td align='center' style=<?php print "'background:" . $globalcolor . ";'" ?>><a href='#' style='color:white;font-size:50pt;' onclick="peldamondatok();"><b><? print translate("tudastar_android"); ?></a></td></tr>
<tr><td align='center' style=<?php print "'background:" . $globalcolor . ";'" ?>><a href='#' style='color:white;font-size:50pt;' onclick="intelligensGyakorlo()" ><b><? print translate("intelligensgyakorlo_android"); ?></a></td></tr>

<?php if(!in_array($userObject["status"], array(1, 2))){ ?>
<tr><td align='center' style='border: 2px solid grey;'><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:50pt;'" ?> onclick=<?php print $onclick1; ?> ><b><? print translate("sajat_mondatok_10"); ?></a></td></tr>
<tr><td align='center' style='border: 2px solid grey;'><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:50pt;'" ?> onclick=<?php print $onclick4; ?> ><b><? print translate("sajat_mondat_szo"); ?></a></td></tr>
<tr><td align='center' style='border: 2px solid grey;'><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:50pt;'" ?> onclick=<?php print $onclick3; ?> ><b><? print translate("tanuloszoba"); ?></a></td></tr>
<tr><td align='center' style='border: 2px solid grey;'><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:50pt;'" ?> onclick="audioSzoba();"><b><? print translate("audioszoba"); ?></a></td></tr>
<?php }  ?>
<?php }  ?>

</table>

<?php   } else{   ?>

<div id='mainDiv' style=<?php print "'position:absolute;top:" . $mainDivtop .";width:100%;text-align:left;" . $mainStyleText . "'"; ?>>
<table border='0px' align='center'>
         <tr>
             <td valign='top' align='center'>
			  <?php if($userObject){ ?>
             <table border='0' align='center' valign='top' cellspacing='0'>
                  <tr>
                          <td align='right' width='152' style=<?php print "'border-radius: 10px 10px 0px 0px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="SajatSzotar" title=<?php print "'" . translate("info_sajatszotar") . "'" ?> href='#' style='color:white;font-size:12pt;'>?</a></td>
                          <td width='6' style='background-color:white;'></td>
                          <td align='right' width='152' style=<?php print "'border-radius: 10px 10px 0px 0px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="AlapSzokincs" title=<?php print "'" . translate("info_alapszokincs") . "'" ?> href='#' style='color:white;font-size:12pt;'>?</a></td>
                          <td width='6' style='background-color:white;'></td>
                          <td align='right' width='152' style=<?php print "'border-radius: 10px 10px 0px 0px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="NyelvtaniPeldatar" title=<?php print "'" . translate("info_nyelvtanipeldatar") . "'" ?> href='#' style='color:white;font-size:12pt;'>?</b></a></td>
                          <td width='6' style='background-color:white;'></td>
                          <td align='right' width='152' style=<?php print "'border-radius: 10px 10px 0px 0px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="IntelligensGyakorlo" title=<?php print "'" . translate("info_intelligensgyakorlo") . "'" ?> href='#' style='color:white;font-size:12pt;'>?</a></td>
                  </tr>

                  <tr>
                          <td valign='top' align='center' style=<?php print "'border-radius: 0px 0px 10px 10px;padding-bottom:20px;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="sajatSzavak();"><? print translate("increasevocabulary"); ?></a></td>
                          <td style='background-color:white;'></td>
                          <td valign='top' align='center' style=<?php print "'border-radius: 0px 0px 10px 10px;padding-bottom:20px;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="alapszokincs();"><? print translate("basicvocabulary"); ?></a></td>
                          <td style='background-color:white;'></td>
                          <td valign='top' align='center' style=<?php print "'border-radius: 0px 0px 10px 10px;padding-bottom:20px;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="peldamondatok();"><? print translate("tudastar"); ?></a></td>
                          <td style='background-color:white;'></td>
                          <td valign='top' align='center' style=<?php print "'border-radius: 0px 0px 10px 10px;padding-bottom:20px;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="intelligensGyakorlo()" ><? print translate("intelligensgyakorlo"); ?></a></td>
                  </tr>

           </table>
		    <?php } ?>

<?php } ?>

<?php if($userObject && !in_array($userObject["status"], array(1, 2))){ ?>
<?php if(!$isAndroid) {  ?>
           <table border='0' align='left' valign='top' cellspacing='0' style='padding-top:10px'>

                  <tr>
                          <td height='40' width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:10pt;'"; ?> onclick=<?php print $onclick1; ?> ><b><? print translate("sajat_mondatok_10"); ?></a></td>
                          <td width='3' style='background:white;'></td>
                          <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a href='#' style=<?php print "'color:" . $globalcolor . ";font-size:10pt;'"; ?> onclick=<?php print $onclick4; ?> ><b><? print translate("sajat_mondat_szo"); ?></a></td>
                          <td width='3' style='background:white;'></td>
                          <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a id="aTanuloszoba" href='#' style=<?php print "'color:" . $globalcolor . ";font-size:10pt;'"; ?> title=<?php print "'" . translate("") . "'" ?> onclick=<?php print $onclick3; ?> ><b><? print translate("tanuloszoba"); ?></a></td>
                          <td width='3' style='background:white;'></td>
                          <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a style=<?php print "'color:" . $globalcolor . ";font-size:10pt;'"; ?> onclick="audioSzoba();" href="#"><b><? print translate("audioszoba"); ?></a></td>
                   </tr>
           </table>
<?php }  ?>
<?php }  ?>

           </td>
        </tr>

	<?php
	if($userObject){
		?>
	<!-- Legujabb szavak box -->
	<tr>
		<td valign='top' align='center' style='padding-top:10'>
        <table width='100% border='0' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
          <tr><td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="legujjabbszavak"  href='#' style='color:white;font-size:12pt;'></a></td></tr><tr>
          <tr><td colspan='3' valign='center' align='center' style=<?php print "'padding-bottom:10px;font-size:14pt;color:white;border-bottom: 1px solid " . $globalcolor . ";background:" . $globalcolor . ";'"; ?>>
          <? print translate("Legújabb szavak"); ?></td>
          </tr>
		  <?php
			print "<td valign='top' align='left' style='padding-left:250px;padding-top:10px;padding-bottom:10px;font-size:10pt;'><font color='grey'>";
			$five_days_ago = strtotime('-5 days');
			$five_days_formatted = date('Y-m-d', $five_days_ago);
			if($userObject["forras_nyelv"] == 0 && $userObject["nyelv"] == 1) {
				$updated_words = getLastFiveUpdatedWords($five_days_formatted);
				foreach($updated_words as $row)
				{
					print("<p><b>".$row["word_angol"]."</b>&nbsp;-&nbsp;".$row["word_hun"]."</p>");

				}
			}
			print "</font></td>";
			print "</tr></table>";
           ?>
      </td>
    </tr>
    
	<?php
		}
	?>
   <tr>
        <td align='center' style='color:#000000;padding-top:10px;' style=<?php print $style; ?> >
<?php if($userObject){ ?>
        <?php if(!$isAndroid) {  ?>
            <?php if(!in_array($userObject["status"], array(1, 2))){ ?>
                <a href='#' onclick=<?php print $onclick2; ?> ><? print translate("kitolto"); ?></a>
                &nbsp;&nbsp;.&nbsp;&nbsp;
                <a href='#' onclick="tudastar();"><? print translate("tudastar_title"); ?></a>
                &nbsp;&nbsp;.&nbsp;&nbsp;
            <?php } ?>
                <a href='#' onclick="szotarFeltoltes();"><? print translate("feltoltes"); ?></a>
                <?php if($userObject['status'] == 6){ ?>
                &nbsp;&nbsp;.&nbsp;&nbsp;
                <a href='#' onclick="location.href='main.php?content=wordCategorize&source=welcome'"><? print translate("kategorizalas"); ?></a>
                <?php } ?>
        <?php }  ?>
<?php }  ?>
    </td>
    </tr>

<?php if($userObject){ ?>

    <tr>
      <td valign='top' align='center' style='padding-top:10'>
        <table border='0' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
          <tr><td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="SzorgalomMutato" title=<?php print "'" . translate("info_szorgalommutato") . "'" ?> href='#' style='color:white;font-size:12pt;'>?</a></td></tr>
          <tr><td colspan='3' valign='center' align='center' style=<?php print "'padding-bottom:10px;font-size:20pt;color:white;border-bottom: 1px solid " . $globalcolor . ";background:" . $globalcolor . ";'"; ?>>
          <? print translate("myperformance"); ?></td>
          </tr>
          <tr>
          <?php
          print "<td height='60' width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject, date('Y-m-d', strtotime("-2 days"))) : 0) . "</font><font size='2'><br>" . date('Y.m.d', strtotime("-2 days")) . "</td>";
          print "<td width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject, date('Y-m-d', strtotime("-1 days"))) : 0) . "</font><font size='2'><br>" . date('Y.m.d', strtotime("-1 days")) . "</td>";
          print "<td width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject) : 0) . "</font><font size='2'><br>" . date('Y.m.d') . "</td>";
          print "</tr></table>";
           ?>
      </td>
    </tr>
<?php }  ?>
</table>
</div>


<!--kakukk-->
	<?
	if($_GET['go']!="")
	{
		printf("<script>$('#%s').goTo();</script>",$_GET['go']);
	}
	?>

        <form name='submitForm' id='submitForm' action='main.php' method='post'>
        <input type='hidden' name='firstVisit' value='1'>
        <input type='hidden' name='content' value=''>
        </form>

<div id='wordPracticeDiv' style='background-color:white;position:absolute;top:100px;left:50%;margin-left:-170px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <table border='0'>
        <tr><td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?> style=<?php echo "\"{$xSize}\"" ?>><a id="SajatSzotar_Div" style='color:white;' title=<?php print "'" . translate("SajatSzotar_Div") . "'" ?>>&nbsp;?&nbsp;</a></td>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('wordPracticeDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>&nbsp;X&nbsp;</a></td>
        </tr>
        <tr><td colspan='3'>
        <div style=<?php echo "\"{$worddivSize}\"" ?>>
            <table border='0' width='330' cellspacing='0' cellpadding='10'>
        <?php
            $partRowNumber = (int)($countOwnWords / $GLOBALS['szoPackageSize']);
            if($partRowNumber * $GLOBALS['szoPackageSize'] < $countOwnWords){
                $partRowNumber++;
            }
            $recordBg = 'color:' . $globalcolor . ';';
            $cellBlocks = array();

            if(!$isAndroid) {
                $mumusPrint = "<a style=\"color:$globalcolor;white-space:nowrap;\" href='#' onclick=\"startPrintMumus();\">print</a>";
            }

            $cellBlocks[] = "<td style='{$recordBg}'><a style='{$worddivFontSize};color:$globalcolor;white-space:nowrap;' href='#' onclick=\"lowerSelectOnChange('listAll', 'szo', 'wordPractice');\">" . translate("sajat_szavak_all") . "</a></td><td style='{$recordBg}'>&nbsp;</td><td style='{$recordBg}'>&nbsp;</td>";
            $cellBlocks[] = "<td style='{$recordBg}'><a style='{$worddivFontSize};color:$globalcolor;white-space:nowrap;' href='#' onclick=\"lowerSelectOnChange('mumus', 'szo', 'wordPractice');\">" . strtoupper(translate('mumus')) . "</a></td><td style='{$recordBg}'>&nbsp;</td>
                <td style='{$recordBg}'>
                    $mumusPrint
                </td>";

            $forSortArray = array();
            for($i = 1; $i <= $partRowNumber; $i++){
                $text = $i . ". " . translate("csomag");
                if($packageRecords[$i]){
                    $addText = "{$packageRecords[$i]['best_time']} " . translate("masodperc");
                }
                else{
                    $addText = '';
                }
                $recordBg = 'color:' . $globalcolor . ';';
                if($packageRecords[$i]['best_time'] > 0 && $packageRecords[$i]['best_time'] < $GLOBALS['szoPackageRecordMpLimit']){
                    $recordBg .= 'background:' . $GLOBALS['szoPackageRecordBg'];
                }
                $printLink = " <a href='#' style='color:$globalcolor;' onclick=\"window.open('printViewSent.php?source=szo&pkg=listFract_{$i}','Mondatok','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')\">print</a>";
                $cell = "
                <td style='{$recordBg}'><a href='#' style='{$worddivFontSize};color:$globalcolor;white-space:nowrap;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'szo', 'wordPractice');\">{$text}</a></td>
                <td align='right' style='{$worddivFontSize};color:grey;{$recordBg};white-space:nowrap;'>{$addText}</td>
                ";
                if(!$isAndroid) {
                    $cell .= "<td style='{$recordBg}'>{$printLink}</td>
                    ";
                }

                if($addText == ''){
                    $cellBlocks[] = $cell;
                }
                else{
                    $forSortArray[] = array(
                        'ido' => $packageRecords[$i]['best_time'] > 0 ? $packageRecords[$i]['best_time'] : 999999,
                        'cell' => $cell
                    );
                }
            }
            $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);

            for($i = 0; $i < count($forSortArray); $i++){
                $cellBlocks[] = $forSortArray[$i]['cell'];
            }
            printCellBlocks($cellBlocks, $columnNumberWords);
        ?>
            </tr></table>
        </td></tr></table>
</div>

<div id='vocabularyDiv' style='background-color:white;position:absolute;top:100px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <table border='0'>
        <tr>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?> style=<?php echo "\"{$xSize}\"" ?>><a id="alapszokincs_Div" style='color:white;' title=<?php print "'" . translate("alapszokincs_Div") . "'" ?>>&nbsp;?&nbsp;</a></td>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('vocabularyDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>&nbsp;X&nbsp;</a></td>
        </tr>
        <tr><td colspan='3'>
        <div style=<?php echo "\"{$worddivSize}\"" ?>>
            <table border='0' width='330' cellspacing='0' cellpadding='10'>
        <?php
            $partRowNumber = (int)($countBasicWords / $GLOBALS['szoPackageSize']);
            if($partRowNumber * $GLOBALS['szoPackageSize'] < $countBasicWords){
                $partRowNumber++;
            }
            $cellBlocks = array();
            $forSortArray = array();
            for($i = 1; $i <= $partRowNumber; $i++){
                $text = $i . ". " . translate("csomag");
                if($packageRecordsBasicWords[$i]){
                    $addText = "{$packageRecordsBasicWords[$i]['best_time']} " . translate("masodperc");
                }
                else{
                    $addText = '';
                }
                $recordBg = '';
                if($packageRecordsBasicWords[$i]['best_time'] > 0 && $packageRecordsBasicWords[$i]['best_time'] < $GLOBALS['szoPackageRecordMpLimit']){
                    $recordBg = 'background-color:' . $GLOBALS['szoPackageRecordBg'];
                }
                $cell = "
                <td style='{$recordBg}'><a href='#' style='{$worddivFontSize};color:$globalcolor;white-space:nowrap;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'alapSzo', 'basicWordPractice');\">{$text}</a></td>
                <td align='right' style='{$worddivFontSize};color:$globalcolor;{$recordBg};white-space:nowrap;'>{$addText}</td>
                ";

                if($addText == ''){
                    $cellBlocks[] = $cell;
                }
                else{
                    $forSortArray[] = array(
                        'ido' => $packageRecordsBasicWords[$i]['best_time'] > 0 ? $packageRecordsBasicWords[$i]['best_time'] : 999999,
                        'cell' => $cell
                    );
                }
            }
            $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);

            for($i = 0; $i < count($forSortArray); $i++){
                $cellBlocks[] = $forSortArray[$i]['cell'];
            }
            printCellBlocks($cellBlocks, $columnNumberWords);
        ?>
            </tr></table>
        </td></tr></table>
</div>

<div id='sentencePracticeDiv' style='background-color:white;position:absolute;top:90px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <table border='0'>
        <tr>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('sentencePracticeDiv').style.display = 'none';" style='font-size:17;font-weight:bold;color:white'>X</a></td>
        </tr>
        <tr><td colspan='2'>
        <div style=<?php echo "\"{$worddivSize}\"" ?>>
            <table border='0' width='330' cellspacing='0' cellpadding='10'>
        <?php
            $lev1count = 0;
            //print "<option value='list2'>?sszes";
            $partRowNumber = (int)($countOwnSentences / $GLOBALS['mondatPackageSize']);
            if($partRowNumber * $GLOBALS['mondatPackageSize'] < $countOwnSentences){
                $partRowNumber++;
            }
            $cellBlocks = array();
            $forSortArray = array();
            for($i = 1; $i <= $partRowNumber; $i++){
                //$text = (($i - 1) * $GLOBALS['mondatPackageSize'] + 1) . " - " . ($i * $GLOBALS['mondatPackageSize']);
                $text = $i . ". " . translate("csomag");
                if($packageRecordsSentences[$i]){
                    $addText = "{$packageRecordsSentences[$i]['best_time']} " . translate("masodperc");
                }
                else{
                    $addText = '';
                }
                $recordBg = 'color:' . $globalcolor . ' !important;';
                if($packageRecordsSentences[$i]['best_time'] > 0 && $packageRecordsSentences[$i]['best_time'] < $GLOBALS['mondatPackageRecordMpLimit']){
                    $recordBg .= 'background-color:' . $GLOBALS['mondatPackageRecordBg'];
                }
                $printLink = '';
        //        if(in_array($userObject['status'], array(6))){
                    $printLink = " <a href='#' style=\"color:$globalcolor;\" onclick=\"window.open('printViewSent.php?source=mondat&pkg=listFract_{$i}','Mondatok','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')\">print</a>";
        //        }

                $cell = "<td style='{$recordBg}'><a href='#' style='font-size:14;color:$globalcolor;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'mondat', 'sentencePractice');\">{$text}</a></td>
                        <td align='right' style='font-size:14;color:grey;{$recordBg};white-space:nowrap;'>{$addText}</td>";

                if(!$isAndroid) {
                    $cell .= "<td style='{$recordBg}'>{$printLink}</td>
                    ";
                }
                $cell .= "</tr>";

                if($addText == ''){
                    $cellBlocks[] = $cell;
                }
                else{
                    $forSortArray[] = array(
                        'ido' => $packageRecordsSentences[$i]['best_time'] > 0 ? $packageRecordsSentences[$i]['best_time'] : 999999,
                        'cell' => $cell
                    );
                }
            }
            $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);

            for($i = 0; $i < count($forSortArray); $i++){
                $cellBlocks[] = $forSortArray[$i]['cell'];
            }
            printCellBlocks($cellBlocks, $columnNumberWords);

        ?>
            </table>
        </td></tr></table>
</div>

<div id='knowledgeBaseDiv' style='background-color:white;position:absolute;top:120px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <table border='0'>
        <tr>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('knowledgeBaseDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>X</a></td>
        </tr>
        <tr><td colspan='2'>

<div style=<?php echo "\"{$knowledgeBaseDivHeight}\"" ?>>
    <table><tr><td style=<?php print "'vertical-align:top;background:" . $globalcolor . "'"; ?>>
        <table width=<?php echo "\"{$knowledgeBaseDivInnerWidth}\"" ?> cellspacing='0' cellpadding='10' border='0'>
<?php
    $i = 1;
    $isLink = ($userObject['max_level'] > 0);
    $cellBlocks = array();
    $cellText = '';
    foreach($list as $key => $value){
        if(in_array($value[1], array(1, 2, 3)) && $key > 0){
            $text2 = "&nbsp;&nbsp;";
            $text3 = "";
            $style2Add = "";
            if(in_array($value[1], array(1, 2))){
                $sorsz = '&nbsp;';
                $text2 .= "";
                /* $text2 .= "&nbsp;&nbsp;&#8627 ";  */
            }
            else{
                $sorsz = $i++ . ".";
                $style2Add .= "font-weight:bold";
            }
            $text2 .= "{$value[0]}";
            if(in_array($value[1], array(1, 2))){
                $text3 = (int)$countList[$key];
            }
            $cellText = "<td align='right' valign='top' style='{$knowledgeBaseDivFontSize};color:$globalcolor;background:white;font-weight:bold;white-space:nowrap;border:1px solid $globalcolor;'>{$sorsz}</td>";
            if($text3 > 0){
                $text3Html = " <span style='{$knowledgeBaseDivFontSize};color:white;'>({$text3})&nbsp;<span style='font-size:14;color:white;cursor:pointer;' onclick='startPrintLevel(\"{$key}\");'>(P)</span></span>";
            }
            else{
                $text3Html = "";
            }
            if($isLink){
                $cellText .= "<td style='border:1px solid white;'><a href='#' style='{$knowledgeBaseDivFontSize};color:white;$style2Add;' onclick=\"lowerSelectOnChange('{$key}', 'tananyag', 'knowledgeBase');\">{$text2}</a>{$text3Html}</td>";
            }
            else{
                $cellText .= "<td style='{$knowledgeBaseDivFontSize};color:grey;$style2Add;border:1px solid white;'>{$text2}{$text3Html}</td>";
            }
            if($userObject['max_level'] == $key){
                $isLink = false;
            }
            $cellBlocks[] = $cellText;
        }
    }
    printCellBlocks($cellBlocks, $columnNumber);
?>
        </table>
    </td></tr></table>
</div>

</td></tr></table>
</div>

<?php
include_once('sentencePracticeDiv2.php');
?>

<div id='sentencePracticeDiv2' style='background-color:white;position:absolute;top:90px;left:50%;margin-left:-200px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <form method='post' action='main.php'>
        <input type='hidden' name='content' value='wordLearning_quick'>
        <input type='hidden' name='packageStart' value='1'>
        <input type='hidden' name='selectedLevel' value=''>
        <input type='hidden' name='source' value='tananyag'>
        <input type='hidden' name='clickSource' value='sentencePractice2'>
        <input type='hidden' name='actionType' value='multiPractice'>
    <table border='0'>
        <tr>
            <td><input type='submit' style='position:relative;float:right;' value='Vegyes'></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('sentencePracticeDiv2').style.display = 'none';" style='font-size:17;font-weight:bold;color:white'>X</a></td>
        </tr>
        <tr><td colspan='2'>
        <div id='peldamondatokDiv' style=<?php echo "\"{$worddivSize}\"" ?>>
                <table><tr><td style=<?php print "'vertical-align:top;background:" . $globalcolor . ";'"; ?>>
                <table width='380' cellspacing='0' cellpadding='10' border='0'>
            <?php
                $i = 1;
                $isLink = ($userObject['max_level'] > 0);
                $cellBlocks = array();
                $cellText = '';
                $countAll = 0;

                foreach((array)$list as $key => $value){
                    if(in_array($value[1], array(1, 2)) && $key > 0){
                        if(in_array($value[1], array(1, 2))){
                            $countAll += (int)$countList[$key];
                        }
                    }
                }
                //$cellText = "<td align='right' valign='top' style='font-size:18;color:$globalcolor;background-color:white;font-weight:bold;white-space:nowrap;border:1px solid $globalcolor;height:50px;'>0.</td>";
                //$cellText .= "<td style='border:1px solid white;'><a href='#' style='font-size:14;color:white;font-weight:bold;' onclick=\"lowerSelectOnChange('tananyagAll', 'tananyag', 'sentencePractice2');\">?sszes</a>{$text3Html}</td>";
                //$cellBlocks[] = $cellText;

                $_SESSION["AccessableTananyagLevels"] = array();
                foreach((array)$list as $key => $value){
                    if(in_array($value[1], array(2)) && $key > 0){
                        $text2 = "";
                        $text3 = "";
                        $style2Add = "";
                        if(in_array($value[1], array(1, 2))){
                            $sorsz = $i++ . ".";
                            $style2Add .= "font-weight:bold";
                        }
                        $text2 .= "{$value[0]}";
                        if(in_array($value[1], array(1, 2))){
                            $text3 = (int)$countList[$key];
                        }
                        $text3Html = " <span style='font-size:14;color:white;'>({$text3})</span>";
                        $cellText = "<td align='right' valign='top' style='font-size:18;color:$globalcolor;background-color:white;font-weight:bold;white-space:nowrap;border:1px solid $globalcolor;height:50px;'>{$sorsz}</td>";
                        if($isLink){
                            $cellText .= "<td style='border:1px solid white;'><input type='checkbox' name='cbMultiPractice[]' value='$key'><a href='#' style='font-size:14;color:white;$style2Add;' onclick=\"lowerSelectOnChange('{$key}', 'tananyag', 'sentencePractice2');\">{$text2}</a>{$text3Html}</td>";
                            $_SESSION["AccessableTananyagLevels"][] = $key;
                        }
                        else{
                            $cellText .= "<td style='font-size:14;color:grey;$style2Add;border:1px solid white;'>{$text2}{$text3Html}</td>";
                        }
                        if($userObject['max_level'] == $key){
                            $isLink = false;
                        }
                        $cellBlocks[] = $cellText;
                    }
                }
                printCellBlocks($cellBlocks, $columnNumber);
            ?>
                </table>
                </td></tr></table>
                </form>
            </div>
</div>

</BODY>
</HTML>

<?php
function printCellBlocks($cellBlocks, $blockNr)
{
    $sepNr = (int)(count($cellBlocks) / $blockNr);
    if((count($cellBlocks) % $blockNr) > 0){
        $sepNr++;
    }
    for($i = 0; $i < $sepNr; $i++){
        print "<tr>";
        for($j = 0; $j < $blockNr; $j++){
            print $cellBlocks[$i + $j * $sepNr];
        }
        print "</tr>";
    }
}
?>