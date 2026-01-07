<?php
session_start();
session_destroy();
print "<script>location.href='../pages/index.php';</script>";
