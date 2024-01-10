<div id='ajaxDiv' style=<?php print "'font-size:16pt;color:" . $globalcolor . ";" . $mainStyleText . "'"; ?>>
    <?php
        $langTitleArray = getLangTitles();
        $possibleLangs = array(0, 1, 2);
        $lang1 = $langTitleArray[$GLOBALS['nyelv']];
        for($i = 0; $i < count($possibleLangs); $i++){
            if($i == $GLOBALS['nyelv'])
                continue;
            if(!$lang2)
                $lang2 = $langTitleArray[$i];
            else
                $lang3 = $langTitleArray[$i];
        }
    ?>
    <?php include("ajaxSearch.php"); ?>
</div>