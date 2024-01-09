<?php

include_once('functions.php');

if(!$userObject || !in_array($userObject['status'], array(4, 5, 6))){
    include_once('index.php');
    exit;
}

?>

<script>
    $(document).ready(function () {
        $("#btnDeleteMulti").click(function () {
            $(".deleteInputGhost").remove();
            if(!confirm('Biztos szeretnéd törölni a becheck-elt finance rekordokat?')){
                return false;
            }
            var isChecked = false;
            $(".cbDelete:checked").each(function () {
                var id = $(this).data('id');
                $('<input />', { type: 'hidden', name: 'idsToDelete[]', value: id, class: 'deleteInputGhost' }).appendTo($("#formSelectedRecord"));
                isChecked = true;
            });
            if(isChecked){
                $("#formSelectedRecord #actionType").val('deleteMultiFinanceForm');
                $("#formSelectedRecord").submit();
            }
        });
    });
</script>

<?php

$localLangs = getClientsLocalLangs();

if($userObject['status'] == 6){
    $canEdit = true;
}
else{
    $canEdit = false;
}

if($_POST['actionType'] == "saveFinanceForm"){
    $storeArray = array();
    $storeArray['id'] = $_POST['financeId'];
    if(isset($_POST['user_id'])) $storeArray['user_id'] = $_POST['user_id'];
    if(isset($_POST['payment_date'])) $storeArray['payment_date'] = $_POST['payment_date'];
    if(isset($_POST['time_package'])) $storeArray['time_package'] = $_POST['time_package'];
    if(isset($_POST['paid_to_who'])) $storeArray['paid_to_who'] = $_POST['paid_to_who'];
    if(isset($_POST['lesson_date'])) $storeArray['lesson_date'] = $_POST['lesson_date'];
    if($_POST['isNewFinanceRecord']){
        $storeArray['amount'] = 5000;
        for($i = 0; $i < $_POST['package_number']; $i++){
            $_POST['financeId'] = createFinance($storeArray, $message);
            if(!$_POST['financeId']){
                print "<script>alert('{$message}');</script>";
            }
            else{
                $_POST['isNewFinanceRecord'] = "0";
            }
        }
    }
    else{
        if(!modifyFinance($storeArray, $message)){
            print "<script>alert('{$message}');</script>";
        }
    }
}
else if($_POST['actionType'] == "deleteFinanceForm"){
    if(!deleteFinance($_POST['financeId'])){
        print "<script>alert('Finance rekord törlése nem sikerült');</script>";
    }
}
else if($_POST['actionType'] == "deleteMultiFinanceForm"){
    if(!deleteFinance($_POST['idsToDelete'])){
        print "<script>alert('Finance rekord törlése nem sikerült');</script>";
    }
}
else if($_POST['actionType'] == "newFinanceRecord"){
    $_POST['financeId'] = 0;
    $selectedFinance['send_mail'] = 1;
}

if(!$_POST['financeId']){
    $_POST['isNewFinanceRecord'] = "1";
}

if($_POST['financeId'] > 0){
    $selectedFinance = getFinanceById($_POST['financeId']);
}
else{
    $selectedFinance['payment_date'] = date("Y-m-d H");
    if($_POST['actionType'] == "saveFinanceForm" && $_POST['isNewFinanceRecord']){
        $selectedFinance['nev'] = $_POST['nev'];
        $selectedFinance['forras_nyelv'] = $_POST['forras_nyelv'];
        $selectedFinance['nyelv'] = $_POST['nyelv'];
        $selectedFinance['max_level'] = $_POST['max_level'];
        $selectedFinance['status'] = $_POST['status'];
        $selectedFinance['payment_date'] = $_POST['payment_date'];
        $selectedFinance['email'] = $_POST['email'];
        $selectedFinance['username'] = $_POST['username'];
        $selectedFinance['client_data'] = $_POST['taComment'];
        $selectedFinance['payment'] = $_POST['taPayment'];
        $selectedFinance['hazi_feladat'] = $_POST['taHaziFeladat'];
        $selectedFinance['next_lesson'] = $_POST['txtNextLesson'];
        $selectedFinance['send_mail'] = $_POST['send_mail'];
    }
}

