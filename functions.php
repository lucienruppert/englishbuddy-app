<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);

define("LOG", "1");
//define("DEBUG", "1");

function getLangArray()
{
    // a sorrend az, amilyen sorrendben a lucien v�ltja a nyelveket a f�oldalon
    $langArray = array(
        1 => 'angol',
        2 => 'spanyol',
        4 => 'nemet',
        5 => 'francia',
        3 => 'arab',
        0 => 'hun'
    );
    return $langArray;
}

include_once('functions_userObj.php');
include_once('functions_levels.php');

ini_set('memory_limit', '1024M');
$ext = "";
$GLOBALS['szoPackageSize'] = 10;
$GLOBALS['szoPackageRecordMpLimit'] = 20;
$GLOBALS['szoPackageRecordBg'] = 'grey';

$GLOBALS['mondatPackageSize'] = 10;
$GLOBALS['mondatPackageRecordMpLimit'] = 100;
$GLOBALS['mondatPackageRecordBg'] = 'grey';

$dark = "#031525"; // dark blue
$highlight = "#e97816"; // orange

$tdValue = "background-color:#031525";
$colorValue = "#293d55"; // medium blue
$GLOBALS['TDBgGlobalColor'] = $tdValue;
$GLOBALS['globalcolor'] = $colorValue;

include("functions_translation.php");

$isAndroid = false;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (stripos($ua, 'android') !== false) { // && stripos($ua,'mobile') !== false) {
    $isAndroid = true;
}

$ButtonFontSize = '10pt';
$cellpadding = '10';
$columnNumber = '1';
$columnNumberWords = '1';
$datadivPosition = 'top:310px';
$generalfontColor = 'grey';
$email_password_title_Size = '12px';
$FlagHeight = '20';
$FlagWidth = '40';
$HelloFontSize = '26px';
$knowledgeBaseDivFontSize = 'font-size:14;height:50px;';
$knowledgeBaseDivHeight = 'width:400px;height:400px;overflow:auto;';
$knowledgeBaseDivPosition = 'width:400px;background-color:white;position:absolute;top:80px;left:50%;margin-left:-200px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;';
$knowledgeBaseDivInnerWidth = '370px';
$lcasa_font_title = '60px';
$lcasa_font_subtitle = '20pt';
$lcasa_column1 = '500';
$lcasa_column_percent = '27.7%';
$lcasa_font_text = '18px';
$logosize1 = '40pt';
$logosize2 = '10pt';
$menuFontSize = 'font-size:10pt;color:grey;font-weight:plain;';
$menuWidth = '180';
$menuHeight = '50';
$menuTablecellspacing = '0px';
$menuPosition = 'top:140px';
$MiddlePadding = '20px';
$picWidth = '60px';
$Padding = '5px';
$RedMenuStyle = 'background-color:white;font-size:12pt;';
$RedMenuStyle2 = 'background-color:white;font-size:12pt;';
$bottomPadding = '20px';
$titleFont = 'font-size:12pt;';
$TopRedHeight = '155px';
$worddivFontSize = 'font-size:14';
$worddivSize = 'width:400px;height:445px;overflow:auto;';
$worddivPosition = 'background-color:white;position:absolute;top:-100px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;';
$xSize = 'font-size:17;font-weight:bold;color:white';
$xWidth = '20';
$SubscribeFontSize = '16px';
$SubscribeCheckBoxZoom = '1';

function DEBUG($variable)
{
    print_r("<pre>");
    print_r($variable);
    print_r("</pre>");
}

// debug  function
function mylog($text, $level = 'i', $file = 'logs')
{
    switch (strtolower($level)) {
        case 'e':
        case 'error':
            $level = 'ERROR';
            break;
        case 'i':
        case 'info':
            $level = 'INFO';
            break;
        case 'd':
        case 'debug':
            $level = 'DEBUG';
            break;
        default:
            $level = 'INFO';
    }
    if (defined("LOG")) {
        error_log(date("[Y-m-d H:i:s]") . "\t[" . $level . "]\t[" . basename(__FILE__) . "]\t" . $text . "\n", 3, $file);
    }
}

function getWords($number = 10, $level = 1, $exceptionArray = array())
{
    if (!$level) {
        $level = 1;
    }
    $wordsRecordArray = getAllWordsByLevel($level, $exceptionArray);

    if (!$number) {
        $number = 1;
    }
    if (count($wordsRecordArray) < $number) {
        $number = count($wordsRecordArray);
    }
    $returnWordsArray = array();
    for ($i = 1; $i <= $number; $i++) {
        $genNumber = mt_rand(0, count($wordsRecordArray) - 1);
        $returnWordsArray[] = $wordsRecordArray[$genNumber];
        $wordsRecordArray = array_merge(array_slice($wordsRecordArray, 0, $genNumber), array_slice($wordsRecordArray, $genNumber + 1));
    }
    return $returnWordsArray;
}

function getFirstNWordsByLevel($topN, $actLevel, $langExt)
{
    $levels = array();
    if ($actLevel == 'list1' || $actLevel == 'list2') {
        $list = getLevelList($langExt);
        foreach ($list as $key => $value) {
            if ($key > 0 && ($actLevel == 'list1' && $value[1] == 1
                || $actLevel == 'list2' && $value[1] == 2)) {
                $levels[] = $key;
            }
        }
        $where_level = "level_{$langExt} in (" . implode(", ", $levels) . ")";
    } else if (startsWith($actLevel, 'listFract_') || $actLevel == 'listAll') {
        $list = getLevelList($langExt);
        foreach ($list as $key => $value) {
            if ($key > 0 && $value[1] == 1) {
                $levels[] = $key;
            }
        }
        $where_level = "level_{$langExt} in (" . implode(", ", $levels) . ")";
    } else {
        $where_level = "level_{$langExt} = $actLevel";
    }

    $query = "SELECT *, level_{$langExt} as level from words where $where_level and word_{$langExt} is not null and word_{$langExt} != '' order by rand() limit $topN";

    if (startsWith($actLevel, 'listFract_')) {
        $toNum = (int)substr($actLevel, 10) * 20;
        $query = "SELECT *, level_{$langExt} as level from words where word_{$langExt} is not null and word_{$langExt} != '' and {$where_level} order by id limit {$toNum}";
    } else if ($actLevel == 'listAll') {
        $query = "SELECT *, level_{$langExt} as level from words where word_{$langExt} is not null and word_{$langExt} != '' and {$where_level} order by id";
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    while ($row = mysql_fetch_assoc($result)) {
        $records[] = $row;
    }
    if (startsWith($actLevel, 'listFract_')) {
        $records = array_slice($records, -20);
        shuffle($records);
    } else if ($actLevel == 'listAll') {
        shuffle($records);
    }
    return $records;
}

function setWordRecordIf($userObject, $tipus, $package, $seconds)
{
    $query = "select count(*) from word_records where user_id = {$userObject['id']} and tipus = {$tipus} and package_number = " . (int)$package;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    list($count) = mysql_fetch_row($result);

    if ($count > 0) {
        $query = "update word_records set best_time = {$seconds} where user_id = {$userObject['id']} and tipus = {$tipus} and package_number = {$package} and best_time > {$seconds}";
    } else {
        $query = "insert into word_records (user_id, tipus, package_number, best_time) values({$userObject['id']}, {$tipus}, {$package}, {$seconds})";
    }
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
}

function getPackageRecords($userObject, $tipus)
{
    $query = "select * from word_records where user_id = {$userObject['id']} and tipus = {$tipus}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        $records[$row['package_number']] = $row;
    }
    return $records;
}

function getFirstNWordsByLevelGroupBy($topN, $actLevel, $langExt, $userObject, $source)
{
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $accessableLevels = (array)$_SESSION["AccessableTananyagLevels"];
    $levels = array();
    $szoLevels = array();
    $mondatLevels = array();

    if ($actLevel == 'list1' || $actLevel == 'list2') {
        $list = getLevelList($langExt);
        foreach ($list as $key => $value) {
            if ($key > 0 && ($actLevel == 'list1' && $value[1] == 1
                || $actLevel == 'list2' && $value[1] == 2)) {
                $levels[] = $key;
            }
        }
        $where_level = "w.level_{$langExt} in (" . implode(", ", $levels) . ")";
    } else if (startsWith($actLevel, 'listFract_') || $actLevel == 'listAll' || $actLevel == 'mumus' || $actLevel == 'tananyagAll') {
        $list = getLevelList($langExt);
        foreach ($list as $key => $value) {
            if (
                $key > 0
                && ($source == 'szo' && $value[1] == 1
                    || $source == 'mondat' && $value[1] == 2
                    || $source == 'szomondat' && ($value[1] == 1 || $value[1] == 2))
                || $source == 'tananyag' && $value[1] == 2
                || $source == 'alapSzo' && $value[1] == 1
            ) {
                $levels[] = $key;
                if ($value[1] == 1) {
                    $szoLevels[] = $key;
                } else if ($value[1] == 2) {
                    $mondatLevels[] = $key;
                }
            }
        }
        if ($actLevel != 'tananyagAll') {
            $left_join = "left outer join user_words u on w.id = u.word_id and u.user_id = {$userObject['id']}";
            $where_level = "w.level_{$langExt} in (" . implode(", ", $levels) . ") and (w.user_id = {$userObject['id']} or u.id is not null)";
        } else {
            $levels = array_intersect($levels, $accessableLevels);
            $levels[] = -1;
            $where_level = "w.level_{$langExt} in (" . implode(", ", $levels) . ")";
        }
    } else {
        $where_level = "w.level_{$langExt} = $actLevel";
    }

    $query = "SELECT w.*, level_{$langExt} as level
                from words w
                $left_join
                where $where_level
                and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                order by rand() limit $topN";

    if (startsWith($actLevel, 'listFract_') || $actLevel == 'listAll' || $actLevel == 'mumus' || $actLevel == 'tananyagAll') {
        if (startsWith($actLevel, 'listFract_')) {
            $mult = ($source == 'szo' || $source == 'alapSzo' ? $GLOBALS['szoPackageSize'] : $GLOBALS['mondatPackageSize']);
            $fromNum = ((int)substr($actLevel, 10) - 1) * $mult;

            if ($source == 'alapSzo') {
                $query = "SELECT w.*, w.level_{$langExt} as level
                    from words w
                    where w.category = 1 and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    and w.level_{$langExt} in (" . implode(",", $szoLevels) . ")
                    and w.level_{$langExt} != 0
                    order by w.crdti, w.id limit {$fromNum}, {$mult}";
            } else {
                $query = "SELECT distinct w.word_{$forras_nyelv_ext}
                    from words w
                    $left_join
                    where (w.user_id = {$userObject['id']} or u.id is not null)
                    and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    and {$where_level}
                    order by coalesce(u.crdti, w.crdti), w.id limit {$fromNum}, {$mult}";
            }
        } else if ($actLevel == 'listAll') {
            $query = "SELECT distinct w.word_{$forras_nyelv_ext}
                from words w
                $left_join
                where (w.user_id = {$userObject['id']} or u.id is not null)
                and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                and {$where_level}
                order by rand() limit 300";
        } else if ($actLevel == 'mumus') {
            $query = "SELECT distinct w.word_{$forras_nyelv_ext}
                from words w
                $left_join
                where (w.user_id = {$userObject['id']} and w.is_marked = 1 or u.id is not null and u.is_marked = 1)
                and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                and {$where_level}
                order by coalesce(u.crdti, w.crdti), w.id";
        } else if ($actLevel == 'tananyagAll') {
            $query = "SELECT distinct w.word_{$forras_nyelv_ext}
                from words w
                where w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                and {$where_level}";
        }

        if ($actLevel == 'tananyagAll') {
            $query = "SELECT *, level_{$langExt} as level
                    from words w
                    where w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    and {$where_level}";
        } else if ($source != 'alapSzo') {
            $result = mysql_query($query);
            if (!$result) {
                print mysql_error();
                exit("Nem siker�lt: " . $query);
            }
            $_words = array();
            while ($row = mysql_fetch_row($result)) {
                $_words[] = str_replace("'", "''", $row[0]);
            }
            $query = "SELECT *, level_{$langExt} as level
                    from words w
                    where w.word_{$forras_nyelv_ext} in ('" . implode("', '", $_words) . "')";
        }
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        if ($row["word_{$langExt}"] != '' && $row["word_{$langExt}"] != '...' && $row["word_{$forras_nyelv_ext}"] != '' && $row["word_{$forras_nyelv_ext}"] != '...') {
            if ($source == 'alapSzo') {
                $records[] = $row;
            } else {
                $records[$row["word_{$forras_nyelv_ext}"]][] = $row;
            }
        }
    }
    if (startsWith($actLevel, 'listFract_') || $actLevel == 'listAll' || $actLevel == 'mumus' || $actLevel == 'tananyagAll') {
        if ($source == 'szomondat') {
            $szoArray = array();
            $mondatArray = array();
            foreach ($records as $record) {
                foreach ($record as $_record) {
                    if (in_array($_record['level'], $szoLevels)) {
                        array_push($szoArray, $_record);
                    } else if (in_array($_record['level'], $mondatLevels)) {
                        array_push($mondatArray, $_record);
                    }
                }
            }
            shuffle($szoArray);
            shuffle($mondatArray);
            $records = array();
            while (true) {
                $szo = array_pop($szoArray);
                if ($szo != null) {
                    $records[$szo["word_{$forras_nyelv_ext}"]][] = $szo;
                }
                $mondat = array_pop($mondatArray);
                if ($mondat != null) {
                    $records[$mondat["word_{$forras_nyelv_ext}"]][] = $mondat;
                }
                if ($szo == null && $mondat == null) {
                    break;
                }
            }
        } else {
            shuffle($records);
        }
    }
    return $records;
}

