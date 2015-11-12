<?php

/*************************************
 * Autor: mgp25                      *
 * Github: https://github.com/mgp25  *
 *************************************/

 // ################ CONFIG PATHS #####################
 require_once('../../Chat-API/src/whatsprot.class.php');
 require 'MyEvents.php';
 include 'config.php';
 // ###################################################

 // ############## CONFIG TIMEZONE ###################
 date_default_timezone_set('Asia/Singapore');
 // ##################################################

//  ############## DEBUG DEV MODE ####################
 $debug = false;
//  ##################################################

// ############### MESSAGE DB PATH ###################
$GLOBALS["msg_db"] = "";
// ###################################################

echo "####################################\n";
echo "#                                  #\n";
echo "#           WA CLI CLIENT          #\n";
echo "#                                  #\n";
echo "####################################\n\n";
echo "====================================\n";

$contactsDB = __DIR__ . DIRECTORY_SEPARATOR . 'contacts.db';

$db = new \PDO("mysql:host=localhost;dbname=smartMessage", 'root', null, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$sql = 'SELECT username, password, nickname, login FROM data';
$row = $db->query($sql);
$result = $row->fetchAll();
$username = $result[0]['username'];
$password = $result[0]['password'];
$nickname = $result[0]['nickname'];
$login    = $result[0]['login'];

//PRUNE group info from database (GUI)
$query = mysql_query($select);

function getDutyNumber() {
	//Get duty number from MySQL
	$select = "SELECT * FROM `mmg_phone_numbers` WHERE id=1";
	$row = mysql_fetch_array(mysql_query($select));
	$dutynumber = $row['current_duty_number'];
	return $dutynumber;
}

function getGroupChats() {
	//Get duty number from MySQL
	$select = "SELECT group_code FROM `WAGroupChats` WHERE status='enable'";
	return mysql_query($select);
}

echo "Current duty number is" .getDutyNumber()."\n\n";

$w = new WhatsProt($username, $nickname, $debug);
$GLOBALS["wa"] = $w;
//$w->setMessageStore(new SqliteMessageStore($username));
$events = new MyEvents($w);
$w->eventManager()->bind('onGetMessage', 'onGetMessage');
$w->eventManager()->bind('onGetGroupV2Info', 'onGetGroupV2Info');
$w->eventManager()->bind('onGetGroups', 'onGetGroups');
$w->eventManager()->bind('onGroupisCreated', 'onGroupisCreated');
$w->eventManager()->bind("onGetGroupMessage", "onGetGroupMessage");
$w->eventManager()->bind('onGetSyncResult', 'onSyncResult');
$w->eventManager()->bind('onGetRequestLastSeen', 'onGetRequestLastSeen');
$w->eventManager()->bind('onPresenceAvailable', 'onPresenceAvailable');
$w->eventManager()->bind('onPresenceUnavailable', 'onPresenceUnavailable');
$w->eventManager()->bind('onGetImage', 'onGetImage');
$w->eventManager()->bind('onGetVideo', 'onGetVideo');
$w->eventManager()->bind('onGetAudio', 'onGetAudio');

$w->connect();
try
{
  $w->loginWithPassword($password);
}
catch (Exception $e)
{
    echo "Error: $e";
    exit();
}
echo "\nConnected to WA\n\n";
if ($login == '1')
{
    $w->sendGetClientConfig();
    $w->sendGetServerProperties();
    $w->sendGetGroups();
    $w->sendGetBroadcastLists();

    $sql = "UPDATE data SET login=?";
    $query = $db->prepare($sql);
    $query->execute(array('0'));
}
else {
	$w->sendGetGroups();
}
//$w->sendGetGroupV2Info();
$w->sendGetPrivacyBlockedList();
$w->sendAvailableForChat($nickname);
$show = true;
global $onlineContacts;
$GLOBALS["online_contacts"] = array();
$GLOBALS["current_contact"];

    $pn = new ProcessNode($w, $contact);
    $w->setNewMessageBind($pn);
    $w->pollMessage();
    $msgs = $w->getMessages();
    foreach ($msgs as $m) {
      # process inbound messages
      #print($m->NodeString("") . "\n");
    }

for ($loop=0; $loop<9; $loop++) {
	sleep(5);
	$w->pollMessage();

	$result = mysql_query("SELECT Job_ID, Job_Time, Job_Type, Dest_CtyCode, Dest_Number, Dest_Message FROM `OutMessageQueue` WHERE Job_Type='WA'");
	while ($msg = mysql_fetch_array($result)) {
		$w->sendMessage($msg['Dest_CtyCode'].$msg['Dest_Number'], $msg['Dest_Message']);
		mysql_query("INSERT INTO `OutMessageCompleted` (Job_ID, Job_Time, Job_Type, Dest_CtyCode, Dest_Number, Dest_Message) VALUES (NULL, NULL, 'WA', '".$msg['Dest_CtyCode']."', '".$msg['Dest_Number']."', '".$msg['Dest_Message']."')");
		mysql_query("DELETE FROM `OutMessageQueue` WHERE Job_ID='".$msg['Job_ID']."'");
	}

	/******
				mysql_query("INSERT INTO `messages` VALUES (NULL, NOW(), 'WA-API', '$dnum', '$dmsg')");
				$gc = getGroupChats();
				while ($row = mysql_fetch_array($gc)) {
					$dnum=$row['group_code'];
					echo 'Send to: '.$dnum . '#'. $dmsg."\n";
					mysql_query("INSERT INTO `messages` VALUES (NULL, NOW(), 'WA-API', '".$row['group_names']."', '$dmsg')");
					$w->sendMessage($dnum, $dmsg);
	*********/

}//for loop

$w->disconnect();
echo "Disconnected. Bye! :D\n";
die();
function onSyncResult($result)
{
    foreach ($result->existing as $number) {
        global $existUser;
        $existUser = true;
    }
}

function onGetGroupV2Info ( $mynumber, $group_id, $creator, $creation, $subject, $participants, $admins, $fromGetGroup ) {
	$select = "SELECT group_names FROM `WAGroupChats` WHERE group_code='$group_id'";
	$row = mysql_fetch_array(mysql_query($select));
	if ($row) {
		mysql_query("UPDATE WAGroupChats SET group_names='$subject' WHERE group_code='$group_id'");
	} else {
		$select = "INSERT INTO `WAGroupChats` VALUES('', '$subject','$group_id','disabled')";
		$result = mysql_query($select);
	}

	echo "$mynumber\n";
	echo "==> $group_id\n";
	echo "$creator\n";
	echo "$creation\n";
	echo "ChatGroup Subject: $subject\n";
	foreach ($participants as $participant) { echo "P: $participant\n"; }
	foreach ($admins as $admin) { echo "A: $admin\n"; }
	echo "$fromGetGroup\n";
	echo "=================\n";


}

function onGetGroups( $mynumber, $groupList ) {
/****	echo "$mynumber\n";
	foreach ($groupList as $gid) {
		foreach ($gid as $gidd) {
			echo "-> $gidd\n";
		}
	}
	echo "=========\n";
****/
}

function onGetRequestLastSeen( $mynumber, $from, $id, $seconds )
{
  if (($seconds != "") || ($seconds != null))
      echo "$from last seen: " . gmdate('l jS \of F Y h:i:s A', intval($seconds)). "\n";
}

function onPresenceAvailable($mynumber, $from)
{
    $number = ExtractNumber($from);
    if (!in_array($number, $GLOBALS["online_contacts"]))
        array_push($GLOBALS["online_contacts"], $number);
    echo " < $number is now online >\n";
}

function onPresenceUnavailable($mynumber, $from, $last)
{
    $number = ExtractNumber($from);
    if(($key = array_search($number, $GLOBALS["online_contacts"])) !== false) {
        unset($GLOBALS["online_contacts"][$key]);
    }
    echo " < $number is now offline >\n";
}

function onGetMessage($mynumber, $from, $id, $type, $time, $name, $body)
{
    $number = ExtractNumber($from);
    echo " < New message from $name ($number) >";
    echo $body;
	mysql_query("INSERT INTO `messages` VALUES (NULL, NOW(), '$number (WA)', 'MODEM', '$body')");
	mysql_query("INSERT INTO `IncomingWA` VALUES (NULL, NULL, '$time', '$name ($number)', '$mynumber', '$body', 0)");
}

function onGetGroupMessage($mynumber, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $body)
{
    $number = ExtractNumber($from_user_jid);
    echo "New message from $name: $body";
	$result = mysql_fetch_array(mysql_query("SELECT group_names FROM `WAGroupChats` WHERE group_code='".ExtractNumber($from_group_jid)."'"));
	mysql_query("INSERT INTO `IncomingWA` VALUES (NULL, NULL, '$time', '$name ($number)', '".$result['group_names']." (GroupChat)', '$body', 0)");
}

function onGetImage($mynumber, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $width, $height, $preview, $caption)
{
    $number = ExtractNumber($from);
    $nickname = $number;
    $path = __DIR__ . DIRECTORY_SEPARATOR . "data/media/$nickname/";
    if (!file_exists($path))
        mkdir($path);
    $filename = $path . time() . ".jpg";
    $data = file_get_contents($url);
    $fp = @fopen($filename, "w");
    if ($fp) {
        fwrite($fp, $data);
        fclose($fp);
    }
    echo " < Received image from $nickname >\n";
}

function onGetVideo($mynumber, $from, $id, $type, $time, $name, $url, $file, $size, $mimeType, $fileHash, $duration, $vcodec, $acodec, $preview, $caption)
{
    $number = ExtractNumber($from);
    $nickname = $number;
    $path = "data/media/$nickname/";
    if (!file_exists($path))
        mkdir($path);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . $path . time() . ".jpg";
    $data = file_get_contents($url);
    $fp = @fopen($filename, "w");
    if ($fp) {
      fwrite($fp, $data);
      fclose($fp);
    }
    echo " < Received video from $nickname >\n";
}

function onGetAudio($mynumber, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $duration, $acodec, $fromJID_ifGroup = null)
{
    $number = ExtractNumber($from);
    $nickname = $number;
    $path = "data/media/$nickname/";
    if (!file_exists($path))
        mkdir($path);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . $path . time() . ".jpg";
    $data = file_get_contents($url);
    $fp = @fopen($filename, "w");
    if ($fp) {
        fwrite($fp, $data);
        fclose($fp);
    }
    echo " < Received audio from $nickname >\n";
}

class ProcessNode
{
    protected $wp = false;
    protected $target = false;

    public function __construct($wp, $target)
    {
        $this->wp = $wp;
        $this->target = $target;
    }

    public function process($node)
    {
        if ($node->getAttribute("type") == 'text')
        {
            $text = $node->getChild('body');
            $text = $text->getData();
            $number = ExtractNumber($node->getAttribute("from"));
            $nickname = $number;

            echo "\n- ".$nickname.": ".$text."    ".date('H:i')."\n";
        }

    }
}
?>
