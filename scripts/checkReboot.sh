#!/bin/bash
if [ -f /var/www/html/reboot.server ]; then
  rm -f /var/www/html/reboot.server
  /sbin/shutdown -r now 
fi
