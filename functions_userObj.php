<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

//php7 hiányzó funkciói
include_once('./php7/mysql_replacement.php');
include_once('./php7/ereg-functions.php');

// Try database connection with error handling
$db_host = '185.65.68.10'; // Remote database IP address
$db_user = 'englishb_admin';
$db_pass = 'klyIrNNauZ2K*2W1';

$conn = @mysql_connect($db_host, $db_user, $db_pass);
if (!$conn) {
    die("Connection failed: " . mysql_error() . "\n" .
        "Error details:\n" .
        "- Attempted to connect to: " . $db_host . "\n" .
        "- Make sure the host is correct in cPanel > Remote MySQL\n" .
        "- Make sure this server's IP is allowed in Remote MySQL Access Hosts");
}

// Try selecting database
if (!@mysql_select_db('englishb_learning_app')) {
    die("Database selection failed: " . mysql_error());
}

// Try setting character set
if (!@mysql_query("SET NAMES 'latin2'")) {
    die("Setting character set failed: " . mysql_error());
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
