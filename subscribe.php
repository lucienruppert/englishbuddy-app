<?php
session_start();

if (array_key_exists("nyelv", $_GET))
  $_SESSION['page_nyelv'] = $_GET['nyelv'];

if (array_key_exists("nyelv", $_REQUEST))
  $GLOBALS['nyelv'] = (int)$_REQUEST['nyelv'];
else
  $GLOBALS['nyelv'] = 0;

require_once('functions.php');

if ($_POST['actionType'] == 'subscribe') {
  ini_set('session.cookie_lifetime', 0);
  ini_set('session.gc_maxlifetime', 1800);
  $user = array();
  $_POST['firstname'] = strtoupper(substr($_POST['firstname'], 0, 1)) . strtolower(substr($_POST['firstname'], 1));
  $_POST['secondname'] = strtoupper(substr($_POST['secondname'], 0, 1)) . strtolower(substr($_POST['secondname'], 1));
  $user['vezeteknev'] = $_POST['firstname'];
  $user['keresztnev'] = $_POST['secondname'];
  $user['email'] = $_POST['email'];
  $user['jelszo'] = $_POST['login'];
  $user['forras_nyelv'] = $_SESSION['page_nyelv'];
  $user['send_mail'] = ($_POST['send_mail'] ? '1' : '0');

  if ($_SESSION['page_nyelv'] == 0)
    $user['nyelv'] = $_POST['nyelv'];
  else if ($_SESSION['page_nyelv'] == 1)
    $user['nyelv'] = 2;
  else if ($_SESSION['page_nyelv'] == 2)
    $user['nyelv'] = 1;
  else
    $user['nyelv'] = 1;

  $user['subscribe_length'] = $_POST['subscribe_length'];
  $user['status'] = 1;

  if (!$user['vezeteknev'] or !$user['keresztnev'] or !$user['email'] or !$user['jelszo'] or (!$GLOBALS["nyelv"] && !$user['nyelv']) /*or !$user['subscribe_length']*/) {
    $GLOBALS['nyelv'] = $_SESSION["page_nyelv"];
    include("functions_translation.php");
    print "<script>alert('" . translate('missing_field') . "');</script>";
  } else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $_POST['email'])) {
    $GLOBALS['nyelv'] = $_SESSION["page_nyelv"];
    include("functions_translation.php");
    print "<script>alert('" . translate('not_valid_email') . "');</script>";
  } else if (createUser2($user, $message)) {
    $to = $_POST['email'];
    //$subject = "�dv�z�l a lingocasa";
    $langTitles = getLangTitles();
    $nyelv = $user['forras_nyelv'];
    if ($nyelv == 1) {
      $subject = "Welcome to Lingocasa,";
      $body = subscribeBodyENG($user['vezeteknev'] . ' ' . $user['keresztnev'], htmlspecialchars($user['email']), htmlspecialchars($user['jelszo']), $langTitles[$user['nyelv']], (int)$user['subscribe_length']);
    } else if ($nyelv == 2) {
      $subject = "&iexcl;Bienvenido a lingocasa!";
      $body = subscribeBodyESP($user['vezeteknev'] . ' ' . $user['keresztnev'], htmlspecialchars($user['email']), htmlspecialchars($user['jelszo']), $langTitles[$user['nyelv']], (int)$user['subscribe_length']);
    }

    if (strlen($body) > 0) {
      endiMail($to, $subject, $body, "lingocasa.com", "lingocasa.com");
      endiMail('luciendelmar@gmail.com', $subject, $body, "lingocasa.com", "hello@lingocasa.com");
    }
    $GLOBALS['nyelv'] = $_SESSION["page_nyelv"];
    include("functions_translation.php");

    $msg = translate("reg_succes_supscribepage");
    print "<script>alert('$msg');</script>";
    print "<script>location.href = 'index.php';</script>";
  } else {
    if (strlen($message) == 0) {
      $message = translate("reg_error_underSub_supscribepage");
    }
    print "<script>alert('$message');</script>";
    $GLOBALS['nyelv'] = $_SESSION["page_nyelv"];
    include("functions_translation.php");
  }
}
?>

<HTML>

<HEAD>
  <?php
  print "<meta http-equiv=\"content-type\" content=\"text-html; charset=$CHARSET\">";

  ?>
