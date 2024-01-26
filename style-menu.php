<style>
  body {
    background: <? print $dark ?>;
    font-family: arial;
    margin: 0;
  }

  img {
    border: none;
  }

  #ragozas {
    position: absolute;
    top: 44px;
    left: 50%;
    margin-left: -190px;
  }

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

  #nevmasoktable {
    position: absolute;
    top: 25px;
    left: 50%;
    margin-left: -472px;
    visibility: hidden;
    background-color: white;
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
    height: 390px;
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
    margin-left: -100px;
    padding-top: 7px;
    z-index: 60;
    
  }

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
    margin-left: 395px;
  }

  #finance {
    position: absolute;
    top: 20px;
    left: 50%;
    margin-left: 340px;
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
    top: 65px;
    left: 50%;
    margin-left: -415px;
    display: none;
    background-color: white;
    z-index: 10;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    padding: 5px;
    border: 1px solid grey;
  }

  #clientDiv {
    position: absolute;
    top: 35px;
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

  #financeDiv {
    position: absolute;
    top: 35px;
    left: 50%;
    margin-left: 0px;
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
    top: 35px;
    left: 50%;
    margin-left: -400px;
  }

  #moreMeaningDiv {
    position: absolute;
    overflow: auto;
    top: 30px;
    background: <?php print "'" . $globalcolor . "'"; ?>;
    color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
    <?php
    if ($isAndroid) {
      print "height:400px;";
    } else {
      print "width:500px;";
      print "left:50%;margin-left:-400px;height:400px;";
    }
    ?>
  }

  .btnAjaxDivSave {
    border: 1px solid grey;
    background: white;
    cursor: pointer;
    <?php
    if ($isAndroid) {
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
    top: 8px;
    left: 50%;
    margin-left: -200px;
    width: 100px;
    height: 22px;
    text-align: center;
    background: <?php print "'" . $globalcolor . "'"; ?>;
    color: white;
    filter: alpha(opacity=100);
    /* IE's opacity*/
    opacity: 1;
    z-index: 99;
  }

  #ajaxTable #ajaxTableFirstTd {
    display: none;
  }

  a {
    color: white;
  }
</style>