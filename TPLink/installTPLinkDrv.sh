apt-get -y install libusb-dev
libusb-config -version
apt-get -y remove usb-modeswitch
apt-get -y install libudev0 libudev-dev tcl
wget http://www.draisberghof.de/usb_modeswitch/usb-modeswitch-2.2.1.tar.bz2
wget http://www.draisberghof.de/usb_modeswitch/usb-modeswitch-data-20150115.tar.bz2
wget http://sourceforge.net/projects/libusb/files/libusb-1.0/libusb-1.0.9/libusb-1.0.9.tar.bz2
bunzip2 usb-modeswitch-2.2.1.tar.bz2 && tar xvfp usb-modeswitch-2.2.1.tar
bunzip2 usb-modeswitch-data-20150115.tar.bz2 && tar xvfp usb-modeswitch-data-20150115.tar
bunzip2 libusb-1.0.9.tar.bz2 && tar xvfp libusb-1.0.9.tar
cd libusb-1.0.9
./configure; make; make install
cd ..
cd usb-modeswitch-2.2.1
make install
cd ../usb-modeswitch-data-20150115
make install
echo Please do manual entry.
echo Add to the end of the file:
echo sudo modprobe usbserial vendor=0x2357 product=0x0201
echo Copy to clipboard now! ^^^
read -p Press any key...
nano /etc/rc.local
