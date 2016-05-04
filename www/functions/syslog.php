<?php
require_once(__DIR__."/initialise.php");

function get_inSyslogs() {
        $query = mysql_query("select ReceivedAt, FromHost, IP, Message from `SystemEvents` order by ID desc;");
        if(!$query) {
                die('invalid query' . mysql_error());
        }

        return $query;
}
?>
