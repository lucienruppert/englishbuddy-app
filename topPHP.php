<?php

    error_reporting(0);
    $defaultNyelv = 0;
    $notLoggedInMessage = "Nem vagy belépve!";
    $premiumUserOnlyMessage = "Csak prémium felhasználók számára elérhető!";

    if(!$_SESSION['userObject']){
        session_start();
    }
    include_once('functions_userObj.php');
    include_once('translations_HUN.php');

    $userObject = $_SESSION['userObject'];
	$isAndroid = 0;
	if($userObject === NULL)
	{
		$userObject = 0;
	}

    require_once('functions_userObj.php');
    if($_REQUEST['actionType'] == 'login'){
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.gc_maxlifetime', 60 * 60);
        session_start();
        if(($_GET['h'] && ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObjByHash($_GET['h'])))
            || ($_SESSION['userObject'] = $GLOBALS['userObject'] = $userObject = getUserObj($_REQUEST['email'], $_REQUEST['username']))){
            if($userObject['status'] == 1){
                //print "<script>alert('El�fizet�sed m�g nem ker�lt aktiv�l�sra!');</script>";
            }
            else if($userObject['program_end_date'] >= date("Y-m-d 00:00:00")){
                $GLOBALS['welcomeText'] = true;
                $GLOBALS['userObject']['forras_nyelv'] = $_SESSION['userObject']['forras_nyelv'];
            }
            else{
                print "<script>alert('El�fizet�sed lej�rt, k�rlek l�pj kapcsolatba a program �zemeltet�j�vel!');</script>";
            }
        }
        else{
            print "<script>alert('A megadott felhasználó nem létezik!');</script>";
        }
    }

    if(!$userObject){
        if(isset($_GET["langChange"])){
            $defaultNyelv = (int)$_GET["langChange"];
            setcookie('preflanguage', $defaultNyelv);
        }
        else if($_COOKIE['preflanguage']){
            $defaultNyelv = (int)$_COOKIE['preflanguage'];
            setcookie('preflanguage', $defaultNyelv);
        }
    }

    $GLOBALS['nyelv'] = $nyelv = $userObject ? $userObject['nyelv'] : $defaultNyelv;
    include_once('functions.php');

    if($userObject)
        $_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);

    if($userObject && in_array($userObject['status'], array(4, 5, 6))){
        $isUserSuperior = true;
    }
    else{
        $isUserSuperior = false;
    }

    if($userObject){
        $list = getLevelList($userObject['nyelv']);
        $countList = getWordCountList($userObject['nyelv']);
        $packageRecords = getPackageRecords($userObject, 1);
        $packageRecordsSentences = getPackageRecords($userObject, 2);
        $packageRecordsBasicWords = getPackageRecords($userObject, 4);

        $goodLevelArray = array();
        $goodSentenceLevelArray = array();
        foreach($list as $key => $value){
            if($value[1] == 1 && $key != 0){
                $goodLevelArray[] = $key;
            }
            else if($value[1] == 2 && $key != 0){
                $goodSentenceLevelArray[] = $key;
            }
        }
        $countOwnWords = getOwnWordCount($userObject, $goodLevelArray);
        $countBasicWords = getBasicWordCount($userObject);
        $countOwnSentences = getOwnWordCount($userObject, $goodSentenceLevelArray);
    }

?>
