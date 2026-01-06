<div id='sentencePracticeDiv2' style='background-color:<?php print $dark ?>;position:absolute;top:90px;left:50%;margin-left:-200px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;border: 1px solid grey'>
    <?php error_log("===== sentencePracticeDiv2.php START ====="); ?>
    <form method='post' action='main.php'>
        <input type='hidden' name='content' value='wordLearning_quick'>
        <input type='hidden' name='packageStart' value='1'>
        <input type='hidden' name='selectedLevel' value=''>
        <input type='hidden' name='source' value='tananyag'>
        <input type='hidden' name='clickSource' value='sentencePractice2'>
        <input type='hidden' name='actionType' value='multiPractice'>
        <table border='0'>
            <tr>
                <td><input type='submit' style='position:relative;float:right;' value='Vegyes'></td>
                <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('sentencePracticeDiv2').style.display = 'none';" style='font-size:17;font-weight:bold;color:white'>X</a></td>
            </tr>
            <tr>
                <td colspan='2'>
                    <div id='peldamondatokDiv' style=<?php echo "\"{$worddivSize}\"" ?>>
                        <table>
                            <tr>
                                <td style=<?php print "'vertical-align:top;"; ?>>
                                    <table cellspacing='0' cellpadding='10' border='0'>
                                        <tr>
                                            <?php
                                            error_log("sentencePracticeDiv2.php: list size = " . count((array)$list));
                                            error_log("sentencePracticeDiv2.php: countList size = " . count((array)$countList));
                                            $i = 1;
                                            $isLink = ($userObject['max_level'] > 0);
                                            $cellBlocks = array();
                                            $cellText = '';
                                            $countAll = 0;

                                            foreach ((array)$list as $key => $value) {
                                                if (in_array($value[1], array(1, 2)) && $key > 0) {
                                                    if (in_array($value[1], array(1, 2))) {
                                                        $countAll += (int)$countList[$key];
                                                    }
                                                }
                                            }
                                            $_SESSION["AccessableTananyagLevels"] = array();
                                            foreach ((array)$list as $key => $value) {
                                                if (in_array($value[1], array(2)) && $key > 0) {
                                                    error_log("sentencePracticeDiv2.php: Processing level $key = " . $value[0] . ", type = " . $value[1]);
                                                    $text2 = "";
                                                    $text3 = "";
                                                    $style2Add = "";
                                                    if (in_array($value[1], array(1, 2))) {
                                                        $sorsz = $i++ . ".";
                                                        $style2Add .= "font-weight:bold";
                                                    }
                                                    $text2 .= "{$value[0]}";
                                                    if (in_array($value[1], array(1, 2))) {
                                                        $text3 = (int)$countList[$key];
                                                    }
                                                    $text3Html = "<span style='font-size:14;color:white;'>({$text3})</span>";
                                                    $cellText = "<td align='right' style='font-size:14;color:white;font-weight:bold;white-space:nowrap;'>{$sorsz}</td>";
                                                    if ($isLink) {
                                                        // VEGYES
                                                        $cellText .= "<td>
                                                    <input type='checkbox' name='cbMultiPractice[]' value='$key'>
                                                    <a href='#' style='font-size:14;color:white;$style2Add;margin-top:10px;' onclick=\"lowerSelectOnChange('{$key}', 'tananyag', 'sentencePractice2');\">{$text2}</a>
                                                    {$text3Html}
                                                    </td>";
                                                        // VEGYES
                                                        $_SESSION["AccessableTananyagLevels"][] = $key;
                                                    } else {
                                                        $cellText .= "<td style='font-size:14;color:grey;$style2Add;>{$text2}{$text3Html}</td>";
                                                    }
                                                    if ($userObject['max_level'] == $key) {
                                                        $isLink = false;
                                                    }
                                                    $cellBlocks[] = $cellText;
                                                }
                                            }
                                            printCellBlocks($cellBlocks, $columnNumber);
                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
    </form>
</div>
</div>