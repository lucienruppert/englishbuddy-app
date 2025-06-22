<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
error_reporting(0);
session_start();
$_SESSION['language'] = 'eng';
$lang = 1;
$mainUrl = "http://www.lingocasa.com/showDailyQuizEng.php";
include('showDailyQuiz.php');
