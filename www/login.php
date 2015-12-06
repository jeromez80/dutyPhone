<?php
require_once('ulogin/config/all.inc.php');
require_once('ulogin/main.inc.php');

// Start a secure session if none is running
if (!sses_running())
        sses_start();

// We define some functions to log in and log out,
// as well as to determine if the user is logged in.
// This is needed because uLogin does not handle access control
// itself.

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
<?php

$ulogin = new uLogin('appLogin', 'appLoginFail');
if (isAppLoggedIn()){
        header('Location:index.php');

}else{

	if($_POST['username'] != "" && $_POST['pwd'] != ""){
 
          $ulogin->Authenticate($_POST['username'],  $_POST['pwd']);
          if ($ulogin->IsAuthSuccess()){
         	// Since we have specified callback functions to uLogin,
         	// we don't have to do anything here.
          	header('Location:index.php'); 
	  }else{     
		$msg = 'Invalid username or password!';
          }//end if-else
	}
}



if (!isAppLoggedIn()) { ?> 
<html>
<head>
<link rel="stylesheet" href="css/foundation1.css" />
<link rel="stylesheet" href="css/foundation.min.css" />
<link rel="stylesheet" href="css/app.css" />
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="row center-page">
  <div class="medium-6 medium-centered large-4 large-centered columns">

    <form action="login.php" method="POST">
      <div class="row column log-in-form">
        <h4 class="text-center">SMSGateway Management Portal Login</h4>
        <label>Username
          <input name="username" type="text"">
        </label>
        <label>Password
          <input name="pwd" type="password" placeholder="Password">
        </label>
      	<p style="color:#FF0000"><br/>
	<?php echo ($msg);?>
	</p>
	<input type="hidden" id="nonce" name="nonce" value="<?php echo ulNonce::Create('login');?>">
	<p><input type="submit" class="button expanded" value="Log In"></p>
      </div>
    </form>

  </div>
</div>
</body>
</html>
<?php
}//end checkAppLogin
?>




