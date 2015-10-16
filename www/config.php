<?php
//CONFIGURATION VALUES
$PATH1 = '/var/www/html/jobs/';
$PATH2 = '/var/www/html/jobswa/';
$DUTYNUM = '/usr/local/src/dutyPhone/dutynumber.txt';
$CONFIGINI = '/usr/local/src/dutyPhone/config.ini';

session_start();
ob_start();
define('DB_HOSTNAME','localhost');
define('DB_USERNAME','');
define('DB_PASSWORD','');
define('DB_DATABASENAME','');
define('Suffix','');
$connect = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
if(!$connect)
{
die(mysql_error());
}
mysql_select_db(DB_DATABASENAME,$connect);
