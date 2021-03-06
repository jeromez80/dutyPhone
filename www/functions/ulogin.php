<?php
require_once("functions/ulogin/config/all.inc.php");
require_once("functions/ulogin/main.inc.php");


function isAppLoggedIn(){
        return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}

function appLogin($uid, $username, $ulogin){
        $_SESSION['uid'] = $uid;
        $_SESSION['username'] = $username;
        $_SESSION['loggedIn'] = true;

        if (isset($_SESSION['appRememberMeRequested']) && ($_SESSION['appRememberMeRequested'] === true))
        {
                // Enable remember-me
                if ( !$ulogin->SetAutologin($username, true))
                        echo "cannot enable autologin<br>";

                unset($_SESSION['appRememberMeRequested']);
        }
        else
        {
                // Disable remember-me
                if ( !$ulogin->SetAutologin($username, false))
                        echo 'cannot disable autologin<br>';
        }
}

function appLoginFail($uid, $username, $ulogin){
        // Note, in case of a failed login, $uid, $username or both
        // might not be set (might be NULL).
}

function appLogout(){
  // When a user explicitly logs out you'll definetely want to disable
  // autologin for the same user. For demonstration purposes,
  // we don't do that here so that the autologin function remains
  // easy to test.
  //$ulogin->SetAutologin($_SESSION['username'], false);

        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        unset($_SESSION['loggedIn']);
}

?>
