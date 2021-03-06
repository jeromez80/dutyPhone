<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/functions/network.php");

if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>


<div class="row">
   <div class="large-10 columns">
        <div class="panel">
          	<h3>Thank you for choosing Smart-Message! </h3>
          	<form name="mmg_numbers" method="post" action="#">
          		<p>To access this appliance from your network, please configure the network options below. Remember to connect your network to the correct physical port on this appliance.</p>
          
			<div class="row">
            		
				<div class="large-6 medium-6 columns">
              				<label>Network IPv4 Address (Leave blank for DHCP)</label>
              				<input type="text" name="staticIP" placeholder="Leave blank for dynamic IP Address" value="<?php echo get_ipaddr();?>"/>
              				<label>Network IPv4 Subnet </label>
              				<input type="text" name="staticSN" placeholder="Leave blank for DHCP assigned value" value="<?php echo get_subnet();?>"/>
              				<label>Network IPv4 Gateway</label>
              				<input type="text" name="staticGW" placeholder="Leave blank for DHCP assigned value" value="<?php echo get_ipgateway();?>"/>
              				<label>Network IPv4 DNS</label>
              				<input type="text" name="staticDNS" placeholder="Leave blank for DHCP assigned value" value="<?php echo get_ipdns();?>"/>
            			</div>
            
				<div class="large-6 medium-6 columns">
                			<?php
                        			if (file_exists('reboot.now')) { echo '<label>Rebooting... Please wait a minute.</label>'; }
                			?>
              				<input type="submit" class="small radius button" name="reboot" value="Reboot Smart-Message"/>
            			</div>
          		</div>
                
			<div class="row">
                        	<div class="panel" style="border:none;">
                                	<input type="submit" class="small radius button" value="Save Network Configuration" name="btnSaveNetwork">
                        	</div>
			</div>
                   
          		<div class="row">
            			<div class="large-12 medium-12 columns">
              				This device is pre-configured to:
              				<ul>
                				<li style='color:gray'>Send incoming email alerts to preconfigured mobile numbers.</li>
              				</ul>
 	           		</div>
         		 </div>
		</form>
       	  </div>
    </div>
</div>
