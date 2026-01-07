<?php
$isAndroid = false;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (stripos($ua, 'android') !== false) { // && stripos($ua,'mobile') !== false) {
    $isAndroid = true;
}
?>
<style>
    .meaningTableClass {
        color: white;
        font-size: 14px;
        font-weight: bold;
        background: #334155;
        width: 100%
    }

    .meaningTableClass td {
        vertical-align: top;
    }
</style>

<script>
    function ajaxSearchCallback(responseObject) {
        ragozasWord = '';
        for (var i = 0; i < responseObject.items.length; i++) {
            if (responseObject.items[i].level_category == 1 || responseObject.items[i].level_category == 0) {
                ragozasWord = responseObject.items[i].word_foreign;
                break;
            }
        }
    }
</script>
<?php
ajaxSearchPrint($userObject ? $userObject['nyelv'] : $defaultNyelv);
?>