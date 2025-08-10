<meta charset="UTF-8">
<div class="login" style="display: flex !important; flex-direction: column !important; justify-content: flex-start !important; align-items: center !important; width: 100vw; margin-top: 20px !important; padding-top: 20px !important;">
  <?php
  if (!$userObject) {
  ?>
    <!-- Word and Sentence Counter Display -->
    <div class="content-stats" style="display: block; width: 300px; max-width: 90vw; text-align: center; margin-bottom: 20px; padding: 30px; background-color: rgba(255,255,255,0.1); border-radius: 15px; order: 1; box-sizing: border-box;">
      <?php
      $totalCounts = getTotalWordAndSentenceCounts();
      ?>
      <div style="color: white; font-size: 14px; margin-bottom: 5px;">
        <strong><?php print translate('available_content'); ?></strong>
      </div>
      <div style="display: flex; justify-content: center; gap: 30px; color: white;">
        <div style="text-align: center;">
          <div style="font-size: 24px; font-weight: bold; color: #4CAF50;">
            <?php echo number_format($totalCounts['words']); ?>
          </div>
          <div style="font-size: 12px; opacity: 0.8;">
            <?php print translate('words'); ?>
          </div>
        </div>
        <div style="text-align: center;">
          <div style="font-size: 24px; font-weight: bold; color: #2196F3;">
            <?php echo number_format($totalCounts['sentences']); ?>
          </div>
          <div style="font-size: 12px; opacity: 0.8;">
            <?php print translate('sentences'); ?>
          </div>
        </div>
      </div>
    </div>

    <form id="login-form" action='index.php' method='POST' style="display: block; order: 2;">
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
            <input class="login-field" type='password' name='username' placeholder="<?php print translate('subs_Jelszó'); ?>" id='username'>
          </div>
        </div>
      </div>
    </form>
  <?php } ?>
</div>