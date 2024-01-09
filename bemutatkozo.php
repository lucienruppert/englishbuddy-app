    <!-- LUCIEN DEL MAR KÉPES CUCC - EREDETI -->
    <table border='0' cellspacing='0px' cellpadding='0px' width='100%' style='background: rgba(36, 78, 117,1);'>

          <tr><td height='324' <?php if($isAndroid){} else{ ?> background='http://www.luciendelmar.com/images/lucien10.gif'  style='background-size:216px 324px;background-repeat:no-repeat;background-position:right;cursor:default;' <?php } ?>
          rowspan='100%'  align='right' width=<?php print $menuWidthPerc ?>><?php if($isAndroid){ ?><img src='images/lucien10.gif' height=<?php print $picHeight ?> style='cursor:default;'> <?php } else{ } ?>
          </td>

          <td valign='center' style=<?php print "'font-size:" . $titleSizeBig . ";line-height:150%;padding-left:40px;padding-right:20px;color:#fafafa;'"; ?>>
          <b><?php print translate('welcome_title2'); ?></b>
          </td></tr>

          <?php if($isAndroid){ } else{ ?>
              <tr><td valign='bottom' align='left' style=<?php print "'font-size:" . $maintextSize3 . ";padding-bottom:20px;padding-left:40px;color:#FAFAFA;'"; ?>>
          <?php print translate('countries_list'); ?>
          </td>
          <?php  } ?>
          </tr>

    </table>

    <!-- GONDOLATÉBRESZTÕ CSALI MONDAT -->
    <table border='0' cellspacing='0px' cellpadding='20px' width='100%' style=<?php print "'padding-bottom:" . $paddingbottom . ";background: rgba(250, 250, 250,1);'"; ?>>

          <tr>
          <td align='center'  valign='center' style=<?php print "'padding-top:30px;font-size:" . $titleSizeBig . ";color:#244e75;'"; ?>>
          <?php print translate('napigondolat_intro'); ?>
          </td></tr>

          <tr><td valign='top' align='center' style=<?php print "'padding-top:" . $paddingSize4 . "'"; ?> >
              <a class="button" href="#subscribe">
              <table align='center' border='0'><tr>
              <td height=<?php print $iapplyHeight ?> width=<?php print $iapplyWidth ?> valign='center' align='center' style='cursor:pointer;background: rgba(67, 198, 219,1);'>
              <font color='#fafafa' size=<?php print $menuFontSize3 ?> ><b><?php print translate('start'); ?></b>
              </td></tr></table></a>
          <br></td></tr>
    </table>

    <!-- NAPI GONDOLATÉBRESZTÕ ISMERTETÕ: ANDROID -->
    <?php if($isAndroid){  ?>

    <table border='0' id="subscribe" cellspacing='0px' cellpadding='0px' width='100%' style='background: rgba(232, 232, 232,1);'>

          <tr>
          <td colspan='100%' height='20%' align='center' valign='top' style=<?php print "'padding-top:30px;font-size:" . $titleSize2 . ";color:#000000;'"; ?>>
          <b><?php print translate('napigondolat_subtitle'); ?></b>
          </td></tr>

          <tr><td colspan='100%' height='80%'  align='center' valign='top' style=<?php print "'font-size:" . $titleSizeBig . ";padding-top:10px;color:#00B6BE;'"; ?>>
          <b><?php print translate('napigondolat_title'); ?></b>
          </td></tr>

          <tr><td colspan='100%' height='80%'  align='center' valign='top' style='padding-top:40px;padding-bottom:40px;'><img src='images/suncoffee.jpg' height=<?php print $picHeight ?>
          </td></tr>

          <tr><td width=<?php print $inDent ?>>&nbsp;</td><td align='center' valign='top' style=<?php print "'padding-top:40px;font-size:" . $titleSizeMini . ";color:#000000;'"; ?>>
          <?php print translate('napigondolat_text'); ?></td><td width=<?php print $inDent ?>>&nbsp;</td></tr>

          <tr><td width=<?php print $inDent ?>>&nbsp;</td><td align='left' valign='top' style=<?php print "'padding-top:40px;font-size:" . $titleSizeMini . ";color:#000000;'"; ?>>
          &hearts; <?php print translate('napigondolat_text_1'); ?></td><td width=<?php print $inDent ?>>&nbsp;</td></tr>

          <tr><td width=<?php print $inDent ?>>&nbsp;</td><td align='left' valign='top'  style=<?php print "'padding-top:40px;font-size:" . $titleSizeMini . ";color:#000000;'"; ?>>
          &hearts; <?php print translate('napigondolat_text_2'); ?></td><td width=<?php print $inDent ?>>&nbsp;</td></tr>

          <tr><td width=<?php print $inDent ?>>&nbsp;</td><td align='left' valign='top'  style=<?php print "'padding-top:40px;font-size:" . $titleSizeMini . ";color:#000000;'"; ?>>
          &hearts; <?php print translate('napigondolat_text_3'); ?></td><td width=<?php print $inDent ?>>&nbsp;</td></tr>

          <tr><td width=<?php print $inDent ?>>&nbsp;</td><td align='center' valign='top'  style=<?php print "'padding-top:40px;font-size:" . $titleSizeMini . ";padding-left:20px;padding-right:20px;color:#000000;'"; ?>>
          <?php print translate('napigondolat_text_more'); ?></td><td width=<?php print $inDent ?>>&nbsp;</td></tr>

          <tr><td colspan='100%' valign='top' align='center' style=<?php print "'padding-top:" . $paddingSize3 . "'"; ?> >
              <a href="http://www.luciendelmar.com/index.php?content=subscribe">
              <table align='center' border='0'><tr>
              <td height=<?php print $iapplyHeight ?> width=<?php print $iapplyWidth2 ?> valign='center' align='center' style='cursor:pointer;background: rgba(67, 198, 219,1);'>
              <font color='#fafafa' size=<?php print $menuFontSize3 ?> ><b><?php print translate('tetszik'); ?></b>
              </td></tr></table></a><br><br><br><br><br><br>
          </td></tr>
    </table>

    <?php } else{ ?>
    <!-- NAPI GONDOLATÉBRESZTÕ ISMERTETÕ: WEB -->
    <table border='0' id="subscribe" cellspacing='0px' cellpadding='0px' width='100%' style='background: rgba(232, 232, 232,1);'>

          <tr>
          <td colspan='100%' height='20%' align='center' valign='top' style=<?php print "'padding-top:30px;font-size:" . $titleSize2 . ";color:#000000;'"; ?>>
          <b><?php print translate('napigondolat_subtitle'); ?></b>
          </td></tr>

          <tr><td colspan='100%' height='80%'  align='center' valign='top' style=<?php print "'font-size:" . $titleSizeBig . ";padding-top:10px;color:#00B6BE;'"; ?>>
          <b><?php print translate('napigondolat_title'); ?></b>
          </td></tr>

          <tr><td width=<?php print $inDent ?>></td><td colspan='2' align='center' valign='top'  style=<?php print "'line-height:200%;font-size:" . $titleSize . ";padding-left:20px;padding-right:20px;padding-top:10px;color:#000000;'"; ?>>
          <?php print translate('napigondolat_text'); ?></td><td width=<?php print $inDent ?>></td></tr>

          <tr><td width=<?php print $inDent ?>></td>
          <td  rowspan='3'><img src='images/suncoffee.jpg' height=<?php print $picHeight ?> style='padding-top:20px;padding-right:20px;cursor:default;'></td>
          <td align='left' valign='top'  style=<?php print "'line-height:200%;padding-top:20px;font-size:" . $titleSize . ";color:#000000;'"; ?>>
          &hearts; <?php print translate('napigondolat_text_1'); ?></td>
          <td  rowspan='3' width=<?php print $inDent ?>></td></tr>

          <tr><td width=<?php print $inDent ?>></td><td align='left' valign='top'  style=<?php print "'line-height:200%;padding-top:10px;font-size:" . $titleSize . ";color:#000000;'"; ?>>
           &hearts; <?php print translate('napigondolat_text_2'); ?></td></tr>

          <tr><td width=<?php print $inDent ?>></td><td align='left' valign='top'  style=<?php print "'line-height:200%;padding-top:10px;font-size:" . $titleSize . ";color:#000000;'"; ?>>
          &hearts; <?php print translate('napigondolat_text_3'); ?></td></tr>

          <tr><td width=<?php print $inDent ?>></td><td colspan='2' align='center' valign='top'  style=<?php print "'line-height:200%;padding-top:20px;font-size:" . $titleSize . ";padding-left:20px;padding-right:20px;color:#000000;'"; ?>>
          <?php print translate('napigondolat_text_more'); ?></td><td width=<?php print $inDent ?>></td></tr>

          <tr><td colspan='100%' valign='top' align='center' style='padding-top:10px;'>
              <a href="http://www.luciendelmar.com/index.php?content=subscribe">
              <table align='center' border='0'><tr>
              <td height=<?php print $iapplyHeight ?> width=<?php print $iapplyWidth2 ?> valign='center' align='center' style='cursor:pointer;background: rgba(67, 198, 219,1);'>
              <font color='#fafafa' size=<?php print $menuFontSize3 ?> ><b><?php print translate('tetszik'); ?></b>
              </td></tr></table></a><br><br><br><br><br><br>
          </td></tr>
    </table>
    <?php  } ?>

