<?php
function printCellBlocks($cellBlocks, $blockNr)
{
  $sepNr = (int)(count($cellBlocks) / $blockNr);
  if ((count($cellBlocks) % $blockNr) > 0) {
    $sepNr++;
  }
  for ($i = 0; $i < $sepNr; $i++) {
    print "<tr>";
    for ($j = 0; $j < $blockNr; $j++) {
      print $cellBlocks[$i + $j * $sepNr];
    }
    print "</tr>";
  }
}
