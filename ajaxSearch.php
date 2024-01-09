<?php
    $isAndroid = false;
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
        $isAndroid = true;
    }
?>
<style>
    <?php if($isAndroid){ ?>
    .meaningTableClass{
        color:white;font-size:20px;font-weight:bold;background:<?php print "" . $globalcolor . ""; ?>;width:80%
    }
    .meaningTableClass a.meaningA {
        font-size: 20px !important;
    }
    <?php } else { ?>
    .meaningTableClass{
        color:white;font-size:14px;font-weight:bold;background:<?php print "" . $globalcolor . ""; ?>;width:100%
    }
    <?php } ?>
    .meaningTableClass td{
        vertical-align:top;
    }
</style>

<div id='ajaxMeaningSearch'>
    <script>
        function ajaxSearchCallback(responseObject)
        {
            ragozasWord = '';
            for(var i = 0; i < responseObject.items.length; i++){
                if(responseObject.items[i].level_category == 1 || responseObject.items[i].level_category == 0){
                    ragozasWord = responseObject.items[i].word_foreign;
                    break;
                }
            }
        }
    </script>
    <?php
        ajaxSearchPrint($userObject ? $userObject['nyelv'] : $defaultNyelv);
    ?>
</div>