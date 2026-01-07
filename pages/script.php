<script>
  var basePath = "<?php print BASE_PATH; ?>";
  $(document).ready(function() {
    $("#ajax").tooltip({
      position: {
        my: "left+10 bottom+15",
        at: "right center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#SajatSzotar").tooltip({
      position: {
        my: "left+15 bottom-15",
        at: "right center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#AlapSzokincs").tooltip({
      position: {
        my: "center+15 bottom-15",
        at: "right center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#NyelvtaniPeldatar").tooltip({
      position: {
        my: "right+15 bottom-15",
        at: "left center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#IntelligensGyakorlo").tooltip({
      position: {
        my: "right+24 bottom-15",
        at: "left center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#aTanuloszoba").tooltip({
      position: {
        my: "left center",
        at: "right center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#SzorgalomMutato").tooltip({
      position: {
        my: "right+24 bottom-20",
        at: "left center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#SajatSzotar_Div").tooltip({
      position: {
        my: "right-15 bottom+160",
        at: "left center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#alapszokincs_Div").tooltip({
      position: {
        my: "right-15 bottom+160",
        at: "left center"
      },
      content: function() {
        return $(this).attr("title");
      }
    });
    $("#wordPracticeDiv td, #vocabularyDiv td, #sentencePracticeDiv2 td").each(function() {
      if ($(this).children().first().is("a")) {
        $(this).css("cursor", "pointer");
      }
    });
    $("#wordPracticeDiv td, #vocabularyDiv td, #sentencePracticeDiv2 td").click(function(e) {
      if ($(this).children().first().is("a")) {
        e.stopPropagation();
        $(this).children().first()[0].click();
      }
    });
  });

  notLoggedInMessage = <?php print "'" . $notLoggedInMessage . "'"; ?>;
  premiumUserOnlyMessage = <?php print "'" . $premiumUserOnlyMessage . "'"; ?>;
  nyelv = <?php print "'" . $GLOBALS['nyelv'] . "'";  ?>;

  /* IE miatt */
  if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj, start) {
      for (var i = (start || 0), j = this.length; i < j; i++) {
        if (this[i] == obj) {
          return i;
        }
      }
      return -1;
    }
  }

  <?php
  print "var level3Array = [];";
  $i = 0;
  foreach ((array)$list as $key => $value) {
    if ($value[1] == 3 && $key > 0) {
      print "level3Array[{$i}] = '{$key}';";
      $i++;
    }
  }
  ?>

  $(document).ready(function() {
    //$("#aTanuloszoba").tooltip({ position: { my: "left+15 center", at: "right center" } });
    $(".imgLangChange").click(function() {
      changeLanguage($(this).data("lang"));
    });
    $(".ajaxLangChoose").click(function() {
      $(".ajaxLangChoose").css("font-weight", "normal");
      $(this).css("font-weight", "bold");
    });
    $("#ajaxTable").css("width", "200px");
    $(".login-controls .login-input").hide();
  });

  // function changeLanguage(lang){
  //     location.href = "index.php?langChange=" + lang;
  // }

  var clearbox = new Array(); // global variable
  clearbox[0] = 0;
  clearbox[1] = 0;

  function clearit(obj, num) {
    if (clearbox[num] == 0) {
      obj.value = "";
      clearbox[num] = 1;
    }
  }

  function toggleMenu() {
    $.post("/api/update_session.php", {
        isShown: <?php echo json_encode($_SESSION['isShown'] ? 0 : 1); ?>
      })
      .done(function() {
        location.reload();
      });
  }

  function submitToMain(content) {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      document.forms['submitForm'].content.value = content;
      document.forms['submitForm'].submit();
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function lowerSelectOnChange(val, src, clickSource) {
    <?php if ($userObject) { ?>
      if (level3Array.indexOf(val.toString()) > -1) {
        location.href = basePath + '/pages/main.php?content=showRule&selectedLevel=' + val + '&source=' + src + '&clickSource=' + clickSource;
      } else {
        location.href = basePath + '/pages/main.php?content=wordLearning_quick&packageStart=1&selectedLevel=' + val + '&source=' + src + '&clickSource=' + clickSource;
      }
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function startPrintLevel(level) {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      var level = parseInt(level, 10);
      if (isNaN(level)) {
        alert('Nem találom a kiválasztott level-t!');
        return;
      }
      window.open('/pages/printViewSent.php?wordLevel=' + level, 'Szófajok', 'fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes');
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function startPrintMumus() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      window.open('/pages/printViewSent.php?pkg=mumus&source=szo', 'Szófajok', 'fullscreen=yes,toolbar=no,status=no,menubar=no,resizable=yes,location=no,scrollbars=yes');
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function intelligensGyakorlo() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      location.href = basePath + '/pages/main.php?content=wordLearning_quick&packageStart=1&source=mondat&clickSource=intelligent';
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function osszgyakorlo() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      location.href = basePath + '/pages/main.php?content=wordLearning_quick&packageStart=1&source=mondat&clickSource=osszgyakorlo';
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function peldamondatok() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      document.getElementById('sentencePracticeDiv2').style.display = 'block';
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function alapszokincs() {
    <?php if ($userObject) { ?>
      document.getElementById('vocabularyDiv').style.display = 'block';
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function sajatSzavak() {
    <?php if ($userObject) { ?>
      document.getElementById('wordPracticeDiv').style.display = 'block';
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function audioSzoba() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      location.href = basePath + '/pages/index.php?audioszoba'
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function tudastar() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      document.getElementById('knowledgeBaseDiv').style.display = 'block';
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function szotarFeltoltes() {
    <?php if ($userObject && $userObject['status'] != 1) { ?>
      location.href = basePath + '/pages/main.php?content=wordLearning_kikerdezo&source=welcome'
    <?php } else if ($userObject['status'] == 1) { ?>
      alert(premiumUserOnlyMessage);
    <?php } else { ?>
      alert(notLoggedInMessage);
    <?php } ?>
  }

  function t_Click(event) {
    event.stopPropagation();
    if (document.getElementById('clientDiv').style.display == 'none') {
      document.getElementById('clientDiv').style.display = 'block';
      document.getElementById('financeDiv').style.display = 'none';
      // Hide only the content part of mainDiv, not the navigation
      var mainDivChildren = document.getElementById('mainDiv').children;
      for (var i = 0; i < mainDivChildren.length; i++) {
        if (!mainDivChildren[i].classList.contains('navigation-mainDiv')) {
          mainDivChildren[i].style.display = 'none';
        }
      }
    } else {
      document.getElementById('clientDiv').style.display = 'none';
      // Show all mainDiv children again
      var mainDivChildren = document.getElementById('mainDiv').children;
      for (var i = 0; i < mainDivChildren.length; i++) {
        mainDivChildren[i].style.display = '';
      }
    }
  }

  function p_Click(event) {
    event.stopPropagation();
    if (document.getElementById('financeDiv').style.display == 'none') {
      document.getElementById('financeDiv').style.display = 'block';
      document.getElementById('clientDiv').style.display = 'none';
      document.getElementById('mainDiv').style.display = 'none';
    } else {
      document.getElementById('financeDiv').style.display = 'none';
      document.getElementById('mainDiv').style.display = 'block';
    }
  }

  function goToRegistration() {
    location.href = basePath + '/pages/subscribe.php?nyelv=' + nyelv;
  }
</script>