<?php
require_once(__DIR__."/../functions/ulogin.php");
require_once(__DIR__."/../config/config.inc.php");
//require_once(__DIR__."/../functions/actions.php");


$connect = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);

if(!$connect)
{
	die(mysql_error());
}

mysql_select_db(DB_DATABASENAME,$connect);

