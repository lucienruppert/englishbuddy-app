<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
error_reporting(0);
session_start();
$_SESSION['language'] = 'hun';
$lang = 0;
$mainUrl = "http://www.lingocasa.com/showDailyQuizHun.php";
include('showDailyQuiz.php');