$jelentkezokForFilter = array();
if(in_array($userObject['status'], array(6))){
    if($_POST['selectedStudent'] > 0){
        $jelentkezok = array();
        $jelentkezok[] = getUserObjById($_POST['selectedStudent']);
        $finances = getFinancesByStudent($_POST['selectedStudent']);
    }
    else if($_POST['selectedTeacher'] > 0){
        $jelentkezok = getUsersByTeacher($_POST['selectedTeacher']);
        $finances = getFinances($_POST['selectedTeacher']);
    }
    else{
        $jelentkezok = getUsersByLanguage(0);
        $finances = getFinances(0);
    }
    $jelentkezokForFilter = getUsersByLanguage(0);
}
else if(in_array($userObject['status'], array(4, 5))){
    if($_POST['selectedStudent'] > 0){
        $jelentkezok = array();
        $jelentkezok[] = getUserObjById($_POST['selectedStudent']);
        $finances = getFinancesByStudent($_POST['selectedStudent']);
    }
    else{
        $jelentkezok = getUsersByTeacher($userObject['id']);
        $finances = getFinances($userObject['id']);
    }
    $jelentkezokForFilter = getUsersByTeacher($userObject['id']);
}

$selectedFinance['payment_date'] = substr($selectedFinance['payment_date'], 0, 13);

?>
<script>window.jQuery || document.write("<script src='js/jquery-1.11.1.min.js' type='text/javascript'>\x3C/script>")</script>
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script>
jQuery(function($){
   $("#txtNextLesson").mask("9999.99.99 99:99");
});
</script>
<?php


print "<form id='formSelectedRecord' action='$formAction' method='post'>";
print "<input type='hidden' id='actionType' name='actionType' value=''>";
print "<input type='hidden' name='sourcePage' value='finance'>";
print "<input type='hidden' name='financeId' value='{$_POST['financeId']}'>";
print "<input type='hidden' name='isNewFinanceRecord' value='{$_POST['isNewFinanceRecord']}'>";
print "<input type='hidden' name='comment' value=''>";
print "<input type='hidden' name='dictionaryUser' value=''>";
print "<input type='hidden' name='homeWorkOrder' value=''>";
print "<input type='hidden' name='selectedTeacher' value='{$_POST['selectedTeacher']}'>";
print "<input type='hidden' name='selectedStudent' value='{$_POST['selectedStudent']}'>";
if($userObject['status'] == 6){
    print "<input type='hidden' name='payment' value=''>";
}
print "<input type='hidden' name='hazi_feladat' value=''>";
print "<input type='hidden' name='next_lesson' value=''>";
print "<table style='border: 1px solid' align='center' width='800'><tr><td colspan=3>";
print "<table border=1 cellpadding=1>";

if($userObject['status'] != 6 && !$selectedFinance['id']){
    $disabled = "disabled";
}
else{
    $disabled = "";
}
$mentGomb = "<input type='button' value='Ment' $disabled onclick=\"
        this.form.actionType.value='saveFinanceForm';
        this.form.comment.value=document.getElementById('taComment').value;
        if(document.forms['wordManagement']){
            this.form.dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
            this.form.homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
        }
        this.form.submit();\">";
