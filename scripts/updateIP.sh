#!/bin/bash
# JACKSON DA GEEK
# get memory size

TOTALMEM=`grep -w MemTotal /proc/meminfo | awk '{print $2 " " $3}'`

# get # of cpus
TOTALCPUS=`grep -c processor /proc/cpuinfo`

# figure out how CPU count is determined
if [ `grep -c "Using ACPI (MADT)" /var/log/dmesg` == "1" ]  ; then
   CPUCNTMETHOD="(via ACPI)"
else
   CPUCNTMETHOD="(via MP table)"
fi

# grep the proc speed from /proc/cpuinfo
if [ `grep "^cpu MHz" /proc/cpuinfo | wc -l` == "1" ] ; then
        SPEED=`grep "^cpu MHz" /proc/cpuinfo | uniq | awk -F : '{ print $2}' | awk -F . '{ print $1 }'`
else
        SPEED="1800"
        grep "^cpu MHz" /proc/cpuinfo > /tmp/speedlist
fi

# grep the proc cache from /proc/cpuinfo
if [ `grep "^cache size" /proc/cpuinfo | uniq | wc -l` == "1" ] ; then
        CACHE=`grep "^cache size" /proc/cpuinfo | uniq | awk -F : '{ print $2 }'`
else
        CACHE="Cache mismatch.  Cache List in /tmp/cachelist"
        grep ^cache /proc/cpuinfo > /tmp/cachelist
fi

# Write the /etc/issue file
ifconfig='/sbin/ifconfig'
uniq='/usr/bin/uniq'
#echo `cat /etc/redhat-release` >/etc/issue
#echo "Kernel \r on an \m" >>/etc/issue
echo "Geektronics :: Message Gateway" >/etc/issue
echo "For support, please contact (+65) 81158438 or email support@geektronics.sg">>/etc/issue
echo " ">>/etc/issue
#echo ${TOTALCPUS}" CPU(s) detected "${CPUCNTMETHOD}" at Speed: ${SPEED} MHz with Cache: ${CACHE}" >>/etc/issue
#echo ${TOTALMEM}" of system memory visible to OS." >>/etc/issue
#echo " " >>/etc/issue
$ifconfig enp3s0 | grep ether | awk '{ printf "Left %s %s %s", $1, "  MAC addr:", $2 }' >> /etc/issue
$ifconfig enp3s0 | grep "inet " | awk '{ print "  IP: " $2 }' >> /etc/issue   
echo " ">>/etc/issue
$ifconfig enp2s0 | grep ether | awk '{ printf "Right %s %s %s", $1, "  MAC addr:", $2 }' >> /etc/issue
echo "  Management IP: 192.168.1.2" >> /etc/issue
#$ifconfig enp2s0 | grep "inet " | awk '{ print "  IP: " $2 }' >> /etc/issue   
echo " ">>/etc/issue

# Make /etc/issue.net a duplicate of /etc/issue...
cp -f  /etc/issue /etc/issue.net

if [ -f /var/www/html/setIP.txt ];
then
	/root/setStaticIP.sh `cat /var/www/html/setIP.txt` `cat /var/www/html/setGW.txt`
	cp ifcfg-new /etc/sysconfig/network-scripts/ifcfg-enp3s0
else
	cp ifcfg-enp3s0 /etc/sysconfig/network-scripts/ifcfg-enp3s0
fi

for REPEAT3 in {1..8}
do
if [ -f /var/www/html/reboot.now ];
then
	rm -f /var/www/html/reboot.now
	/usr/sbin/shutdown -r now
	exit 0
fi

sleep 7
done
