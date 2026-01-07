<?php
    $userObject = $_SESSION['userObject'];

    if($_POST['actionType'] == 'applySettings'){
        $errorMessage = '';
        if(!modifyUser(array(
                'id' => $userObject['id'],
                'keresztnev' => $_POST['keresztnev'],
                'send_mail' => ($_POST['send_mail'] ? '1' : '0')
            ), $errorMessage)){
            print "<script>alert('" . translate("unsuccessfulSettingchange") . "')</script>";
        }
        else{
            print "<script>location.href='index.php?usersettings=1';</script>";
            print "<script>alert('" . translate("successfulSettingchange") . "')</script>";
            $GLOBALS["userObject"] = $_SESSION["userObject"] = $userObject = getUserObjById($userObject['id']);
        }

        if($errorMessage != ''){
            print "<script>alert('{$errorMessage}')</script>";
        }
    }
    if($_POST['actionType'] == 'deleteUser'){
        if(!deleteUser($userObject['id'])){
            print "<script>alert('" . translate("unsuccessfulUserdelete") . "')</script>";
        }
        else{
            print "<script>alert('" . translate("successfulUserdelete") . "')</script>";
            print "<script>location.href='logout.php';</script>";
        }
    }
    if($_POST['actionType'] == 'changePassword'){
        if(!changePassword($userObject['id'], array('oldPassword' => $_POST['oldPassword'],
                                                    'newPassword' => $_POST['newPassword'],
                                                    'confirmNewPassword' => $_POST['confirmNewPassword']))){
            print "<script>alert('" . translate("unsuccessfulPwchange") . "')</script>";
        }
        else{
            print "<script>alert('" . translate("passwordChanged") . "')</script>";
            print "<script>location.href='index.php';</script>";
        }
    }

    if($userObject['send_mail']){
        $isSendMailChecked = 'checked';
    }
    else{
        $isSendMailChecked = '';
    }
?>


