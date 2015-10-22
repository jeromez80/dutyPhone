<?php
include("config.php");
 
if(isset($_POST['submit']))
{
		$sms_number = $_POST['sms_message_centre'];
		$last_number = $_POST['last_incoming_message_form'];
		$current_number = $_POST['current_duty_number'];				
		$update	= "UPDATE ".Suffix."mmg_phone_numbers SET `sms_message_center`='".$sms_number."', `current_duty_number`='".$current_number."', `last_incoming_message`='".$last_number."' where `id`='1'";
		$query = mysql_query($update);
		$newIP = $_POST['staticIP'];
		$newGW = $_POST['staticGW'];
		if ($newIP == '') {
			unlink('setIP.txt');
		} else {
			file_put_contents('setIP.txt', $newIP);
		}
		if ($newGW == '') {
			unlink('setGW.txt');
		} else {
			file_put_contents('setGW.txt', $newGW);
		}
}
if(isset($_POST['action'])){
	$id	=	$_POST['id'];
	mysql_query("DELETE from superviser_number WHERE id='".$id."'");
	die;
}
if(isset($_POST['submit2']))
{
		$superviser_number = $_POST['superviser_number'];
		$number_type = $_POST['number_type'];
		$insert = "Insert INTO superviser_number SET `number`='".$superviser_number."',number_type='".$number_type."' ";
		$query_insert = mysql_query($insert);
}
if(isset($_POST['submit3']))
{
		$superviser_number = $_POST['staff_number'];
		$number_type = $_POST['number_type'];
		$insert = "Insert INTO superviser_number SET `number`='".$superviser_number."',number_type='".$number_type."' ";
		$query_insert = mysql_query($insert);
}
if(isset($_POST['reboot']))
{
		file_put_contents('reboot.now', 'via GUI');
}
if(isset($_POST['newWAlic']))
{
	$decoded = base64_decode($_POST['newlicense'], true);
	if ($decoded === false) { $licmsg = 'Invalid license.'; }
	$lines = explode(PHP_EOL, $decoded);
	if ($lines[0] != 'GeekWAlic00011') {
		$licmsg = '<font color="red">This is not a valid license file.</font>';
	} else {
		//VALID
		$newnum = $lines[1];
		$newpw = $lines[2];
		if (substr($newnum,0,2) != '65') {
			$licmsg = '<font color="red">The number contained in the license file is invalid.</font>';
		} else {
			mysql_query("TRUNCATE data;");
			mysql_query("INSERT INTO data VALUES ('$newnum', '$newpw', 'SmartMessage', '1')");
			$licmsg = '<font color="green">The new number '.$newnum.' has been registered.</font>';
		}
	}
}
 
$select = "select * from `mmg_phone_numbers`";
$query = mysql_query($select);
while($row=mysql_fetch_array($query))
{
	$data[] = $row;		
}

$select = "select * from `group_details`";
$query = mysql_query($select);
while($row=mysql_fetch_array($query))
{
	$group_deails[] = $row;		
}

