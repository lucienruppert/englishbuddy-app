<!-- NAPI KV?Z ?S A KEZD?K?P -->
<script>
    var facebookLinkHun = <?php print "\"https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.lingocasa.com%2FshowDailyQuizHun.php?id={$dailyQuiz['id']}\""; ?>;
    var facebookLinkEng = <?php print "\"https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.lingocasa.com%2FshowDailyQuizEng.php?id={$dailyQuiz['id']}\""; ?>;
    var facebookLinkEsp = <?php print "\"https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.lingocasa.com%2FshowDailyQuizEsp.php?id={$dailyQuiz['id']}\""; ?>;
</script>

<?php
if(!$userObject) {
if(!$isAndroid){ ?>

<div id='quiz'>
<table border='0' align='center'>

  <tr>
 <!--

  <td valign='top' align='center' style='padding-top:120;padding-left:80;'>
      <a href="#show" style='text-decoration:none;'><table><tr><td align='center' width='200' height='90' style=<?php print "'line-height:150%;border-radius: 10px 10px 10px 10px;padding:10px;font-size:14pt;background:" . $globalcolor . ";color:white'"; ?>><b>
      <? print translate("showmewhatitis"); ?></a></b></td></tr></table></a>
      </td>
-->
      <td align='center' style='padding-top:60;padding-bottom:20;'><img style="height:150" src="images/laptop.jpg"></td>
  </tr>

 <!--

  <tr>
      <td  colspan='2' valign='top' align='center'>

        <table border='0' align='center' valign='center' style=<?php print "'background: rgba(252,252,252);border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='5'>
          <tr>
              <td colspan='3' valign='center' align='center' style=<?php print "'font-size:16pt;border-bottom: 1px solid " . $globalcolor . ";color:" . $globalcolor . ";'"; ?>>
              <? print translate("napikviz"); ?></td>
          </tr>
          <tr>
              <td width='205' valign='top' align='center' style='font-size:12pt;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_angol"] ?></font><font size='2'><br>(<? print translate("angol1"); ?>)<br>
              </td>
              <td width='205' valign='top' align='center' style='font-size:12pt;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_spanyol"] ?></font><font size='2'><br>(<? print translate("spanyol1"); ?>)<br>
              </td>
              <td width='205' valign='top' align='center' style='font-size:12pt;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_hun"] ?></font><font size='2'><br>(<? print translate("magyar1"); ?>)<br>
              </td>
          </tr>
          <tr>
              <td valign='top' align='center'>
                  <a href="#" onclick="event.stopPropagation();window.open(facebookLinkEng,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                     <img src='images/fb_grey1.png' border='0' style='height:20px;'>
                     </a>
              </td>
               <td valign='top' align='center'>
                   <a href="#" onclick="event.stopPropagation();window.open(facebookLinkEsp,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                    <img src='images/fb_grey1.png' border='0' style='height:20px;'>
                </a>
              </td>
              <td valign='top' align='center'>
                  <a href="#" onclick="event.stopPropagation();window.open(facebookLinkHun,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                    <img src='images/fb_grey1.png' border='0' style='height:20px;'>
                </a>
              </td>
          </tr>
        </table>
       </td>
 </tr>

	<tr>
	   <td colspan='4' valign='top' align='center' style='padding-top:0'>
	   <table align='center' cellspacing='0px' cellpadding='0px' width='680px'>
		<tr>
			<td valign='center' align='center' style=<?php print "'padding-top:" . $Padding . ";padding-bottom:" . $Padding . ";border:1px solid white;background:" . $globalcolor . ";height:22px'"; ?>>
					   <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> onclick="goToRegistration()"><?php print translate('subscribe'); ?></a>
			 </td>
		</tr>
		</table>
	</tr>

-->

</table>
</div>

<!--

<?php 	}
  else
{ ?>

<div id='quiz'>
<br><table border='0' width='100%' align='center'>
  <tr>
      <td valign='top' align='center'>
        <table border='0' align='center' valign='center' style=<?php print "'border: 2px solid " . $globalcolor . ";'"; ?> cellpadding='10' cellspacing='0'>
          <tr>
              <td width='870' valign='center' align='center' style=<?php print "'padding-top:40px;padding-bottom:40px;font-size:60pt;background:" . $globalcolor . ";border-bottom: 1px solid " . $globalcolor . ";color:white;'"; ?>>
              <b><? print translate("napikviz"); ?></b></td>
          </tr>
          <tr>
              <td valign='top' align='center' style='font-size:40pt;padding-top:40px;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_angol"] ?>
          </tr>
          <tr>
              <td align='center' style='font-size:26pt;'>(<? print translate("angol1"); ?>)</td>
          </tr>
          <tr>
              <td valign='top' align='center'>
                  <a href="#" onclick="event.stopPropagation();window.open(facebookLinkEng,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                     <img src='images/fb_grey1.png' border='0' style='height:80px;'>
                     </a>
              </td>
          </tr>

          <tr>
              <td valign='top' align='center' style='font-size:40pt;padding-top:40px;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_spanyol"] ?>
          </tr>
          <tr>
              <td align='center' style='font-size:26pt;'>(<? print translate("spanyol1"); ?>)</td>
          </tr>
          <tr>
               <td valign='top' align='center'>
                   <a href="#" onclick="event.stopPropagation();window.open(facebookLinkEsp,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                    <img src='images/fb_grey1.png' border='0' style='height:80px;'>
                </a>
              </td>
          </tr>

          <tr>
              <td valign='top' align='center' style='font-size:40pt;padding-top:40px;'><font color=<?php print "'" . $globalcolor . "'"; ?>><?php print $dailyQuiz["word_hun"] ?>
          </tr>
          <tr>
              <td align='center' style='font-size:26pt;'>(<? print translate("magyar1"); ?>)</td>
          </tr>
          <tr>
              <td valign='top' align='center'>
                  <a href="#" onclick="event.stopPropagation();window.open(facebookLinkHun,'showDailyQuiz','height=300,width=600,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes')" style='color:#FFBF00;cursor:pointer;'>
                    <img src='images/fb_grey1.png' border='0' style='height:80px;'>
                </a>
              </td>
          </tr>
        </table>
       </td>
  </tr>
</table>
</div>
-->
<?php }	} ?>

