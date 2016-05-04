<?php
require_once(__DIR__."/initialise.php");

function get_inOutSMSlogs() {
        	
	$statement = "SELECT * FROM ( SELECT Timestamp, MsgFrom, MsgTo, Message from `IncomingSMS` UNION ALL SELECT job_Time as TimeStamp,`MsgFrom`,concat(`Dest_CtyCode`,`Dest_Number`) as MsgTo,Dest_Message FROM OutMessageCompleted where Job_Type='SMS') as a ORDER BY TimeStamp DESC;";

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

?>
