#!/bin/bash
if [ -f /var/www/html/web/reboot.server ]; then
  rm -f /var/www/html/web/reboot.server
  /sbin/shutdown -r now 
fi
