<script type="text/javascript">
var searchTimeout;
function getMeaning(str)
{
    if (str=="")
    {
        return;
    }

    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{ // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
                                    {
                                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                        {
                                            document.getElementById("ajaxSearchOutput").innerHTML = xmlhttp.responseText;
                                        }
                                    }
    xmlhttp.open("GET","meaningSearch_server.php?txt=" + str + "&lang=1", true);
    xmlhttp.setRequestHeader("Content-Type", "text/plain;charset=UTF-8");
    xmlhttp.send();
}

function getTimeoutText(val)
{
    return "getMeaning('" + encodeURIComponent(val) + "')";
    //return "getMeaning('" + escape(val) + "')";
}
</script>

<input type='text' name='ajaxSearchInput' onkeyup="
    if (searchTimeout != undefined){
        clearTimeout(searchTimeout);
    }
    searchTimeout = setTimeout(getTimeoutText(this.value), 1000);
    " />
<br>
<div id='ajaxSearchOutput'></div>