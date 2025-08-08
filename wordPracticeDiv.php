<div id='wordPracticeDiv' style='background-color:#334155;position:absolute;top:80px;left:50%;margin-left:-165px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;border: 1px solid grey;'>
    <table border='0'>
        <tr>
            <td></td>
            <td align='right' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('wordPracticeDiv').style.display = 'none';" style=<?php echo "\"{$xSize}\"" ?>>&nbsp;X&nbsp;</a></td>
        </tr>
        <tr>
            <td colspan='3'>
                <div style=<?php echo "\"{$worddivSize}\"" ?>>
                    <table border='0' cellspacing='0' cellpadding='10'>
                        <?php
                        $partRowNumber = (int)($countOwnWords / $GLOBALS['szoPackageSize']);
                        if ($partRowNumber * $GLOBALS['szoPackageSize'] < $countOwnWords) {
                            $partRowNumber++;
                        }
                        $recordBg = 'color:white;';
                        $cellBlocks = array();

                        if (!$isAndroid) {
                            $mumusPrint = "<a style=\"color:white;white-space:nowrap;\" href='#' onclick=\"startPrintMumus();\">print</a>";
                        }

                        $cellBlocks[] = "<td style='{$recordBg}'><a style='{$worddivFontSize};color:white;white-space:nowrap;' href='#' onclick=\"lowerSelectOnChange('listAll', 'szo', 'wordPractice');\">" . translate("sajat_szavak_all") . "</a></td><td style='{$recordBg}'>&nbsp;</td><td style='{$recordBg}'>&nbsp;</td>";
                        $cellBlocks[] = "<td style='{$recordBg}'><a style='{$worddivFontSize};color:white;white-space:nowrap;' href='#' onclick=\"lowerSelectOnChange('mumus', 'szo', 'wordPractice');\">" . strtoupper(translate('mumus')) . "</a></td><td style='{$recordBg}'>&nbsp;</td>";

                        $forSortArray = array();
                        for ($i = 1; $i <= $partRowNumber; $i++) {
                            $text = $i . ". " . translate("csomag");
                            if ($packageRecords[$i]) {
                                $addText = "{$packageRecords[$i]['best_time']} " . translate("masodperc");
                            } else {
                                $addText = '';
                            }
                            $recordBg = 'color:white;';
                            if ($packageRecords[$i]['best_time'] > 0 && $packageRecords[$i]['best_time'] < $GLOBALS['szoPackageRecordMpLimit']) {
                                $recordBg .= 'background:' . $GLOBALS['szoPackageRecordBg'];
                            }
                            $cell = "
                <td style='{$recordBg}'><a href='#' style='{$worddivFontSize};color:white;white-space:nowrap;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'szo', 'wordPractice');\">{$text}</a></td>
                <td align='right' style='{$worddivFontSize};color:white;{$recordBg};white-space:nowrap;'>{$addText}</td>
                ";
                            if (!$isAndroid) {
                                $cell .= "<td style='{$recordBg}'>{$printLink}</td>
                    ";
                            }

                            if ($addText == '') {
                                $cellBlocks[] = $cell;
                            } else {
                                $forSortArray[] = array(
                                    'ido' => $packageRecords[$i]['best_time'] > 0 ? $packageRecords[$i]['best_time'] : 999999,
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