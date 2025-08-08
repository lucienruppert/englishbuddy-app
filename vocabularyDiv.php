<div id='vocabularyDiv' style='background-color:#334155;position:absolute;top:100px;left:50%;margin-left:-180px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;border: 1px solid grey;'>
    <table border='0'>
        <tr>
            <td></td>
            <td></td>
            <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style="background:#334155;"><a href='#' onmouseover="document.getElementById('vocabularyDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>&nbsp;X&nbsp;</a></td>
        </tr>
        <tr>
            <td colspan='3'>
                <div style=<?php echo "\"{$worddivSize}\"" ?>>
                    <table border='0' width='330' cellspacing='0' cellpadding='10'>
                        <?php
                        $partRowNumber = (int)($countBasicWords / $GLOBALS['szoPackageSize']);
                        if ($partRowNumber * $GLOBALS['szoPackageSize'] < $countBasicWords) {
                            $partRowNumber++;
                        }
                        $cellBlocks = array();
                        $forSortArray = array();
                        for ($i = 1; $i <= $partRowNumber; $i++) {
                            $text = $i . ". " . translate("csomag");
                            if ($packageRecordsBasicWords[$i]) {
                                $addText = "{$packageRecordsBasicWords[$i]['best_time']} " . translate("masodperc");
                            } else {
                                $addText = '';
                            }
                            $recordBg = '';
                            if ($packageRecordsBasicWords[$i]['best_time'] > 0 && $packageRecordsBasicWords[$i]['best_time'] < $GLOBALS['szoPackageRecordMpLimit']) {
                                $recordBg = 'background-color:' . $GLOBALS['szoPackageRecordBg'];
                            }
                            $cell = "
                <td style='{$recordBg}'><a href='#' style='{$worddivFontSize};white-space:nowrap;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'alapSzo', 'basicWordPractice');\">{$text}</a></td>
                <td align='right' style='{$worddivFontSize};{$recordBg};white-space:nowrap;'>{$addText}</td>
                ";

                            if ($addText == '') {
                                $cellBlocks[] = $cell;
                            } else {
                                $forSortArray[] = array(
                                    'ido' => $packageRecordsBasicWords[$i]['best_time'] > 0 ? $packageRecordsBasicWords[$i]['best_time'] : 999999,
                                    'cell' => $cell
                                );
                            }
                        }
                        $forSortArray = array_sort($forSortArray, 'ido', SORT_DESC);

                        for ($i = 0; $i < count($forSortArray); $i++) {
                            $cellBlocks[] = $forSortArray[$i]['cell'];
                        }
                        printCellBlocks($cellBlocks, $columnNumberWords);
                        ?>
        </tr>
    </table>
    </td>
    </tr>
    </table>
</div>