<?php

class ConfigData {

	private $smsc;
	private $dutynum;
	private $lastmsgnum;

	function __construct() {
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="SMSC_Num"');
		if ($row=mysql_fetch_array($query)) { $this->smsc=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Duty_Num"');
		if ($row=mysql_fetch_array($query)) { $this->dutynum=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Last_Num"');
		if ($row=mysql_fetch_array($query)) { $this->lastmsgnum=$row["Config_Value"]; }
	}

	function load_data() {
	}

	function get_smsc() {
		return $this->smsc;
	}

	function set_smsc($value) {
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("SMSC_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function get_dutynum() {
		return $this->dutynum;
	}

	function set_dutynum($value) {
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Duty_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function get_lastmsgnum() {
		return $this->lastmsgnum;
	}

	function set_lastmsgnum($value) {
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Last_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

}