$staticIP = file_get_contents('setIP.txt');

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart-Message Gateway :: Configuration</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
	
  </head>
  <body>
    
    <div class="row">
      <div class="large-12 columns">
        <h1>Smart-Message Gateway Setup</h1>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
        <div class="panel">
          <h3>Thank you for choosing Smart-Message! </h3>
          <form name="mmg_numbers" method="post" action="#">
          <p>To access this appliance from your network, please configure the network options below. Remember to connect your network to the correct physical port on this appliance.</p>
          <div class="row">
            <div class="large-8 medium-8 columns">
              <label>Network IPv4 Address (Leave blank for DHCP)</label>
              <input type="text" name="staticIP" placeholder="Leave blank for dynamic IP Address" value="<?php if(isset($staticIP)) { echo $staticIP; }?>"/>
              <label>Network IPv4 Gateway</label>
              <input type="text" name="staticGW" placeholder="Leave blank for DHCP assigned value" value="<?php if(isset($staticGW)) { echo $staticGW; }?>"/>
            </div>
            <div class="large-4 medium-4 columns">
		<?php
			if (file_exists('reboot.now')) { echo '<label>Rebooting... Please wait a minute.</label>'; }
		?>
              <input type="submit" class="small radius button" name="reboot" value="Reboot Smart-Message"/>
            </div>
          </div>
          <p>Depending on your messaging provider, please configure the appropriate settings here.</p>
          <div class="row">
            <div class="large-4 medium-4 columns">
              <label>SMS Message Center</label>
              <input type="text" name="sms_message_centre" placeholder="SMSC Number" value="<?php if(isset($data['0']['sms_message_center'])) { echo $data['0']['sms_message_center']; }?>"/>
            </div>
            <div class="large-4 medium-4 columns">
              <label>Current Duty Number</label>
              <input type="text" name="current_duty_number" placeholder="+65" value="<?php if(isset($data['0']['current_duty_number'])) { echo $data['0']['current_duty_number']; }?>"/>
            </div>
            <div class="large-4 medium-4 columns">
	      <label>Last Incoming Message From</label>
              <input type="text" name="last_incoming_message_form" placeholder="+65xxxxx" value="<?php if(isset($data['0']['last_incoming_message'])) { echo $data['0']['last_incoming_message']; }?>"/>
            </div>
          </div>
		 
		  <div class="row">
			<div class="panel" style="border:none;">
				<input type="submit" class="small radius button" value="Update" name="submit">
			</div>
			 </form>
		  </div>
          <div class="row">
            <div class="large-12 medium-12 columns">
              This device is pre-configured to: 
              <ul>
                <li style='color:green'><b>Send incoming alerts to both SMS duty number and selected WhatsApp Group Chat (Enabled)</b></li>
                <li style='color:gray'>Send incoming alerts to SMS duty number only</li>
                <li style='color:gray'>Send incoming alerts selected WhatsApp Group Chat. If it fails, send to duty number via SMS</li>
              </ul>
              Supported alerts: SMS, HTTP, SMTP via TCP/25
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="large-6 medium-6 columns">
        <div class="panel">
          <div class="row">
            <div class="large-6 medium-6 columns">
              <h4>SMS Options</h4>
            </div>
          </div>
          <div class="row">
            <div class="large-12 medium-12 columns">
              <p>Registered numbers</p>
	<ul class=mtree>
		<?php
			$res55	=	mysql_query("SELECT * FROM `superviser_number`  ") or die(mysql_error());
			if(mysql_num_rows($res55) > 0){
				while ($dao = mysql_fetch_assoc($res55)){
					if($dao['number_type']=='S'){
						$number_type	=	'Supervisor';	
					}else{
						$number_type	=	'Staff';
					}
					echo  '<li id="li_'.$dao['id'].'">'.$dao['number'].'&nbsp;&nbsp;'.$number_type.'&nbsp;&nbsp;<a href="javascript:void(0)" rel="'.$dao['id'].'" class="small radius button delete_no" style="background-color:red;">Delete</a></li>';	
				}
			}
		?>
	</ul>
              <a href="javascript:void(0)" class="small radius button superviser_number">Add Supervisor Number</a><br/>
			  <form name="f2" method="post" action="#">
			   <input type="text" class="superviser" name="superviser_number" placeholder="Superviser Number" value="" style="display:none;">
			   <input type="hidden" name="number_type" value="S">
			   <input type="submit" class="small radius button superviser" value="submit" name="submit2" style="display:none;">
			  </form> 
              <a href="javascript:void(0)" class="staff_data small radius button">Add Staff Number</a><br/>
			  <form name="f2" method="post" action="#">
			   <input type="text" class="staff_data_input" name="staff_number" placeholder="Staff Number" value="" style="display:none;">
			   <input type="hidden" name="number_type" value="D">
			   <input type="submit" class="small radius button staff_data_input" value="submit" name="submit3" style="display:none;">
			  </form> 
            </div>
          </div>
        </div>
      </div>

      <div class="large-6 medium-6 columns">
        <div class="panel">
          <div class="row">
            <div class="large-12 medium-12 columns">
              <h4>WhatsApp Options</h4>
            </div>
          </div>
          <div class="row">
            <div class="large-12 medium-12 columns">
		<p>Load a new WhatsApp license:</p>
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
			  <?php foreach($group_deails as $group_data){ ?>	
              <li><?php echo $group_data['group_names']; ?></a> <input class="state" type="checkbox" value ="<?php echo $group_data['status']; ?>" rel="<?php echo $group_data['id'] ?>"<?php if($group_data['status'] == "enable"){ echo 'checked'; } ?> /><label>Enable</label></li>
              <?php }	?>	
			</ul>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="large-12 medium-12 columns">
        <div class="panel">
        <h3>Message Log</h3>
<?php
$select = "select timestamp, sender, receiver, message from `messages` order by id desc";
$query = mysql_query($select);
while($row=mysql_fetch_array($query))
{
	echo '
		<div class="panel">
		<div class="row">
		<div class="large-4 medium-4 columns"><label>Date: '.$row[0].'</label></div>
		<div class="large-4 medium-4 columns"><label>From: '.$row[1].'</label></div>
		<div class="large-4 medium-4 columns"><label>To: '.$row[2].'</label></div>
		</div><div class="row">
		<div class="large-12 medium-12 columns"><label>Message: '.$row[3].'</label></div>
		</div></div>
	';
}

?>
        <form action="#" method="POST"><input class="small radius button" type="submit" name="nothing" value="Refresh"></form>
        </div>
      </div>
    </div>

    <script src="js/velocity.js"></script>
    <script src="js/mtree.js"></script>
    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
	  $( ".state" ).click(function() {
		   var id = $(this).attr("rel");
		   var group_status = $(this).val();
		   
				   $.ajax({
				  method: "POST",
				  url: "change_status.php",
				  data: { group_id: id, status: group_status },
				  success:function(a){alert('GroupChat is no longer '+group_status+'d.');}
				})
		});
		$('.delete_no').click(function(){
			var id	=	$(this).attr('rel');
			var data	=	'id='+id+'&action=delete';
			$.ajax({
				data: data,
				type:'POST',
				url:'index.php',
				success:function(r){
					$('#li_'+id).remove();
				}
			})
		})
		$(".superviser_number").click(function(){
			$(".superviser").toggle();
		});
		$(".staff_data").click(function(){
			$(".staff_data_input").toggle();
		});
	</script>
  </body>
</html>
