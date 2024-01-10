<style>

    * {
        border: 1px solid green;
    }

    body {
        background-color: green;
    }
    input[type=checkbox] {
        zoom: 1.5;
    }

    img.imgLangChange {
        cursor: pointer !important;
    }

    .ui-tooltip {
        white-space: pre-line;
        content: attr(title);
    }

    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px <? print $globalcolor ?> inset;
        -webkit-text-fill-color: #FFFFFF;
    }

    #knowledgeBaseDiv {
        display: none;
        position: absolute;
        top: -200px;
        left: 50%;
        margin-left: -200px;
        background-color: white;
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 99;
    }

    #wordPracticeDiv {
        display: none;
        position: absolute;
        top: -200px;
        left: 50%;
        margin-left: -200px;
        background-color: white;
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 99;
    }

    #vocabularyDiv {
        display: none;
        position: absolute;
        top: -200px;
        left: 50%;
        margin-left: -200px;
        background-color: white;
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 99;
    }

    #sentencePracticeDiv {
        display: none;
        position: absolute;
        top: -200px;
        left: 50%;
        margin-left: -200px;
        background-color: white;
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 99;
    }

    #tblPerformance tr:first-child td {
        font-weight: bold;
        color: <? print $globalcolor ?>;
    }

    #tblPerformance td:last-child {
        text-align: right;
        padding-left: 4px;
        font-size: 10pt;
    }

    #moreMeaningDiv {
        position: absolute;
        overflow: auto;
        background-color: <? print $globalcolor ?>;
        color: white;
        filter: alpha(opacity=100);
        /* IE's opacity*/
        opacity: 1;
        z-index: 99;
        margin-left: -250px;
        top: 30px;
        left: 50%;
        width: 500px;
        height: 400px;
    }

    .btnAjaxDivSave {
        border: 1px solid grey;
        background: white;
        cursor: pointer;
        <?php
        if ($isAndroid) {
            print "font-size:20pt; padding: 1px 20px;";
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
        margin-left: 140px;
        width: 100px;
        height: 22px;
        text-align: center;
        background-color: <? print $globalcolor ?>;
        color: white;
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 99;
    }

    #ajaxSearchInput {
        font-size: 12pt;
    }

    #ajaxDiv {
        border: 0px solid black;
        position: absolute;
        left: 50%;
        text-align: left;
        margin-left: -140px;
        top: 0px;
        width: 280px;
    }

    .fa-search {
        font-size: 14pt;
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

    .ajaxLangChoose {
        cursor: pointer;
        color: white;
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
        margin-left: -405px;
        display: none;
        background-color: white;
        -webkit-transform: translate3d(0, 0, 0);
        transform: translateX(-50%);
        filter: alpha(opacity=100);
        opacity: 1;
        z-index: 100;
        padding: 5px;
        border: 1px solid grey;
    }
</style>