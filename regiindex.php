<?php
    session_start();
    include_once('functions_userObj.php');
    include_once('translations_HUN.php');
/*
    if(!$userObject){
        include_once('index.php');
        exit;
    }
*/
    require_once('functions_userObj.php');
    if($_POST['actionType'] == 'login'){
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.gc_maxlifetime', 60 * 60);
        session_start();
        session_register('userObject');
        if($GLOBALS['userObject'] = $userObject = getUserObj($_POST['email'], $_POST['username'])){
            if($userObject['status'] == 1){
                print "<script>alert('Elõfizetésed még nem került aktiválásra!');</script>";
            }
            else if($userObject['program_end_date'] >= date("Y-m-d 00:00:00")){
                $GLOBALS['welcomeText'] = true;
                $GLOBALS['userObject']['forras_nyelv'] = $_SESSION['userObject']['forras_nyelv'];
                include_once('functions.php');
                include_once('welcomePage.php');
                exit;
            }
            else{
                print "<script>alert('Elõfizetésed lejárt, kérjek lépj kapcsolatba a program üzemeltetõjével!');</script>";
            }
        }
        else{
            print "<script>alert('A megadott felhasználó nem létezik!');</script>";
        }
    }
    include_once('functions.php');

    $isAndroid = false;
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
        $isAndroid = true;
    }
    if($isAndroid){
        //$androidText = "EZ ANDROID!";
        $textboxFontStyle = 'font-size:50pt';
        $cellspacing = '30';
        $picSize = '300';
    }
    else{
        //$androidText = "EZ NEM ANDROID!";
        $textboxFontStyle = '';
        $cellspacing = '';
        $picSize = '100';
    }

    $dailyQuiz = getDailyQuiz();
?>

<HTML>
<HEAD><TITLE>Kikérdezõ.hu</TITLE>
	<link rel="shortcut icon" type="image/x-icon" href="/images/owl.ico">
<?php
        print "<meta http-equiv=\"content-type\" content=\"text-html; charset=$CHARSET\">";
        print "<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">";
?>

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <style>

    #fb{
           position:absolute;top:400px;left:50%;margin-left:-350px;}


    input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px white inset;
    }

    </style>


    <link rel=stylesheet type='text/css' href='baseStyle.css'>
    <script>
    $(document).ready(function (){
        $(username).keyup(function (e) {
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code==13)e.preventDefault();
            if(code==32||code==13||code==188||code==186){
                $(btnLogin).click();
            }
        });
    });
    </script>

</HEAD>
<BODY>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/hu_HU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

            <table border='0' align='center' cellspacing=<?php echo "\"{$cellspacing}\"" ?> cellpadding='0' width='50%' style='border:1px solid #D9D9D9'>
            <form action='index.php' method='POST'>
                 <tr>
                     <td align='left' valign='top'>
                         <input style='font-size:15pt;border:1px solid #D9D9D9;' type='text' name='email' value='' size=20 onclick="event.stopPropagation();clearit(this, 0);">
                     </td>

                     <td align='left' valign='top'>
                         <input style='font-size:15pt;border:1px solid #D9D9D9;' type='password' name='username' id='username' size=20 value=''>
                     </td>

                     <td valign='center'>
                         <input type='hidden' name='actionType' value='login'>
                         <input style='display:none' type='submit'>
                         <a href='#' style='font-size:12pt;' id='btnLogin' onclick='document.forms[0].submit()'>Belépés</a>
                     </td>

               </tr>

            </form>
            </table>



<table align='center' cellpadding='10'>
    <tr>
        <td>
               <tr>
                                        <td align='left' valign='top'>
                        <a href='https://www.facebook.com/Kikerdezo' target='_blank'><img height='22' border="0" width='20' src='images/fb.jpg' style='cursor:pointer'></img></a>
                    </td>
                </tr>
</table>

       <td width='20'></td>
      <!-- ////////////////AJAX --->
        <td valign='top'>
          <table align='center' valign='top' border='0' cellpadding='5' width=<?php echo "\"{$menuWidth}\"" ?>  style='border:1px solid #D9D9D9;' height='260'>
          <tr><td style='font-size:16pt;' align='center' valign='top' height='40'><b><font color=<?php print "'" . $globalcolor . "'"; ?>><u>SZÓTÁR</u></td></tr>
          <tr><td style='font-size:16pt;' align='left' valign='top'><font size=2><?php print getAllWordCount(); ?> szó, kifejezés és mondat</td></tr>
          <tr><td></td></tr>
          </table>
        </td>

</BODY>
</HTML>

<style>
KIKÉRDEZÕ: a leghasználhatóbb magyar szótár és nyelvtanító program

