<?php include_once('login.php'); ?>
<div id='mainDiv' style=<?php print "' . $mainStyleText . '"; ?>>
  <?php if ($userObject) { ?>
    <div class="navigation-mainDiv">
      <span class="welcome hello">
        <?php
        if ($userObject)
          print translate('szia') . "&nbsp;" . $userObject['keresztnev'] . "!";
        else
          print "";
        ?>
      </span>
      <span class='hamburger'><img src='images/hamburger.svg' width="30px" height="30px" onclick="toggleMenu();"></span>
      <span style="display:<?php echo $_SESSION['isShown'] ? 'none' : 'flex'; ?>" class="welcome submenu">
        <a href='#' class="medium-color" onclick="sajatSzavak();"><? print translate("increasevocabulary"); ?></a>
        <a href='#' class="medium-color" onclick="alapszokincs();"><? print translate("basicvocabulary"); ?></a>
        <a href='#' class="medium-color" onclick="peldamondatok();"><? print translate("tudastar"); ?></a>
        <a href='#' class="medium-color show-menu" onclick="intelligensGyakorlo()"><? print translate("intelligensgyakorlo"); ?></a>
      <?php } ?>
      <?php if ($userObject && !in_array($userObject["status"], array(1, 2))) { ?>
        <a href='#' class="medium-color" onclick=<?php print $onclick1; ?>><? print translate("sajat_mondatok_10"); ?></a>
        <a href='#' class="medium-color" onclick=<?php print $onclick4; ?>><? print translate("sajat_mondat_szo"); ?></a>
        <a class="medium-color show-menu" onclick="audioSzoba();" href="#"><? print translate("audioszoba"); ?></a>
        <?php
        if ($userObject && in_array($userObject['status'], array(4, 5, 6))) {
        ?>
          <a href='#' class="white-color" onclick="p_Click(event)"><?php print translate('tandijak'); ?></a>
          <a href='#' class="white-color" onclick="t_Click(event)"><?php print translate('tanulok'); ?></a>
        <?php }
        if ($userObject) {
        ?>
          <a href='#' class="logout" onclick="event.stopPropagation();location.href='logout.php'"><?php print translate('kijelentkezes'); ?>
          </a>
        <?php } ?>
      </span>
    </div>
  <?php } ?>

  <?php if ($userObject['status'] == 6) { ?>
    <div class="submenu admin-menu">
      <a href='#' class="menu-link" onclick=<?php print $onclick2; ?>><? print translate("kitolto"); ?></a>
      <a href='#' class="menu-link" onclick="tudastar();"><? print translate("tudastar_title"); ?></a>
      <a href='#' class="menu-link" onclick="szotarFeltoltes();"><? print translate("feltoltes"); ?></a>
      <a href='#' class="menu-link" onclick="location.href='main.php?content=wordCategorize&source=welcome'"><? print translate("kategorizalas"); ?></a>
    </div>
  <?php }  ?>

  <?php if ($userObject) { ?>
    <span class="classroom submenu">
      <a id="aTanuloszoba" href='#' class="button classroom-button" title=<?php print "'" . translate("") . "'" ?> onclick=<?php print $onclick3; ?>><? print translate("tanuloszoba"); ?></a>
    </span>
  <?php } ?>

  <!-- <?php if ($userObject) { ?>
  <table width='100%' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
    <tr>
      <td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="legujjabbszavak" href='#' style='color:white;font-size:12pt;'></a>
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
          if ($userObject["forras_nyelv"] == 0 && $userObject["nyelv"] == 1) {
            $updated_words = getLastFiveUpdatedWords($five_days_formatted);
            foreach ($updated_words as $row) {
              print("<p><b>" . $row["word_angol"] . "</b>&nbsp;-&nbsp;" . $row["word_hun"] . "</p>");
            }
          } ?>
      </font>
      </td>
    </tr>
  </table>
<?php } ?> -->

  <!-- <table>
 <?php if ($userObject) { ?>
      <tr>
        <td valign='top' align='center' style='padding-top:10'>
          <table border='0' align='center' valign='center' style=<?php print "'border: 1px solid " . $globalcolor . ";'"; ?> cellpadding='0' cellspacing='0'>
            <tr>
              <td colspan='3' align='right' style=<?php print "'padding-top:5px;padding-right:10px;background:" . $globalcolor . ";'"; ?>><a id="SzorgalomMutato" title=<?php print "'" . translate("info_szorgalommutato") . "'" ?> href='#' style='color:white;font-size:12pt;'></a></td>
            </tr>
            <tr>
              <td colspan='3' valign='center' align='center' style=<?php print "'padding-bottom:10px;font-size:20pt;color:white;border-bottom: 1px solid " . $globalcolor . ";background:" . $globalcolor . ";'"; ?>>
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
</table> -->

</div>