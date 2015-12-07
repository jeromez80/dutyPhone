<?php
include_once("includes/main.inc.php");
if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>