function getIntelligentFilteredWords($txt)
{
    if (!$txt) {
        return array();
    }
    $langExt = getLangExtByLangId($GLOBALS['userObject']['nyelv']);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $langArray = getLangArray();

    $txt = aposztrofRepToDb(mb_strtolower($txt, "iso-8859-1"));
    $txt = str_replace(chr(195) . chr(177), '&#241;', $txt);
    $spec_chars = "([/ ?,!.%])";
    //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $query = "select w.*, level_{$langExt} as level, level_{$forras_nyelv_ext} as forras_level
                from words w
                left outer join lmjelentkezok l on w.user_id = l.id
                where (
                        trim(lower(w.word_{$forras_nyelv_ext})) = '{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) = '&#191;{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^&#191;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#191;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#191;{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) = '&#161;{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^&#161;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#161;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#161;{$spec_chars}{$txt}{$spec_chars}'

                        or trim(lower(w.word_{$langExt})) = '{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) = '&#191;{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^&#191;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '&#191;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '&#191;{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) = '&#161;{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^&#161;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '&#161;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '&#161;{$spec_chars}{$txt}{$spec_chars}'
                    )
                    and (w.word_{$langExt} is not null and w.word_{$forras_nyelv_ext} is not null)
                    and trim(w.word_{$langExt}) != '' and trim(w.word_{$forras_nyelv_ext}) != ''
                    and trim(w.word_{$langExt}) != '...' and trim(w.word_{$forras_nyelv_ext}) != '...'
                order by rand()";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $list = getLevelList($GLOBALS['userObject']['nyelv']);
    $forras_list = getLevelList($GLOBALS['userObject']['forras_nyelv']);
    $records = array();
    $cnt = 0;
    while ($row = mysql_fetch_assoc($result)) {
        if ($list[$row['level']][1] == 2 || $forras_list[$row['forras_level']][1] == 2) {
            $records[] = $row;
            $cnt++;
            if ($cnt >= 300)
                break;
        }
    }
    return $records;
}

function getLastFiveUpdatedWords($date)
{
    //$query = "SELECT w.word_angol,w.word_hun FROM `words` w WHERE w.id IN (select id from `WordsUpdate` WHERE Modified>='".$date."')";
    $query = "SELECT w.word_angol,w.word_hun,wup.Modified FROM `words` w,`WordsUpdate` wup WHERE w.id = wup.id AND w.level_angol <6 AND w.level_angol >0 order by wup.Modified desc limit 5";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    $i = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $records[$i] = $row;
        $i++;
    }
    return $records;
}

function getWordsByWordLevel($wordLevel, $langExt)
{
    $wordLevel = (int)$wordLevel;
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    $query = "SELECT w.*, level_{$langExt} as level
                from words w
                where w.level_{$langExt} = $wordLevel
                and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();

    while ($row = mysql_fetch_assoc($result)) {
        $records[$row["word_{$forras_nyelv_ext}"]][] = $row;
    }
    return $records;
}

function getNotOwnedWordIds()
{
    $userObject = $GLOBALS['userObject'];
    $forras_nyelv_ext = getLangExtByLangId($userObject['forras_nyelv']);
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $levels = array();

    $list = getLevelList($langExt);
    foreach ($list as $key => $value) {
        if ($key > 0 && ($value[1] == 1))
            $levels[] = $key;
    }
    $query = "SELECT distinct w.id
        from words w
        left outer join user_words u on w.id = u.word_id and u.user_id = {$userObject['id']}
        where (w.user_id <> {$userObject['id']} and u.id is null)
        and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
        and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
        and w.level_{$langExt} in (" . implode(", ", $levels) . ")
        order by rand()";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_row($result)) {
        $records[] = $row[0];
    }
    return $records;
}

function getNotCategorizedWordIds()
{
    $userObject = $GLOBALS['userObject'];
    $forras_nyelv_ext = getLangExtByLangId($userObject['forras_nyelv']);
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $levels = array();

    $list = getLevelList($langExt);
    foreach ($list as $key => $value) {
        if ($key > 0 && ($value[1] == 1))
            $levels[] = $key;
    }
    $query = "SELECT distinct w.id
        from words w
        where w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
        and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
        and w.level_{$langExt} in (" . implode(", ", $levels) . ")
        and w.category is null
        order by w.id";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_row($result)) {
        $records[] = $row[0];
    }
    return $records;
}

function getWordById($id)
{
    $query = "SELECT * from words where id = " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $record = null;
    while ($row = mysql_fetch_assoc($result)) {
        $record = $row;
    }
    return $record;
}

function getAllWordsWithLevelExceptions($levelExceptionArray, $orderLang, $lang, $isForEveryLang = false, $isFilled = false)
{
    $langExt = getLangExtByLangId($lang);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    if ($isForEveryLang) {
        $langArray = getLangArray();
        $wherePartArray = array();
        foreach ($langArray as $currentLang) {
            $wherePartArray[] = "level_{$currentLang} not in (" . implode(',', $levelExceptionArray) . ")";
        }
        $wherePart = '(' . implode(" or ", $wherePartArray) . ')';
    } else {
        $wherePart = "level_{$langExt} not in (" . implode(',', $levelExceptionArray) . ")";
    }
    if ($isFilled) {
        $wherePart .= " and word_{$langExt} is not null and word_{$langExt} != '' and word_{$langExt} != '...'
                and word_{$forras_nyelv_ext} is not null and word_{$forras_nyelv_ext} != '' and word_{$forras_nyelv_ext} != '...'";
    }
    $levelExceptionArray[] = -1;
    $query = "SELECT id, word_{$forras_nyelv_ext}, word_{$langExt} as word_foreign, pronunc_{$langExt} as pronunc_foreign, comment_{$langExt} as comment_foreign, level_{$langExt} as level, user_id,
                    level_hun, level_angol, level_spanyol, level_nemet, level_francia, level_arab
                from words
                where {$wherePart}
                order by ";
    if ($orderLang == 'foreign') {
        $query .= "word_{$langExt}";
    } else {
        $query .= "word_{$forras_nyelv_ext}";
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        $records[] = $row;
    }
    return $records;
}

function getAllWordsWithLevel($levelArray, $orderLang, $lang)
{
    $langExt = getLangExtByLangId($lang);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    $levelArray[] = -1;
    $query = "SELECT id, word_{$forras_nyelv_ext}, word_{$langExt} as word_foreign, level_{$langExt} as level, user_id from words where level_{$langExt} in (" . implode(',', $levelArray) . ") and level_{$langExt} != 0 order by ";
    if ($orderLang == 'foreign') {
        $query .= "word_{$langExt}";
    } else {
        $query .= "word_{$forras_nyelv_ext}";
    }
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        $records[] = $row;
    }
    return $records;
}

function getFirstNWordsForMultiplePractice($topN, $actLevelArray, $langExt)
{
    if (!is_array($actLevelArray) || count($actLevelArray) == 0) {
        return [];
    }
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $accessableLevels = (array)$_SESSION["AccessableTananyagLevels"];
    $levels = array();
    $szoLevels = array();
    $mondatLevels = array();

    $records = array();
    foreach ($actLevelArray as $actLevel) {
        $query = "SELECT w.*, level_{$langExt} as level
                    from words w
                    where w.level_{$langExt} = $actLevel
                    and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    order by rand() limit $topN";

        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $query);
        }
        while ($row = mysql_fetch_assoc($result)) {
            if ($row["word_{$langExt}"] != '' && $row["word_{$langExt}"] != '...' && $row["word_{$forras_nyelv_ext}"] != '' && $row["word_{$forras_nyelv_ext}"] != '...') {
                $records[$row["word_{$forras_nyelv_ext}"]][] = $row;
            }
        }
    }
    shuffle($records);

    return $records;
}

function getHomeWorks($userObject, $user_id, $homeWorkOrder)
{
    $recordNum = 60;
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    if ($homeWorkOrder) {
        $ascDesc = "desc";
    } else {
        $ascDesc = "asc";
    }

    if ($userObject['status'] == 6 || $user_id > 0) {
        $where = "level_{$langExt} = 0";

        if ($user_id > 0) {
            $where .= " and user_id = " . (int)$user_id;
        }

        $query = "SELECT id, word_{$forras_nyelv_ext}, comment_{$forras_nyelv_ext}, word_{$langExt} as word_foreign, pronunc_{$langExt} as pronunc_foreign, comment_{$langExt} as comment_foreign, level_{$langExt} as level, user_id
                    from words
                    where {$where}
                    order by id $ascDesc limit $recordNum";
    }
    // ilyenkor nincs ki v�lasztva user, csak a saj�t tan�tv�nyai h�zijait l�thatja
    else if (in_array($userObject['status'], array(4, 5))) {
        $query = "SELECT w.id, w.word_{$forras_nyelv_ext}, w.comment_{$forras_nyelv_ext}, w.word_{$langExt} as word_foreign, w.pronunc_{$langExt} as pronunc_foreign, w.comment_{$langExt} as comment_foreign, w.level_{$langExt} as level, w.user_id
                    from words w
                    inner join lmjelentkezok l on w.user_id = l.id and l.tanar_id = {$userObject['id']}
                    where w.level_{$langExt} = 0
                    order by id $ascDesc limit $recordNum";
    } else {
        $query = "SELECT id, word_{$forras_nyelv_ext}, comment_{$forras_nyelv_ext}, word_{$langExt} as word_foreign, pronunc_{$langExt} as pronunc_foreign, comment_{$langExt} as comment_foreign, level_{$langExt} as level, user_id
                    from words
                    where level_{$langExt} = 0 and user_id = {$userObject['id']}
                    order by id $ascDesc limit $recordNum";
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        $records[] = $row;
    }
    return $records;
}


