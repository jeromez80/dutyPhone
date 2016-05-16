<?php
require_once(__DIR__."/initialise.php");

function get_inOutSMSlogs() {
        	
	$statement = "
		SELECT * FROM 
			( SELECT Timestamp, MsgFrom, MsgTo, Message, 'Received' from `IncomingSMS` 
				UNION ALL 
			SELECT job_Time as TimeStamp,`MsgFrom`,concat(`Dest_CtyCode`,`Dest_Number`) as MsgTo,Dest_Message, 'Sent' 
				FROM OutMessageCompleted where Job_Type='SMS') as A
			UNION ALL
			SELECT job_Time as TimeStamp,'SMGateway',concat(`Dest_CtyCode`,`Dest_Number`) as MsgTo,Dest_Message, 'Queued' 
				FROM OutMessageQueue where Job_Type='SMS'
			ORDER BY TimeStamp DESC;
		";

	$query = mysql_query($statement);
	if(!$query) {
		die('invalid query' . mysql_error());
	} 

	return $query;
}


function get_inSMSlogs() {
        $query = mysql_query("select Timestamp, MsgFrom, MsgTo, Message from `IncomingSMS` order by SMS_ID desc;");
        if(!$query) {
                die('invalid query' . mysql_error());
        }

        return $query;
}


function get_outSMSlogs() {
        $query = mysql_query("SELECT `Job_ID`,`MsgFrom`,concat(`Dest_CtyCode`,`Dest_Number`) as `MsgTo`,`Dest_Message` FROM `OutMessageCompleted` where Job_Type='SMS';");
        if(!$query) {
                die('invalid query' . mysql_error());
        }

        return $query;
}

if ($_POST['btnSendSms'] != '') {
	$msg= $_POST['message'];
	if ($_POST['destnum'][0]=='+') {
		$ctycode = substr($_POST['destnum'],1,2);
		$destnum = substr($_POST['destnum'],3);
	} else {
		$ctycode = '';
		$destnum = $_POST['destnum'];
	}
        $query = mysql_query("INSERT INTO `OutMessageQueue` (Job_ID, Job_Time, Job_Type, Dest_CtyCode, Dest_Number, Dest_Message) VALUES (NULL, NULL, 'SMS', '$ctycode', '$destnum', '$msg')
	");
        if(!$query) {
                die('invalid query' . mysql_error());
        }
	$msgBox = 'Message sent: ' .$_POST['message'] . ' To: '.$_POST['destnum'];

        return $query;
}

?>
