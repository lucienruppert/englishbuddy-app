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
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="spanish" value="<?php print translate("Spanyol") ?>" /></td>
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="angol_01" value="<?php print translate("Angol kezdo") ?>" /></td>
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="angol_02" value="<?php print translate("Angol brit") ?>" /></td>
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="angol_03" value="<?php print translate("Angol halado") ?>" /></td>
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="angol_04" value="<?php print translate("Angol BP") ?>" /></td>
			<td width='120' height='50'> <input style=<?php print "'width:100%;height:100%;background:" . $globalcolor . ";color:white;font-size:15pt;'" ?> type="submit" name="angol_05" value="<?php print translate("Angol ECL") ?>" /></td>
		</tr>
</form>

<table border='0' align='center' width='95%' cellspacing='0'>
	<?php if (isset($_POST['angol_01'])) { ?>
		<tr>
			<td style="text-align:center;">
				<a href="https://drive.google.com/file/d/12Bog9R49ok54xAxBBNjAS92FKAuQ3rIk/view?usp=drive_link" target="_blank" style="font-size:16px;color:<?php print $globalcolor; ?>;text-decoration:underline;">K01</a>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;">
				<a href="https://drive.google.com/file/d/1zoq7dFpFFr-8MuMEo3hsKKBd-7jTPi8b/view?usp=sharing" target="_blank" style="font-size:16px;color:<?php print $globalcolor; ?>;text-decoration:underline;">K02</a>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;">
				<a href="https://drive.google.com/file/d/1VHxgabMvldA7qziTzFhEomu4yMoaJXzQ/view?usp=sharing" target="_blank" style="font-size:16px;color:<?php print $globalcolor; ?>;text-decoration:underline;">K03</a>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;">
				<a href="https://drive.google.com/file/d/1ROm8ccULkrMBJptD7bgPwgzfr1syTF7P/view?usp=sharing" target="_blank" style="font-size:16px;color:<?php print $globalcolor; ?>;text-decoration:underline;">K04</a>
			</td>
		</tr>
	<?php } ?>
</table>