function getWordUsers($userObject)
{
    $langExt = getLangExtByLangId($userObject['nyelv']);

    $query = "SELECT l.id as user_id, count(*) as num, min(l.vezeteknev) as vezeteknev, min(l.keresztnev) as keresztnev, min(l.nyelv) as nyelv, min(w.id) as w_id, min(l.status) as status
                from lmjelentkezok l
                left outer join words w on w.user_id = l.id
                    and w.level_{$langExt} = 0
                    and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                group by l.id
                order by vezeteknev, keresztnev";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        if (is_null($row['w_id'])) {
            $row['num'] = 0;
        }
        $records[] = $row;
    }
    return $records;
}

function getAllWordsByLevel($level, $exceptionArray)
{
    $forrasLangExt = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $targetLangExt = getLangExtByLangId($GLOBALS['userObject']['nyelv']);
    $exceptionArray[] = 0;
    $exceptionString = implode(",", $exceptionArray);
    $query = "SELECT *, level_{$targetLangExt} as level from words where level_{$targetLangExt} = $level and id not in ($exceptionString) and word_{$forrasLangExt} != '...' and word_{$forrasLangExt} != '' and word_{$targetLangExt} != '...' and word_{$targetLangExt} != ''";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    while ($row = mysql_fetch_assoc($result)) {
        $records[] = $row;
    }
    return $records;
}

function setHit($id)
{
    $query = "update words set hits = hits + 1 where id = " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    } else {
        print "<script>parent.frames[0].location.href = parent.frames[0].location.href;</script>";
    }


    $date = new DateTime();
    $timestamp = $date->format('Y-m-d H:i:s');
    $query = "update WordsUpdate set Modified = '$timestamp' where id = " . (int)$id;
    mysql_query($query);
}

function getAllTheHits()
{
    $query = "SELECT sum(hits) as allhits from words";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $records = array();
    $count = 0;
    while ($row = mysql_fetch_row($result)) {
        $count = $row[0];
    }
    return $count;
}

function getGeneratedWordList($levelTypeArray)
{
    $resultArray = array();
    for ($i = 0; $i < count($levelTypeArray); $i++) {
        $actLevel = $levelTypeArray[$i];
        $resultArray = array_merge($resultArray, getFirstNWordsByLevel(1, $actLevel));
    }
    return $resultArray;
}

function getIgeragozasTable()
{
    return "<table border=1>
            <tr>
                <th>&nbsp;</th><th>JELEN</th><th>M�LT</th><th>BIRT.NVM</th><th>'ENGEM'</th><th>'T�LEM'</th><th>L�TIGE M�LT</th><th>&nbsp;</th><th>&nbsp;</th>
            </tr>
            <tr>
                <td><b>ANA</b></td><td>E/A/U+</td><td>+ET</td><td>(T)+I</td><td>BI</td><td>MINNI</td><td>KONT</td><td>ez (f)</td><td>HADA</td>
            </tr>
            <tr>
                <td><b>ENTA</b></td><td>T+</td><td>+TA</td><td>(T)+EK</td><td>BIK</td><td>MINNEK</td><td>KONTA</td><td>ez (n)</td><td>HAZIHI</td>
            </tr>
            <tr>
                <td><b>ENTI</b></td><td>T+I</td><td>+TI</td><td>(T)+UKI</td><td>BIKI</td><td>MINNUKI</td><td>KONTI</td><td>az (f)</td><td>HADAK</td>
            </tr>
            <tr>
                <td><b>HUA</b></td><td>J+</td><td>-</td><td>(T)+HU</td><td>BIHU</td><td>MINNO</td><td>KAN</td><td>az (n)</td><td>HADIK</td>
            </tr>
            <tr>
                <td><b>HIJE</b></td><td>T+</td><td>+T</td><td>(T)+HA</td><td>BIHA</td><td>MINHA</td><td>KANET</td><td>azok (f)</td><td>hadol</td>
            </tr>
            <tr>
                <td><b>NEHNA</b></td><td>N+</td><td>+NA</td><td>(T)+NA</td><td>BINA</td><td>MINNA</td><td>KONNA</td><td>azok (n)</td><td>hadole</td>
            </tr>
            <tr>
                <td><b>ENTOM</b></td><td>T+U</td><td>+TOM</td><td>(T)+KOM</td><td>BIKOM</td><td>MINKOM</td><td>KONTOM</td><td>itt</td><td>hon</td>
            </tr>
            <tr>
                <td><b>HOM</b></td><td>J+U</td><td>+U</td><td>(T)+HOM</td><td>BIHOM</td><td>MINHOM</td><td>KANU</td><td>ott</td><td>hunig</td>
            </tr>
        </table><p>&nbsp;";
}

function getWordCount()
{
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $query = "SELECT count(*) from words where level_{$langExt} not in (8)";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_row($result)) {
        $number = $row[0];
    }
    return $number;
}

function getAllWordCount()
{
    $query = "SELECT count(*) from words";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_row($result)) {
        $number = $row[0];
    }
    return $number;
}

function getAllSentenceCount()
{
    $query = "SELECT count(*) from words WHERE `category` = 2";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_row($result)) {
        $number = $row[0];
    }
    return $number;
}
function checkWord($id, $hunWord, $nyelv, $foreignWord)
{
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    $hunWord = aposztrofRepToDb($hunWord);
    $foreignWord = aposztrofRepToDb($foreignWord);
    $foreignPron = aposztrofRepToDb($foreignPron);
    $foreignComm = aposztrofRepToDb($foreignComm);

    $ext = getLangExtByLangId($nyelv);

    $levelList = getLevelList($nyelv);
    $levels = array(-1);
    foreach ($levelList as $key => $value) {
        if ($key > 0 && $value[1] == 1) {
            $levels[] = $key;
        }
    }
    $where_level = "level_{$ext} in (" . implode(", ", $levels) . ")";
    $query = "select count(*) from words where word_{$forras_nyelv_ext} = '$hunWord' and word_{$ext} = '{$foreignWord}' and {$where_level} and id != " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    list($letezik) = mysql_fetch_row($result);

    return $letezik;
}

function storeWord($id, $hunWord, $nyelv, $foreignWord, $foreignComm, $sourceComm, $level, $userId, $category, $forceChangeUserId = false)
{
    mylog("storeWord: id:" . $id . " hunWord:" . $hunWord . " nyelv:" . $nyelv . " foreignWord:" . $foreignWord . " foreignComm:" . $foreignComm . " sourceComm:" . $sourceComm . " level" . $level . " userId" . $userId . " category" . $category . " forceChangeUserId" . $forceChangeUserId, "d");
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    $hunWord = str_replace("&#241;", "n", str_replace("&#369;", "�", str_replace("&#337;", "�", aposztrofRepToDb(rtrim($hunWord)))));
    $foreignWord = aposztrofRepToDb(rtrim($foreignWord));
    $foreignComm = aposztrofRepToDb($foreignComm);
    $sourceComm = aposztrofRepToDb($sourceComm);

    $ext = getLangExtByLangId($nyelv);

    $date = new DateTime();
    $timestamp = $date->format('Y-m-d H:i:s');

    $category = (int)$category;
    if ($category == 0) {
        $category = 'null';
    }

    // �j rekordk�nt kezelj�k
    if ($id == 0) {
        $query = "select count(*) from words where word_{$forras_nyelv_ext} = '$hunWord' and level_{$ext} = " . (int)$level . " and (word_{$ext} = '{$foreignWord}' or word_{$ext} = null or word_{$ext} = '' or word_{$ext} = '...')";
        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            return false;
        }
        list($letezik) = mysql_fetch_row($result);
        if ($letezik) {
            if ($forceChangeUserId) {
                $addPart = ", level_{$ext} = {$level}, user_id = " . (int)$userId . ", crdti = NOW()";
            }
            $query = "update words set word_{$ext} = '$foreignWord', comment_{$ext} = '$foreignComm', comment_{$forras_nyelv_ext} = '$sourceComm', category = $category $addPart where word_{$forras_nyelv_ext} = '$hunWord' and level_{$ext} = " . (int)$level . " and (word_{$ext} = null or word_{$ext} = '' or word_{$ext} = '...')";
        } else {
            $langArray = getLangArray();
            $fields = array();
            $values = array();
            foreach ($langArray as $currentLang) {
                if ($currentLang != $forras_nyelv_ext and $currentLang != $ext) {
                    $fields[] = "word_" . $currentLang;
                    $values[] = "'...'";
                }
            }
            $query = "insert into words (word_{$forras_nyelv_ext}, word_{$ext}, " . implode(", ", $fields) . ", comment_{$ext}, comment_{$forras_nyelv_ext}, level_{$ext}, category, user_id) values('$hunWord', '$foreignWord', " . implode(", ", $values) . ", '$foreignComm', '$sourceComm', " . (int)$level . ", $category, " . (int)$userId . ")";
        }
    }
    // update
    else {
        if ($forceChangeUserId) {
            $addPart = ", user_id = " . (int)$userId . ", crdti = NOW()";
        }
        $query = "update words set word_{$forras_nyelv_ext} = '$hunWord', word_{$ext} = '$foreignWord', comment_{$ext} = '$foreignComm', comment_{$forras_nyelv_ext} = '$sourceComm', level_{$ext} = $level, category = $category $addPart where id = " . (int)$id;
    }
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }


    if ($id == 0) {
        $lastID = mysql_insert_id();
        if ($lastID > 0) {
            $query = "INSERT INTO `WordsUpdate` (`id`, `Deleted`)VALUES (" . (int)$lastID . ",false) ON DUPLICATE KEY UPDATE id = " . (int)$lastID;

            //$query = "insert into WordsUpdate(id,Deleted) values(".(int)$lastID.",false)";
            mysql_query($query);
        }
    } else {
        $query = "INSERT INTO `WordsUpdate` (`id`, `Deleted`)VALUES (" . (int)$id . ",false) ON DUPLICATE KEY UPDATE id = " . (int)$id;
        //$query = "update WordsUpdate set Modified = '$timestamp' where id = " . (int)$id;
        mysql_query($query);
    }


    return true;
}

function storeUserWord($wordId, $userId)
{
    $query = "insert into user_words (user_id, word_id) values(" . (int)$userId . ", " . (int)$wordId . ")";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}

function deleteWord($id, $nyelv, $forras_nyelv, $isCheckNeed)
{
    if ($isCheckNeed) {
        $langArray = getLangArray();
        $ext = array();
        foreach ($langArray as $key => $value) {
            if ($key != $nyelv && $key != $forras_nyelv) {
                $ext[] = "word_{$value} is not null and word_{$value} != '' and word_{$value} != '...'";
            }
        }

        $query = "select count(*) from words where id = " . (int)$id . " and (" . implode(' or ', $ext) . ")";

        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            return -1;
        }
        list($nemtorlendo) = mysql_fetch_row($result);

        if ($nemtorlendo) {
            return 0;
        }
    }
    $query = "delete from words where id = " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return -1;
    }

    $date = new DateTime();
    $timestamp = $date->format('Y-m-d H:i:s');
    $query = "update WordsUpdate set Modified = '$timestamp', Deleted = true where id = " . (int)$id;
    //$query = "delete from WordsUpdate where id = " . (int)$id;
    mysql_query($query);


    return 1;
}

function setWordCategory($wordId, $category)
{
    $query = "update words set category = " . (int)$category . " where id = " . (int)$wordId;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}


function getWord($id, $lang)
{
    $langExt = getLangExtByLangId($lang);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);

    $query = "select id, word_{$forras_nyelv_ext}, comment_{$forras_nyelv_ext}, word_{$langExt} as word_foreign, pronunc_{$langExt} as pronunc_foreign, comment_{$langExt} as comment_foreign, level_{$langExt} as level, category from words where id = " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $row = mysql_fetch_assoc($result);
    return $row;
}

