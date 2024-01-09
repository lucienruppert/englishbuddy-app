<?php

include_once('functions.php');

    $query = "select word_hun from words w
                where w.word_hun regexp '.*\\n.*'";


    $result = mysql_query($query);
    if(!$result){
        print mysql_error();
        return false;
    }

    $limit = 20;
    $i = 0;
    while($row = mysql_fetch_assoc($result)){
        //deb($row);
        $i++;
     /*
        if($i > $limit){
            print "TÚL SOK REKORD!";
            break;
        }
    */
    }
    print $i;

    /*
    $query = "update words set word_hun = trim(word_hun), word_arab = trim(word_arab), word_angol = trim(word_angol), word_spanyol = trim(word_spanyol), word_nemet = trim(word_nemet), word_francia = trim(word_francia)";


    $result = mysql_query($query);
    if(!$result){
        print mysql_error();
        return false;
    }
      */
?>