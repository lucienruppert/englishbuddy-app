<?php
include_once('topPHP.php');
?>

<HTML>

<HEAD>
    <META HTTP-EQUIV='CHARSET' CONTENT='text/html; charset=ISO-8859-2'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="/images/white.ico">
    <TITLE>EnglishBuddy</TITLE>
    <link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <?php
    include_once('script.php');
    include_once('style.php');
    include_once('style-navigation.php');
    ?>
</HEAD>

<BODY style='margin:0px;'>

    <?php
    include_once('ifElse.php');
    // include_once('ajaxDiv.php');
    include_once('mainDiv.php');
    ?>

    <?
    if ($_GET['go'] != "") {
        printf("<script>$('#%s').goTo();</script>", $_GET['go']);
    }
    ?>

    <?php
    include_once('wordPracticeDiv.php');
    include_once('vocabularyDiv.php');
    include_once('sentencePracticeDiv.php');
    include_once('knowledgeBaseDiv.php');
    include_once('sentencePracticeDiv2.php');
    ?>

    <!-- Ez itt kell, hogy a tanul�szoba m�k�dj�n! -->
    <form name='submitForm' id='submitForm' action='main.php' method='post'>
        <input type='hidden' name='firstVisit' value='1'>
        <input type='hidden' name='content' value=''>
    </form>
    <!-- !!! -->


</BODY>

</HTML>

<?php
function printCellBlocks($cellBlocks, $blockNr)
{
    $sepNr = (int)(count($cellBlocks) / $blockNr);
    if ((count($cellBlocks) % $blockNr) > 0) {
        $sepNr++;
    }
    for ($i = 0; $i < $sepNr; $i++) {
        print "<tr>";
        for ($j = 0; $j < $blockNr; $j++) {
            print $cellBlocks[$i + $j * $sepNr];
        }
        print "</tr>";
    }
}
?>