function getWordsByHun($userObject, $txt, $lang)
{
    $langExt = getLangExtByLangId($lang);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $langArray = getLangArray();
    $otherLangsExt = array();
    foreach ($langArray as $currentLang) {
        if ($currentLang == $forras_nyelv_ext || $currentLang == $langExt) continue;
        $otherLangsExt[] = "w.word_{$currentLang} as word_for_{$currentLang}";
    }
    $txt = aposztrofRepToDb(mb_strtolower($txt, 'UTF-8'));
    $txt = str_replace(chr(195) . chr(177), '&#241;', $txt);
    $spec_chars = "([/ ?,!.%])";
    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $query = "select w.id, w.word_{$forras_nyelv_ext} as word_hun, w.comment_{$forras_nyelv_ext} as comment_hun,
                            w.word_{$langExt} as word_foreign, w.comment_{$langExt} as comment_foreign,
                    w.level_{$langExt} as level, " . implode(", ", $otherLangsExt) . "
                from words w
                left outer join lmjelentkezok l on w.user_id = l.id
                where (
                        trim(lower(w.word_{$forras_nyelv_ext})) = '{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) = '&#191;{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^&#191;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#191;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#191;{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) = '&#161;{$txt}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '^&#161;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#161;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$forras_nyelv_ext})) regexp '&#161;{$spec_chars}{$txt}{$spec_chars}'
                    )
                    and w.word_{$langExt} is not null
                    and trim(w.word_{$langExt}) != ''
                    /*and (w.level_{$langExt} != 0 or l.status in (1, 4, 5, 6))*/
                order by word_foreign";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $list = getLevelList($lang);
    $records1 = array();
    $records2 = array();
    $records3 = array();
    while ($row = mysql_fetch_assoc($result)) {
        $row['level_category'] = (($row['level'] > 0) ? $list[$row['level']][1] : 0);
        $row['level_title'] = (($row['level'] > 0) ? $list[$row['level']][0] : '');
        $row['other_langs'] = array();
        foreach ($langArray as $currentLang) {
            if (isset($row['word_for_' . $currentLang])) {
                $row['other_langs'][$currentLang] = $row['word_for_' . $currentLang];
            }
        }
        if ($list[$row['level']][1] == 1 && $row['level'] > 0) {
            $records1[] = $row;
        } else if ($list[$row['level']][1] == 2) {
            $records2[] = $row;
        } else if (!isset($list[$row['level']]) || $row['level'] == 0) {
            $records3[] = $row;
        }
    }

    return array($records1, $records2, $records3);
}

function getWordsByFor($userObject, $txt, $lang)
{
    $langExt = getLangExtByLangId($lang);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $langArray = getLangArray();
    $otherLangsExt = array();
    foreach ($langArray as $currentLang) {
        if ($currentLang == $forras_nyelv_ext || $currentLang == $langExt) continue;
        $otherLangsExt[] = "w.word_{$currentLang} as word_for_{$currentLang}";
    }
    $txt = aposztrofRepToDb(mb_strtolower($txt, 'UTF-8'));
    //$spec_chars = "(&#241;|&#191;|&#161;|[/ ?,!.])";
    /*
print "lalala: ";
for($i = 0; $i < 5; $i++){
    print ord($txt[$i]) . ";";
}
*/
    $txt = str_replace(chr(195) . chr(177), '&#241;', $txt);
    $spec_chars = "([/ ?,!.%])";
    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $query = "select w.id, w.word_{$forras_nyelv_ext} as word_hun, w.comment_{$forras_nyelv_ext} as comment_hun,
                            w.word_{$langExt} as word_foreign, w.comment_{$langExt} as comment_foreign,
                    w.level_{$langExt} as level, " . implode(", ", $otherLangsExt) . "
                from words w
                left outer join lmjelentkezok l on w.user_id = l.id
                where (
                        trim(lower(w.word_{$langExt})) = '{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) = '&#191;{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^&#191;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '&#191;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '&#191;{$spec_chars}{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) = '&#161;{$txt}'
                        or trim(lower(w.word_{$langExt})) regexp '^&#161;{$txt}{$spec_chars}'
                        or trim(lower(w.word_{$langExt})) regexp '&#161;{$spec_chars}{$txt}$'
                        or trim(lower(w.word_{$langExt})) regexp '&#161;{$spec_chars}{$txt}{$spec_chars}'
                    )
                    and w.word_{$forras_nyelv_ext} is not null
                    and trim(w.word_{$forras_nyelv_ext}) != ''
                    /*and (w.level_{$langExt} != 0 or l.status in (1, 4, 5, 6))*/
                order by word_foreign";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $list = getLevelList($lang);
    $records1 = array();
    $records2 = array();
    $records3 = array();
    while ($row = mysql_fetch_assoc($result)) {
        $row['level_category'] = (($row['level'] > 0) ? $list[$row['level']][1] : 0);
        $row['level_title'] = (($row['level'] > 0) ? $list[$row['level']][0] : '');
        $row['other_langs'] = array();
        foreach ($langArray as $currentLang) {
            if (isset($row['word_for_' . $currentLang])) {
                $row['other_langs'][$currentLang] = $row['word_for_' . $currentLang];
            }
        }
        if ($list[$row['level']][1] == 1 && $row['level'] > 0) {
            $records1[] = $row;
        } else if ($list[$row['level']][1] == 2) {
            $records2[] = $row;
        } else if (!isset($list[$row['level']]) || $row['level'] == 0) {
            $records3[] = $row;
        }
    }
    return array($records1, $records2, $records3);
}

function incUserWordHitByDay($userObject)
{
    $userId = (int)$userObject['id'];
    $datum = date("Y-m-d");

    $query = "select count(*) from user_hits where user_id = $userId and datum = '$datum'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    list($cnt) = mysql_fetch_row($result);
    if ($cnt > 0) {
        $query = "update user_hits set hits = hits + 1 where user_id = $userId and datum = '$datum'";
    } else {
        $query = "insert into user_hits (user_id, datum, hits) values ($userId, '$datum', 1)";
    }
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return getUserWordHitByDay($userObject);
}

function getUserWordHitByDay($userObject, $datum = null)
{
    $userId = (int)$userObject['id'];
    if (is_null($datum)) {
        $datum = date("Y-m-d");
    }

    $query = "select hits from user_hits where user_id = $userId and datum = '$datum'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    list($hits) = mysql_fetch_row($result);
    return (int)$hits;
}


