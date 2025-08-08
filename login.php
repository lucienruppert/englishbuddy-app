<meta charset="UTF-8">
<div class="login">
  <?php
  if (!$userObject) {
  ?>
    <form id="login-form" action='index.php' method='POST'>
      <div class="login-controls">
        <div class="button login-toggle">
          <input type='hidden' name='actionType' value='login'>
          <input style='display:none' type='submit'>
          <a href='#' class="login-button"><?php print translate('enter'); ?></a>
        </div>
        <script>
          // Wait for document to be ready
          document.addEventListener('DOMContentLoaded', function() {
            var loginButton = document.querySelector('.login-toggle');
            if (loginButton) {
              loginButton.addEventListener('click', function(e) {
                e.preventDefault();
                var loginInputs = document.querySelector('.login-input');
                if (loginInputs) {
                  if (loginInputs.style.display === 'none' || loginInputs.style.display === '') {
                    loginInputs.style.display = 'block';
                  } else {
                    document.getElementById('login-form').submit();
                  }
                }
              });
            }
          });
        </script>
        <div class='login-input'>
          <div>
            <input class="login-field" type='text' name='email' placeholder="Email" onclick="event.stopPropagation();clearit(this, 0);">
          </div>
          <div>
            <input class="login-field" type='password' name='username' placeholder="<?php print translate('subs_Jelszo'); ?>" id='username'>
          </div>
        </div>
      </div>
    </form>
  <?php } ?>
</div>