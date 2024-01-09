<?php

    $list = getLevelList($userObject['nyelv']);
    $countList = getWordCountList($userObject['nyelv']);

    print "<script>var level3Array = [];";
    $i = 0;
    foreach($list as $key => $value){
        if($value[1] == 3 && $key > 0){
            print "level3Array[{$i}] = '{$key}';";
            $i++;
        }
    }
?>
    function lowerSelectOnChange(val)
    {
        if(level3Array.indexOf(val.toString()) > -1){
            location.href='main.php?content=showRule&selectedLevel=' + val;
        }
        else{
            location.href='main.php?content=wordLearning_quick&selectedLevel=' + val;
        }
    }

    </script>
<?php

    print "<div id='level_list'>";

    print "<table border=0 width='770' cellpadding='5'>";
    print "<tr><td height='40'></td></tr>";

    print "<tr><td align='center' valign='top' style='color:#F62817;font-size:35pt;background-color:white;'>
            <b>Alkoss mondatokat!</td></tr>";
    print "<tr><td align='center' valign='top' style='color:#F62817;font-size:15pt;background-color:white;'>
            Töltsd fel a szótáradat!</td></tr>";
    print "<tr><td valign='top' align='center' height=80>
            <input type='button' value='Start' onclick=\"document.onclick=null;location.href='main.php?content=wordManagement'\"></td>
            </tr>";

    print "<tr><td align='center' valign='top' style='color:#8D38C9;font-size:30pt;background-color:white;'>
            <b>Tanulj szavakat!</td></tr>";
    print "<tr><td align='center' valign='top' style='color:#8D38C9;font-size:15pt;background-color:white;'>
            Írj velük példákat!</td></tr>";
    print "<tr><td valign='top' align='center' height=100>
            <select name='levelSelection1' onchange=\"location.href='main.php?content=wordLearning_quick&selectedLevel=' + this.value;\">
            <option value=''>Válassz fajtát!
            <option value='list1'>Összes";
    $i = 1;
    foreach($list as $key => $value){
        if($value[1] == 1 && $key > 0){
            print "\n<option value='{$key}'>" . $i++ . ". {$value[0]} (" . (int)$countList[$key] . ")";
        }
    }
    print "</select></td></tr>";

    print "<tr><td align='center' valign='top' style='color:#4AA02C;font-size:20pt;background-color:white;'>
            <b>Gyakorold a nyelvtant</td></tr>";
    print "<tr><td align='center' valign='top' style='color:#4AA02C;font-size:15pt;background-color:white;'>
            egyszerû lépésekben!</td></tr>";
    print "<tr></td><td valign='top' align='center'>
            <select name='levelSelection2' onchange='selectedValue=this.value;lowerSelectOnChange(this.value);'>
            <option value=''>Válassz szintet!
            <option value='list2'>Összes";
    $i = 1;
    foreach($list as $key => $value){
        if(($value[1] == 2 || $value[1] == 3) && $key > 0){
            print "\n<option value='{$key}'>" . $i++ . ". {$value[0]} (" . (int)$countList[$key] . ")";
        }
    }
    print "</select></td></tr>";

    print "</table>";
    print "</div>";
?>