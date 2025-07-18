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
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/12Bog9R49ok54xAxBBNjAS92FKAuQ3rIk/view?usp=drive_link','_blank');return false;">K01</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1zoq7dFpFFr-8MuMEo3hsKKBd-7jTPi8b/view?usp=sharing','_blank');return false;">K02</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1VHxgabMvldA7qziTzFhEomu4yMoaJXzQ/view?usp=sharing','_blank');return false;">K03</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1ROm8ccULkrMBJptD7bgPwgzfr1syTF7P/view?usp=sharing','_blank');return false;">K04</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1WuozLWE6yRbEUXLWBEepo4aY28EW6rtD/view?usp=sharing','_blank');return false;">K05</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1Of-2pn-n5bsz75XGPd1vpor7qG58gDvx/view?usp=sharing','_blank');return false;">K06</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1VS1I5rHooC-m692SmJLWRefvuIy7nXtW/view?usp=sharing','_blank');return false;">K07</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1odlZixvQVZar9CSnM3Dmw2J9rjtuZ2Zf/view?usp=sharing','_blank');return false;">K08</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/1JdIpJi1c-D9-mIeTOkDmjq3keOSXgxQ-/view?usp=sharing','_blank');return false;">K09</button>
		<button class="audio-btn" onclick="window.open('https://drive.google.com/file/d/16HKNtpA60JBB_LFbUAm8-34ThlX8mWHV/view?usp=sharing','_blank');return false;">K10</button>
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
		gap: 16px;
		max-width: 600px;
		margin: 30px auto 0 auto;
	}

	.audio-btn {
		background: <?php print $globalcolor; ?>;
		color: white;
		font-size: 16px;
		border: none;
		border-radius: 10px;
		padding: 18px 0;
		cursor: pointer;
		transition: background 0.2s;
		width: 100%;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
	}

	.audio-btn:hover {
		background: <?php print $highlight; ?>;
	}
</style>
</style>