<?php
require_once('config/all.inc.php');
require_once('main.inc.php');
function isAppLoggedIn(){
        return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}
