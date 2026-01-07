<div id='knowledgeBaseDiv' style='background-color:white;position:absolute;top:120px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;'>
    <table border='0'>
        <tr>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('knowledgeBaseDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>X</a></td>
        </tr>
        <tr><td colspan='2'>

    <div style=<?php echo "\"{$knowledgeBaseDivHeight}\"" ?>>
    <table><tr><td style=<?php print "'vertical-align:top;background:" . $globalcolor . "'"; ?>>
        <table width=<?php echo "\"{$knowledgeBaseDivInnerWidth}\"" ?> cellspacing='0' cellpadding='10' border='0'>
        <?php
            $i = 1;
            $isLink = ($userObject['max_level'] > 0);
            $cellBlocks = array();
            $cellText = '';
            foreach($list as $key => $value){
                if(in_array($value[1], array(1, 2, 3)) && $key > 0){
                    $text2 = "&nbsp;&nbsp;";
                    $text3 = "";
                    $style2Add = "";
                    if(in_array($value[1], array(1, 2))){
                        $sorsz = '&nbsp;';
                        $text2 .= "";
                        /* $text2 .= "&nbsp;&nbsp;&#8627 ";  */
                    }
                    else{
                        $sorsz = $i++ . ".";
                        $style2Add .= "font-weight:bold";
                    }
                    $text2 .= "{$value[0]}";
                    if(in_array($value[1], array(1, 2))){
                        $text3 = (int)$countList[$key];
                    }
                    $cellText = "<td align='right' valign='top' style='{$knowledgeBaseDivFontSize};color:$globalcolor;background:white;font-weight:bold;white-space:nowrap;border:1px solid $globalcolor;'>{$sorsz}</td>";
                    if($text3 > 0){
                        $text3Html = " <span style='{$knowledgeBaseDivFontSize};color:white;'>({$text3})&nbsp;<span style='font-size:14;color:white;cursor:pointer;' onclick='startPrintLevel(\"{$key}\");'>(P)</span></span>";
                    }
                    else{
                        $text3Html = "";
                    }
                    if($isLink){
                        $cellText .= "<td style='border:1px solid white;'><a href='#' style='{$knowledgeBaseDivFontSize};color:white;$style2Add;' onclick=\"lowerSelectOnChange('{$key}', 'tananyag', 'knowledgeBase');\">{$text2}</a>{$text3Html}</td>";
                    }
                    else{
                        $cellText .= "<td style='{$knowledgeBaseDivFontSize};color:grey;$style2Add;border:1px solid white;'>{$text2}{$text3Html}</td>";
                    }
                    if($userObject['max_level'] == $key){
                        $isLink = false;
                    }
                    $cellBlocks[] = $cellText;
                }
            }
            printCellBlocks($cellBlocks, $columnNumber);
        ?>
        </table>
    </td></tr></table>
    </div>
    </td></tr></table>
</div>