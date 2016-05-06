<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/functions/mobilenetwork.php");

if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>


	<form name="mobile_settings" method="post" action="#">
	<div class="row">
		<div class="large-10 medium-10 columns">
			<div class="panel">
			<h3>Mobile Network Settings</h3>
          <p>Depending on your messaging provider, please configure the appropriate settings here.</p>
	<p>Singtel Mobile, please enter +6596197777</p>
	<p>Singtel Hi! Card, please enter +6596400001</p>
	<p>Starhub, please enter +6598540020</p>
	<p>M1 (MobileOne), please enter +6596845997</p>
          <div class="row">
            <div class="large-4 medium-4 columns">
              <label>SMS Message Center</label>
              <input type="text" name="sms_message_centre" placeholder="SMSC Number from Telco" value="<?php echo get_smsc(); ?>"/>
            </div>
          </div>
                  <div class="row">
                        <div class="panel" style="border:none;">
                                <input type="submit" class="small radius button" value="Update" name="btnMNsubmit">
                        </div>
                  </div>

			</div>
		</div>
	</div>
	</form>
