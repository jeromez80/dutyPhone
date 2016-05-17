# dutyPhone
This is the dutyPhone system that will forward SMS and calls to a designated number.

SMSes can be forwarded to multiple parties (i.e. supervisors), while calls will only be diverted to the duty number.

Supervisors can also subscribe to keywords.

To run: ./startWork.py

To run in headless mode:
nohup ./startWork.py > out.log&

This will output the log to the file out.log

Quick References for Setup

Set alias for easy shortcut to working folder.

alias gduty='cd /usr/local/src/dutyPhone'

Disable SELinux in:
/etc/selinux/config

Install epel-release in Yum

Set timezone
timedatectl set-timezone Asia/Singapore

Install NTP
yum install ntpdate
ntpdate -b -u -s pool.ntp.org

Sync to hardware clock
hwclock -w

Edit php.ini
Set date.timezone to Asia/Singapore
