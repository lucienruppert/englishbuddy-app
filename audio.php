
<?

if(isset($_GET['audioszoba']))  {
	$lang = $_GET['audioszoba'];
}
$link = "index.php?audioszoba=".$lang;
?>
<div style='width:100%;text-align:center;margin-top:20px;margin-bottom:20px;'><a href='index.php' style='font-size:14px;'><?php print translate("vissza_a_fooldalra") ?></a></div>


<form action="<?echo $link;?>" method="POST">
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
<?  if(isset($_POST['spanish'])){ ?>
<tr><td>Spanish 201 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/spanish/colloq/201.ogg" type="audio/ogg"></audio></td></tr>
<tr><td>Spanish 202 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/spanish/colloq/202.ogg" type="audio/ogg"></audio></td></tr>
<tr><td>Spanish 203 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/spanish/colloq/203.ogg" type="audio/ogg"></audio></td></tr>
<tr><td>Spanish Imm <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/spanish/imm/11-Lesson011.mp3" type="audio/mpeg"></audio></td></tr>
<? } if(isset($_POST['angol_01'])){ ?>
<tr><td>English k01 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k01.mp3" type="audio/mp3"></audio></td></tr>
<tr><td>English k02 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k02.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k03 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k03.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k04 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k04.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k05 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k05.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k06 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k06.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k07 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k07.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k08 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k08.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k09 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k09.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k10 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k10.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k11 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k11.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k12 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k12.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k13 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k13.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k14 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k14.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k15 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k15.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k16 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k16.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k17 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k17.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k18 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k18.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k19 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k19.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k20 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k20.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k21 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k21.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k22 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k22.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k23 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k23.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k24 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k24.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k25 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k25.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k26 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k26.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k27 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k27.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k28 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k28.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k29 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k29.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English k30 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/beginner/k30.mp3" type="audio/mpeg"></audio></td></tr>
<? } if(isset($_POST['angol_02'])){ ?>
<tr><td>English br1 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br1.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English br2 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br2.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English br3 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br3.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English br4 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br4.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English br5 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br5.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English br6 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/british/Br6.mp3" type="audio/mpeg"></audio></td></tr>
<? } if(isset($_POST['angol_03'])){ ?>
<tr><td>English 01 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/01.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 02 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/02.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 03 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/03.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 04 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/04.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 05 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/05.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 06 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/06.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 07 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/07.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 08 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/08.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 09 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/09.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 10 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/10.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 11 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/11.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 12 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/12.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 13 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/13.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>English 14 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/tgr/14.mp3" type="audio/mpeg"></audio></td></tr>
<? } if(isset($_POST['angol_04'])){ ?>
<tr><td>Bad Pharma 07 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/007.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 08 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/008.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 09 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/009.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 10 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/010.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 11 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/011.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 12 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/012.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 13 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/013.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 14 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/014.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>Bad Pharma 15 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/badpharma/015.mp3" type="audio/mpeg"></audio></td></tr>
<? } if(isset($_POST['angol_05'])){ ?>
<tr><td>ECL 01 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/ecl/ecl01.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>ECL 02 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/ecl/ecl02.mp3" type="audio/mpeg"></audio></td></tr>
<tr><td>ECL 03 <audio style="width:100%;" controls><source src="https://www.lingocasa.com/audio/english/ecl/ecl03.mp3" type="audio/mpeg"></audio></td></tr>
<? } ?>
</table>