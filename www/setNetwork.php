<form method="POST" action="">
Static IP <input type=text name='ip'>
Subnet <input type=text name='subnet'>
<input type=submit>
</form>
<?php
if ($_POST['ip']!='') {
	$ipsettings='BOOTPROTO=static
IPADDR='.$_POST['ip'];
}
else {
	$ipsettings='BOOTPROTO=dhcp';
}

//Write to file regardless
file_put_contents('/etc/sysconfig/network-scripts/ifcfg-dumb0',
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
NAME=enp2s0
UUID=751607d1-a6ef-4e39-8a85-07c6c69aee55
DEVICE=enp2s0
ONBOOT=yes
");

?>
