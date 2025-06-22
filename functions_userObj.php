<?php
// Only show errors for non-AJAX requests
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

//php7 hiányzó funkciói
include_once('./php7/mysql_replacement.php');
include_once('./php7/ereg-functions.php');

// Database connection configuration
$db_host = '185.65.68.10';
$db_user = 'englishb_admin';
$db_pass = 'klyIrNNauZ2K*2W1';

// Try database connection with error handling
try {
    $conn = @mysql_connect($db_host, $db_user, $db_pass);
    if (!$conn) {
        throw new Exception(mysql_error());
    }

    if (!@mysql_select_db('englishb_learning_app')) {
        throw new Exception(mysql_error());
    }

    if (!@mysql_query("SET NAMES 'latin2'")) {
        throw new Exception(mysql_error());
    }
} catch (Exception $e) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Database connection failed']));
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

function getUserObj($email, $username)
{
    if (strlen($username) == 0 || strlen($email) == 0) {
        return false;
    }
    $email = aposztrofRepToDb($email);
    $username = aposztrofRepToDb($username);

    $query = "SELECT * from lmjelentkezok where email = '$email' and jelszo = '$username'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $userObject = false;
    while ($row = mysql_fetch_assoc($result)) {
        $userObject = $row;
    }
    if ($userObject && $userObject['program_end_date'] >= date("Y-m-d 00:00:00")) {
        $sql = "update lmjelentkezok set last_login_date = now() where id = " . $userObject['id'];
        $result = mysql_query($sql);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $sql);
        }
    }
    return $userObject;
}

function getUserObjByHash($hash)
{
    if (strlen($hash) == 0) {
        return false;
    }
    $hash = aposztrofRepToDb($hash);

    $query = "SELECT * from lmjelentkezok where hash = '$hash'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $userObject = false;
    while ($row = mysql_fetch_assoc($result)) {
        $userObject = $row;
    }
    if ($userObject && $userObject['program_end_date'] >= date("Y-m-d 00:00:00")) {
        $sql = "update lmjelentkezok set last_login_date = now() where id = " . $userObject['id'];
        $result = mysql_query($sql);
        if (!$result) {
            print mysql_error();
            exit("Nem siker�lt: " . $sql);
        }
    }
    return $userObject;
}

function getUserObjById($id)
{
    if (strlen($id) == 0) {
        return false;
    }

    $query = "SELECT * from lmjelentkezok where ID = '$id'";
    $result = mysql_query($query);
    if (!$result) {
        print mysql_error();
        exit("Nem siker�lt: " . $query);
    }
    $userObject = false;
    while ($row = mysql_fetch_assoc($result)) {
        $userObject = $row;
    }
    return $userObject;
}

function aposztrofRepToDb($word)
{
    $word = str_replace("\\'", "'", $word);
    $word = str_replace("\\\"", "\"", $word);
    $word = str_replace("'", "''", $word);

    return $word;
}
