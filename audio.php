<?php
include_once('audioProgress.php');

if (isset($_GET['audioszoba'])) {
	$lang = $_GET['audioszoba'];
}
$link = "index.php?audioszoba=" . $lang;

// Determine active category
$activeCategory = '';
if (isset($_POST['angol_01'])) {
	$activeCategory = 'angol_01';
} elseif (isset($_POST['bad_pharma'])) {
	$activeCategory = 'bad_pharma';
} elseif (isset($_POST['british'])) {
	$activeCategory = 'british';
} elseif (isset($_POST['ecl'])) {
	$activeCategory = 'ecl';
} elseif (isset($_POST['think_grow_rich'])) {
	$activeCategory = 'think_grow_rich';
}

// Get user's completed audio for this category
$completedAudio = array();
if ($userObject && $activeCategory) {
	$completedAudio = getAudioProgress($userObject['id'], $activeCategory);
}
?>
<div style='width:100%;text-align:center;margin-top:20px;margin-bottom:20px;'><a href='index.php' style='font-size:14px;color:white;'><?php print translate("vissza_a_fooldalra") ?></a></div>

<script>
	// Set active category for JavaScript use
	window.activeCategory = '<?php echo $activeCategory; ?>';
</script>


<form action="<? echo $link; ?>" method="POST">
	<table border='0' align='center' cellspacing='10'>
		<tr>
			<!-- <td width='120' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="spanish" value="<?php print translate("Spanyol") ?>" /></td> -->
			<td width='150' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="angol_01" value="<?php print translate("Angol kezdo") ?>" data-category="angol_01" /></td>
			<td width='150' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="bad_pharma" value="BAD PHARMA" data-category="bad_pharma" /></td>
			<td width='150' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="british" value="BRITISH" data-category="british" /></td>
			<td width='150' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="ecl" value="ECL" data-category="ecl" /></td>
			<td width='150' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="think_grow_rich" value="THINK AND GROW RICH" data-category="think_grow_rich" /></td>
			<!-- <td width='120' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="angol_02" value="<?php print translate("Angol brit") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="angol_03" value="<?php print translate("Angol halado") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="angol_04" value="<?php print translate("Angol BP") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style="width:100%;height:100%;background:white;color:#334155;font-size:15pt;border:none;border-radius:10px;" type="submit" name="angol_05" value="<?php print translate("Angol ECL") ?>" /></td> -->
		</tr>

	</table>
</form>

