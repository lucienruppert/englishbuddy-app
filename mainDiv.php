<div id='mainDiv' style=<?php print "'position:absolute;top:" . $mainDivtop .";width:100%;text-align:left;" . $mainStyleText . "'"; ?>>
    <table border='0px' align='center'>
        <tr>
            <td valign='top' align='center'>
			<?php if($userObject) { ?>
                <table border='0' align='center' valign='top' cellspacing='0'>
                    <tr>
                        <td valign='top'  width='152' align='center' style=<?php print "'border-radius: 10px;padding: 20px 10px 20px 0;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="sajatSzavak();"><? print translate("increasevocabulary"); ?></a></td>
                        <td width='6'></td>
                        <td valign='top'  width='161' align='center' style=<?php print "'border-radius: 10px;padding: 20px 10px 20px 0;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="alapszokincs();"><? print translate("basicvocabulary"); ?></a></td>
                        <td width='6'></td>
                        <td valign='top'  width='161' align='center' style=<?php print "'border-radius: 10px;padding: 20px 10px 20px 0;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="peldamondatok();"><? print translate("tudastar"); ?></a></td>
                        <td width='6'></td>
                        <td valign='top'  width='161' align='center' style=<?php print "'border-radius: 10px;padding: 20px 10px 20px 0;background:" . $globalcolor . ";'"; ?>><a href='#' style='color:white;font-size:15pt;' onclick="intelligensGyakorlo()" ><? print translate("intelligensgyakorlo"); ?></a></td>
                    </tr>
                </table>
                <?php } ?>    
                <?php if($userObject && !in_array($userObject["status"], array(1, 2))){ ?>
                    <table border='0' align='left' valign='top' cellspacing='0' style='padding-top:10px'>
                        <tr>
                            <td height='40' width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a href='#' style='font-size:10pt;color:<?php print $highlight ?>;' onclick=<?php print $onclick1; ?> ><b><? print translate("sajat_mondatok_10"); ?></a></td>
                            <td width='6'></td>
                            <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a href='#' style='font-size:10pt;color:<?php print $highlight ?>;' onclick=<?php print $onclick4; ?> ><b><? print translate("sajat_mondat_szo"); ?></a></td>
                            <td width='6'></td>
                            <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a id="aTanuloszoba" href='#' style='font-size:10pt;color:<?php print $highlight ?>' title=<?php print "'" . translate("") . "'" ?> onclick=<?php print $onclick3; ?> ><b><? print translate("tanuloszoba"); ?></a></td>
                            <td width='6'></td>
                            <td width='161' align='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?>><a style='font-size:10pt;color:<?php print $highlight ?>' onclick="audioSzoba();" href="#"><b><? print translate("audioszoba"); ?></a></td>
                    </tr>
                    </table>
                <?php } ?>
            </td>
        </tr>
        <?php if($userObject) { ?>
        <!-- Legujabb szavak box -->
	    <tr>
		    <td valign='top' align='center' style='padding-top:10'>
                <table width='100% border='0' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
                    <tr>
                        <td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="legujjabbszavak"  href='#' style='color:white;font-size:12pt;'></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='3' valign='center' align='center' style=<?php print "'padding-bottom:10px;font-size:14pt;color:white;border-bottom: 1px solid " . $globalcolor . ";background:" . $globalcolor . ";'"; ?>>
                        <? print translate("legujabb_szavak"); ?>
                        </td>
                    </tr>
                    <tr>
                    <?php
                        print "<td valign='top' align='left' style='padding-left:250px;padding-top:10px;padding-bottom:10px;font-size:10pt;'><font color='grey'>";
                        $five_days_ago = strtotime('-5 days');
                        $five_days_formatted = date('Y-m-d', $five_days_ago);
                        if($userObject["forras_nyelv"] == 0 && $userObject["nyelv"] == 1) {
                            $updated_words = getLastFiveUpdatedWords($five_days_formatted);
                            foreach($updated_words as $row)
                            {
                                print("<p><b>".$row["word_angol"]."</b>&nbsp;-&nbsp;".$row["word_hun"]."</p>");
                            }
                        } ?>
			            </font></td>
			        </tr>
                </table>        
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td align='center' style='color:#000000;padding-top:10px;' style=<?php print $style; ?>>
            <?php if($userObject){ ?>
                <?php if(!in_array($userObject["status"], array(1, 2))){ ?>
                    <a href='#' onclick=<?php print $onclick2; ?> ><? print translate("kitolto"); ?></a>
                    &nbsp;&nbsp;.&nbsp;&nbsp;
                    <a href='#' onclick="tudastar();"><? print translate("tudastar_title"); ?></a>
                    &nbsp;&nbsp;.&nbsp;&nbsp;
                <?php } ?>
                    <a href='#' onclick="szotarFeltoltes();"><? print translate("feltoltes"); ?></a>
                    <?php if($userObject['status'] == 6){ ?>
                    &nbsp;&nbsp;.&nbsp;&nbsp;
                    <a href='#' onclick="location.href='main.php?content=wordCategorize&source=welcome'"><? print translate("kategorizalas"); ?></a>
                <?php }  ?>
            <?php }  ?>
            </td>
        </tr>
        <?php if($userObject){ ?>
        <tr>
            <td valign='top' align='center' style='padding-top:10'>
                <table border='0' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
                <tr><td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="SzorgalomMutato" title=<?php print "'" . translate("info_szorgalommutato") . "'" ?> href='#' style='color:white;font-size:12pt;'></a></td></tr>
                <tr><td colspan='3' valign='center' align='center' style=<?php print "'padding-bottom:10px;font-size:20pt;color:white;border-bottom: 1px solid " . $globalcolor . ";background:" . $globalcolor . ";'"; ?>>
                <? print translate("myperformance"); ?></td>
                </tr>
                <tr>
                <?php
                print "<td height='60' width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject, date('Y-m-d', strtotime("-2 days"))) : 0) . "</font><font size='2'><br>" . date('Y.m.d', strtotime("-2 days")) . "</td>";
                print "<td width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject, date('Y-m-d', strtotime("-1 days"))) : 0) . "</font><font size='2'><br>" . date('Y.m.d', strtotime("-1 days")) . "</td>";
                print "<td width='225' valign='top' align='center' style='padding-top:10px;font-size:14pt;'><font color='" . $globalcolor . "'>" . ($userObject ? getUserWordHitByDay($userObject) : 0) . "</font><font size='2'><br>" . date('Y.m.d') . "</td>";
                print "</tr></table>";
                ?>
            </td>
        </tr>
        <?php }  ?>
    </table>
</div>