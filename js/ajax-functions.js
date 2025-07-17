// Global variable to store last XML HTTP request
var xmlhttp = null;

// Function to handle AJAX requests
function getAjaxResponse(target, callbackFunction) {
  // If there's already an ongoing request, abort it
  if (xmlhttp) {
    xmlhttp.abort();
  }

  // Create new XMLHttpRequest object
  xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4) {
      if (xmlhttp.status == 200) {
        try {
          var responseObject = JSON.parse(xmlhttp.responseText);
          if (callbackFunction) {
            callbackFunction(responseObject);
          }
        } catch (e) {
          console.error("Error parsing JSON response:", e);
        }
      } else {
        console.error("AJAX request failed:", xmlhttp.status);
      }
    }
  };

  xmlhttp.open("GET", target, true);
  xmlhttp.setRequestHeader("Content-Type", "text/plain;charset=ISO-8859-2");
  xmlhttp.send();
}
