<?php
define('DB_HOSTNAME','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASENAME','smartMessage');
$connect = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
if(!$connect)
{
	die(mysql_error());
}
mysql_select_db(DB_DATABASENAME,$connect);
