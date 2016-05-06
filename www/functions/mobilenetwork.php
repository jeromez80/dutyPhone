<?php
require_once(__DIR__."/initialise.php");

function get_smsc() {

        $query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="SMSC_Num"');

        if ($row=mysql_fetch_array($query)) {
                return $row["Config_Value"];
        }

}


function get_dutynum() {

        $query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Duty_Num"');

        if ($row=mysql_fetch_array($query)) {
                return $row["Config_Value"];
        }
}

function get_lastmsgnum() {

        $query = mysql_query('SELECT * FROM ConfigData WHERE Config_Key="Last_Num"');

        if ($row=mysql_fetch_array($query)) {
                return $row["Config_Value"];
        }
}

function set_smsc($value) {
    return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("SMSC_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

function set_dutynum($value) {
    return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Duty_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

function set_lastmsgnum($value) {
    return(mysql_query('INSERT INTO ConfigData (Config_Key, Config_Value) VALUES ("Last_Num", "'.$value.'") ON DUPLICATE KEY UPDATE Config_Value="'.$value.'"'));
}

if ($_POST['btnMNsubmit'] != '') {
        set_smsc($_POST['sms_message_centre']);
}
?>