function incUserWordHit($userObject, $isSentenceNotWord)
{
    if ($isSentenceNotWord) {
        $field = "sentence_hits";
    } else {
        $field = "word_hits";
    }
    $query = "update lmjelentkezok set {$field} = {$field} + 1 where id = " . (int)$userObject['id'];
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }

    $query = "SELECT {$field} from lmjelentkezok where id = " . (int)$userObject['id'];
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function getUserWordHit($userObject, $isSentenceNotWord)
{
    if ($isSentenceNotWord) {
        $field = "sentence_hits";
    } else {
        $field = "word_hits";
    }
    $query = "SELECT {$field} from lmjelentkezok where id = " . (int)$userObject['id'];
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function getLevelComment($selectedLevel, $lang, $needEncode)
{
    $langExt = getLangExtByLangId($lang);
    $langSource = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $query = "SELECT rule_{$langExt}_{$langSource} as rule from level_rules where level = $selectedLevel";
    if ($needEncode)
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function setLevelComment($selectedLevel, $rule, $lang)
{
    $langExt = getLangExtByLangId($lang);
    $langSource = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $rule = str_replace(chr(13) . chr(10), "<br>", $rule);
    $rule = aposztrofRepToDb($rule);

    $query = "SELECT count(*) from level_rules where level = $selectedLevel";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    list($count) = mysql_fetch_row($result);

    if ($count == 0) {
        $query = "insert into level_rules (rule_{$langExt}_{$langSource}, level) values ('$rule', $selectedLevel)";
    } else {
        $query = "update level_rules set rule_{$langExt}_{$langSource} = '$rule' where level = $selectedLevel";
    }
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
}

function getOwnWordCount($userObject, $goodLevelArray)
{
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    if (count($goodLevelArray) > 1) {
        $where = " and w.level_{$langExt} in (" . implode(", ", $goodLevelArray) . ")";
    }

    $query = "SELECT count(distinct w.word_{$forras_nyelv_ext})
                from words w
                left outer join user_words u on w.id = u.word_id and u.user_id = {$userObject['id']}
                where (w.user_id = {$userObject['id']} or u.id is not null)
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'
                    $where";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function getBasicWordCount($userObject)
{
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $forras_nyelv_ext = getLangExtByLangId($userObject['forras_nyelv']);

    $query = "SELECT count(distinct w.word_{$forras_nyelv_ext})
                from words w
                where w.category = 1 and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != '' and w.word_{$forras_nyelv_ext} != '...'
                    and w.word_{$langExt} is not null and w.word_{$langExt} != '' and w.word_{$langExt} != '...'";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        deb(debug_backtrace());
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function getAllUserOwnWordCount()
{
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $sqlPart = array();
    $langArray = getLangArray();
    foreach ($langArray as $langId => $langText) {
        $levelList = getLevelList($langId);
        $goodLevelArray = array(-1);
        foreach ((array)$levelList as $key => $value) {
            if ($value[1] == 1 && $key != 0) {
                $goodLevelArray[] = $key;
            }
        }
        $sqlPart[] = "j.nyelv = {$langId} and w.level_{$forras_nyelv_ext} in (" . implode(", ", $goodLevelArray) . ")";
    }
    $query = "select j.id, count(*)
                from lmjelentkezok j
                inner join words w on j.id = w.user_id
                where w.level_{$forras_nyelv_ext} > 0
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != ''
                    and (" . implode(' or ', $sqlPart) . ")
                group by j.id

                union all

                select j.id, count(*)
                from lmjelentkezok j
                inner join user_words uw on j.id = uw.user_id
                inner join words w on w.id = uw.word_id and w.user_id <> j.id
                where w.level_{$forras_nyelv_ext} > 0
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != ''
                    and (" . implode(' or ', $sqlPart) . ")
                group by j.id";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $return = array();
    while (list($id, $count) = mysql_fetch_row($result)) {
        $return[$id] += $count;
    }
    return $return;
}

function getUserWords($userObject, $level, $orderLang, $useMarked = false)
{
    $langExt = getLangExtByLangId($userObject['nyelv']);
    $forras_nyelv_ext = getLangExtByLangId($GLOBALS['userObject']['forras_nyelv']);
    $query = "select w.*, w.word_{$langExt} as word_foreign, w.pronunc_{$langExt} as pronunc_foreign, w.comment_{$langExt} as comment_foreign, w.level_{$langExt} as level, uw.id as uw_id, coalesce(uw.is_marked, w.is_marked) as my_is_marked
                from words w
                left outer join user_words uw on w.id = uw.word_id and uw.user_id = {$userObject['id']}
                where (w.user_id = {$userObject['id']} or uw.id is not null)
                    and w.word_{$forras_nyelv_ext} is not null and w.word_{$forras_nyelv_ext} != ''
                    and w.word_{$langExt} is not null and w.word_{$langExt} != ''
                    and w.level_{$langExt} > 0
                    order by ";
    if ($useMarked) {
        $query .= "my_is_marked desc, ";
    }

    if ($orderLang == 'foreign') {
        $query .= "word_{$langExt}";
    } else {
        $query .= "word_{$forras_nyelv_ext}";
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }

    $levelList = getLevelList($userObject['nyelv']);

    $return = array();
    while ($row = mysql_fetch_assoc($result)) {
        if ($levelList[$row['level']][1] == $level) {
            $return[] = $row;
        }
    }
    return $return;
}

function getUserWordId($wordId, $userId)
{
    $sql = "select id from user_words where user_id = " . (int)$userId . " and word_id = " . (int)$wordId;
    $result = mysql_query($sql);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $sql);
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

function markUserWord($wordId, $userWordId, $userId, $isChecked)
{
    if ($userWordId > 0) {
        $sql = "update user_words set is_marked = " . ($isChecked ? 1 : 0) . " where id = $userWordId and user_id = " . (int)$userId;
    } else {
        $sql = "update words set is_marked = " . ($isChecked ? 1 : 0) . " where id = $wordId and user_id = " . (int)$userId;
    }
    mysql_query($sql);
}

function removeUserWord($userId, $wordId)
{
    $sql = "delete from user_words where word_id = " . (int)$wordId . " and user_id = " . (int)$userId;
    mysql_query($sql);
    $sql = "update words set user_id = 0 where id = " . (int)$wordId . " and user_id = " . (int)$userId;
    mysql_query($sql);
}

function getLevelLangIndep($dbLevel)
{
    static $levelListArray;
    if (!is_array($levelListArray)) {
        $langArray = getLangArray();
        $levelListArray = array();
        foreach ($langArray as $lang) {
            $levelListArray[$lang] = getLevelList($lang);
        }
    }
    foreach ($levelListArray as $levelList) {
        if (array_key_exists($dbLevel, $levelList)) {
            return $levelList[$dbLevel][1];
        }
    }
}

function getWordCountList($lang)
{
    $langExt = getLangExtByLangId($lang);
    $query = "SELECT level_{$langExt} as level, count(*) from words where word_{$langExt} is not null and word_{$langExt} != '' and word_{$langExt} != '...' group by level_{$langExt}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $returnList = array();
    while ($row = mysql_fetch_row($result)) {
        $returnList[$row[0]] = $row[1];
    }
    return $returnList;
}

function ajaxSearchPrint($lang)
{
    global $globalcolor;
    global $TDBgGlobalColor;
?>

    <script type="text/javascript">
        var ajaxSearchId = 0;
        var searchTimeout = null;
        var responseObject = null;

        function getAjaxResponse(target, callbackFunction) {
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    responseObject = JSON.parse(xmlhttp.responseText);
                    if (callbackFunction != null) {
                        callbackFunction(responseObject);
                    }
                }
            }
            xmlhttp.open("GET", target, true);
            xmlhttp.setRequestHeader("Content-Type", "text/plain;charset=ISO-8859-2");
            xmlhttp.send();
        }

        function getMeaning(responseObject) {
            if (responseObject.items.length > 0) {
                var myObj = responseObject.items[0];
                document.getElementById('moreMeaningDiv').innerHTML = getMoreMeaningDivContent(responseObject);
                document.getElementById('moreMeaningDiv').style.display = 'block';
                $('#linkSave').show();

                ajaxSearchId = myObj.id;
            } else {
                document.getElementById("ajaxSearchOutput").style.display = 'block';
                document.getElementById("ajaxSearchOutput").style.marginLeft = '-230px';
                document.getElementById("ajaxSearchOutput").style.marginTop = '-8px';
                document.getElementById("ajaxSearchOutput").innerHTML = <?php print "'" . translate('nincs_talalat') . "!'"; ?>;
                ajaxSearchId = 0;
            }
            ajaxSearchCallback(responseObject);
            document.getElementById("ajaxSearchInput").select();
        }

        function getMoreMeaningPart(responseObject) {
            if (responseObject.items.length > 1 ||
                (responseObject.items.length > 0 &&
                    (responseObject.items[0].pronunc_foreign.length > 0 || responseObject.items[0].comment_foreign.length > 0 || responseObject.searchedWord != responseObject.items[0].word_hun && responseObject.searchedWord != responseObject.items[0].word_foreign))) {
                return " <a href='#' style='color:white;font-weight:bold;font-size:20px;' onmouseover=\"if(document.getElementById('moreMeaningDiv').style.display == 'none'){ if(document.getElementById('moreMeaningDiv').innerHTML.length==0){document.getElementById('moreMeaningDiv').innerHTML = getMoreMeaningDivContent(responseObject);} document.getElementById('moreMeaningDiv').style.display='block';$('#linkSave').show();}\" onmouseout=\"document.getElementById('moreMeaningDiv').style.display='none';$('#linkSave').hide();$('#ajaxSearchOutput').hide();\">&rarr;</a>";
            } else {
                return '';
            }
        }

        function getMoreMeaningDivContent(responseObject) {
            var str = "<table class='meaningTableClass' cellpadding=5>";
            if (responseObject.items.length > 0) {
                var isChanged = null;
                for (var i = 0; i < responseObject.items.length; i++) {
                    responseObject.items[i].word_hun = decode_utf8(responseObject.items[i].word_hun);
                    responseObject.items[i].word_foreign = decode_utf8(responseObject.items[i].word_foreign);
                    //responseObject.items[i].pronunc_foreign = ""/*decode_utf8(responseObject.items[i].pronunc_foreign)*/;
                    responseObject.items[i].comment_foreign = decode_utf8(responseObject.items[i].comment_foreign);
                    responseObject.items[i].comment_hun = decode_utf8(responseObject.items[i].comment_hun);

                    var levelClass = 'meaningCell';
                    var levelAClass = 'meaningA';
                    var levelAStyle = 'font-weight:bold;color:white;';
                    if (responseObject.items[i].level_category != 1) {
                        levelClass = 'meaningLevel2Cell';
                        levelAClass = 'meaningLevel2A';
                        levelAStyle = 'font-weight:normal;color:white;';
                        if (isChanged === false) {
                            str += "<tr><td colspan='3'><hr></td></tr>";
                        }
                        isChanged = true;
                    } else {
                        isChanged = false;
                    }
                    str += "<tr>";
                    <?php if (in_array($GLOBALS['userObject']['status'], array(4, 5, 6))) { ?>
                        var divStr = '';
                        for (var prop in responseObject.items[i].other_langs) {
                            divStr += decode_utf8(eval("responseObject.items[i].other_langs." + prop)) + "&nbsp;(" + decode_utf8(prop) + ")&nbsp;&nbsp;";
                        }
                        var txt_left = "";
                        if (responseObject.items[i].comment_hun) {
                            if (responseObject.items[i].comment_hun) {
                                txt_left = " (" + responseObject.items[i].comment_hun + ")";
                            } else {
                                txt_left = " (" + responseObject.items[i].comment_hun + ")";
                            }
                        }
                        txt_left = "<span style='font-weight:normal;color:white;'>" + txt_left + "</span>";

                        var txt_right = "";
                        if (responseObject.items[i].comment_foreign) {
                            if (responseObject.items[i].comment_foreign) {
                                txt_right = " (" + responseObject.items[i].comment_foreign + ")";
                            } else {
                                txt_right = " (" + responseObject.items[i].comment_foreign + ")";
                            }
                        }
                        txt_right = "<span style='font-weight:normal;color:white;'>" + txt_right + "</span>";

                        str += "<td style='width:48%'><a href='#' class='" + levelAClass + "' style='" + levelAStyle + "' onmouseover=\"moreMeaningWordMouseOver('" + divStr +
                            "')\" onmouseout=\"moreMeaningWordMouseOut()\" onclick=\"if(typeof window.wordLink == 'function'){ wordLink(" + responseObject.items[i].id + ", 0) }\">" + responseObject.items[i].word_hun + "</a>" +
                            txt_left +
                            (responseObject.items[i].level_category == 1 ? " <font size='1'>(" + responseObject.items[i].level_title + ")</font>" : "") +
                            "</td>";

                        str += "<td class='" + levelClass + "'>" + responseObject.items[i].word_foreign + txt_right;
                    <?php } else { ?>
                        var txt_left = "";
                        if (responseObject.items[i].comment_hun) {
                            if (responseObject.items[i].comment_hun) {
                                txt_left = " (" + responseObject.items[i].comment_hun + ")";
                            } else {
                                txt_left = " (" + responseObject.items[i].comment_hun + ")";
                            }
                        }
                        txt_left = "<span style='font-weight:normal;color:white;'>" + txt_left + "</span>";

                        var txt_right = "";
                        if (responseObject.items[i].comment_foreign) {
                            if (responseObject.items[i].comment_foreign) {
                                txt_right = " (" + responseObject.items[i].comment_foreign + ")";
                            } else {
                                txt_right = " (" + responseObject.items[i].comment_foreign + ")";
                            }
                        }
                        txt_right = "<span style='font-weight:normal;color:white;'>" + txt_right + "</span>";

                        str += "<td style='width:48%;font-style:normal;" + levelAStyle + "' class='" + levelClass + "'>" + responseObject.items[i].word_hun +
                            txt_left +
                            (responseObject.items[i].level_category == 1 ? " <font size='1'>(" + responseObject.items[i].level_title + ")</font>" : "") +
                            "</td>";

                        str += "<td class='" + levelClass + "'>" + responseObject.items[i].word_foreign + txt_right;
                    <?php } ?>
                    if (responseObject.items[i].level_category == 1) {
                        str += "</td><td><span class='btnAjaxDivSave' style='color:<? print $globalcolor; ?>;' onclick='event.stopPropagation();setUserWordById(" + responseObject.items[i].id + ")'>" + <?php print "'" . translate("ajaxDivSave") . "'"; ?> + "</span>";
                    }
                    str += "</td></tr>";
                }
            }
            str += "</table>";
            return str;
        }

        function decode_utf8(s) {
            return decodeURIComponent(escape(s));
        }

        function moreMeaningWordMouseOver(str) {
            if (document.getElementById('ajax_other_langs') != null) {
                document.getElementById('ajax_other_langs').innerHTML = str;
                document.getElementById('ajax_other_langs').style.display = "block";
            } else {
                alert('M�g v�rj, mert az oldal nem t�lt�d�tt be teljesen!');
            }
        }

        function moreMeaningWordMouseOut() {
            document.getElementById('ajax_other_langs').style.display = "none";
        }

        function getLevelInfo(level, sorsz) {
            if (!(level > 0)) {
                getLevelInfoCallback(null);
                return;
            }
            getAjaxResponse('meaningSearch_server.php?getLevel=1&selectedLevel=' + level + '&sorsz=' + sorsz, getLevelInfoCallback);
        }

        function setUserWord(word) {
            if (!(word.length > 0)) {
                setUserWordCallback(null);
                return;
            }
            var url = 'meaningSearch_server.php?setUserWord=1&word=' + encodeURIComponent(word) + '&lang=' + <?php print $lang; ?>;
            if (typeof(dictionaryUser) !== 'undefined' && dictionaryUser > 0) {
                url += "&dictionaryUser=" + dictionaryUser;
            }
            getAjaxResponse(url, setUserWordCallback);
        }

        function setUserWordById(id) {
            <?php
            global $globalcolor;
            if (!$GLOBALS['userObject']) {
                print "alert('" . translate('ajaxDivSaveLoginMessage') . "'); return;";
            }
            ?>
            id = parseInt(id, 10);
            if (isNaN(id)) {
                return;
            }
            var url = 'meaningSearch_server.php?setUserWord=1&id=' + id;
            if (typeof dictionaryUser !== 'undefined' && dictionaryUser > 0) {
                url += "&dictionaryUser=" + dictionaryUser;
            }
            getAjaxResponse(url, setUserWordCallback);
        }

        function setUserWordCallback(responseObject) {
            if (responseObject && responseObject.result == 1) {
                document.getElementById("ajaxSearchOutput").innerHTML = <?php print "'" . translate('word_saved') . "'"; ?>;
            } else if (responseObject && responseObject.result == 666) {
                alert(<?php print "'" . translate('ajaxDivSaveLoginMessage') . "'"; ?>);
            } else {
                document.getElementById("ajaxSearchOutput").innerHTML = <?php print "'" . translate('not_successful') . "'"; ?>;
            }
            document.getElementById("ajaxSearchOutput").style.display = 'block';
        }

        function getLevelInfoCallback(responseObject) {
            if (responseObject) {
                document.getElementById("ruleTitleSpan").innerHTML = responseObject.sorsz + '. ' + decode_utf8(responseObject.title);
                document.getElementById("ruleTextContainer").innerHTML = "<div style='position:absolute;top:0;left:0;width:100%;height:100%;color:white'></div>" + decode_utf8(responseObject.text);
                document.getElementById("ruleId").value = responseObject.id;
                document.getElementById("ruleDiv").style.display = 'block';
            }
        }

        function getTimeoutTextAjax(val) {
            document.getElementById("ajaxSearchOutput").innerHTML = "";
            document.getElementById("ajaxSearchOutput").style.display = 'none';
            if (encodeURIComponent(val) == "") {
                return;
            }
            document.getElementById('moreMeaningDiv').innerHTML = '';
            document.getElementById('moreMeaningDiv').style.display = 'none';
            $('#linkSave').hide();
            $('#ajaxSearchOutput').hide();
            lastWordLookedUp = val;
            return "getAjaxResponse(\"meaningSearch_server.php?getMeaning=1&txt=" + encodeURIComponent(val) + "&lang=" + <?php print $lang; ?> + "\", getMeaning)";
        }
        var lastWordLookedUp = null;
    </script>
    <table id="ajaxTable" border='0' align='center' cellpadding='3' cellspacing=0 onclick="event.stopPropagation();" style="width:800px">
        <tr>
            <td id='ajaxTableFirstTd' align='right' valign='top'><a id="ajax" title=<?php print "'" . translate("info_ajax") . "'" ?> href='#' style='color:white;font-size:12pt;'></td>
            <td style='<? print $GLOBALS['TDBgGlobalColor']; ?>;width:150px;' align='left'>
                <div class='ajaxSearchTxtContainer'>
                    <span class="fa fa-search"></span>
                    <input type='text' name='ajaxSearchInput' id='ajaxSearchInput' placeholder=<?php print "'" . translate('search') . "...'"; ?> onclick="event.stopPropagation();" onblur="this.value = '';$('#ajaxSearchOutput').hide();" onkeyup="
                    if (searchTimeout != undefined){
                        clearTimeout(searchTimeout);
                    }
                    searchTimeout = setTimeout(getTimeoutTextAjax(this.value), 3000);
                    " />
                </div>
            </td>
            <td style='padding-left:0'><a id='linkSave' style='display:none;color:white;padding-left:0' href='#' onclick="event.stopPropagation();setUserWord(lastWordLookedUp);">
                    <b><?php print translate('ment'); ?>
                </a></td>
            <td align='left' colspan='2' valign='center' height='30' style='<? print $GLOBALS['TDBgGlobalColor']; ?>color:<? print $GLOBALS['globalcolor']; ?>'><b>
                    <div id='ajaxSearchOutput' style='display:none;'></div>
            </td>
        </tr>
    </table>
    <div id='moreMeaningDiv' style='position:absolute;left:50%;margin-left:-250px;width:500px;display:none;z-index:100;background:#B6000A none repeat scroll 0 0;' onclick="event.stopPropagation();this.style.display = 'none';$('#linkSave').hide();$('#ajaxSearchOutput').hide();"></div>
    <div id='ajax_other_langs' style='<? echo $GLOBALS['TDBgGlobalColor']; ?>color:white;position:absolute;top:10px;left:50%;margin-left:-190px;width:550px;filter:alpha(opacity=100);opacity:1;z-index:101;font-size:10pt;'></div>
<?php
}

function ajaxTimerPrint()
{
?>
    <script type="text/javascript">
        function setUserTimeoutAjax() {
            return "getAjaxResponse('meaningSearch_server.php?setUserTime=1', setUserTimeoutCallback)";
        }

        function setUserTimeoutCallback(responseObject) {
            bodyOnload();
        }

        function bodyOnload() {
            setTimeout(setUserTimeoutAjax(), 20000);
        }

        window.onload = bodyOnload;
    </script>
<?php
}

function setUserTime($userObject, $lastUpdateTime)
{
    // ha m�g nem t�roltuk le a session-be a last update-et, akkor most kezdj�k el a sz�mol�st
    if (!$lastUpdateTime) {
        return time();
    }

    $elapsedSec = time() - $lastUpdateTime;

    if ($elapsedSec >= 30 && $elapsedSec <= 10 * 60) {
        $query = "update lmjelentkezok set time_used = time_used + {$elapsedSec} where id = " . (int)$userObject['id'];
        $result = mysql_query($query);
        return time();
    } else if ($elapsedSec < 30) {
        return $lastUpdateTime;
    } else if ($elapsedSec > 10 * 60) {
        return time();
    }
}

function getUsedTime($id)
{
    $query = "select time_used from lmjelentkezok where id = " . (int)$id;
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    list($time_used) = mysql_fetch_row($result);
    return getTimeFormattedString($time_used);
}

function getTimeFormattedString($sec)
{
    $unith = 3600;        // Num of seconds in an Hour...
    $unitm = 60;            // Num of seconds in a min...

    $hh = intval($sec / $unith);    // '/' given value by num sec in hour... output = HOURS
    $ss_remaining = ($sec - ($hh * $unith));        // '*' number of hours by seconds, then '-' from given value... output = REMAINING seconds

    $mm = intval($ss_remaining / $unitm);    // take remaining sec and devide by sec in a min... output = MINS
    //$ss = ($ss_remaining - ($mm * $unitm));        // '*' number of mins by seconds, then '-' from remaining sec... output = REMAINING seconds.

    return str_pad($hh, 2, "0", STR_PAD_LEFT) . ':' . str_pad($mm, 2, "0", STR_PAD_LEFT);
}

function getWordMeaningAjaxObject($userObject, $txt, $lang)
{
    $list = getLevelList($userObject['nyelv']);
    $txt = mb_convert_encoding($txt, "UTF-8", "auto");
    list($records1, $records2, $records3) = getWordsByHun($userObject, $txt, $lang);

    $show = 1;
    if (count($records1) + count($records2) + count($records3) == 0) $show = 2;

    list($records4, $records5, $records6) = getWordsByFor($userObject, $txt, $lang);

    $kitoltottNemKifejezesSzavak = array();
    $kitoltottKifejezesSzavak = array();
    $nemKitoltottNemKifejezesSzavak = array();
    $nemKitoltottKifejezesSzavak = array();

    $kitoltottNemOsszetettMondatok = array();
    $kitoltottOsszetettMondatok = array();
    $nemKitoltottNemOsszetettMondatok = array();
    $nemKitoltottOsszetettMondatok = array();

    routeHitArray($records1, 39, $kitoltottKifejezesSzavak, $kitoltottNemKifejezesSzavak, $nemKitoltottKifejezesSzavak, $nemKitoltottNemKifejezesSzavak);
    routeHitArray($records4, 39, $kitoltottKifejezesSzavak, $kitoltottNemKifejezesSzavak, $nemKitoltottKifejezesSzavak, $nemKitoltottNemKifejezesSzavak);
    routeHitArray($records2, 44, $kitoltottOsszetettMondatok, $kitoltottNemOsszetettMondatok, $nemKitoltottOsszetettMondatok, $nemKitoltottNemOsszetettMondatok);
    routeHitArray($records5, 44, $kitoltottOsszetettMondatok, $kitoltottNemOsszetettMondatok, $nemKitoltottOsszetettMondatok, $nemKitoltottNemOsszetettMondatok);

    $records = array();
    $ids = array();

    foreach ((array)$kitoltottNemKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$kitoltottKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$nemKitoltottNemKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$nemKitoltottKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$kitoltottNemOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$kitoltottOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$nemKitoltottNemOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$nemKitoltottOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$records3 as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$records6 as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (($curRec["word_hun"] == $txt || $curRec["word_foreign"] == $txt) && !in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    /**********************************************************************************************/

    foreach ((array)$kitoltottNemKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$kitoltottKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$nemKitoltottNemKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$nemKitoltottKifejezesSzavak as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$kitoltottNemOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$kitoltottOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$nemKitoltottNemOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$nemKitoltottOsszetettMondatok as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }

    foreach ((array)$records3 as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    foreach ((array)$records6 as $curRec) {
        if (!in_array($GLOBALS['userObject']['status'], array(4, 5, 6)) && ($curRec["word_hun"] == '...' || $curRec["word_foreign"] == '...'))
            continue;
        if (!in_array($curRec['id'], $ids)) {
            $records[] = $curRec;
            $ids[] = $curRec['id'];
        }
    }
    //$records = array_merge($records, $records2);
    $record['direction'] = $show;
    $record['searchedWord'] = $txt;
    $record['items'] = $records;

    return $record;
}

function routeHitArray($hitArray, $levelToTheEnd, &$array1, &$array2, &$array3, &$array4)
{
    foreach ((array)$hitArray as $curRec) {
        // kit�lt�tt
        if ($curRec['word_hun'] != null && $curRec['word_hun'] != '' && $curRec['word_hun'] != '...' && $curRec['word_foreign'] != null && $curRec['word_foreign'] != '' && $curRec['word_foreign'] != '...') {
            // kifejez�s
            if ($curRec['level'] == $levelToTheEnd) {
                $array1[] = $curRec;
            } else {
                $array2[] = $curRec;
            }
        } else {
            if ($curRec['level'] == $levelToTheEnd) {
                $array3[] = $curRec;
            } else {
                $array4[] = $curRec;
            }
        }
    }
    return array($array1, $array2, $array3, $array4);
}

function setUserWord($userObject, $word, $lang)
{
    $record = getWordMeaningAjaxObject($userObject, $word, $lang);
    $userId = $userObject['id'];
    foreach ($record['items'] as $item) {
        // csak az 1-es level�eket mentj�k el
        if ($item['level_category'] !== 1) {
            continue;
        }
        $wordId = $item['id'];
        $query = "select count(*) from user_words where user_id = {$userId} and word_id = {$wordId}";
        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $query);
        }
        list($exist) = mysql_fetch_row($result);

        if (!$exist) {
            $query = "insert into user_words (user_id, word_id) values ({$userId}, {$wordId})";
            $result = mysql_query($query);
            if (!$result) {
                print mysql_error();
                exit("Nem siker�lt: " . $query);
            }
        }
    }
}

function setUserWordById($userObject, $id)
{
    $wordId = $id;
    $userId = $userObject['id'];
    $query = "select count(*) from user_words where user_id = {$userId} and word_id = {$wordId}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    list($exist) = mysql_fetch_row($result);

    if (!$exist) {
        $query = "insert into user_words (user_id, word_id) values ({$userId}, {$wordId})";
        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $query);
        }
    }
}


function deb($array)
{
    print "<pre>";
    print_r($array);
    print "</pre>";
}


function deleteUser($userId)
{
    $query = "delete from word_records where user_id = {$userId}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }

    $query = "delete from user_words where user_id = {$userId}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }

    $query = "delete from lmjelentkezok where id = {$userId}";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }

    return true;
}

