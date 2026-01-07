<?php

include_once(__DIR__ . '/../includes/functions.php');
include_once('../includes/functions_levels.php');

if (!$userObject || !in_array($userObject['status'], array(4, 5, 6))) {
    include_once('../pages/index.php');
    exit;
}

$localLangs = getClientsLocalLangs();

if ($userObject['status'] == 6) {
    $canEdit = true;
} else {
    $canEdit = false;
}

if (isset($_POST['actionType']) && $_POST['actionType'] == "saveForm") {
    $message = '';
    $storeArray = array();
    $storeArray['id'] = $_POST['userId'];
    $storeArray['email'] = $_POST['email'] ?? '';
    $storeArray['jelszo'] = $_POST['username'] ?? '';
    $storeArray['max_level'] = $_POST['max_level'] ?? '';
    $storeArray['status'] = $_POST['status'] ?? '';
    $storeArray['tanar'] = $_POST['tanar'] ?? '0';
    $storeArray['vezeteknev'] = $_POST['vezeteknev'] ?? '';
    $storeArray['keresztnev'] = $_POST['keresztnev'] ?? '';
    $storeArray['forras_nyelv'] = $_POST['forras_nyelv'] ?? '';
    $storeArray['nyelv'] = $_POST['nyelv'] ?? '';
    $storeArray['program_start_date'] = $_POST['program_start_date'] ?? '';
    $storeArray['program_end_date'] = $_POST['program_end_date'] ?? '';
    $storeArray['client_data'] = $_POST['comment'] ?? '';
    $storeArray['payment'] = $_POST['payment'] ?? '';
    $storeArray['hazi_feladat'] = $_POST['hazi_feladat'] ?? '';
    $storeArray['next_lesson'] = $_POST['next_lesson'] ?? '';
    if ($canEdit) $storeArray['send_mail'] = ($_POST['send_mail'] ? '1' : '0');
    else $storeArray['send_mail'] = '0';
    if ($_POST['isNewRecord']) {
        $storeArray['max_level'] = $_POST['max_level'] = 1000;
        $_POST['userId'] = createUser($storeArray, $message);
        if (!$_POST['userId']) {
            print "<script>alert('{$message}');</script>";
        } else {
            $_POST['isNewRecord'] = "0";
        }
    } else {
        $modifyResult = modifyUser($storeArray, $message);

        if (!$modifyResult) {
            $escapedMessage = addslashes($message);
            print "<script>alert('{$escapedMessage}');</script>";
        }
    }
} else if (isset($_POST['actionType']) && $_POST['actionType'] == "deleteForm") {
    if (!deleteUser($_POST['userId'])) {
        print "<script>alert('Felhaszn�l� t�rl�se nem siker�lt');</script>";
    } else {
        $_POST['userId'] = null;
    }
} else if (isset($_POST['actionType']) && $_POST['actionType'] == "newRecord") {
    $_POST['userId'] = 0;
    $selectedUser['send_mail'] = 1;
    $selectedUser['forras_nyelv'] = 1;  // Default to first language
    $selectedUser['nyelv'] = 2;  // Default to second language
    $selectedUser['status'] = 1;  // Default to Free trial
}

if (!isset($_POST['userId']) || !$_POST['userId']) {
    $_POST['isNewRecord'] = "1";
}