<!-- LINGOCASA LE?R?S A F?OLDALON -->

<!--

<?php if(!$userObject){ ?>
<div style='position:relative;'>
<table border='0' align='center' style='padding-top:60px;border: 1px solid white;' cellspacing='0px' cellpadding='0px'>
          <tr><td id="show" width=<?php print "" . $lcasa_column_percent . ""; ?>></td>
              <td  align='center' style=<?php print "'padding-bottom:30px;line-height:200%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
              <?php print translate('intro_1'); ?></td>
              <td width=<?php print "" . $lcasa_column_percent . ""; ?>></td>

          <tr><td></td><td>
          <table cellspacing='0' style="border-collapse:collapse;">
          <tr>
          <td width=<?php print "" . $lcasa_column1 . ""; ?>></td>
          <td width='200' align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:10px;line-height:150%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('service_alap'); ?></b><br><font size=3><?php print translate('service_free'); ?></font></td>
          <td width='200' align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:10px;line-height:150%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('service_premium'); ?></b><br><font size=3><?php print translate('service_fee'); ?></font></td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b>ANDROID APP<br><a target='blank' href="https://play.google.com/store/apps/details?id=com.happygames.kikerdezo"><img width='100' src="https://www.lingocasa.com/images/googleplay.png"></a></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;<br><font size=3><?php print translate('functions_some'); ?></font></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;<br><font size=3><?php print translate('functions_all'); ?></font></td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('quiz'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('searchbox'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('increasevocabulary2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('basicvocabulary2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('tudastar2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          </td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('intelligensgyakorlo2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          </td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>
         </table>
        </td><td></td></tr>

-->

<!--subscribe-->
        <tr><td colspan='3' height='20'></td></tr>
        <tr><td></td>
            <td valign='center' height='50' align='center' style=<?php print "background:" . $globalcolor . ";'padding-top:" . $Padding . ";padding-bottom:" . $Padding . "'"; ?>>
                <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> onclick="goToRegistration()"><?php print translate('iwilltryit'); ?></a>
            </td>
            <td></td>
       </tr>
<!--subscribe-->


</table>
</div>


<?php    } ?>

<!--

<?php if(!$userObject){ ?>
    <div>
    <table align='center' width='100%'>
    <tr><td align='center' valign='top' style='padding:10px;font-size:8pt;' colspan='100%'><font color='#000000'>2013 &copy; lingocasa

    <?php if($defaultNyelv == 0){
        print "&nbsp;&nbsp;-&nbsp;&nbsp;<a href='https://www.lingocasa.com/aszf.php' target='blank'>?SZF Adatv?delmi nyilatkozat</a>";
        }
        ?>

    </td></tr>
    </table>
    </div>
<?php }  ?>

-->

<!--
   <tr><td colspan='100%' valign='center' style='padding-bottom:20px;'><hr></hr></td></tr>

   <tr><td colspan='100%' valign='center' style='padding-bottom:5px;padding-top:10px;'><hr></hr></td></tr>

    <tr>
    <td  height='40' align='middle' valign='bottom' style='font-size:10pt;' colspan='100%'>
    <font color=<?php print"'" . $globalcolor . "'" ?>><b><?php print getAllWordCount(); ?></b></font>
    sz?val, kifejez?ssel ?s gyakorl?mondattal.
    </tr>

    <tr><td valign='top' colspan='100%' height='330' align='center'>

        <table style='border:1px solid gray;' cellspacing='0px' cellpadding='2px'>
            <tr><td  align='center' width='200' style=<?php print"'padding-top:15px;background:white;font-size:10pt;color:" . $globalcolor . ";'" ?>><b><? print translate("szotar"); ?></td></tr>
            <tr><td  align='center' width='200' style='padding-top:15px;background:white;font-size:10pt;'>
            <?php print getAllWordCount(); ?> <font size=2>sz?val, kifejez?ssel ?s mondattal
            </td></tr>
            <tr><td  align='center' style='background-color:white;'>
                 <table><tr><td style='background:white;border:1px solid gray;' width='160' height='25'>
                 </td></tr></table>
            </td></tr>
            <tr><td align='center' style='padding-bottom:10px;background-color:white;font-size:10pt;'>spanyol . angol</td></tr>
            <tr><td align='center' style='padding-top:15px;'><a href='#' style=<?php print"'color:" . $globalcolor . ";'" ?> onclick="sajatSzavak();"><? print translate("savedwords"); ?></a></td></tr>
            <tr><td align='center'>2233 <? print translate("words"); ?></td></tr>
            <tr><td align='center' style='padding-top:15px;'><a href='#' style=<?php print"'color:" . $globalcolor . ";'" ?> onclick="alapszokincs();"><? print translate("basicvocabulary"); ?></a></td></tr>
            <tr><td align='center'><a href='#' style='font-size:10;' onclick="alapszokincs();"><? print translate("basicwords"); ?></a></td></tr>
            <tr><td align='center' style='padding-bottom:15px;'><?php print $progressPct; ?>%</td></tr>
       </table>

    </td>
    </tr>
-->
<!--

<div id='DataDiv' style=<?php print "'border: 0px solid black;position:absolute;top:200px;left:50%;margin-left:-150px;width:300px;" . $mainStyleText . "'"; ?>>
<table border='1px' cellpadding='15' cellspacing='0' align='center'>
  <tr>
      <td valign='top' width='300'>
        <span id='lastlesson' style='font-size:11pt;color:#000000;'><b>
            <?php print translate('utoljara_vett_tananyag'); ?></b>
        </span>
        &nbsp;&nbsp;
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
            <?php
                if($userObject){
                    $list = getLevelList($nyelv);
                    $lastRule = '';
                    $selectedRule = '';
                    $i = 0;
                    $sorsz = '';
                    foreach($list as $key => $value){
                        if(in_array($value[1], array(1, 2, 3)) && $key > 0){
                            if($value[1] == 3){
                                $lastRule = $value[0];
                                $i++;
                            }
                            if($userObject && $userObject['max_level'] == $key){
                                $selectedRule = $lastRule;
                                $sorsz = $i . '. ';
                                break;
                            }
                        }
                    }
                    print $sorsz . $selectedRule;
                }
            ?>
            </span>
            <br><br>
            <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('felhasznalt_ido'); ?></b>
            </span>
           &nbsp;&nbsp;
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
                   <?php print $userObject ? getUsedTime($userObject['id']) : ""; ?>
                    </span>
           <br><br>
            <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('feladatok_kovetkezo_orara'); ?></b>
                        </span>
            <br><br>
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
            <?php
                print str_replace(chr(13) . chr(10), "<br>", $userObject['hazi_feladat']);;
            ?>
                    </span>
  </td>
                    <br><br>
                        <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('kovetkezo_ora'); ?></b>
                        </span>
                    <br><br>
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
                   <?php print substr($userObject['next_lesson'], 0, 16); ?>
                    </span>
  </tr></table>
</div>
-->

        <form name='submitForm' id='submitForm' action='main.php' method='post'>
        <input type='hidden' name='firstVisit' value='1'>
        <input type='hidden' name='content' value=''>
        </form>


<!--subscribe-->
<tr><td colspan='3' height='20'></td></tr>
        <tr><td></td>
            <td valign='center' height='50' align='center' style=<?php print "background:" . $globalcolor . ";'padding-top:" . $Padding . ";padding-bottom:" . $Padding . "'"; ?>>
                <a href='#' style=<?php print "'font-size:" . $ButtonFontSize . ";color:white;'"; ?> onclick="goToRegistration()"><?php print translate('iwilltryit'); ?></a>
            </td>
            <td></td>
       </tr>
<!--subscribe-->

<!--

<?php if(!$userObject){ ?>
    <div>
    <table align='center' width='100%'>
    <tr><td align='center' valign='top' style='padding:10px;font-size:8pt;' colspan='100%'><font color='#000000'>2013 &copy; lingocasa

    <?php if($defaultNyelv == 0){
        print "&nbsp;&nbsp;-&nbsp;&nbsp;<a href='https://www.lingocasa.com/aszf.php' target='blank'>?SZF Adatv?delmi nyilatkozat</a>";
        }
        ?>

    </td></tr>
    </table>
    </div>
<?php }  ?>

-->

<!--
   <tr><td colspan='100%' valign='center' style='padding-bottom:20px;'><hr></hr></td></tr>

   <tr><td colspan='100%' valign='center' style='padding-bottom:5px;padding-top:10px;'><hr></hr></td></tr>

    <tr>
    <td  height='40' align='middle' valign='bottom' style='font-size:10pt;' colspan='100%'>
    <font color=<?php print"'" . $globalcolor . "'" ?>><b><?php print getAllWordCount(); ?></b></font>
    sz?val, kifejez?ssel ?s gyakorl?mondattal.
    </tr>

    <tr><td valign='top' colspan='100%' height='330' align='center'>

        <table style='border:1px solid gray;' cellspacing='0px' cellpadding='2px'>
            <tr><td  align='center' width='200' style=<?php print"'padding-top:15px;background:white;font-size:10pt;color:" . $globalcolor . ";'" ?>><b><? print translate("szotar"); ?></td></tr>
            <tr><td  align='center' width='200' style='padding-top:15px;background:white;font-size:10pt;'>
            <?php print getAllWordCount(); ?> <font size=2>sz?val, kifejez?ssel ?s mondattal
            </td></tr>
            <tr><td  align='center' style='background-color:white;'>
                 <table><tr><td style='background:white;border:1px solid gray;' width='160' height='25'>
                 </td></tr></table>
            </td></tr>
            <tr><td align='center' style='padding-bottom:10px;background-color:white;font-size:10pt;'>spanyol . angol</td></tr>
            <tr><td align='center' style='padding-top:15px;'><a href='#' style=<?php print"'color:" . $globalcolor . ";'" ?> onclick="sajatSzavak();"><? print translate("savedwords"); ?></a></td></tr>
            <tr><td align='center'>2233 <? print translate("words"); ?></td></tr>
            <tr><td align='center' style='padding-top:15px;'><a href='#' style=<?php print"'color:" . $globalcolor . ";'" ?> onclick="alapszokincs();"><? print translate("basicvocabulary"); ?></a></td></tr>
            <tr><td align='center'><a href='#' style='font-size:10;' onclick="alapszokincs();"><? print translate("basicwords"); ?></a></td></tr>
            <tr><td align='center' style='padding-bottom:15px;'><?php print $progressPct; ?>%</td></tr>
       </table>

    </td>
    </tr>
-->


<!--

<div id='DataDiv' style=<?php print "'border: 0px solid black;position:absolute;top:200px;left:50%;margin-left:-150px;width:300px;" . $mainStyleText . "'"; ?>>
<table border='1px' cellpadding='15' cellspacing='0' align='center'>
  <tr>
      <td valign='top' width='300'>
        <span id='lastlesson' style='font-size:11pt;color:#000000;'><b>
        <?php print translate('utoljara_vett_tananyag'); ?></b>
        </span>
        &nbsp;&nbsp;
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
            <?php
                if($userObject){
                    $list = getLevelList($nyelv);
                    $lastRule = '';
                    $selectedRule = '';
                    $i = 0;
                    $sorsz = '';
                    foreach($list as $key => $value){
                        if(in_array($value[1], array(1, 2, 3)) && $key > 0){
                            if($value[1] == 3){
                                $lastRule = $value[0];
                                $i++;
                            }
                            if($userObject && $userObject['max_level'] == $key){
                                $selectedRule = $lastRule;
                                $sorsz = $i . '. ';
                                break;
                            }
                        }
                    }
                    print $sorsz . $selectedRule;
                }
            ?>
            </span>
            <br><br>
            <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('felhasznalt_ido'); ?></b>
            </span>
           &nbsp;&nbsp;
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
                   <?php print $userObject ? getUsedTime($userObject['id']) : ""; ?>
                    </span>
           <br><br>
            <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('feladatok_kovetkezo_orara'); ?></b>
                        </span>
            <br><br>
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
            <?php
                print str_replace(chr(13) . chr(10), "<br>", $userObject['hazi_feladat']);;
            ?>
                    </span>
  </td>
                    <br><br>
                        <span id='welcome' style='font-size:11pt;color:#000000;'><b>
                            <?php print translate('kovetkezo_ora'); ?></b>
                        </span>
                    <br><br>
        <span style=<?php print "'color:" . $globalcolor . "'"; ?>>
                   <?php print substr($userObject['next_lesson'], 0, 16); ?>
                    </span>
  </tr></table>
</div>
-->

<?php /*
        <span id='welcome' style=<?php echo "\"{$welcomeFontSize}\"" ?><b>
        <font color='#c8c8c8'>
        <br>
        <?php
            if($userObject)
                print getUserWordHit($userObject, false) . "-" . getUserWordHit($userObject, true); ?>
        </span><br>
        <span style='font-size:11pt;' <?php print $onclick; ?>><?php print $welcomeTextA; ?></span>
        <?php if($showFormSpan){ ?>
            <span id='welcomeTextFormSpan' style='display:none;'>
                <form method='post' action='index.php' id='welcomeTextForm'>
                    <textarea name='welcomeText' cols='50' rows='8'><?php print $welcomeText; ?></textarea>
                    <input type='hidden' name='welcomeTextSave' value='1'><br>
                    <input type='submit' value='Ment'>
                </form>
            </span>
      <?php } ?>
        </i>
*/ ?>

<?php if($userObject){ ?>
    <div>
    <table align='center' width='100%'>
    <tr><td align='center' valign='top' style='padding:10px;font-size:8pt;' colspan='100%'><font color='#000000'>2013 &copy; lingocasa

    <?php if($defaultNyelv == 0){
        print "&nbsp;&nbsp;-&nbsp;&nbsp;<a href='https://www.lingocasa.com/aszf.php' target='blank'>?SZF Adatv?delmi nyilatkozat</a>";
        }
        ?>

    </td></tr>
    </table>
    </div>
<?php }  ?>



<!-- LINGOCASA LE?R?S A F?OLDALON -->

<?php if(!$userObject){ ?>
<div style='position:relative;'>
<table border='0' align='center' style='padding-top:60px;border: 1px solid white;' cellspacing='0px' cellpadding='0px'>
          <tr><td id="show" width=<?php print "" . $lcasa_column_percent . ""; ?>></td>
              <td  align='center' style=<?php print "'padding-bottom:30px;line-height:200%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
              <?php print translate('intro_1'); ?></td>
              <td width=<?php print "" . $lcasa_column_percent . ""; ?>></td>

          <tr><td></td><td>
          <table cellspacing='0' style="border-collapse:collapse;">
          <tr>
          <td width=<?php print "" . $lcasa_column1 . ""; ?>></td>
          <td width='200' align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:10px;line-height:150%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('service_alap'); ?></b><br><font size=3><?php print translate('service_free'); ?></font></td>
          <td width='200' align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:10px;line-height:150%;font-size:" . $lcasa_font_subtitle . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('service_premium'); ?></b><br><font size=3><?php print translate('service_fee'); ?></font></td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b>ANDROID APP<br><a target='blank' href="https://play.google.com/store/apps/details?id=com.happygames.kikerdezo"><img width='100' src="https://www.lingocasa.com/images/googleplay.png"></a></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;<br><font size=3><?php print translate('functions_some'); ?></font></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;<br><font size=3><?php print translate('functions_all'); ?></font></td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('quiz'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('searchbox'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('increasevocabulary2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('basicvocabulary2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('tudastar2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          </td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>

          <tr>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:15px;font-size:" . $lcasa_font_text . ";color:" . $globalcolor . ";'"; ?>>
          <b><?php print translate('intelligensgyakorlo2'); ?></b></td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          </td>
          <td align='center' style=<?php print "'border: 1px solid " . $globalcolor . ";padding:5px;font-size:30px;color:" . $globalcolor . ";'"; ?>>
          &#10004;</td>
          </tr>
         </table>
        </td><td></td></tr>

</table>
</div>


<?php    } ?>


