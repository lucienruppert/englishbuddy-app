<?php
global $_SESSION;

if(!$userObject){
    include_once('index.php');
    exit;
}

$ext = getLangExtByLangId($userObject['nyelv']);
$forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

if(!is_array($_SESSION['wordCategorization']) || $_REQUEST['source'] == 'welcome'){
    $_SESSION['wordCategorization'] = getNotCategorizedWordIds();
}
if($_REQUEST['store'] == 1){
    $selectedId = $_REQUEST['selectedId'];
    $category = $_REQUEST['category'];

    if(!setWordCategory($selectedId, $category)){
        print "<script>alert('R�gz�t�s nem siker�lt!')</script>";
    }
}

$wordCount = count($_SESSION['wordCategorization']);
$currentWordId = array_shift($_SESSION['wordCategorization']);
$currentWord = getWordById($currentWordId);

$wordOrig = $currentWord['word_' . $forras_nyelv_ext];
$wordForeign = $currentWord['word_' . $ext];

?>

<style>
    .btnCategory{
        height: 100px;
        width: 200px;
    }
</style>

<div name='quickLearning' id='quickLearning'>
    <table border='0' width='800' cellspacing=0 cellpadding=0><tr><td width='50' align='left' valign='middle' style='background-color:grey;'>
        <tr>
            <td align='center' height='50' valign='center' style='width:100%;font-size:20pt;color:white;background-color:grey'>Kategoriz�l�s</td>
        </tr>
        <tr>
            <td align='center' valign='center' height='40' style='font-size:16pt;color:grey;font-weight:bold;'><?php print $wordCount; ?></td>
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
            <td align='center' valign='top' style='height:40px;white-space: nowrap;' onclick="event.stopPropagation();">
                <input type="button" style=<?php print "'background:" . $globalcolor . ";color:white;font-weight:plain;font-size:18px;border: 0px solid;cursor:pointer;'"; ?> class="btnCategory" value="alap" onclick="store(1)">&nbsp;
                <input type="button" style=<?php print "'background:" . $globalcolor . ";color:white;font-weight:plain;font-size:18px;border: 0px solid;cursor:pointer;'"; ?> class="btnCategory" value="v�laszt�kos" onclick="store(2)">&nbsp;
                <input type="button" style=<?php print "'background:" . $globalcolor . ";color:white;font-weight:plain;font-size:18px;border: 0px solid;cursor:pointer;'"; ?> class="btnCategory" value="ritka" onclick="store(3)">
            </td>
        </tr>
    </table>
</div>
<script>

function store(category){
    var selectedId = <?php print $currentWordId; ?>;
    location.href = 'main.php?content=wordCategorize&store=1&selectedId=' + selectedId + '&category=' + category;
}

function doOnClickBody() {
    location.href='main.php?content=wordCategorize&inbetween=1';
}
document.onclick = doOnClickBody;

</script>
