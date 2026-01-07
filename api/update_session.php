<?php
session_start();
if (isset($_POST['isShown'])) {
  $_SESSION['isShown'] = $_POST['isShown'] === '1' ? true : false;
}
