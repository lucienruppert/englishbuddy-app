<?php

print "<input type='button' name='generateSentence' value='Ööööö' onclick=\"document.forms[0].submit();\">";
    $generatedWordList = getGeneratedWordList(array(9,4,6,7,2,1,3));
    for($i = 0; $i < count($generatedWordList); $i++){
        if($i > 0){
            print " - ";
        }
        print $generatedWordList[$i]['word_hun'];
    }

print "<script>
    document.forms[0].actionType.value = 'createSentences';
</script>";

?>