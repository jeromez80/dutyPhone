<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/functions/sms.php");

if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>
	<form name="sendsms" method="post" action="#">
	<div class="row">
		<div class="large-10 medium-10 columns">
			<div class="panel">
			<h3>Send SMS</h3>
              <label>You can send messages from SmartMessage using the following form.</label>
			<div>
		              <input type="text" name="destnum" placeholder="Recipient mobile number" value=""/>
		              <input type="text" name="message" placeholder="Text message" value=""/>
			      <input type="submit" name="btnSendSms" value="Send" class="small radius button"/>
			</div>
                        </div>
		</div>
	</div>
	</form>
