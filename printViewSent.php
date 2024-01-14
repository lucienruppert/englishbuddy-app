<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    
    if(!$_SESSION['userObject']){
        session_start();
    }
    include('functions.php');
    if(!$userObject && $_SESSION['userObject']){
        $userObject = $_SESSION['userObject'];
    }

    if(!$userObject){
        include_once('index.php');
        exit;
    }

    $ext = getLangExtByLangId($userObject['nyelv']);

    if((int)$_REQUEST['wordLevel'] > 0){
        $records = getWordsByWordLevel((int)$_REQUEST['wordLevel'], $ext);
        $levels = getLevelList($userObject['nyelv']);
        $levelTitle = $levels[(int)$_REQUEST['wordLevel']][0];
    }
    else{
        $records = getFirstNWordsByLevelGroupBy(100000, $_REQUEST['pkg'], $ext, $userObject, $_REQUEST['source']);
    }
    $wordsGroupBy = array();
//deb($records);
    foreach($records as $record){
        if(count($record) > 1){
            for($i = 1; $i < count($record); $i++){
                $record[0]['word_' . $ext] .= " / " . $record[$i]['word_' . $ext];
                $record[0]['pronunc_' . $ext] .= " / " . $record[$i]['pronunc_' . $ext];
                $record[0]['comment_' . $ext] .= " / " . $record[$i]['comment_' . $ext];
            }
        }
//print "lalala ";
//deb($record[0]);
        $wordsGroupBy[] = $record[0];
    }
    $words = $wordsGroupBy;

    if((int)$_REQUEST['wordLevel'] > 0){
        $pageTitle = $levelTitle;
    }
    else if($_REQUEST['pkg'] == 'mumus'){
        $pageTitle = 'Mumus';
    }
    else{
        $size = 10;
        if($_REQUEST['source'] == "szo"){
            $size = $GLOBALS['szoPackageSize'];
            $title = "Szavak";
        }
        else if($_REQUEST['source'] == "mondat"){
            $size = $GLOBALS['mondatPackageSize'];
            $title = "Mondatok";
        }
        $fromNum = ((int)substr($_REQUEST['pkg'], 10) - 1) * $size + 1;
        $text = $fromNum . " - " . ($fromNum + $size - 1);
        $pageTitle = "{$title} ({$text})";
    }

print "<html>
<head>
<title>Sentence print view</title>
<meta http-equiv=\"content-type\" content=\"text-html;\">
</head>";
print "<body>";
print "<table border=0 align='left' style='width:700'>
      <tr><td>&nbsp;</td><td align='right'><FONT size=4 face=Georgia>{$pageTitle}</td></tr>
      <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
      <tr><td width='200'>&nbsp;</td><td><table>";

$num = 1;
$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
for($i = 0; $i < count($words); $i++){
    print "<tr><td align=left><FONT size=3 face=Arial>" . ($num++) . ". " . $words[$i]['word_' . $forras_nyelv_ext] . "</td></tr>";
    if($words[$i]['pronunc_' . $ext]){
        $addedPronunc = " (" . $words[$i]['pronunc_' . $ext] . ")";
    }
    else{
        $addedPronunc = "";
    }
    print "<tr><td align=left>&nbsp;<span style='margin-left: 2em;'>" . $words[$i]['word_' . $ext] . $addedPronunc . "</span></td></tr>";
    if($i < count($words) - 1){
        print "<tr><td><p>&nbsp;</p></td></tr>";
        if($_REQUEST['source'] == 'mondat'){
            print "<tr><td><p>&nbsp;</p></td></tr>";
        }
    }
}
print "</table></td></tr></table>";
print "</form>";
print "</body>";
print "</html>";

?>