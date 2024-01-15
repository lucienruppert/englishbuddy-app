<div>
	<div class="navigation">
		<?php
		if ($userObject && in_array($userObject['status'], array(4, 5, 6))) {
		?>
			<a href='#' onclick="p_Click(event)"><?php print translate('tandijak'); ?></a>
			<a href='#' onclick="t_Click(event)"><?php print translate('tanulok'); ?></a>
		<?php }
		if ($userObject) {
		?>
			<a href='#' class="logout" onclick="event.stopPropagation();location.href='logout.php'"><?php print translate('kijelentkezes'); ?>
			</a>
		<?php } ?>
	</div>
	<?php include_once('login.php'); ?>
</div>