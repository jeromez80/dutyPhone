<?php
require_once(__DIR__."/initialise.php");

$connect = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);

function get_ipaddr() { 
	$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Addr"');

	if ($row=mysql_fetch_array($query)) { 
		return $row["Config_Value"]; 
	}

}

function get_ipgateway() { 

	$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Gateway"');
	
	if ($row=mysql_fetch_array($query)) { 
		return $row["Config_Value"];
	}

}

function get_ipdns() { 
	$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_DNS"');
	
	if ($row=mysql_fetch_array($query)) { 
		return $row["Config_Value"]; 
	}

}


function set_ipaddr($value) {
     return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_Addr", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}



?>
