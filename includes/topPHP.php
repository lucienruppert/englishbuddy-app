<?php
// Define the application base path (works for both localhost and /app/ on live server)
if (!defined('BASE_PATH')) {
    if (strpos($_SERVER['REQUEST_URI'], '/app/') !== false) {
        define('BASE_PATH', '/app');
    } else {
        define('BASE_PATH', '');
    }
}

// Set proper character encoding...
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

error_reporting(0);
ini_set('display_errors', 0);
$defaultNyelv = 0;
$notLoggedInMessage = "Nem vagy belépve!";
$premiumUserOnlyMessage = "Csak prémium felhasználók számára elérhető!";

// Start session at the beginning before any session operations
if (session_status() === PHP_SESSION_NONE) {
    // Set session parameters before starting the session
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.gc_maxlifetime', 3600); // 60 * 60
    session_start();
}

include_once(__DIR__ . '/functions_userObj.php');

$userObject = isset($_SESSION['userObject']) ? $_SESSION['userObject'] : null;
$isAndroid = 0;
if ($userObject === NULL) {
    $userObject = 0;
}

require_once(__DIR__ . '/functions_userObj.php');
if (isset($_REQUEST['actionType']) && $_REQUEST['actionType'] == 'login') {
    if ((isset($_GET['h']) && ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObjByHash($_GET['h']))) || ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObj($_REQUEST['email'], $_REQUEST['username']))) {
        if ($userObject['status'] == 1) {
            //print "<script>alert('El�fizet�sed m�g nem ker�lt aktiv�l�sra!');</script>";
        } else {
            $GLOBALS['welcomeText'] = true;
            $GLOBALS['userObject']['forras_nyelv'] = $_SESSION['userObject']['forras_nyelv'];
            // Redirect directly to classroom after successful login
            if (!in_array($userObject['status'], array(1, 2))) {
                header("Location: main.php?content=wordManagement");
                exit;
            }
        }
    } else {
        print "<script>alert('A megadott felhasználó nem létezik!');</script>";
    }
}

if (!$userObject) {
    if (isset($_GET["langChange"])) {
        $defaultNyelv = (int)$_GET["langChange"];
        setcookie('preflanguage', $defaultNyelv);
    } else if (isset($_COOKIE['preflanguage'])) {
        $defaultNyelv = (int)$_COOKIE['preflanguage'];
        setcookie('preflanguage', $defaultNyelv);
    }
}

$GLOBALS['nyelv'] = $nyelv = $userObject ? $userObject['nyelv'] : $defaultNyelv;

// Load the appropriate translation file based on the user's SOURCE language (forras_nyelv)
// This is the language the user understands/native language
$sourceLanguage = $userObject ? $userObject['forras_nyelv'] : $defaultNyelv;
$translationFiles = array(
    0 => 'translations_HUN.php',  // Hungarian
    1 => 'translations_ENG.php',  // English
    2 => 'translations_ESP.php',  // Spanish
    3 => 'translations_HUN.php',  // Arabic (fallback to Hungarian)
    4 => 'translations_HUN.php',  // German (fallback to Hungarian)
    5 => 'translations_HUN.php'   // French (fallback to Hungarian)
);
$translationFile = isset($translationFiles[$sourceLanguage]) ? $translationFiles[$sourceLanguage] : 'translations_HUN.php';
include_once(__DIR__ . '/../dictionary/' . $translationFile);

include_once(__DIR__ . '/functions.php');
include_once(__DIR__ . '/cellBlocksHelper.php');

if ($userObject)
    $_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

if ($userObject && in_array($userObject['status'], array(4, 5, 6))) {
    $isUserSuperior = true;
} else {
    $isUserSuperior = false;
}

if ($userObject) {
    $list = getLevelList($userObject['nyelv']);
    $countList = getWordCountList($userObject['nyelv']);
    $packageRecords = getPackageRecords($userObject, 1);
    $packageRecordsSentences = getPackageRecords($userObject, 2);
    $packageRecordsBasicWords = getPackageRecords($userObject, 4);

    $goodLevelArray = array();
    $goodSentenceLevelArray = array();
    foreach ($list as $key => $value) {
        if ($value[1] == 1 && $key != 0) {
            $goodLevelArray[] = $key;
        } else if ($value[1] == 2 && $key != 0) {
            $goodSentenceLevelArray[] = $key;
        }
    }
    $countOwnWords = getOwnWordCount($userObject, $goodLevelArray);
    $countBasicWords = getBasicWordCount($userObject);
    $countOwnSentences = getOwnWordCount($userObject, $goodSentenceLevelArray);
}
