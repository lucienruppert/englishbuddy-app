<style>
    #header {
        /* border: 1px solid green; */
        width: 100%;
    }

    body {
        background: <? print $dark ?>;
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

    .login {
        display: flex;
        justify-content: center;
        margin-top: 300px;
    }

    .button {
        text-align: center;
        background-color: <?php print $highlight ?>;
        border-radius: 5px;
        padding: 10px 0;
        cursor: pointer;
    }

    table {
        font-family: arial;
        font-size: 12;
        color: grey;
        text-align: left
    }

    span {
        font-family: arial;
        font-size: 12;
        color: grey;
        text-align: left
    }

    A {
        font-family: Tahoma;
        font-size: 12
    }

    A:link {
        text-decoration: none;
        color: grey;
    }

    A:active {
        text-decoration: none;
        color: grey;
    }

    A:visited {
        text-decoration: none;
        color: grey;
    }

    A:hover {
        text-decoration: underline;
        color: grey;
    }

    A.selected {
        font-family: Tahoma;
        font-size: 12;
        color: grey;
    }

    A.selected:link {
        text-decoration: none;
        color: grey;
    }

    A.selected:active {
        text-decoration: none;
        color: grey;
    }

    A.selected:visited {
        text-decoration: none;
        color: grey;
    }

    A.selected:hover {
        text-decoration: underline;
        color: grey;
    }

    body {
        font-family: Tahoma;
        background-color: #ffffff;
        scrollbar-track-color: white;
        scrollbar-face-color: silver;
        scrollbar-highlight-color: black;
        scrollbar-shadow-color: gray
    }

    div#igeragozasDiv table {
        font-family: Tahoma;
        font-size: 16;
        color: grey;
        text-align: left
    }

    .ajaxSearchTxt {
        position: relative;
        color: #aaa;
    }

    .ajaxSearchTxtContainer {
        position: relative;
    }

    .ajaxSearchTxtContainer input {
        background: #fcfcfc;
        border: 1px solid #aaa;
        border-radius: 5px;
        box-shadow: 0 0 3px #ccc, 0 10px 15px #ebebeb inset;
        text-indent: 23px;
        position: relative;
    }

    .ajaxSearchTxtContainer .fa-search {
        position: absolute;
        top: 3px;
        left: 5px;
        z-index: 50;
    }
</style>