<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    session_start();

    include_once('functions.php');
    if(!$_SESSION['language']){
        $_SESSION['language'] = 'eng';
    }
    if(strlen($_GET['lang']) > 0){
        $_SESSION['language'] = $_GET['lang'];
        if($_GET['changeLanguage'] == 1){
            setcookie('preflanguage', $_GET['lang']);
            languageChanged();
        }
        if(!$_SESSION['language']){
            $_SESSION['language'] = 'eng';
        }
    }
    $record = getWordById($_REQUEST['id']);

    if($_SESSION['language'] == 'eng'){
        $title = $record['word_angol'];
        $imgSrc = "http://www.lingocasa.com/images/quiz_eng_.gif";
        $description = "How do you say it in Spanish? Click for the answer";
    }
    else if($_SESSION['language'] == 'hun'){
        $title = $record['word_hun'];
        $imgSrc = "http://www.lingocasa.com/images/quiz_hun_.gif";
        $description = "Hogy mondod angolul? Klikkelj a megold�shoz!";
    }
    else if($_SESSION['language'] == 'esp'){
        $title = $record['word_spanyol'];
        $imgSrc = "http://www.lingocasa.com/images/quiz_esp_.gif";
        $description = "&#191;C�mo se dice en ingl�s? Haz clic para la soluci�n";
    }
    $url = "www.lingocasa.com";

    /*
    $description = '&quot;' . trim(str_replace('"', '\'\'', $_SESSION['language'] == 'eng' ? strip_tags($record['concept_eng']) : strip_tags($record['concept']))) . '&quot;';
    $description = "" . $description;
    */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title>lingocasa</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
	<meta name="google-site-verification" content="lingocasa">
	<meta name="keywords" content="lingocasa">
	<meta property="og:title" content="<?php print $title; ?>" />
    <meta property="og:img" content="<?php print $imgSrc; ?>" />
    <meta property="og:image" content="<?php print $imgSrc; ?>" />
    <meta property="og:description" content="<?php print $description; ?>" />
    <meta property="og:url" content="<?php print $url; ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="/Image/site/favicon.ico">
	<script src="jquery-1.10.2.min.js"></script>
    <style>
        img{
    	   border:none;
        }
        .cardPicStyle {
            margin-right:15px;
            height:300px;
        }
    </style>
    <script>
        var lang = <?php print $lang; ?>;
        //location.href = 'http://www.lingocasa.com?langChange=' + lang;
        location.href = 'http://www.lingocasa.com/index.php?langChange=' + lang + '#quiz';    
    </script>
</head>
<body>
</body>