$userProgress = "";
if (isset($_POST['userId']) && $_POST['userId'] > 0) {
    $selectedUser = getUserObjById($_POST['userId']);
    $userProgress = getUserProgress($selectedUser);
} else {
    $selectedUser['program_start_date'] = date("Y-m-d H");
    $selectedUser['program_end_date'] = date('Y-m-d H', strtotime(date("Y-m-d", time()) . " + 365 day"));
    if (isset($_POST['actionType']) && $_POST['actionType'] == "saveForm" && $_POST['isNewRecord']) {
        $selectedUser['vezeteknev'] = $_POST['vezeteknev'];
        $selectedUser['keresztnev'] = $_POST['keresztnev'];
        $selectedUser['forras_nyelv'] = $_POST['forras_nyelv'];
        $selectedUser['nyelv'] = $_POST['nyelv'];
        $selectedUser['max_level'] = $_POST['max_level'];
        $selectedUser['status'] = $_POST['status'];
        $selectedUser['program_start_date'] = $_POST['program_start_date'];
        $selectedUser['program_end_date'] = $_POST['program_end_date'];
        $selectedUser['email'] = $_POST['email'];
        $selectedUser['username'] = $_POST['username'];
        $selectedUser['client_data'] = $_POST['taComment'];
        $selectedUser['payment'] = $_POST['taPayment'];
        $selectedUser['hazi_feladat'] = $_POST['taHaziFeladat'];
        $selectedUser['next_lesson'] = $_POST['txtNextLesson'];
        $selectedUser['send_mail'] = $_POST['send_mail'];
    }
}
if ($userObject['status'] == 6) {
    $jelentkezok = getUsersByLanguage(0);
} else {
    $jelentkezok = getUsersByTeacher($userObject['id']);
}

$tanarok = getUsersByStatusArray(array(4, 5));

$levelList = getLevelList(isset($selectedUser['nyelv']) ? $selectedUser['nyelv'] : 0);
$statusList = array(1 => 'Free trial', 2 => 'Course student', 3 => 'Skype student', 4 => 'Tan�r', 5 => 'Curriculum �r�', 6 => 'Admin');

$userWordCounts = getAllUserOwnWordCount();

$selectedUser['program_start_date'] = substr($selectedUser['program_start_date'], 0, 13);
$selectedUser['program_end_date'] = substr($selectedUser['program_end_date'], 0, 13);

?>
<script>
    window.jQuery || document.write("<script src='<?php print BASE_PATH; ?>/js/jquery-1.11.1.min.js' type='text/javascript'>\x3C/script>")
</script>
<script src="<?php print BASE_PATH; ?>/js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script>
    jQuery(function($) {
        $("#txtNextLesson").mask("9999.99.99 99:99");
    });
</script>
<?php


print "<form action='$formAction' method='post'>";
print "<input type='hidden' name='actionType' value=''>";
print "<input type='hidden' name='sourcePage' value='clients'>";
print "<input type='hidden' name='userId' value='" . (string)($_POST['userId'] ?? '') . "'>";
print "<input type='hidden' name='isNewRecord' value='" . (isset($_POST['isNewRecord']) ? $_POST['isNewRecord'] : '') . "'>";
print "<input type='hidden' name='comment' value=''>";
print "<input type='hidden' name='dictionaryUser' value=''>";
print "<input type='hidden' name='homeWorkOrder' value=''>";
if ($userObject['status'] == 6) {
    print "<input type='hidden' name='payment' value=''>";
}
print "<input type='hidden' name='hazi_feladat' value=''>";
print "<input type='hidden' name='next_lesson' value=''>";
print "<table style='border: 1px solid' align='center' width='700'><tr><td colspan=3>";
print "<table border='1' style='border: 1px solid'>";
print "<tr>
    <th>&nbsp;Vezetéknév</th>
    <th>&nbsp;Keresztnév</th>
    <th>&nbsp;Forrás nyelv</th>
    <th>&nbsp;Nyelv</th>
    <th>&nbsp;Start/Limit</th>
    <th>&nbsp;Email</th>
    <th>&nbsp;Jelszó</th>
    <th>&nbsp;Státusz</th>";
if ($userObject['status'] == 6) {
}
print "<th><input type='button' value='Ment' onclick=\"
    this.form.actionType.value='saveForm';
    this.form.comment.value=document.getElementById('taComment').value;
    if(document.getElementById('taPayment'))
        this.form.payment.value=document.getElementById('taPayment').value;
    if(document.forms['wordManagement']){
        this.form.dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
        this.form.homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
    }
    this.form.submit();\"></th>";

if ($userObject['status'] == 6) {
    print "<th><input type='button' value='Új' onclick=\"this.form.actionType.value='newRecord';this.form.submit();\"></th>";
}
print "</tr>";

