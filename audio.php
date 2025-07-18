<?

if (isset($_GET['audioszoba'])) {
	$lang = $_GET['audioszoba'];
}
$link = "index.php?audioszoba=" . $lang;
?>
<div style='width:100%;text-align:center;margin-top:20px;margin-bottom:20px;'><a href='index.php' style='font-size:14px;color:<?php print $globalcolor; ?>;'><?php print translate("vissza_a_fooldalra") ?></a></div>


<form action="<? echo $link; ?>" method="POST">
	<table border='0' align='center' cellspacing='10'>
		<tr>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="spanish" value="<?php print translate("Spanyol") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="angol_01" value="<?php print translate("Angol kezdo") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="angol_02" value="<?php print translate("Angol brit") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="angol_03" value="<?php print translate("Angol halado") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="angol_04" value="<?php print translate("Angol BP") ?>" /></td>
			<td width='120' height='50'> <input class="main-select-btn" style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;border:none;border-radius:10px;'" ?> type="submit" name="angol_05" value="<?php print translate("Angol ECL") ?>" /></td>
		</tr>

	</table>
</form>

<?php if (isset($_POST['angol_01'])) { ?>
	<div class="audio-grid">
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/12Bog9R49ok54xAxBBNjAS92FKAuQ3rIk/view?usp=drive_link','_blank');return false;">1</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1zoq7dFpFFr-8MuMEo3hsKKBd-7jTPi8b/view?usp=sharing','_blank');return false;">2</button>
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
	</div>
<?php } ?>

<style>
	.main-select-btn {
		cursor: pointer;
		font-size: 13px !important;
		text-transform: capitalize;
	}

	.main-select-btn:hover,
	.main-select-btn:active {
		background: <?php print $highlight; ?> !important;
	}

	.audio-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
		row-gap: 32px;
		column-gap: 32px;
		max-width: 600px;
		margin: 30px auto 0 auto;
	}

	.audio-btn {
		background: <?php print $globalcolor; ?>;
		color: white;
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
		background: <?php print $highlight; ?>;
	}
</style>
</style>