if($userObject['status'] == 6){
    if($_POST['selectedTeacher'] > 0){
        $balance = getBalance($_POST['selectedTeacher']);
    }
    else{
        $balance = 0;
    }
}
else{
    $balance = getBalance($userObject['id']);
}
if($userObject['status'] == 6){
    print "<tr>
            <th>&nbsp;Név</th>
            <th>&nbsp;Fizetési dátum</th>";
    if(!$selectedFinance['id']){
        print "<th>&nbsp;Csomag db</th>";
    }
    print "<th>&nbsp;Skype perc</th>";
    print "<th>&nbsp;Kinek utalva</th>";
    print "<th>&nbsp;<a href='#' onclick=\"
        var d = new Date();
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        document.getElementById('lesson_date_text').value = curr_year + '-' + curr_month + '-' + curr_date;
    \">Letanítva</a></th>";
    print "<th>$mentGomb</th>";
    print "<th><input type='button' value='Új' onclick=\"this.form.actionType.value='newFinanceRecord';this.form.submit();\"></th>";
    print "<th rowspan=2 style='font-size:16px;color:red;'>&nbsp;Balance: {$balance}</th>";
    print "</tr>";
}
else{
    print "<tr>
            <th>&nbsp;Név</th>
            <th>&nbsp;Fizetési dátum</th>
            <th>&nbsp;Skype perc</th>
            <th>&nbsp;Kinek utalva</th>
            <th>&nbsp;<a href='#' onclick=\"
                var d = new Date();
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                document.getElementById('lesson_date_text').value = curr_year + '-' + curr_month + '-' + curr_date;
            \">Letanítva</a></th>
            <th>$mentGomb</th>
            <th></th>
            <th rowspan=2 style='font-size:16px;color:red;'>&nbsp;Balance: {$balance}</th>
        </tr>";
}
/*
else{
    print "\n<tr><select name='selectedStudent'><option value=''>";
    foreach($jelentkezok as $jelentkezo){
        print "\n<option value='{$jelentkezo['id']}' onchange=\"this.form.submit();\">{$jelentkezo['vezeteknev']} {$jelentkezo['keresztnev']}";
    }
    print "\n</select></tr>";
}
*/
if(!$_POST['financeId'] && $userObject['status'] == 6){

    $nevText = "<select name='user_id' id='nev'>\n<option value='0'>";
    $selected = '';
    foreach($jelentkezok as $jelentkezo){
        if($selectedFinance['user_id'] == $jelentkezo['id']){
            $selected = "selected";
        }
        else{
            $selected = "";
        }
        $nevText .= "\n<option value='{$jelentkezo['id']}' {$selected}>{$jelentkezo['vezeteknev']} {$jelentkezo['keresztnev']}";
    }
}
else{
    $nevText = $selectedFinance['vezeteknev'] . ' ' . $selectedFinance['keresztnev'];
}
if($userObject['status'] == 6){
    $programStartDateText = "\n<input type='text' name='payment_date' value='" . substr($selectedFinance['payment_date'], 0, 10) . "' size='8'>";
    $csomagSzamText = "\n<select name='package_number'>";
    for($i = 1; $i <= 20; $i++){
        $csomagSzamText .= "\n<option value='{$i}'>{$i}";
    }
    $csomagSzamText .= "\n</select>";
    $skypePercText = "\n<select name='time_package'>";
    $skypePercText .= "\n<option value='1' " . ($selectedFinance['time_package'] == '1' ? 'selected' : '') . ">60";
    $skypePercText .= "\n<option value='2' " . ($selectedFinance['time_package'] != '1' ? 'selected' : '') . ">90";
    $skypePercText .= "\n</select>";
    $kinekUtalvaText = "\n<select name='paid_to_who'>";
    $kinekUtalvaText .= "\n<option value='1' " . ($selectedFinance['paid_to_who'] == '1' ? 'selected' : '') . ">Tanár";
    $kinekUtalvaText .= "\n<option value='2' " . ($selectedFinance['paid_to_who'] != '1' ? 'selected' : '') . ">Kikérdezõ";
    $kinekUtalvaText .= "\n</select>";
}
else{
    $programStartDateText = substr($selectedFinance['payment_date'], 0, 10);
    $skypePercText = $selectedFinance['time_package'] == 1 ? '60' : ($selectedFinance['time_package'] == 2 ? '90' : '-');
    $kinekUtalvaText = $selectedFinance['paid_to_who'] == 1 ? 'Tanár' : ($selectedFinance['paid_to_who'] == 2 ? 'Kikérdezõ' : '-');
}
if($userObject['status'] != 6 && !$selectedFinance['id']){
    $disabled = "disabled";
}
else{
    $disabled = "";
}
$lessonDateText = "\n<input type='text' name='lesson_date' id='lesson_date_text' value='" . substr($selectedFinance['lesson_date'], 0, 10) . "' size='13' {$disabled}>";

print "<tr>
        <td>&nbsp;$nevText</td>";
print "<td>&nbsp;$programStartDateText</td>";
if($userObject['status'] == 6){
    if(!$selectedFinance['id']){
        print "<td>&nbsp;$csomagSzamText</td>";
    }
}
print "<td>&nbsp;$skypePercText</td>";
print "<td>&nbsp;$kinekUtalvaText</td>";
print "<td>&nbsp;$lessonDateText</td>";
if($userObject['status'] == 6){
    print "<td><input type='button' name='deleteBtn' value='Töröl' onclick=\"
        if(confirm('Biztos szeretnéd törölni a finance rekordot?')){
            this.form.actionType.value='deleteFinanceForm';
            this.form.submit();
        }
        \"></td>";
    //print "<td><input type='checkbox' name='send_mail' value='1' " . ($selectedFinance['send_mail'] ? 'checked' : '') . "></td>";
}
print "</tr></table>";
print "</form>";
print "</td></tr>";
print "<tr><td valign='top' rowspan='3'>";
print "<div style='width:100%;height:425;overflow:auto;filter:alpha(opacity=100);opacity:1;z-index:99;background-color:white;'>";
print "<form id='userSelectFormForFinance' name='userSelectFormForFinance' action='$formAction' method='post'>
            <input type='hidden' name='actionType' value='selectFinanceRecord'>
            <input type='hidden' name='isNewFinanceRecord' value='0'>
            <input type='hidden' name='sourcePage' value='finance'>
            <input type='hidden' name='financeId' value=''>
            <input type='hidden' name='dictionaryUser' value=''>
            <input type='hidden' name='homeWorkOrder' value=''>
            <input type='hidden' name='comment' value=''>";
