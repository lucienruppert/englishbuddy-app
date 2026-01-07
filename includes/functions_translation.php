<?php
// Initialize global variables
global $userObject;
if (!isset($GLOBALS['userObject'])) {
    $GLOBALS['userObject'] = null;
}
if (!isset($GLOBALS['nyelv'])) {
    $GLOBALS['nyelv'] = 0;
}

if ($GLOBALS['userObject']) {
    if ($GLOBALS['userObject']['forras_nyelv'] === '0' and file_exists('translations_HUN.php')) {
        include_once('translations_HUN.php');
    } else if ($GLOBALS['userObject']['forras_nyelv'] === '2' and file_exists('translations_ESP.php')) {
        include_once('translations_ESP.php');
    } else if (file_exists('translations_ENG.php')) {
        include_once('translations_ENG.php');
    }
} else if ($GLOBALS['nyelv'] > 0) {
    $nyelv = (int)$GLOBALS['nyelv'];
    if ($nyelv == 1 && file_exists('translations_ENG.php')) {
        include_once('translations_ENG.php');
    } else if ($nyelv == 2 && file_exists('translations_ESP.php')) {
        include_once('translations_ESP.php');
    } else {
        include_once('translations_HUN.php');
    }
} else {
    if (file_exists('translations_HUN.php')) {
        include_once('translations_HUN.php');
    } else if (file_exists('translations_ESP.php')) {
        include_once('translations_ESP.php');
    } else if (file_exists('translations_ENG.php')) {
        include_once('translations_ENG.php');
    }
}
