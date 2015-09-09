<?php
$PATH1 = '/var/www/jobs/';
$PATH2 = '/var/www/jobswa/';
$DUTYNUM = '/root/mcmodem/dutynumber.txt';

$destnumber = $_POST["destnumber"];
$destMsg = $_POST["destMsg"];
$sendsms = 0;
$sendwa = 0;

$desttype = $_POST["desttype"];

if ($desttype=='dutynum') {
	$sendwa = 1;
	$destnumber = 'DUTYNUM';
}
else if ($desttype=='destsms') {
	$sendsms = 1;
}
else if ($desttype=='destwa') {
	$sendwa = 1;
}
else if ($desttype=='destwagc') {
	$destnumber = '+YOURCHATNUMBERHERE';
	$sendwa = 1;
}

	if ($sendsms==1) {
	file_put_contents($PATH1.md5(microtime()).'.msg', $destnumber . "\n" . $destMsg);
	}
	if ($sendwa == 1) {
	file_put_contents($PATH2.md5(microtime()).'.msg', $destnumber . "\n" . $destMsg);
	}
	echo "OK - sent!\n";

?>
