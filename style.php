<style>
  /* border: 1px solid green; */
  #header {
    width: 100%;
  }

  body {
    background: white;
    font-family: arial;
    margin: 0;
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
    -webkit-box-shadow: 0 0 0 1000px #334155 inset;
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
    filter: alpha(opacity=100);
    opacity: 1;
    z-index: 99;
  }

  #wordPracticeDiv * {
    color: white;
  }

  #vocabularyDiv {
    display: none;
    position: absolute;
    top: -200px;
    left: 50%;
    margin-left: -200px;
    filter: alpha(opacity=100);
    opacity: 1;
    z-index: 99;
  }

  #vocabularyDiv * {
    color: white;
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

  #ajaxDiv {
    border: 0px solid black;
    position: absolute;
    left: 50%;
    text-align: left;
    margin-left: -140px;
    top: 0px;
    width: 280px;
  }

  #ajaxSearchInput {
    font-size: 12pt;
  }

  .fa-search {
    font-size: 14pt;
  }

  .meaningCell {
    font-style: italic;
  }

  .meaningA {
    font-size: 15px;
  }

  .meaningLevel2Cell {
    font-weight: normal;
  }

  .meaningLevel2A {
    font-weight: normal;
    font-size: 15px;
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

  #clientDiv {
    color: black;
  }

  #financeDiv {
    position: absolute;
    top: 35px;
    left: 50%;
    margin-left: 0px;
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
    align-items: flex-start;
    margin-top: 50px;
    width: 100vw;
    background: #334155;
    min-height: 400px;
    padding: 20px 0;
    padding-top: calc(50vh - 150px);
  }

  /* .login * {
    border: 1px solid green;
  } */

  .button {
    text-align: center;
    background: white;
    border-radius: 8px;
    padding: 15px 12px;
    cursor: pointer;
    letter-spacing: 2px;
    box-shadow: 0 4px 15px rgba(51, 65, 85, 0.3);
    transition: all 0.3s ease;
    border: 2px solid #334155;
  }

  .button:hover {
    background: #f8fafc;
    box-shadow: 0 6px 20px rgba(51, 65, 85, 0.4);
    transform: translateY(-2px);
  }

  .login-controls {
    position: relative;
    width: 300px;
    background: #334155;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
  }

  @media (max-width: 768px) {
    .login-controls {
      width: 95vw;
      margin: 0 10px;
      padding: 20px;
    }
  }

  .login-button {
    font-size: 20px;
    color: #334155;
    background: white;
    text-decoration: none;
    font-weight: 600;
    text-shadow: none;
  }

  .menu-link {
    color: white;
  }

  .login-field {
    margin-top: 8px;
    font-size: 1.2rem;
    border-radius: 8px;
    color: white;
    border: 2px solid #475569;
    width: 100%;
    background: #334155;
    padding: 12px 15px;
    transition: all 0.3s ease;
    box-sizing: border-box;
  }

  .login-field:focus {
    border-color: #6b7280;
    background: #334155;
    outline: none;
    box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.2);
  }

  .login-field::placeholder {
    color: rgba(255, 255, 255, 0.6);
  }

  .login-input {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    margin-top: 10px;
    animation: slideDown 0.3s ease;
    background: #334155;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    display: none;
  }

  .login-input>div {
    margin-bottom: 10px;
  }

  .login-input>div:last-child {
    margin-bottom: 0;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Add some polish to the login toggle button */
  .login-toggle {
    position: relative;
    overflow: hidden;
  }

  .login-toggle::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .login-toggle:active::before {
    width: 300px;
    height: 300px;
  }

  table {
    font-size: 12;
    color: grey;
    text-align: left
  }

  span {
    font-size: 12;
    color: grey;
    text-align: left
  }

  div#igeragozasDiv table {
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

  #mainDiv {
    position: absolute;
    display: flex;
    flex-direction: column;
    top: 20;
    width: 100%;
    z-index: 90;
  }

  .logout,
  .home {
    color: #334155;
  }

  .grammar-examples * {
    border: 1px solid red;
  }
</style>