<?php
//only include ulogin.php as we only need that.
//The rest of the script should include includes/main.inc,php
require_once("functions/ulogin.php");

// Start a secure session if none is running
if (!sses_running())
        sses_start();


$msg = "";
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
  <div class="medium-12 medium-centered large-4 large-centered columns">

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
	<p><input type="submit" class="button button-expanded" value="Log In"></p>
      </div>
    </form>

  </div>
</div>
</body>
</html>
<?php
}//end checkAppLogin
?>




