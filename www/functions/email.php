<?php
require_once(__DIR__."/initialise.php");

function get_inEmails() {
        $query = mysql_query("select Timestamp, MsgFrom, MsgTo, Message from `IncomingEmail` order by Email_ID desc;");
        if(!$query) {
                die('invalid query' . mysql_error());
        }

        return $query;
}
?>
