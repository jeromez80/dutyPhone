<?php
require_once(__DIR__."/initialise.php");

function get_ipaddr() { 
	$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Addr"');

	if ($row=mysql_fetch_array($query)) { 
		return $row["Config_Value"]; 
	}

}

function get_subnet() { 
	$query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="IP_Subnet"');

	if ($row=mysql_fetch_array($query)) { 
		return $row["Config_Value"]; 
	} else {
		return '255.255.255.0';
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

function set_subnet($value) {
     return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_Subnet", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

function set_ipgateway($value) {
     return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_Gateway", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

function set_dns($value) {
     return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("IP_DNS", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

function write_ifcfg($filename, $interface, $uuid) {
	//Write to file with a standard template
	$ipaddr=get_ipaddr();
	if ($ipaddr != '') {
	        $ipsettings='BOOTPROTO=static
IPADDR='.$ipaddr.'
NETMASK='.get_subnet().'
GATEWAY='.get_ipgateway();
	}
	else {
	      	$ipsettings='BOOTPROTO=dhcp';
	}
	file_put_contents($filename,
"TYPE=Ethernet
$ipsettings
DEFROUTE=yes
PEERDNS=yes
PEERROUTES=yes
IPV4_FAILURE_FATAL=no
IPV6INIT=yes
IPV6_AUTOCONF=yes
IPV6_DEFROUTE=yes
IPV6_PEERDNS=yes
IPV6_PEERROUTES=yes
IPV6_FAILURE_FATAL=no
NAME=$interface
UUID=$uuid
DEVICE=$interface
ONBOOT=yes
");
}


if ($_POST['btnSaveNetwork']!='') {
	set_ipaddr($_POST['staticIP']);
	if ($_POST['staticIP']!='') {
		set_subnet($_POST['staticSN']);
		set_ipgateway($_POST['staticGW']);
	} else {
		set_subnet('');
		set_ipgateway('');
	}
	set_dns($_POST['staticDNS']);

	write_ifcfg('/etc/sysconfig/network-scripts/ifcfg-enp2s0', 'enp2s0', '751607d1-a6ef-4e39-8a85-07c6c69aee55');
}

if ($_POST['reboot']!='') {
	file_put_contents('/var/www/html/reboot.server', 'GO');
}

?>
