<?php
if ($_REQUEST['sourcePage'] == 'clients') {
    $clientStyleText = "style='display:block'";
    $mainStyleText = "display:block;";
    $mainContentStyleText = "display:none;";
    $financeStyleText = "style='display:none'";
} else if ($_REQUEST['sourcePage'] == 'finance') {
    $clientStyleText = "style='display:none;";
    $mainStyleText = "display:block;";
    $mainContentStyleText = "display:none;";
    $financeStyleText = "style='display:block'";
} else {
    $clientStyleText = "style='display:none'";
    $mainStyleText = "display:block;";
    $mainContentStyleText = "display:block;";
    $financeStyleText = "style='display:none'";
}

if (in_array($userObject['status'], array(5, 6))) {
    print "\n<div id='clientDiv' {$clientStyleText}>\n";
    $formAction = BASE_PATH . "/pages/index.php";
    include('../admin/clients.php');
    print "\n</div>";
}
if (in_array($userObject['status'], array(5, 6))) {
    print "\n<div id='financeDiv' {$financeStyleText}>\n";
    $formAction = BASE_PATH . "/pages/index.php";
    include('../admin/finance.php');
    print "\n</div>";
}
// if(in_array($userObject['status'], array(4, 5, 6))){
if ($userObject) {

    if ($userObject['status'] != 2 && $userObject['status'] != 1) {
        $onclick1 = "document.getElementById('sentencePracticeDiv').style.display = 'block';";
        $onclick1_1 = "lowerSelectOnChange('listAll', 'mondat', 'sentencePractice');";
        $onclick2 = "submitToMain('wordManagementKitolto');";
        $onclick3 = "submitToMain('wordManagement');";
        $onclick4 = "lowerSelectOnChange('listAll', 'szomondat', 'wordSentencePractice');";
        $style = "'font-size:13pt;color:red'";
        $imgstyle = "'cursor:pointer;'";
    } else {
        $onclick1 = "alert('" . translate("funkcio_skype") . "')";
        $onclick1_1 = "alert('" . translate("funkcio_skype") . "')";
        $onclick2 = "alert('" . translate("funkcio_skype") . "')";
        $onclick3 = "alert('" . translate("funkcio_skype") . "')";
        $onclick4 = "alert('" . translate("funkcio_skype") . "')";
        $style = "'font-size:13pt;color:$globalcolor;opacity:0.4;filter:alpha(opacity=40);'";
        $imgstyle = "'cursor:pointer;opacity:0.4;filter:alpha(opacity=40);'";
    }
} else {
    $onclick1 = "alert('" . $notLoggedInMessage . "')";
    $onclick1_1 = "alert('" . $notLoggedInMessage . "')";
    $onclick2 = "alert('" . $notLoggedInMessage . "')";
    $onclick3 = "alert('" . $notLoggedInMessage . "')";
    $onclick4 = "alert('" . $notLoggedInMessage . "')";
    $style = "'font-size:13pt;color:$globalcolor;opacity:0.4;filter:alpha(opacity=40);'";
    $imgstyle = "'cursor:pointer;opacity:0.4;filter:alpha(opacity=40);'";
}
$_SESSION['intelligentFilterWord'] = null;

if (isset($_REQUEST["usersettings"])) {
    include("../admin/usersettings.php");
    exit;
} else if (isset($_REQUEST["audioszoba"])) {
    include("../api/audio.php");
    exit;
}
