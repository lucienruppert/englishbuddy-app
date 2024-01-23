<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
if ($_POST['actionType'] == 'firstVisit') {
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.gc_maxlifetime', 60 * 60);
}
if (!$_SESSION['userObject']) {
    session_start();
}

if (!$userObject && $_SESSION['userObject']) {
    $userObject = $_SESSION['userObject'];
}

include('functions.php');
if (!$userObject && $_SESSION['userObject']) {
    $userObject = $_SESSION['userObject'];
}
if (!$userObject) {
    include_once('index.php');
    exit;
}

$_SESSION['lastMessageUpdateTime'] = setUserTime($userObject, $_SESSION['lastMessageUpdateTime']);
?>


<HTML>

<HEAD>

    <meta http-equiv="X-UA-Compatible" content="IE=8"> <!-- IE8 mode -->
    <META HTTP-EQUIV='CHARSET' CONTENT='text/html; charset=ISO-8859-2'>
    <link rel="shortcut icon" type="image/x-icon" href="/images/lingocasa.ico">
    <?php ajaxTimerPrint(); ?>
</HEAD>
<style>
    #content {
        position: absolute;
        top: 57px;
        left: 0;
        z-index: 50;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    #welcome {
        position: absolute;
        top: 35px;
        left: 45%;
        margin-left: -400px;
    }

    .word-management {
        margin-top: 30px;
    }

    .word-management select {
        color: black;
    }

    textarea,
    input[type='text'] {
        background-color: <?php print $dark ?>;
    }

    input[type='text'] {
        border: none;
        border: 1px solid grey;
    }

    input[type='button'] {
        text-align: center;
        background-color: <?php print $dark ?>;
        border: 1px solid <?php print $highlight ?>;
        border-radius: 2px;
        padding: 2px 12px;
        cursor: pointer;
        letter-spacing: 2px;
        color: white;
        font-size: 11px;
    }

    /* .word-management * {
        border: 1px solid red;
    } */
</style>

<BODY>
    <?php
    include('menu.php');
    if ($GLOBALS['welcomeText']) {
        print "<div id='welcome'><span style='font-size:15pt;color:yellow'>Szia {$userObject['keresztnev']}!</span></div>";
    }
    ?>
    <div id="content">
        <?php
        switch ($_REQUEST['content']) {
            case 'wordLearning_old':
                $includeFile = 'wordLearning_old.php';
                break;
            case 'wordLearning_quick':
                $includeFile = 'wordLearning_quick.php';
                break;
            case 'wordLearning_list':
                $includeFile = 'wordLearning_list.php';
                break;
            case 'wordLearning_kikerdezo':
                $includeFile = 'wordLearning_kikerdezo.php';
                break;
            case 'createSentences':
                $includeFile = 'createSentences.php';
                break;
            case 'sentenceLearning':
                $includeFile = 'sentenceLearning.php';
                break;
            case 'igeragozas':
                $includeFile = 'igeragozas.php';
                break;
            case 'wordManagement':
                $includeFile = 'wordManagement.php';
                break;
            case 'wordManagementKitolto':
                $_REQUEST['kitolto'] = 1;
                $includeFile = 'wordManagement.php';
                break;
            case 'dictionary':
                $includeFile = 'dictionary.php';
                break;
            case 'logout':
                $includeFile = 'logout.php';
                break;
            case 'showRule':
                $includeFile = 'showRule.php';
                break;
            case 'clients':
                $includeFile = 'clients.php';
                break;
            case 'wordCategorize':
                $includeFile = 'wordCategorization.php';
                break;
            case 'changeLevelPage':
                $selectedLevel = $_REQUEST['selectedLevel'];
                $levelList = getLevelList($_SESSION['userObject']['nyelv']);
                if ($_REQUEST['clickSource'] == "sentencePractice2") {
                    $goodArray = array(2);
                } else {
                    $goodArray = array(1, 2, 3);
                }

                if (in_array($selectedLevel, array_keys($levelList))) {
                    reset($levelList);
                    while (current($levelList) && key($levelList) != $selectedLevel) {
                        next($levelList);
                    }
                    if ($_REQUEST['direction'] == 'next') {
                        while (next($levelList)) {
                            $goodOne = current($levelList);
                            if (!in_array($goodOne[1], $goodArray) || key($levelList) == '0') {
                                continue;
                            }
                            break;
                        }
                    }
                    if ($_REQUEST['direction'] == 'prev') {
                        while (prev($levelList)) {
                            $goodOne = current($levelList);
                            if (!in_array($goodOne[1], $goodArray) || key($levelList) == '0') {
                                continue;
                            }
                            break;
                        }
                    }
                    $_REQUEST['selectedLevel'] = $selectedLevel = key($levelList);
                    if ($goodOne[1] == 3) {
                        $includeFile = 'showRule.php';
                    } else if ($goodOne[1] == 2 || $goodOne[1] == 1) {
                        $includeFile = 'wordLearning_quick.php';
                    } else {
                        $includeFile = 'index.php';
                    }
                } else {
                    $includeFile = 'index.php';
                }
                break;
            default:
                print "<script>location.href='index.php';</script>";
                //$includeFile = 'welcomePage.php';
                exit;
        }

        if ($includeFile) {
            include($includeFile);
        }
        ?>
    </div>
</BODY>

</HTML>