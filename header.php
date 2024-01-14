<div id='header'>
	<div>
		<?php
		if ($userObject && in_array($userObject['status'], array(4, 5, 6))) {
		?>
			<a href='#' style='color:white;' onclick="p_Click(event)"><?php print translate('tandijak'); ?></a>
			<a href='#' style='color:white;' onclick="t_Click(event)"><?php print translate('tanulok'); ?></a>
		<?php }
		if ($userObject) {
		?>
			<a href='#' style=<?php print "'font-size:" . $loginFontSize . ";color:white;'"; ?> onclick="event.stopPropagation();location.href='logout.php'"><?php print translate('kijelentkezes'); ?>
			</a>
		<?php } ?>
	</div>
	<?php include_once('login.php'); ?>
</div>