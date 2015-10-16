<?php
include("config.php");
$id = $_POST['group_id'];
$old_status = trim($_POST['status']);
if($old_status == "enable")
{
	$status = "disable";
}
if($old_status == "disable")
{
	$status = "enable";
}
$update	= "UPDATE group_details SET `status`='".$status."' where `id`='".$id."'";
$query = mysql_query($update);

?>