<?php if(!$isAndroid){ ?>

<div style='width:100%;text-align:center;margin-top:10px;'>
<a href='index.php'><?php print translate("vissza_a_fooldalra") ?></a></div>

<form id="formUserSettings" method='POST'>
<br>
<table style='border:solid #000000 1px' align='center' bgcolor='#FAFAFA'>
 <tr>
  <td>
  <table border='0' cellpadding='4' style='font-size:11px;'>
     <tr>
       <td colspan='2' style=<?php print "'color:" . $globalcolor . ""; ?>;font-size:12px' align='center'><font size='5'>
       <?php print "" . translate('usersettings_header_3') . ""; ?><br></font>
       </td>
     </tr>
     <tr>
       <td>
       <input type='hidden' id='actionType' name='actionType' value=''>
       <?php print translate('Keresztnev_2'); ?>
       </td>
       <td>
       <input type='text' size='15' name='keresztnev' value=<?php print "'{$userObject['keresztnev']}'";?>>
       </td>
     </tr>
     <tr>
        <td>
         <?php echo translate("sendMeQuotes"); ?>
       </td>
        <td>
        <input type='checkbox' style='zoom:3;' name='send_mail' value='1' <?php print $isSendMailChecked ?>>
       </td>
     </tr>
      <?php
      print "<tr><td colspan='2' valign='top' align='center' style='padding-bottom:20px;'><input type='button' name='applyButton' value='" . translate('set') . "' onclick=\"
            $('#formUserSettings #actionType').val('applySettings');
            $('#formUserSettings').submit();
      \"></td></tr>";
      ?>
      <tr><td><?php echo translate("oldPassword"); ?>: </td><td><input type='text' size='15' name='oldPassword' value=''></td></tr>
      <tr><td><?php echo translate("newPassword"); ?>: </td><td><input type='text' size='15' name='newPassword' value=''></td></tr>
      <tr><td><?php echo translate("confirmNewPassword"); ?>: </td><td><input type='text' size='15' name='confirmNewPassword' value=''>
      </td></tr>
      <tr><td colspan='2' valign='top' align='center' style='padding-bottom:40px;'>
      <?php
      print "<input type='button' name='changePasswordButton' value='" . translate('changePassword') . "' onclick=\"
            $('#formUserSettings #actionType').val('changePassword');
            $('#formUserSettings').submit();
      \">";
      ?>
      </td></tr>
      <tr><td colspan='2' align='center'>
      <?php
      print "<input type='button' name='deleteButton' value='" . translate("deleteMe") . "' onclick=\"
          if(confirm('" . translate('sureWannaDelete') . "')){
            $('#formUserSettings #actionType').val('deleteUser');
            $('#formUserSettings').submit();
          }
      \">";
      ?>
      </table>
   </td></tr></table>
<input type='hidden' name='usersettings' value='1'>
</form>

<?php 	}
  else
{ ?>

<div style='width:100%;text-align:center;margin-top:30px;margin-bottom:20px;'>
<a href='index.php' style='font-size:40px'><?php print translate("vissza_a_fooldalra") ?></a></div>

<form id="formUserSettings" method='POST'>
<br>
<table style='border:solid #000000 1px' align='center' bgcolor='#FAFAFA'>
 <tr>
  <td>
  <table border='0' cellpadding='4'>
     <tr>
       <td colspan='2' style=<?php print "'color:" . $globalcolor . ";font-size:80px'"; ?> align='center'>
       <?php print "" . translate('usersettings_header_3') . ""; ?><br></font>
       </td>
     </tr>
     <tr>
       <td style=<?php print "'color:" . $globalcolor . ";font-size:50px'"; ?>>
       <input type='hidden' id='actionType' name='actionType' value=''>
       <?php print translate('Keresztnev_2'); ?>
       </td>
       <td>
       <input type='text' size='15' style='font-size:50px;' name='keresztnev' value=<?php print "'{$userObject['keresztnev']}'";?>>
       </td>
     </tr>
     <tr>
       <td style=<?php print "'color:" . $globalcolor . ";font-size:50px'"; ?>>
         <?php echo translate("sendMeQuotes"); ?>
       </td>
        <td>
        <input type='checkbox' name='send_mail' value='1' <?php print $isSendMailChecked ?>>
       </td>
     </tr>
      <?php
      print "<tr><td colspan='2' valign='top' align='center' style='padding:20px;'><input style='font-size:50px;padding:40px' type='button' name='applyButton' value='" . translate('set') . "' onclick=\"
            $('#formUserSettings #actionType').val('applySettings');
            $('#formUserSettings').submit();
      \"></td></tr>";
      ?>
      <tr><td style=<?php print "'color:" . $globalcolor . ";font-size:50px'"; ?>><?php echo translate("oldPassword"); ?>: </td><td><input style='font-size:50px;' type='text' size='15' name='oldPassword' value=''></td></tr>
      <tr><td style=<?php print "'color:" . $globalcolor . ";font-size:50px'"; ?>><?php echo translate("newPassword"); ?>: </td><td><input type='text' style='font-size:50px;' size='15' name='newPassword' value=''></td></tr>
      <tr><td style=<?php print "'color:" . $globalcolor . ";font-size:50px'"; ?>><?php echo translate("confirmNewPassword"); ?>: </td><td><input type='text' style='font-size:50px;' size='15' name='confirmNewPassword' value=''>
      </td></tr>
      <tr><td colspan='2' valign='top' align='center' style='padding-bottom:40px;'>
      <?php
      print "<input type='button' style='font-size:50px;padding:40px' name='changePasswordButton' value='" . translate('changePassword') . "' onclick=\"
            $('#formUserSettings #actionType').val('changePassword');
            $('#formUserSettings').submit();
      \">";
      ?>
      </td></tr>
      <tr><td colspan='2' align='center'>
      <?php
      print "<input type='button' style='font-size:50px;padding:40px' name='deleteButton' value='" . translate("deleteMe") . "' onclick=\"
          if(confirm('" . translate('sureWannaDelete') . "')){
            $('#formUserSettings #actionType').val('deleteUser');
            $('#formUserSettings').submit();
          }
      \">";
      ?>
      </table>
   </td></tr></table>
<input type='hidden' name='usersettings' value='1'>
</form>

<?php 	} ?>

</body>
</html>