function createUser($userArray, &$message)
{
    if (!$userArray['jelszo'] or !$userArray['vezeteknev'] or !$userArray['keresztnev'] or !$userArray['email']) {
        $message = "A vezet�kn�v, keresztn�v, jelsz� �s email kit�lt�se k�telez�!";
        return false;
    }
    foreach ($userArray as $key => $value) {
        $userArray[$key] = str_replace("'", "''", $value);
    }
    $userArray['send_mail'] = (int)$userArray['send_mail'];
    $userArray['forras_nyelv'] = (int)$userArray['forras_nyelv'];
    $userArray['nyelv'] = (int)$userArray['nyelv'];
    $userArray['max_level'] = (int)$userArray['max_level'];
    $userArray['status'] = (int)$userArray['status'];
    $userArray['tanar'] = (int)$userArray['tanar'];

    $query = "select count(*) as nr from lmjelentkezok where email = '{$userArray['email']}'";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $number = $row['nr'];
    }
    if ($number > 0) {
        $message = "Ezzel az e-mail c�mmel m�r van regisztr�lt felhaszn�l�!";
        return false;
    }
    $hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
    $query = "insert into lmjelentkezok (jelszo, vezeteknev, keresztnev, email, program_start_date, program_end_date, client_data, send_mail, forras_nyelv, nyelv, max_level, status, tanar_id, payment, hazi_feladat, next_lesson, hash)
                values('{$userArray['jelszo']}', '{$userArray['vezeteknev']}', '{$userArray['keresztnev']}', '{$userArray['email']}'
                    , '{$userArray['program_start_date']}', '{$userArray['program_end_date']}', '{$userArray['client_data']}', {$userArray['send_mail']}, {$userArray['forras_nyelv']}, {$userArray['nyelv']}, {$userArray['max_level']}, {$userArray['status']}, " . (int)$userArray['tanar'] . ", '{$userArray['payment']}', '{$userArray['hazi_feladat']}', '{$userArray['next_lesson']}', '{$hash}')";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $query = "select id from lmjelentkezok where email = '{$userArray['email']}'";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $id = 0;
    while ($row = mysql_fetch_row($result)) {
        $id = $row[0];
    }

    return $id;
}

