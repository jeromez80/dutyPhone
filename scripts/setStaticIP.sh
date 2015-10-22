sed '/BOOTPROTO/d' ./ifcfg-enp3s0 > ifcfg-new
echo 'BOOTPROTO=static' >>ifcfg-new
echo 'IPADDR='$1 >>ifcfg-new
echo 'NETMASK=255.255.255.0' >>ifcfg-new
echo 'GATEWAY=$2' >>ifcfg-new
