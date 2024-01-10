<?php
//php7 hiÃ¡nyzÃ³ funkciÃ³i
    include_once('./php7/mysql_replacement.php');
    include_once('./php7/ereg-functions.php');

mysql_connect ('mysql.luciendelmar.com','luciendelmar','9CUiNwYzV3');
mysql_select_db('luciendelmar');
mysql_query("SET NAMES 'latin2'");

function getUserObj($email, $username)
{
    if(strlen($username) == 0 || strlen($email) == 0){
        return false;
    }
    $email = aposztrofRepToDb($email);
    $username = aposztrofRepToDb($username);

    $query = "SELECT * from lmjelentkezok where email = '$email' and jelszo = '$username'";
    $result = mysql_query($query);
    if(!$result){
        print mysql_error();
        exit("Nem sikerült: " . $query);
    }
    $userObject = false;
    while($row = mysql_fetch_assoc($result)) {
        $userObject = $row;
    }
    if($userObject && $userObject['program_end_date'] >= date("Y-m-d 00:00:00")){
        $sql = "update lmjelentkezok set last_login_date = now() where id = " . $userObject['id'];
        $result = mysql_query($sql);
        if(!$result){
            print mysql_error();
            exit("Nem sikerült: " . $sql);
        }
    }
    return $userObject;
}

function getUserObjByHash($hash)
{
    if(strlen($hash) == 0){
        return false;
    }
    $hash = aposztrofRepToDb($hash);

    $query = "SELECT * from lmjelentkezok where hash = '$hash'";
    $result = mysql_query($query);
    if(!$result){
        print mysql_error();
        exit("Nem sikerült: " . $query);
    }
    $userObject = false;
    while($row = mysql_fetch_assoc($result)) {
        $userObject = $row;
    }
    if($userObject && $userObject['program_end_date'] >= date("Y-m-d 00:00:00")){
        $sql = "update lmjelentkezok set last_login_date = now() where id = " . $userObject['id'];
        $result = mysql_query($sql);
        if(!$result){
            print mysql_error();
            exit("Nem sikerült: " . $sql);
        }
    }
    return $userObject;
}

function getUserObjById($id)
{
    if(strlen($id) == 0){
        return false;
    }

    $query = "SELECT * from lmjelentkezok where ID = '$id'";
    $result = mysql_query($query);
    if(!$result){
        print mysql_error();
        exit("Nem sikerült: " . $query);
    }
    $userObject = false;
    while($row = mysql_fetch_assoc($result)) {
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

?>