	<div class="navigation">
		<span class="welcome">
			<?php
			if ($userObject)
				print translate('szia') . "&nbsp;" . $userObject['keresztnev'] . "!";
			else
				print "";
			?>
		</span>
		<?php
		if ($userObject && in_array($userObject['status'], array(4, 5, 6))) {
		?>
			<a href='#' class="menu-button" onclick="p_Click(event)"><?php print translate('tandijak'); ?></a>
			<a href='#' class="menu-button" onclick="t_Click(event)"><?php print translate('tanulok'); ?></a>
		<?php }
		if ($userObject) {
		?>
			<a href='#' class="logout" onclick="event.stopPropagation();location.href='logout.php'"><?php print translate('kijelentkezes'); ?>
			</a>
		<?php } ?>
	</div>
	<?php include_once('login.php'); ?>
	</div>