<?php if (isset($_POST['angol_01'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/12Bog9R49ok54xAxBBNjAS92FKAuQ3rIk/view?usp=drive_link','_blank');return false;" data-category="angol_01" data-number="1" <?php if (in_array(1, $completedAudio)) echo 'data-completed="true"'; ?>>1</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1zoq7dFpFFr-8MuMEo3hsKKBd-7jTPi8b/view?usp=sharing','_blank');return false;" data-category="angol_01" data-number="2" <?php if (in_array(2, $completedAudio)) echo 'data-completed="true"'; ?>>2</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1VHxgabMvldA7qziTzFhEomu4yMoaJXzQ/view?usp=sharing','_blank');return false;">3</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1ROm8ccULkrMBJptD7bgPwgzfr1syTF7P/view?usp=sharing','_blank');return false;">4</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1WuozLWE6yRbEUXLWBEepo4aY28EW6rtD/view?usp=sharing','_blank');return false;">5</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Of-2pn-n5bsz75XGPd1vpor7qG58gDvx/view?usp=sharing','_blank');return false;">6</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1VS1I5rHooC-m692SmJLWRefvuIy7nXtW/view?usp=sharing','_blank');return false;">7</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1odlZixvQVZar9CSnM3Dmw2J9rjtuZ2Zf/view?usp=sharing','_blank');return false;">8</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1JdIpJi1c-D9-mIeTOkDmjq3keOSXgxQ-/view?usp=sharing','_blank');return false;">9</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/16HKNtpA60JBB_LFbUAm8-34ThlX8mWHV/view?usp=sharing','_blank');return false;">10</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1yF5qA0wNe2Zj371a_3mc9ZsXuru9fgSf/view?usp=sharing','_blank');return false;">11</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1m5Amq2eFZs68BhweSBssUGYr__RHDM_l/view?usp=sharing','_blank');return false;">12</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Q9OqXAgfx0biN06ERxDDcL9GIkyMTf3r/view?usp=sharing','_blank');return false;">13</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1cvRafh94KPkoJRYyRGLLE_pBrFJfaM67/view?usp=sharing','_blank');return false;">14</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1qneYZZ0h0XNxxVHtvDIan_EGc79Zavyv/view?usp=sharing','_blank');return false;">15</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1mFBfa9ZnTsO8wzL8n_frnGXQ1Q6iG3F9/view?usp=sharing','_blank');return false;">16</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1monhMXDZzv-ZsCZsxa1f6efCF6bgeegd/view?usp=sharing','_blank');return false;">17</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1VXeRjZl5F3ETkoPMSWEsaT81Vq-Q_3hV/view?usp=sharing','_blank');return false;">18</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1292D5hBczKQaZD3euq2qCakVUFjwtTbx/view?usp=sharing','_blank');return false;">19</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1evNi84i_s7sgURm5v08PL8GWp3h1pIls/view?usp=sharing','_blank');return false;">20</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1kooXarGpAsYcrbiuW0ExLQsoX9KUyIIF/view?usp=drive_link','_blank');return false;">21</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1sJ0waPCUMLiUknFGv2D588SbMqzPCW4I/view?usp=drive_link','_blank');return false;">22</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Avcbq1L_9Kyk6QuuLKdal5pyBikrm-Q5/view?usp=drive_link','_blank');return false;">23</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1jz8dD9RgGLDEFomKUqk4g3uTu8gpDcu4/view?usp=drive_link','_blank');return false;">24</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1XO8N_oViIaypFW12-ZScr8IeGUIMph7V/view?usp=drive_link','_blank');return false;">25</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1U19B9cur9-naeWS2ceaQJuR6236PPKev/view?usp=drive_link','_blank');return false;">26</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1KgHVp6F2XrbiFJ-cpOcSodoElFRqd-_f/view?usp=drive_link','_blank');return false;">27</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1DGX2FeEYFp39YMjKDrrpc1wSq8J3eLsO/view?usp=drive_link','_blank');return false;">28</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1TuPWb6rjLwAoxDNtP4vEDXmivHawxruF/view?usp=drive_link','_blank');return false;">29</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/18F0sYgGnFwzAWcJh5ok6HcJ4UZ4F0CuM/view?usp=drive_link','_blank');return false;">30</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1_DHjIuhkqeRUUYz40ZEMpYndJQXKbcb_/view?usp=drive_link','_blank');return false;">31</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1v2M1vmFuulVG8vfiSKVjoxgmLm3136-K/view?usp=drive_link','_blank');return false;">32</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1n_Trx32CpuHLvs710LtpO_T1YFeQr3Yx/view?usp=drive_link','_blank');return false;">33</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Uu-nTKrhCUALExAG55DFuatTSocvfIiX/view?usp=drive_link','_blank');return false;">34</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1K3_-4titcrebX5JE3dMkffmSAqj-T1rr/view?usp=drive_link','_blank');return false;">35</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1j-I2tb2fgjOGkigOPwhWDeigHlU8dHqs/view?usp=drive_link','_blank');return false;">36</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1ll09OZTAvKcjN2hE8KzftyPvVmlW7cSy/view?usp=drive_link','_blank');return false;">37</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1ASgV0OxHrkOHFHac7t2EM_QwKmOK9eI3/view?usp=drive_link','_blank');return false;">38</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Kkaly4lfI4tKeZYfMc2GMRH8whG4nSxx/view?usp=drive_link','_blank');return false;">39</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/18LoQVHlKidyPb1XXSNr5NVFMYrF8fcyu/view?usp=drive_link','_blank');return false;">40</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1G_sCQeLZMzYoD8OWpfEGGXxOvhv2R1je/view?usp=drive_link','_blank');return false;">41</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1dP-vyGGrjPK7OpURKv8ippTYDgdIaPNd/view?usp=drive_link','_blank');return false;">42</button>
	</div>
<?php } ?>