if ($canEdit) {
    $vezetekNevText = "<input type='text' name='vezeteknev' value='" . (isset($selectedUser['vezeteknev']) ? $selectedUser['vezeteknev'] : '') . "' size='12'>";
    $keresztNevText = "<input type='text' name='keresztnev' value='" . (isset($selectedUser['keresztnev']) ? $selectedUser['keresztnev'] : '') . "' size='12'>";
    $forrasNyelvText = "\n<select name='forras_nyelv'>";
    foreach ($localLangs as $key => $value) {
        $forrasNyelvText .= "\n<option value='{$key}' " . (isset($selectedUser['forras_nyelv']) && $selectedUser['forras_nyelv'] == $key ? 'selected' : '') . ">{$value}";
    }
    $forrasNyelvText .= "\n</select>";
    $nyelvText = "\n<select name='nyelv'>";
    foreach ($localLangs as $key => $value) {
        $nyelvText .= "\n<option value='{$key}' " . (isset($selectedUser['nyelv']) && $selectedUser['nyelv'] == $key ? 'selected' : '') . ">{$value}";
    }
    $nyelvText .= "\n</select>";
    $programStartDateText = "<input type='text' name='program_start_date' value='" . (isset($selectedUser['program_start_date']) ? $selectedUser['program_start_date'] : '') . "' size='6'>";
    $programEndDateText = "<input type='text' name='program_end_date' value='" . (isset($selectedUser['program_end_date']) ? $selectedUser['program_end_date'] : '') . "' size='6'>";
    $emailText = "<input type='text' name='email' value='" . (isset($selectedUser['email']) ? $selectedUser['email'] : '') . "' style='width:100px'>";
    $jelszoText = "<input type='text' name='username' value='" . (isset($selectedUser['jelszo']) ? $selectedUser['jelszo'] : '') . "' size='4'>";
    $statusText = "<select name='status'>";
    foreach ($statusList as $status => $statusName) {
        if (isset($selectedUser['status']) && $selectedUser['status'] == $status) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $statusText .= "\n<option value='{$status}' $selected>{$statusName}";
    }
    $statusText .= "\n</select>";
} else {
    $vezetekNevText = $selectedUser['vezeteknev'];
    $keresztNevText = $selectedUser['keresztnev'];
    $forrasNyelvText = $localLangs[$selectedUser['forras_nyelv']];
    $nyelvText = $localLangs[$selectedUser['nyelv']];
    $programStartDateText = $selectedUser['program_start_date'];
    $programEndDateText = $selectedUser['program_end_date'];
    $emailText = $selectedUser['email'];
    $jelszoText = $selectedUser['jelszo'];
    $statusText = $statusList[$selectedUser['status']];
}

print "<tr>
        <td>&nbsp;$vezetekNevText</td>
        <td>&nbsp;$keresztNevText</td>";
print "<td>&nbsp;$forrasNyelvText</td>";
print "<td>&nbsp;$nyelvText</td>";
print "<td>$programStartDateText<br>$programEndDateText</td>
        <td>&nbsp;$emailText</td>
        <td>&nbsp;$jelszoText</td>";
print "<td>$statusText</td>";
if ($userObject['status'] == 6) {
    print "<td><input type='button' name='deleteBtn' value='Töröl' onclick=\"
        if(confirm('Biztos szeretn�d t�r�lni a felhaszn�l�t?')){
            this.form.actionType.value='deleteForm';
            this.form.submit();
        }
        \"></td>";
    print "<td><input type='checkbox' name='send_mail' value='1' " . (isset($selectedUser['send_mail']) && $selectedUser['send_mail'] ? 'checked' : '') . "></td>";
}

print "</tr></table>";
print "</form>";
print "</td></tr>";
print "<tr><td valign='top' colspan='2'>";
print "<div style='width:390;height:280;overflow:auto'>";
print "<form id='userSelectForm' name='userSelectForm' action='$formAction' method='post'>
            <input type='hidden' name='actionType' value='selectRecord'>
            <input type='hidden' name='isNewRecord' value='0'>
            <input type='hidden' name='sourcePage' value='clients'>
            <input type='hidden' name='userId' value=''>
            <input type='hidden' name='dictionaryUser' value=''>
            <input type='hidden' name='homeWorkOrder' value=''>
        </form>";
print "<table border=1 cellpadding=0 style='width:100%'>";

