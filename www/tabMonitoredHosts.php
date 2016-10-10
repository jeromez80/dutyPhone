<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/functions/monitoredhosts.php");

if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>


<div class="row">
   <div class="large-10 columns">
        <div class="panel">
          	<h3>Monitored Hosts</h3>
          	<form name="monitoredhosts" method="post" action="#">
			<p>You can monitor the uptime of specific IP addresses. Please enter your host IP addresses in this list and SmartMessage will alert you once it fails the configured  ping tests.</p>
			<div class="row">
				<div class="large-12 medium-12 columns">
						<p>Host Fail Definition: <b>5</b> consecutive ping timeout</p>
						<p>Host Available Definition: <b>5</b> consecutive ping reply</p>
						<p>Repeated Fail Alerts: <b>Disabled</b></p>
				</div>

				<div class="large-12 medium-12 columns">
					<div class="large-9 medium-9 columns">
						<label>Host IP:</label>
<input type='text' name='filter1keyword' value='192.168.10.254' class="small radius" length="10">
            				</div>
					<div class="large-3 medium-3 columns">
						<input type="button" class="small radius button" value="Delete">
            				</div>
				</div>

				<div class="large-12 medium-12 columns">
					<div class="large-9 medium-9 columns">
						<label>Host IP:</label>
<input type='text' name='filter1keyword' value='192.168.10.1' class="small radius" length="10">
            				</div>
					<div class="large-3 medium-3 columns">
						<input type="button" class="small radius button" value="Delete">
            				</div>
				</div>


				<div class="large-12 medium-12 columns">
					<input type="button" class="small radius button" value="Add Host...">
				</div>

          		</div>
                
			<div class="row">
                        	<div class="panel" style="border:none;">
                                	<input type="submit" class="small radius button" value="Save Monitored Hosts" name="btnSaveFilters">
                        	</div>
			</div>
                   
		</form>
       	  </div>
    </div>
</div>
