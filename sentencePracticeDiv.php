<div id='sentencePracticeDiv' style='background-color:<?php print $dark ?>;position:absolute;top:90px;left:50%; margin-left:-200px;filter:alpha(opacity=100);opacity:1;z-index:99;display:none;border: 1px solid grey''>
    <table border=' 0'>
    <tr>
        <td></td>
        <td align='center' width=<?php echo "\"{$xWidth}\"" ?> style=<?php print "'background:" . $globalcolor . "'"; ?>><a href='#' onmouseover="document.getElementById('sentencePracticeDiv').style.display = 'none';" style='font-size:17;font-weight:bold;color:white'>X</a></td>
    </tr>
    <tr>
        <td colspan='2'>
            <div style=<?php echo "\"{$worddivSize}\"" ?>>
                <table border='0' width='330' cellspacing='0' cellpadding='10'>
                    <?php
                    $lev1count = 0;
                    //print "<option value='list2'>�sszes";
                    $partRowNumber = (int)($countOwnSentences / $GLOBALS['mondatPackageSize']);
                    if ($partRowNumber * $GLOBALS['mondatPackageSize'] < $countOwnSentences) {
                        $partRowNumber++;
                    }
                    $cellBlocks = array();
                    $forSortArray = array();
                    for ($i = 1; $i <= $partRowNumber; $i++) {
                        //$text = (($i - 1) * $GLOBALS['mondatPackageSize'] + 1) . " - " . ($i * $GLOBALS['mondatPackageSize']);
                        $text = $i . ". " . translate("csomag");
                        if ($packageRecordsSentences[$i]) {
                            $addText = "{$packageRecordsSentences[$i]['best_time']} " . translate("masodperc");
                        } else {
                            $addText = '';
                        }
                        $recordBg = 'color:' . $globalcolor . ' !important;';
                        if ($packageRecordsSentences[$i]['best_time'] > 0 && $packageRecordsSentences[$i]['best_time'] < $GLOBALS['mondatPackageRecordMpLimit']) {
                            $recordBg .= 'background-color:' . $GLOBALS['mondatPackageRecordBg'];
                        }
                        $printLink = '';
                        //        if(in_array($userObject['status'], array(6))){
                        $printLink = " <a href='#' style=\"color:white;\" onclick=\"window.open('printViewSent.php?source=mondat&pkg=listFract_{$i}','Mondatok','fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')\">print</a>";
                        //        }

                        $cell = "<td style='{$recordBg}'><a href='#' style='font-size:14;color:white;' onclick=\"lowerSelectOnChange('listFract_{$i}', 'mondat', 'sentencePractice');\">{$text}</a></td>
                        <td align='right' style='font-size:14;color:grey;{$recordBg};white-space:nowrap;'>{$addText}</td>";

                        if (!$isAndroid) {
                            $cell .= "<td style='{$recordBg}'>{$printLink}</td>
                    ";
                        }
                        $cell .= "</tr>";

                        if ($addText == '') {
                            $cellBlocks[] = $cell;
                        } else {
                            $forSortArray[] = array(
                                'ido' => $packageRecordsSentences[$i]['best_time'] > 0 ? $packageRecordsSentences[$i]['best_time'] : 999999,
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
                </table>
        </td>
    </tr>
    </table>
</div>