$sorszam = count($jelentkezok);
$jelentkezok_ordered = array();

foreach ($jelentkezok as $jelentkezo) {
    if ($jelentkezo['status'] == 1) {
        $jelentkezok_ordered[] = $jelentkezo;
    }
}
foreach ($jelentkezok as $jelentkezo) {
    if ($jelentkezo['status'] == 2) {
        $jelentkezok_ordered[] = $jelentkezo;
    }
}
foreach ($jelentkezok as $jelentkezo) {
    if ($jelentkezo['status'] != 1 && $jelentkezo['status'] != 2) {
        $jelentkezok_ordered[] = $jelentkezo;
    }
}

foreach ($jelentkezok_ordered as $jelentkezo) {
    $jelentkezo['program_start_date'] = substr($jelentkezo['program_start_date'], 0, 10);
    $jelentkezo['program_end_date'] = substr($jelentkezo['program_end_date'], 0, 10);
    if ($jelentkezo['status'] == 2) {
        $bgcolor = 'green';
    } else if ($jelentkezo['status'] == 1) {
        $bgcolor = 'grey';
    } else if ($jelentkezo['send_mail']) {
        $bgcolor = 'red';
    } else {
        $bgcolor = 'red';
    }

    if ($jelentkezo['last_login_date']) {
        $eltelt_mpek = abs(strtotime(date("Y-m-d H:i:s")) - strtotime($jelentkezo['last_login_date']));
        $napja = intdiv($eltelt_mpek, 60 * 60 * 24);
        $oraja = intdiv($eltelt_mpek, 60 * 60) % 24;
        $perce = intdiv($eltelt_mpek, 60) % 60;
        $ideje = $napja . " napja " . $oraja . " oraja " . $perce . " perce";
    } else {
        $ideje = "M�g soha.";
    }

    //    $timeFromLastLogin =
    print "<tr>
        <td height='28' align='right' style='font-size:15px;font-weight:500;background-color:{$bgcolor};color:white;'width='22'>{$sorszam}</td>
        <td>&nbsp;<a href='#' style='font-weight:bold;color:white' onclick=\"
            document.forms['userSelectForm'].userId.value={$jelentkezo['id']};
            if(document.forms['wordManagement']){
                document.forms['userSelectForm'].dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
                document.forms['userSelectForm'].homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
            }
            document.forms['userSelectForm'].submit();\" title=\"" . htmlspecialchars($ideje, ENT_QUOTES) . "\">{$jelentkezo['vezeteknev']} {$jelentkezo['keresztnev']} (" . (isset($userWordCounts[$jelentkezo['id']]) ? (int)$userWordCounts[$jelentkezo['id']] : 0) . ")</a></td>
        <td style='font-weight:bold'>&nbsp;" . getUsedTime($jelentkezo['id']) . "</td>
        </tr>";
    $sorszam--;
}
print "</table><a name='bottom'>";
print "</div>";
print "</td>";
/*
print "<td valign='top' rowspan='2'><select name='max_level' size='12' style='width:100px'>";

foreach((array)$levelList as $level => $levelName){
    if($selectedUser['max_level'] == 1000){
        $usedMaxLevel = $level;
    }
    else{
        if($selectedUser['max_level'] >= $level && $level > $usedMaxLevel){
            $usedMaxLevel = $level;
        }
    }
}

$i = 1;
foreach((array)$levelList as $level => $levelName){
    if($usedMaxLevel == $level){
        $selected = 'selected';
    }
    else{
        $selected = '';
    }
    if(!in_array($levelName[1], array(1, 2))){
        $text = $i++ . ". ";
    }
    else{
        $text = "&nbsp;&nbsp;&nbsp;&#8627 ";
    }
    $text .= $levelName[0];
    print "\n<option value='{$level}' $selected>{$text}";
}
print "</select></td>;
*/
print "<td valign='top'><textarea name='taComment' style='font-size:14px;font-weight:300;background-color:WHITE;color:BLACK' id='taComment' cols='46', rows='16'>" . (isset($selectedUser['client_data']) ? $selectedUser['client_data'] : '') . "</textarea></td>";
print "</tr>";

print "</table>";
?>