function createUser2($userArray, &$message)
{
    if (!$userArray['jelszo'] or !$userArray['vezeteknev'] or !$userArray['keresztnev'] or !$userArray['email']) {
        $message = "A vezet�kn�v, keresztn�v, jelsz� �s email kit�lt�se k�telez�!";
        return false;
    }
    foreach ($userArray as $key => $value) {
        $userArray[$key] = str_replace("'", "''", $value);
    }
    $userArray['nyelv'] = (int)$userArray['nyelv'];
    $userArray['forras_nyelv'] = (int)$userArray['forras_nyelv'];
    $userArray['status'] = (int)$userArray['status'];
    $userArray['subscribe_length'] = (int)$userArray['subscribe_length'];
    $userArray['send_mail'] = (int)$userArray['send_mail'];

    $query = "select count(*) as nr from lmjelentkezok where email = '{$userArray['email']}'";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $number = $row['nr'];
    }
    if ($number > 0) {
        $message = "Ezzel az e-mail c�mmel m�r van regisztr�lt felhaszn�l�!";
        return false;
    }

    $start = date('Y-m-d', strtotime('0 years'));
    $end = date('Y-m-d', strtotime('+1 years'));
    $max_level = 1000;

    $hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
    $query = "insert into lmjelentkezok (jelszo, vezeteknev, keresztnev, email, forras_nyelv, nyelv, status, subscribe_length, send_mail,max_level,program_start_date,program_end_date, hash)
                values('{$userArray['jelszo']}', '{$userArray['vezeteknev']}', '{$userArray['keresztnev']}', '{$userArray['email']}',
                    {$userArray['forras_nyelv']}, {$userArray['nyelv']}, {$userArray['status']}, {$userArray['subscribe_length']}, {$userArray['send_mail']},{$max_level},'{$start}','{$end}', '{$hash}')";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    $query = "select id from lmjelentkezok where email = '{$userArray['email']}'";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $id = 0;
    while ($row = mysql_fetch_row($result)) {
        $id = $row[0];
    }

    return $id;
}

function modifyUser($storeArray, &$message)
{
    if (isset($storeArray['email'])) $fields['email'] = "'" . $storeArray['email'] . "'";
    if (isset($storeArray['jelszo'])) $fields['jelszo'] = "'" . $storeArray['jelszo'] . "'";
    if (isset($storeArray['vezeteknev'])) $fields['vezeteknev'] = "'" . $storeArray['vezeteknev'] . "'";
    if (isset($storeArray['keresztnev'])) $fields['keresztnev'] = "'" . $storeArray['keresztnev'] . "'";
    if (isset($storeArray['program_start_date'])) $fields['program_start_date'] = "'" . $storeArray['program_start_date'] . "'";
    if (isset($storeArray['program_end_date'])) $fields['program_end_date'] = "'" . $storeArray['program_end_date'] . "'";
    if (isset($storeArray['client_data'])) $fields['client_data'] = "'" . $storeArray['client_data'] . "'";
    if (isset($storeArray['send_mail'])) $fields['send_mail'] = (int)$storeArray['send_mail'];
    if (isset($storeArray['forras_nyelv'])) $fields['forras_nyelv'] = (int)$storeArray['forras_nyelv'];
    if (isset($storeArray['nyelv'])) $fields['nyelv'] = (int)$storeArray['nyelv'];
    if (isset($storeArray['max_level'])) $fields['max_level'] = (int)$storeArray['max_level'];
    if (isset($storeArray['status'])) $fields['status'] = (int)$storeArray['status'];
    if (isset($storeArray['tanar'])) $fields['tanar_id'] = (int)$storeArray['tanar'];
    if (isset($storeArray['payment'])) $fields['payment'] = "'" . $storeArray['payment'] . "'";
    if (isset($storeArray['hazi_feladat'])) $fields['hazi_feladat'] = "'" . $storeArray['hazi_feladat'] . "'";
    if (isset($storeArray['next_lesson'])) $fields['next_lesson'] = "'" . $storeArray['next_lesson'] . "'";

    if (isset($storeArray['email'])) {
        $query = "select count(*) as nr from lmjelentkezok where email = '{$storeArray['email']}' and id != " . (int)$storeArray['id'];

        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $query);
        }
        $number = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $number = $row['nr'];
        }
        if ($number > 0) {
            $message = "Ezzel az e-mail c�mmel m�r van regisztr�lt felhaszn�l�!";
            return false;
        }
    }

    $sqlString = array();
    foreach ($fields as $key => $value) {
        $sqlString[] = "$key = $value";
    }
    $sql = "update lmjelentkezok set " . implode(', ', $sqlString) . "
                where id = " . (int)$storeArray['id'];

    $result = mysql_query($sql);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}

function getFinanceById($id)
{
    if (strlen($id) == 0) {
        return false;
    }

    $query = "SELECT f.*, u.vezeteknev, u.keresztnev from finance f inner join lmjelentkezok u on f.user_id = u.id where f.ID = '$id'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $financeObject = false;
    while ($row = mysql_fetch_assoc($result)) {
        $financeObject = $row;
    }
    return $financeObject;
}


function createFinance($userArray, &$message)
{
    foreach ($userArray as $key => $value) {
        $userArray[$key] = str_replace("'", "''", $value);
    }
    // fifty-fifty
    if ((int)$userArray['time_package'] == 1) {
        $userArray['payable_to_teacher'] = 2500;
        $userArray['payable_to_boss'] = 2500;
    }
    // 3500ft (tan�r�) - 1500ft (boss�)
    else if ((int)$userArray['time_package'] == 2) {
        $userArray['payable_to_teacher'] = 3500;
        $userArray['payable_to_boss'] = 1500;
    } else {
        $userArray['payable_to_teacher'] = 0;
        $userArray['payable_to_boss'] = 0;
    }
    $query = "insert into finance (user_id, payment_date, amount, paid_to_who, time_package, payable_to_teacher, payable_to_boss, lesson_date)
                values('{$userArray['user_id']}', '{$userArray['payment_date']}', " . (int)$userArray['amount'] . ", " . (int)$userArray['paid_to_who'] . "
                    ,  " . (int)$userArray['time_package'] . ",  " . (int)$userArray['payable_to_teacher'] . ",  " . (int)$userArray['payable_to_boss'] . ", '{$userArray['lesson_date']}')";

    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        return false;
    }
    $query = "select max(id) from finance where user_id = '{$userArray['user_id']}' and payment_date = '{$userArray['payment_date']}'";

    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $id = 0;
    while ($row = mysql_fetch_row($result)) {
        $id = $row[0];
    }

    return $id;
}

function modifyFinance($storeArray, &$message)
{
    if (isset($storeArray['user_id'])) $fields['user_id'] = (int)$storeArray['user_id'];
    if (isset($storeArray['payment_date'])) $fields['payment_date'] = "'" . $storeArray['payment_date'] . "'";
    if (isset($storeArray['time_package'])) $fields['time_package'] = (int)$storeArray['time_package'];
    if (isset($storeArray['paid_to_who'])) $fields['paid_to_who'] = (int)$storeArray['paid_to_who'];
    if (isset($storeArray['lesson_date'])) $fields['lesson_date'] = "'" . $storeArray['lesson_date'] . "'";

    // fifty-fifty
    if ((int)$fields['time_package'] == 1) {
        $fields['payable_to_teacher'] = 2500;
        $fields['payable_to_boss'] = 2500;
    }
    // 3500ft (tan�r�) - 1500ft (boss�)
    else if ((int)$fields['time_package'] == 2) {
        $fields['payable_to_teacher'] = 3500;
        $fields['payable_to_boss'] = 1500;
    } else if (isset($fields['time_package'])) {
        $fields['payable_to_teacher'] = 0;
        $fields['payable_to_boss'] = 0;
    }

    $sqlString = array();
    foreach ($fields as $key => $value) {
        $sqlString[] = "$key = $value";
    }
    $sql = "update finance set " . implode(', ', $sqlString) . "
                where id = " . (int)$storeArray['id'];

    $result = mysql_query($sql);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}

function deleteFinance($financeId)
{
    if (is_array($financeId)) {
        $ids = array();
        foreach ($financeId as $id) {
            $ids[] = (int)$id;
        }
        $query = "delete from finance where id in (" . implode(", ", $ids) . ")";
    } else {
        $query = "delete from finance where id = {$financeId}";
    }

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}

function getFinances($teacherId)
{
    $query = "select f.*, u.vezeteknev, u.keresztnev from finance f inner join lmjelentkezok u on f.user_id = u.id";
    if ($teacherId > 0) {
        $query .= " where u.tanar_id = {$teacherId}";
    } else {
        $query .= " where u.tanar_id = 0";
    }
    $query .= " order by f.payment_date desc";
    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        return false;
    }
    $resultArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function getFinancesByStudent($studentId)
{
    $query = "select f.*, u.vezeteknev, u.keresztnev from finance f inner join lmjelentkezok u on f.user_id = u.id";
    if ($studentId > 0) {
        $query .= " where u.id = {$studentId}";
    }
    $query .= " order by f.payment_date desc";
    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        return false;
    }
    $resultArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function getBalance($userId)
{
    $query = "select sum(f.amount) as amount from finance f inner join lmjelentkezok u on f.user_id = u.id where u.tanar_id = {$userId} and f.paid_to_who = 1";
    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        return false;
    }
    list($penz_tanarnal) = mysql_fetch_row($result);

    $query = "select sum(f.payable_to_teacher) as amount from finance f inner join lmjelentkezok u on f.user_id = u.id where u.tanar_id = {$userId}";
    $result = mysql_query($query);
    if (!$result) {
        print $query . ' ' . mysql_error();
        return false;
    }
    list($penz_tanarnak) = mysql_fetch_row($result);

    return ((int)$penz_tanarnal - (int)$penz_tanarnak);
}