<!--

<table border='0' height='400' background='http://www.luciendelmar.com/images/covergroup.jpg' cellspacing='0px' cellpadding='0px' width='100%' >
<tr>
<td align='center' height='70%' valign='bottom' style=<?php print "'font-size:" . $titleSizeBig . ";color:#00B6BE;'"; ?>>
<?php print translate('welcome_title2'); ?>
</td>
</tr>
<tr>
<td align='center' valign='top' style=<?php print "'padding-top:10px;font-size:" . $titleSize2 . ";color:#000000;'"; ?>>
<?php print translate('welcome_title1'); ?>
</td>
</tr>
<tr>
<td align='center'>
    <table align='center'><tr>
    <td height='35' width=<?php print $iapplyWidth ?> valign='center' align='center' style='border-radius:10px;padding-bottom:4px;font-size:14pt;background: rgba(1,85,147,0.8);'>
    <a class="button" href="#subscribe"><font color='#ffffff' size=<?php print $menuFontSize3 ?> ><?php print translate('start'); ?></a></td></tr></table>
</td>
</tr>
<tr>
<td valign='bottom' align='center' style=<?php print "'font-size:10px;color:#A4A4A4;'"; ?>>
<?php print translate('countries_list'); ?>
</td>
</tr>
</table>

<table border='0' height='361' align='center' background='http://www.luciendelmar.com/images/lucien10.jpg' style='background-repeat:no-repeat;background-position:center;' cellspacing='0px' cellpadding='0px' width='100%' >
<tr><td valign='bottom'>

    <table width='100%' style='background: rgba(250,250,250,0.7);'>
    <tr align='center'><td height='30%' valign='bottom' style=<?php print "'font-size:" . $titleSizeBig . ";padding-left:20px;padding-right:20px;color:#00B6BE;'background: rgba(250,250,250,1);'"; ?>
    <b><?php print translate('welcome_title2'); ?></b>
    </td></tr>

    <tr align='center'><td height='20%' valign='top' style=<?php print "'padding-top:10px;font-size:" . $titleSize2 . ";padding-left:20px;padding-right:20px;color:#000000;'"; ?>>
    <?php print translate('welcome_title1'); ?>
    </td></tr>

    <tr align='center'><td valign='bottom' align='left' style=<?php print "'font-size:" . $maintextSize3 . ";padding-bottom:40px;padding-left:20px;color:#A4A4A4;'"; ?>>
    <?php print translate('countries_list'); ?>
    </td></tr>
    </table>

</td></tr>
</table>

-->


