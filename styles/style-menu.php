<style>
  body {
    background: #334155;
    font-family: arial;
    margin: 0;
  }

  img {
    border: none;
  }

  /* #ragozas {
    position: absolute;
    top: 44px;
    left: 50%;
    margin-left: -190px;
  } */

  #spec_chars_ajax {
    position: absolute;
    top: 44px;
    left: 50%;
    margin-left: -130px;
  }

  #abctable {
    position: absolute;
    top: 25px;
    left: 50%;
    margin-left: -290px;
    visibility: hidden;
    background-color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
  }

  #kiejtestable {
    position: absolute;
    top: 25px;
    left: 50%;
    margin-left: -500px;
    visibility: hidden;
    background-color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
  }

  #szorendtable {
    position: absolute;
    overflow: auto;
    top: 25px;
    left: 50%;
    margin-left: -472px;
    display: none;
    background-color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    padding: 5px;
    border: 1px solid grey;
  }

  #szorendtable2 {
    position: absolute;
    overflow: auto;
    height: 410px;
    width: 700px;
    top: 35px;
    left: 50%;
    margin-left: -120px;
    display: none;
    background-color: <?php print $GLOBALS['dark']; ?>;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    padding: 5px;
  }

  #nevmasoktable {
    position: absolute;
    height: 430px;
    width: 700px;
    top: 35px;
    left: 50%;
    margin-left: -120px;
    visibility: hidden;
    background-color: <?php print $GLOBALS['dark']; ?>;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
  }

  #menu {
    position: absolute;
    top: 10px;
    left: 50%;
    margin-left: -300px;
  }

  #stats {
    position: absolute;
    top: 4px;
    left: 50%;
    margin-left: 160px;
  }

  .smallerCell {
    color: #d8d8d8;
  }

  .meaningCell {
    font-style: italic;
  }

  .meaningA {
    font-size: 15px;
    font-family: arial;
  }

  .meaningLevel2Cell {
    font-weight: normal;
  }

  .meaningLevel2A {
    font-weight: normal;
    font-size: 15px;
    font-family: arial;
  }

  #arrow_balra {
    position: absolute;
    top: 15px;
    left: 50%;
    margin-left: -183px;
  }

  #arrow_jobbra {
    position: absolute;
    top: 15px;
    left: 50%;
    margin-left: 105px;
  }

  #nyelvtansorminta {
    position: absolute;
    top: 57px;
    left: 50%;
    margin-left: -110px;
    padding-top: 7px;
    z-index: 60;
  }

  /* #nyelvtansorminta ul li a {
    line-height: 20px;
  } */

  #time {
    position: absolute;
    top: 4px;
    left: 50%;
    margin-left: -35px;
  }

  #tanitvanyok {
    position: absolute;
    top: 20px;
    left: 50%;
    margin-left: 155px;
  }

  #finance {
    position: absolute;
    top: 20px;
    left: 50%;
    margin-left: 100px;
  }

  .admin-info-board {
    color: <?php print $GLOBALS['colorValue']; ?>
  }

  #logout {
    position: absolute;
    top: 12px;
    left: 50%;
    margin-left: 315px;
  }

  #ruleDiv {
    position: absolute;
    overflow: auto;
    height: 400px;
    width: 830px;
    top: 90px;
    left: 50%;
    margin-left: -415px;
    display: none;
    background-color: <?php print $GLOBALS['dark']; ?>;
    z-index: 55;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    padding: 5px;
  }

  #ruleTextContainer {
    color: white !important;
  }

  #clientDiv {
    position: absolute;
    top: 50px;
    left: 50%;
    margin-left: -500px;
    display: none;
    background-color: <?php print $GLOBALS['globalcolor']; ?>;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    padding: 5px;
    /* border: 1px solid grey; */
    color: black;
  }

  #financeDiv {
    position: absolute;
    top: 35px;
    left: 50%;
    margin-left: -500px;
    display: none;
    background-color: white;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 100;
    padding: 5px;
    border: 1px solid grey;
  }

  #igeragozasDiv {
    position: absolute;
    overflow: auto;
    height: 420px;
    top: 25px;
    left: 50%;
    margin-left: -405px;
    display: none;
    background-color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    padding: 5px;
    border: 1px solid grey;
  }

  #ajaxMeaningSearch {
    position: absolute;
    top: 50px;
    left: 50%;
    margin-left: -400px;
    /* EZT NE VÁLTOZTASD MEG! */
    z-index: 60;
  }

  input[type='text'] {
    color: white;
  }

  #moreMeaningDiv {
    position: absolute;
    overflow: auto;
    top: 50px;
    background: <?php print "'" . $GLOBALS['globalcolor'] . "'"; ?>;
    color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    width: 500px;
    left: 50%;
    margin-left: -400px;
    height: 400px;
    border: 2px solid white;
    border-radius: 8px;
  }

  .btnAjaxDivSave {
    border: 1px solid grey;
    background: white;
    cursor: pointer;
    <?php
    if ($GLOBALS['isAndroid']) {
      //print "font-size:20pt; padding: 1px 20px;";
      print "font-size:10pt; padding: 1px 20px;";
    } else {
      print "padding: 1px 3px;";
    }
    ?>
  }

  #ajaxSearchOutput {
    position: absolute;
    overflow: auto;
    /* top: 8px; */
    left: 50%;
    margin-left: -100px;
    width: 200px;
    height: 40px;
    text-align: center;
    background-color: #334155;
    color: white;
    filter: alpha(opacity=100);
    opacity: 1;
    z-index: 99;
    border: 2px solid white !important;
    border-radius: 6px !important;
    padding: 8px;
    font-size: 14px;
  }

  #ajaxTable #ajaxTableFirstTd {
    display: none;
  }

  a {
    color: white;
  }
</style>