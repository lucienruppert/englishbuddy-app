<div class="login">
  <?php
  if (!$userObject) {
  ?>
    <form id="formLogin" action='index.php' method='POST'>
      <table id="tblLogin" border='0' width='200'>
        <tr>
          <td class="button">
            <input type='hidden' name='actionType' value='login'>
            <input style='display:none' type='submit'>
            <a href='#' class="login-button" onclick="if(!$('.loginInput').is(':visible')){ $('.loginInput').show(); } else{ $('#formLogin').submit(); }"><?php print translate('enter'); ?></a>
          </td>
        </tr>
        <tr>
          <td align='left'>
            <table border='0' align='right'>
              <tr>
                <td align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>>Email</td>
                <td>
                  <input class='loginInput' type='text' name='email' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?> onclick="event.stopPropagation();clearit(this, 0);">
                </td>
              </tr>
              <tr>
                <td align='right' class='loginInput' style=<?php print "'font-size:" . $email_password_title_Size . ";color:white;'"; ?>><?php print translate('subs_Jelszo'); ?></td>
                <td>
                  <input class='loginInput' type='password' name='username' id='username' size=<?php print $PasswordSize ?> style=<?php print "'font-size:" . $EmailFieldFontSize . ";color:white;border:1px solid white;background-color:" . $globalcolor . ";'" ?>>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
  <?php } ?>
</div>