function getUsersByLanguage($lang)
{
    if ($lang > 0) {
        $where = "where nyelv = {$lang}";
    }
    $query = "select *, datediff(now(), program_start_date) as eltelt_napok
                from lmjelentkezok
                $where
                order by vezeteknev, keresztnev";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $resultArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function getUsersByTeacher($user_id)
{
    $query = "select *, datediff(now(), program_start_date) as eltelt_napok
                from lmjelentkezok
                where tanar_id = {$user_id}
                order by vezeteknev, keresztnev";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $resultArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function getUsersByStatusArray($statusArray)
{
    $statusArray[] = -1;
    $query = "select *
                from lmjelentkezok
                where status in (" . implode(', ', $statusArray) . ")
                order by keresztnev";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $resultArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        $resultArray[$row['id']] = $row;
    }
    return $resultArray;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

function isPrevArrow($selectedLevel, $userObject, $isPeldamondatok)
{
    $levelList = getLevelList($_SESSION['userObject']['nyelv']);
    $isPrev = false;
    if ($isPeldamondatok) {
        $goodArray = array(2);
    } else {
        $goodArray = array(1, 2, 3);
    }
    if (in_array($selectedLevel, array_keys($levelList))) {
        reset($levelList);
        while (current($levelList) && key($levelList) != $selectedLevel) {
            next($levelList);
        }
        while (prev($levelList)) {
            $currentOne = current($levelList);
            if (!in_array($currentOne[1], $goodArray) || key($levelList) == '0') {
                continue;
            }
            $isPrev = true;
            break;
        }
    }
    return $isPrev;
}

function isNextArrow($selectedLevel, $userObject, $isPeldamondatok)
{
    $levelList = getLevelList($_SESSION['userObject']['nyelv']);
    $isNext = false;
    if ($isPeldamondatok) {
        $goodArray = array(2);
    } else {
        $goodArray = array(1, 2, 3);
    }
    if (in_array($selectedLevel, array_keys($levelList))) {
        if ($selectedLevel == $userObject['max_level']) {
            return false;
        }
        $isMaxLevel = false;
        reset($levelList);
        while (current($levelList) && key($levelList) != $selectedLevel) {
            if (key($levelList) == $userObject['max_level']) {
                return false;
            }
            next($levelList);
        }
        while (next($levelList)) {
            $currentOne = current($levelList);
            if (!in_array($currentOne[1], $goodArray) || key($levelList) == '0') {
                continue;
            }
            $isNext = true;
            break;
        }
    }
    return $isNext;
}

function endiMail($to, $subject, $body, $fromName, $fromEmail, $hiddenAddresses = array(), $userNames = array(), $userLogins = array(), $charcode = 'ISO-8859-2', $userEmails = array())
{
    // a lev�lk�ld�s lev�gja a body utols� k�t karakter�t, tudja a h�h�r hogy mi�rt
    $body = str_replace(chr(13) . chr(10), "<br>", $body);
    $body = "<span style='font-family:Arial;'>" . $body . '</span>  ';
    $body = "<HTML><head><META HTTP-EQUIV='CHARSET' CONTENT='text/html; charset=$charcode'></head><body>" . $body . "</body></html>  ";
    $mime_boundary = "---- lingocasa.com ----" . md5(time());
    $headers = "From: $fromName <$fromEmail>\n";
    $headers .= "Reply-To: $fromName <$fromEmail>\n";
    $headers .= "MIME-Version: 1.0\n";
    //    $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\r\n";
    $headers .= "Content-Type: text/html\n";
    if (count((array)$hiddenAddresses) > 0) {
        for ($i = 0; $i < count((array)$hiddenAddresses); $i++) {
            if (count($userNames) == count($hiddenAddresses) and count($userNames) > 0) {
                $body2 = str_replace('<nameVar />', $userNames[$i], $body);
                $body2 = str_replace('<loginVar />', $userLogins[$i], $body2);
                $body2 = str_replace('<emailVar />', $userEmails[$i], $body2);
            }
            if (!mail($hiddenAddresses[$i], $subject, $body2, $headers)) {
                return false;
            }
        }
        return true;

        // $headers .= "BCC: " . implode(',', $hiddenAddresses) . "\r\n";
    }
    set_time_limit(0);
    if (!mail($to, $subject, $body, $headers)) {
        return false;
    }
    return true;
}

function subscribeBody($nev, $email, $jelszo, $nyelv, $subscribe_length)
{
    return "
Szia!

�dv�zl�nk nyelvgyakorl�ink t�bor�ban!

Javasoljuk, hogy sz�nj id�t a program megismer�s�re, ha valami nem megy, a kis k�rd�jelekkel felhozhat� instrukci�k seg�thetnek.
Ha ezen k�v�l van k�rd�sed, �rj emailt nyugodtan, minden visszajelz�st megk�sz�n�nk, hiszen folyamatosan t�reksz�nk a m�g jobb
felhaszn�l�i �lm�ny l�trehoz�s�ra.

A weboldal Google Chrome, Mozilla Firefox �s Microsoft Edge B�ng�sz�kre van optimaliz�lva, az Internet Explorert
nem aj�nljuk haszn�latra.

Ha a regisztr�ci�n�l bejel�lted, minden reggel a Napi Kv�zzel k�sz�nt�nk emailben. Ezt a be�ll�t�sokban b�rmikor kikapcsolhatod.

Ha androidos (pl. Samsung) okostelefonod van, a regisztr�c�ddal a Google Playb�l let�lthet� lingocasa alkalmaz�s haszn�lat�ra is jogosult lett�l.

Eredm�nyes tanul�st k�v�n,
A <a href='https://www.lingocasa.com'>lingocasa.com</a> csapata

<u>Adataid</u><br>
N�v: $nev
E-mail: $email
Jelsz�: $jelszo
V�lasztott nyelv: $nyelv";
}

function subscribeBodyENG($nev, $email, $jelszo, $nyelv, $subscribe_length)
{
    return "
Hello,

Welcome to our tribe of eager learners.

We suggest that you take your time to get to know the programme and if you do not understand anything click on the question marks throughout the website for help. If you have any further questions email us, we are grateful for all the feedback as we continuously strive for a better user experience.

The page is optimalized for Google Chrome, Mozilla Firefox and Microsoft Edge. Internet Explorer is not recommended.

If you subscribed for it, we will greet you with the Daily Quiz every day. You can turn this off in Settings any time.

For Android devices (like Samsung) the lingocasa app is available in Google Play and you can use it with you subscription.

Have fun with learning,
<a href='https://www.lingocasa.com'>lingocasa.com</a> team

<u>Your personal data:</u><br>
N�v: $nev
E-mail: $email
Jelsz�: $jelszo
V�lasztott nyelv: $nyelv";
}

function subscribeBodyESP($nev, $email, $jelszo, $nyelv, $subscribe_length)
{
    return "
Bienvenid@ en el tribu de nuestros estudiantes de idiomas.

Te recomendamos que tomes tu tiempo para conocer bien la aplicaci�n. Si algo no est� claro pinchando en las pequenas interrogaciones saldr� ayuda. Si a�n tienes dudas escr�benos un e-mail. Te agradeceremos todo tipo de comentario o cr�tica ya que seguimos procurando mejorar la experiencia de usuario.

La p�gina est� optimizada para Google Chrome, Mozilla Firefox y Microsoft Edge. No recomendamos el uso de Internet Explorer.

Si durante la suscripci�n has marcado la opci�n, cada manana te saludaremos con ''Reto del D�a''. Puedes apagar esta funci�n en cualquier momento en los ajustes.

Para dispositivos con Android la aplicaci�n est� disponible en Google Play. Con tu suscripci�n tienes derecho a descargarla.

Disfruta aprendiendo,
<a href='https://www.lingocasa.com'>lingocasa.com</a>

<u>Adataid</u><br>
Nombre: $nev
Email: $email
Contra&#241;a: $jelszo
Idioma: $nyelv";
}

function array_utf8_encode_recursive($dat)
{
    if (is_string($dat)) {
        return utf8_encode($dat);
    }
    if (is_object($dat)) {
        $ovs = get_object_vars($dat);
        $new = $dat;
        foreach ($ovs as $k => $v) {
            $new->$k = array_utf8_encode_recursive($new->$k);
        }
        return $new;
    }

    if (!is_array($dat)) return $dat;
    $ret = array();
    foreach ($dat as $i => $d) $ret[$i] = array_utf8_encode_recursive($d);
    return $ret;
}

function array_utf8_decode_recursive($dat)
{
    if (is_string($dat)) {
        return utf8_decode($dat);
    }
    if (is_object($dat)) {
        $ovs = get_object_vars($dat);
        $new = $dat;
        foreach ($ovs as $k => $v) {
            $new->$k = array_utf8_decode_recursive($new->$k);
        }
        return $new;
    }

    if (!is_array($dat)) return $dat;
    $ret = array();
    foreach ($dat as $i => $d) $ret[$i] = array_utf8_decode_recursive($d);
    return $ret;
}

function translate($word)
{
    global $trans;
    if (array_key_exists($word, (array)$trans)) {
        return $trans[$word];
    } else {
        return $word;
    }
}

function getLangExtByLangId($langId)
{
    $langArray = getLangArray();
    return $langArray[$langId];
}

function getLangTitles()
{
    // a sorrend az, amilyen sorrendben a lucien v�ltja a nyelveket a f�oldalon
    $langArray = array(
        1 => 'angol',
        2 => 'spanyol',
        4 => 'n�met',
        5 => 'francia',
        3 => 'arab',
        0 => 'magyar'
    );
    return $langArray;
}

function getClientsLocalLangs()
{
    return array(
        0 => 'hun',
        1 => 'eng',
        2 => 'esp',
        3 => 'arb',
        4 => 'ger',
        5 => 'fra'
    );
}

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        $i = 0;
        foreach ($sortable_array as $k => $v) {
            $new_array[$i++] = $array[$k];
        }
    }

    return $new_array;
}

function getUserProgress($userObject, $countBasicWords = null, $packageRecordsBasicWords = null)
{
    if ($countBasicWords == null)
        $countBasicWords = getBasicWordCount($userObject);
    if ($packageRecordsBasicWords == null)
        $packageRecordsBasicWords = getPackageRecords($userObject, 4);

    $partRowNumber = (int)($countBasicWords / $GLOBALS['szoPackageSize']);
    if ($partRowNumber * $GLOBALS['szoPackageSize'] < $countBasicWords) {
        $partRowNumber++;
    }
    $cntCsomag = 0;
    $sumCsomagProgress = 0;
    for ($i = 1; $i <= $partRowNumber; $i++) {
        $cntCsomag++;
        if ($packageRecordsBasicWords[$i]['best_time'] > 0) {
            $sumCsomagProgress += (($packageRecordsBasicWords[$i]['best_time'] <= $GLOBALS['szoPackageRecordMpLimit']) ? 1 : ((float)$GLOBALS['szoPackageRecordMpLimit'] / $packageRecordsBasicWords[$i]['best_time']));
        }
    }
    return number_format(100 * (float)$sumCsomagProgress / $cntCsomag, 2, ",", "");
}

function getDailyQuiz()
{
    $datum = date("Y-m-d");
    $query = "
        select w.id, w.word_hun, w.word_angol, w.word_spanyol
        from daily_quiz q
        inner join words w on q.word_id = w.id
        where q.datum = '$datum'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $row = mysql_fetch_assoc($result);
    if ($row) {
        return $row;
    }

    $list = getLevelList(1);
    $levels = array();
    foreach ($list as $key => $value) {
        if ($key > 0 && $value[1] == 2) {
            $levels[] = $key;
        }
    }
    $query = "
        select id
        from words
        where word_angol is not null and word_angol != '...'
            and word_hun is not null and word_hun != '...'
            and word_spanyol is not null and word_spanyol != '...'
            and level_angol in (" . implode(",", $levels) . ")
            and id not in (select word_id from daily_quiz)
        order by rand() limit 1";

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    list($wordId) = mysql_fetch_row($result);
    if ($wordId > 0) {
        $query = "insert into daily_quiz (word_id, datum) values ($wordId, '$datum')";
        $result = mysql_query($query);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $query);
        }
        return getDailyQuiz();
    }
}

function changePassword($userId, $settingArray)
{
    if (!$userId) {
        return false;
    }
    if ($settingArray['newPassword'] != $settingArray['confirmNewPassword']) {
        print "<script>alert('" . translate('passwordMismatch') . "');</script>";
        return false;
    }
    $jelszo = str_replace("'", "''", $settingArray['oldPassword']);
    $ujJelszo = str_replace("'", "''", $settingArray['newPassword']);
    $query = "select count(*) as NR from lmjelentkezok where jelszo = '$jelszo' and id = " . (int)$userId;

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $number = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $number = $row['NR'];
    }
    if ($number < 1) {
        print "<script>alert('" . translate('origPwBad') . "');</script>";
        return false;
    }

    $query = "update lmjelentkezok set jelszo = '$ujJelszo' where id = " . (int)$userId;

    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        return false;
    }
    return true;
}
?>