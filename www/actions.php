<?php
if(isset($_POST['btnSaveNetwork']))
{
		$newIP = $_POST['staticIP'];
		if (!$config->set_ipaddr($newIP)) { echo 'Set StaticIP Error!'; }
		$newGW = $_POST['staticGW'];
		if (!$config->set_ipgateway($newGW)) { echo 'Set Gateway Error!'; }
		$newDNS = $_POST['staticDNS'];
		if (!$config->set_ipdns($newDNS)) { echo 'Set DNS Error!'; }

		if ($newIP == '') { unlink('setIP.txt'); } else { file_put_contents('setIP.txt', $newIP); }
		if ($newGW == '') { unlink('setGW.txt'); } else { file_put_contents('setGW.txt', $newGW); }
		if ($newDNS == '') { unlink('setDNS.txt'); } else { file_put_contents('setDNS.txt', $newDNS); }
}
if(isset($_POST['submit']))
{
		$sms_number = $_POST['sms_message_centre'];
		if (!$config->set_smsc($sms_number)) { echo 'Set SMSC Error!'; }
		$last_number = $_POST['last_incoming_message_form'];
		if (!$config->set_lastmsgnum($last_number)) { echo 'Set LastNum  Error!'; }
		$current_number = $_POST['current_duty_number'];
		if (!$config->set_dutynum($current_number)) { echo 'Set DutyNum Error!'; }

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
 
$select = "select * from `WAGroupChats`";
$query = mysql_query($select);
while($row=mysql_fetch_array($query))
{
	$group_details[] = $row;		
}

$staticIP = file_get_contents('setIP.txt');
$staticGW = file_get_contents('setGW.txt');
$staticDNS = file_get_contents('setDNS.txt');

