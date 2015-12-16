<?php
include_once("includes/main.inc.php");
if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>

<div class="row">
      		<div class="large-10 medium-10 columns">
        		<div class="panel">
          			<div class="row">
            				<div class="large-12 medium-12 columns">
              					<h4>WhatsApp Options</h4>
            				</div>
          			</div>
          
				<div class="row">
            
					<div class="large-12 medium-12 columns">
          	      
						<p>Load a new WhatsApp license:</p>

						<p> TODO: Show WhatsApp number and current license status (valid, not valid, etc)</P>
                
						<?php if (isset($licmsg)) { echo "<p>$licmsg</p>"; } ?>
							<form method="POST" action="#">
               							<textarea name="newlicense" class="small radius panel"></textarea>
                						<input type="submit" class="small radius button" name="newWAlic">
                					</form>
            				</div>
          			</div>
          

				<div class="row">
            
					<div class="large-12 medium-12 columns">
            
						<p>List of Group Chats:</p>
            
						<ul>
                          				<?php foreach($group_details as $group_data){ ?>
              
								<li><?php echo $group_data['group_names']; ?></a> <input class="state" type="checkbox" value ="<?php echo $group_data['status']; ?>" rel="<?php echo $group_data['id'] ?>"<?php if($group_data['status'] == "enable"){ echo 'checked'; } ?> /><label>Enable</label></li>
              <?php }   ?>
                        			</ul>
            
					</div>
          			</div>
        		</div>
      
		</div>
    	</div>