<?php if (isset($_POST['bad_pharma'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1-kdLRxvGnSHM7dIGCMEjeuQfxH1pVNET/view?usp=drive_link','_blank');return false;">1</button>
	</div>
<?php } ?>

<?php if (isset($_POST['british'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1v9n-scL2E_S1_0UgTl1RWccdiXPDQGT_/view?usp=drive_link','_blank');return false;">1</button>
	</div>
<?php } ?>

<?php if (isset($_POST['ecl'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/13TMy3m7JvjAcfqcXg10fqWjmlkavMYMD/view?usp=drive_link','_blank');return false;">1</button>
	</div>
<?php } ?>

<?php if (isset($_POST['think_grow_rich'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1j7FO0gz2CnnMTqSPzxIa7P5-E2AqZ_OJ/view?usp=drive_link','_blank');return false;">1</button>
	</div>
<?php } ?>

<style>
	body {
		background: #334155;
	}

	.main-select-btn {
		cursor: pointer;
		font-size: 13px !important;
		text-transform: capitalize;
		background: white !important;
		color: #334155 !important;
	}

	.main-select-btn:hover,
	.main-select-btn:active,
	.main-select-btn:focus {
		background: #334155 !important;
		color: white !important;
		border: 1px solid white !important;
	}

	.main-select-btn.active {
		background: #334155 !important;
		color: white !important;
		border: 1px solid white !important;
	}

	.audio-grid {
		display: grid;
		grid-template-columns: repeat(8, 1fr);
		row-gap: 16px;
		column-gap: 12px;
		max-width: 750px;
		margin: 30px auto 0 auto;
	}

	.audio-btn {
		background: white;
		color: #334155;
		font-size: 16px;
		border: none;
		border-radius: 50%;
		width: 64px;
		height: 64px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		transition: background 0.2s;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
		margin: 0 auto;
		padding: 0;
	}

	.audio-btn:hover {
		background: #334155;
		color: white;
		border: 1px solid white;
	}

	.audio-btn.completed {
		background: #10b981;
		color: white;
		border: 2px solid white;
		position: relative;
		font-weight: bold;
	}

	.audio-btn.completed::before {
		content: '✓ ';
		font-size: 20px;
	}
</style>

<script>
	// Handle marking audio as completed
	document.addEventListener('DOMContentLoaded', function() {
		// Get active category from global variable
		const activeCategory = window.activeCategory;

		// Mark the active category button
		if (activeCategory) {
			const categoryButtons = document.querySelectorAll('.main-select-btn');
			categoryButtons.forEach(btn => {
				if (btn.getAttribute('data-category') === activeCategory) {
					btn.classList.add('active');
				} else {
					btn.classList.remove('active');
				}
			});
		}

		// Add right-click handler to all audio buttons
		const buttons = document.querySelectorAll('.audio-btn');
		buttons.forEach(button => {
			// Check if marked as completed on page load
			if (button.getAttribute('data-completed') === 'true') {
				button.classList.add('completed');
			}

			// Right-click to mark as completed
			button.addEventListener('contextmenu', function(e) {
				e.preventDefault();
				const category = this.getAttribute('data-category');
				const audioNumber = this.getAttribute('data-number');
				const isCompleted = this.classList.contains('completed');

				toggleAudioCompletion(category, audioNumber, !isCompleted);
			});

			// Alt+click as alternative way to mark
			button.addEventListener('click', function(e) {
				if (e.altKey) {
					e.preventDefault();
					const category = this.getAttribute('data-category');
					const audioNumber = this.getAttribute('data-number');
					const isCompleted = this.classList.contains('completed');

					toggleAudioCompletion(category, audioNumber, !isCompleted);
				}
			});
		});
	});

	function toggleAudioCompletion(category, audioNumber, completed) {
		const data = {
			action: 'toggleAudio',
			category: category,
			audio_number: audioNumber,
			completed: completed ? 1 : 0
		};

		fetch('audioProgress.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&')
			})
			.then(response => response.json())
			.then(result => {
				if (result.success) {
					// Toggle the button class
					const button = document.querySelector(`[data-category="${category}"][data-number="${audioNumber}"]`);
					if (button) {
						if (completed) {
							button.classList.add('completed');
						} else {
							button.classList.remove('completed');
						}
					}
				} else {
					alert('Failed to update progress');
				}
			})
			.catch(error => console.error('Error:', error));
	}
</script>