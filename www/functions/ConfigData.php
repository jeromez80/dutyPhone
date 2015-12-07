<?php

class ConfigData {

	private $smsc;
	private $dutynum;
	private $lastmsgnum;
	private $ipaddr;
	private $ipgateway;
	private $ipdns;

	function __construct() {
		$this->load_data();
	}

	function load_data() {
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="SMSC_Num"');
		if ($row=mysql_fetch_array($query)) { $this->smsc=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Duty_Num"');
		if ($row=mysql_fetch_array($query)) { $this->dutynum=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Last_Num"');
		if ($row=mysql_fetch_array($query)) { $this->lastmsgnum=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Addr"');
		if ($row=mysql_fetch_array($query)) { $this->ipaddr=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Gateway"');
		if ($row=mysql_fetch_array($query)) { $this->ipgateway=$row["Config_Value"]; }
		$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_DNS"');
		if ($row=mysql_fetch_array($query)) { $this->ipdns=$row["Config_Value"]; }
	}

	function get_smsc() { return $this->smsc; }
	function get_dutynum() { return $this->dutynum; }
	function get_lastmsgnum() { return $this->lastmsgnum; }
	function get_ipaddr() { return $this->ipaddr; }
	function get_ipgateway() { return $this->ipgateway; }
	function get_ipdns() { return $this->ipdns; }

	function set_smsc($value) {
		$this->smsc=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("SMSC_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function set_dutynum($value) {
		$this->dutynum=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Duty_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function set_lastmsgnum($value) {
		$this->lastmsgnum=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Last_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function set_ipaddr($value) {
		$this->ipaddr=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_Addr", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function set_ipgateway($value) {
		$this->ipgateway=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_Gateway", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));		
	}

	function set_ipdns($value) {
		$this->ipdns=$value;
		return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_DNS", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
	}

}