</HEAD>

<BODY BGCOLOR=<?php print "'" . $globalcolor . "'"; ?>>
  <table valign='top' width='100%' align='center' border='2' bordercolor=<?php print "'" . $globalcolor . "'"; ?> style=<?php print "'background-color:" . $globalcolor . "'"; ?>>
    <tr>
      <td align='center'>
        <FORM action='subscribe.php' method='POST'>
          <input type='hidden' name='actionType' id='actionType' value='subscribe'>
          <table align='center' border='0' cellspacing='10px'>
            <tr>
              <td align='left' colspan='2' style='padding-top:10%;padding-bottom:30px;font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_�dv�z�lj�k!") ?></font>
              </td>
            </tr>
            <tr>
              <td align='left' colspan='2' style='padding-bottom:10%;font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_K�rj�k, t�ltse ki adatait!") ?>
              </td>
            </tr>
            <tr>
              <td align='right' valign='center' style='font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_Vezet�kn�v") ?>*
              </td>
              <td><input type='text' size='12' name='firstname' style='font-size:<?php print($SubscribeFontSize); ?>;' value=<?php print "'{$_POST['firstname']}'"; ?>></td>
            </tr>
            <tr>
              <td align='right' valign='center' style='20px;font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_Keresztn�v") ?>*
              </td>
              <td><input type='text' size='12' name='secondname' style='font-size:<?php print($SubscribeFontSize); ?>;' value=<?php print "'{$_POST['secondname']}'"; ?>></td>
            </tr>
            <tr>
              <td align='right' valign='center' style='20px;font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_E-mail") ?>*
              </td>
              <td><input type='text' size='12' name='email' style='font-size:<?php print($SubscribeFontSize); ?>;' value=<?php print "'{$_POST['email']}'"; ?>></td>
            </tr>
            <tr>
              <td align='right' valign='center' style='20px;font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_Jelsz�") ?>*
              </td>
              <td><input type='text' size='12' name='login' style='font-size:<?php print($SubscribeFontSize); ?>;' value=<?php print "'{$_POST['login']}'"; ?>></td>
            </tr>

            <?php if ($_SESSION['page_nyelv'] == 0) { ?>
              <tr>
                <td align='right' style='font-size:<?php print($SubscribeFontSize); ?>;'>
                  <font color='white'><?php print translate("subs_Tanuland� nyelv") ?>*
                </td>
                <td>
                  <select name='nyelv' style='font-size:<?php print($SubscribeFontSize); ?>;'>
                    <?php
                    $langs = getLangTitles();
                    foreach ($langs as $value => $langTitle) {
                      if ($langTitle != 'angol' && $langTitle != 'spanyol')
                        continue;
                      if ($langTitle == 'angol') {
                        $sel = 'selected';
                      } else {
                        $sel = '';
                      }
                      print "<option value='{$value}' $sel>{$langTitle}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td align='right' style='font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><?php print translate("subs_SendMail") ?>:
              </td>
              <td><input type='checkbox' style='zoom:<?php print($SubscribeCheckBoxZoom); ?>;' name='send_mail' value="1" checked="checked"></td>
            </tr>
            <!--
<tr>
    <td align='right'><font size='3' color='white'><?php print translate("subs_El�fizet�si id�") ?>*: </td><td>
        <select name='subscribe_length'>
        <?php
        for ($i = 1; $i <= 12; $i++) {
          print "<option value='{$i}'>{$i}</option>";
        }
        ?>
        </select> <?php print translate("subs_h�nap") ?>
    </td>
</tr>
-->
            <tr>
              <td align='center' colspan='2' style='font-size:<?php print($SubscribeFontSize); ?>;'>
                <font color='white'><br><br><?php print translate("subs_text2") ?><br><br>
              </td>
            </tr>
            <tr>
              <td align='center' colspan='2'>
                <input type='button' style='padding-left:80px;padding-right:80px;padding-top:10px;padding-bottom:10px;font-size:<?php print($SubscribeFontSize); ?>;' value=<?php print "'" . translate("subs_Elk�ld") . "'" ?> onclick="
    with(document.forms[0]){
        actionType.value = 'subscribe';
        submit();
    }
 ">
              </td>
            </tr>

          </table>
        </FORM>
</BODY>

</HTML>