print "\n<table style='width:100%'><tr><td><select name='selectedStudent' onchange=\"document.forms['userSelectFormForFinance'].submit();\"><option value=''>";
foreach($jelentkezokForFilter as $jelentkezo){
    if($_POST['selectedStudent'] == $jelentkezo['id']){
        $selected = 'selected';
    }
    else{
        $selected = '';
    }
    print "\n<option value='{$jelentkezo['id']}' $selected>{$jelentkezo['vezeteknev']} {$jelentkezo['keresztnev']}";
}
print "\n</select></td>";
if($userObject['status'] == 6){
    $teachers = getUsersByStatusArray(array(4, 5));
    print "<td><select name='selectedTeacher' onchange=\"
        this.form.comment.value=document.getElementById('taComment').value;
        if(document.forms['wordManagement']){
            this.form.dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
            this.form.homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
        }
        this.form.submit();
     \">
        <option value=''>";
    foreach($teachers as $teacher){
        if($_POST['selectedTeacher'] > 0 && $teacher['id'] == $_POST['selectedTeacher']){
            $selected = 'selected';
        }
        else{
            $selected = '';
        }
        print "\n<option value='{$teacher['id']}' $selected>{$teacher['keresztnev']}";
    }
    print "</select></td>";
}
print "\n<td>";
print "\n<input type='button' name='students' id='students' value='Tanítványok' onclick=\"document.forms['userSelectForm'].userId.value=" . (int)$_POST['selectedStudent'] . ";
                                                                                            if(document.forms['wordManagement']){
                                                                                                document.forms['userSelectForm'].dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
                                                                                                document.forms['userSelectForm'].homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
                                                                                            }
                                                                                            document.forms['userSelectForm'].submit();\">";
print "\n</td>";
print "\n<td style='text-align:right;width:100%'>";
print "\n<input type='button' id='btnDeleteMulti' value='Kijelöltek törlése'>";
print "\n</td>";

print "</tr></table>";
print "</form>";

print "<table border=1 cellpadding=2 width='100%'>";
    print "<tr>
        <th>Név</th>
        <th>Fizetési dátum</th>
        <th>Összeg</th>
        <th>Skype perc</th>
        <th>Kinek utalva</th>
        <th>Tanár része</th>
        <th>Kikérdezõ része</th>
        <th>Letanítva</th>
        <th></th>
        </tr>";

foreach((array)$finances as $finance){
    if(!$finance['time_package']) $time_package_text = '-';
    else if($finance['time_package'] == 1) $time_package_text = '60';
    else if($finance['time_package'] == 2) $time_package_text = '90';
    else $time_package_text = 'Namostmivan?';

    if(!$finance['paid_to_who']) $paid_to_who_text = '-';
    else if($finance['paid_to_who'] == 1) $paid_to_who_text = 'tanár';
    else if($finance['paid_to_who'] == 2) $paid_to_who_text = 'kikérdezõ';
    else $paid_to_who_text = 'Namostmivan?';
    
    if(strlen($finance['lesson_date']) > 4 && $finance['lesson_date'][0] != '0'){
        $style = 'background-color:#FDA8AC;';
    }
    else{
        $style = '';
    }

    print "<tr style='{$style}'>
        <td>&nbsp;<a href='#' style='font-weight:bold;' onclick=\"
            document.forms['userSelectFormForFinance'].financeId.value={$finance['id']};
            if(document.forms['wordManagement']){
                document.forms['userSelectFormForFinance'].dictionaryUser.value = document.forms['wordManagement'].dictionaryUser.value;
                document.forms['userSelectFormForFinance'].homeWorkOrder.value = document.forms['wordManagement'].homeWorkOrder.value;
            }
            document.forms['userSelectFormForFinance'].submit();\">{$finance['vezeteknev']} {$finance['keresztnev']}</a></td>
        <td style='font-weight:bold;white-space:nowrap'>" . substr($finance['payment_date'], 0, 10) . "</td>
        <td align='right' style='font-weight:bold'>{$finance['amount']}</td>
        <td align='right' style='font-weight:bold'>{$time_package_text}</td>
        <td align='right' style='font-weight:bold'>{$paid_to_who_text}</td>
        <td align='right' style='font-weight:bold'>{$finance['payable_to_teacher']}</td>
        <td align='right' style='font-weight:bold'>{$finance['payable_to_boss']}</td>
        <td style='font-weight:bold;white-space:nowrap'>" . substr($finance['lesson_date'], 0, 10) . "</td>
        <td><input type='checkbox' class='cbDelete' data-id='{$finance['id']}'></td>
        </tr>";
}
print "</table><a name='bottom'>";
print "</div>";
print "</td>";
print "</tr>";
print "</table>";
?>