<?php
global $_SESSION;

if(!$userObject){
    include_once('index.php');
    exit;
}
$ext = getLangExtByLangId($userObject['nyelv']);
$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

if(!is_array($_SESSION['wordLearning_kikerdezo']) || $_REQUEST['source'] == 'welcome'){
    $_SESSION['wordLearning_kikerdezo'] = getNotOwnedWordIds();
}
if($_REQUEST['store'] == 1){
    $selectedId = $_REQUEST['selectedId'];
    $userId = (int)$userObject['id'];

    if(!storeUserWord($selectedId, $userId)){
        print "<script>alert('Rögzítés nem sikerült!')</script>";
    }
}

$wordCount = count($_SESSION['wordLearning_kikerdezo']);
$currentWordId = array_shift($_SESSION['wordLearning_kikerdezo']);
$currentWord = getWordById($currentWordId);


$isNeedAudioPart = ($ext == "angol");
$wordOrig = $currentWord['word_' . $forras_nyelv_ext];
$wordForeign = $currentWord['word_' . $ext];

if($isNeedAudioPart){
/*
    $audio_part = "<a href=\"http://szotar.sztaki.hu/pron/audict.php?L=ENG:HUN:EngHunDict&lang=en&word=" . urlencode($wordForeign) . "&accent=\" target='_blank'>
                                    <img src='images/speaker.jpg' alt='Pronunciation' height='15' width='15'>
                                </a>";
*/                                
}
?>
<div name='quickLearning' id='quickLearning'>
    <table border='0' width='800' cellspacing=0 cellpadding=0><tr><td width='50' align='left' valign='middle' style='background-color:grey;'>
        <tr>
            <td align='center' height='50' valign='center' style='width:100%;font-size:20pt;color:white;background-color:grey'>Szótárfeltöltés</td>
        </tr>
        <tr>
            <td align='center' valign='center' height='40' style='font-size:16pt;color:c8c8c8;background-color:;font-weight:bold;'><?php print $wordCount; ?></td>
        </tr>
        <tr>
            <td height='100' align='center' valign='top'><span id='origSpan' style=<?php print "'font-size:24pt;color:" . $globalcolor . ";font-weight:bold;'"; ?>><?php print $wordOrig; ?></span></td>
        </tr>
        <tr>
            <td height='50' align='center' valign='top'>
                <span style='font-size:18;' onclick="event.stopPropagation();"><u><?php print $wordForeign; ?></u><?php print $audio_part; ?></span>
            </td>
        </tr>
        <tr>
            <td align='center' valign='top' style='height:40px;' onclick="event.stopPropagation();">
                <a href='#' style=<?php print "'font-size:10pt;color:" . $globalcolor . ";font-weight:bold;'"; ?> onclick="event.stopPropagation();storeWord();">RÖGZÍTEM A SZÓTÁRAMBA</a>
            </td>
        </tr>
    </table>
</div>
<script>
function storeWord() {
    location.href='main.php?content=wordLearning_kikerdezo&store=1&selectedId=' + <?php print $currentWordId; ?>;
}

function doOnClickBody() {
    location.href='main.php?content=wordLearning_kikerdezo&inbetween=1';
}
document.onclick = doOnClickBody;

</script>
