<div class="content" id="panelMN">
	<form name="mobile_settings" method="post" action="#">
	<div class="row">
		<div class="large-10 medium-10 columns">
			<div class="panel">
			<h3>Mobile Network Settings</h3>
          <p>Depending on your messaging provider, please configure the appropriate settings here.</p>
          <div class="row">
            <div class="large-4 medium-4 columns">
              <label>SMS Message Center</label>
              <input type="text" name="sms_message_centre" placeholder="SMSC Number from Telco" value="<?php echo $config->get_smsc(); ?>"/>
            </div>
            <div class="large-4 medium-4 columns">
              <label>Current Duty Number</label>
              <input type="text" name="current_duty_number" placeholder="Default to receive alerts" value="<?php echo $config->get_dutynum(); ?>"/>
            </div>
            <div class="large-4 medium-4 columns">
              <label>Last Incoming Message From</label>
              <input type="text" name="last_incoming_message_form" placeholder="For replying to SMS" value="<?php echo $config->get_lastmsgnum(); ?>"/>
            </div>
          </div>
                  <div class="row">
                        <div class="panel" style="border:none;">
                                <input type="submit" class="small radius button" value="Update" name="submit">
                        </div>
                  </div>

			</div>
		</div>
	</div>
	</form>
</div>
