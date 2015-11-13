<?php
require '../../Chat-API/src/events/AllEvents.php';

class MyEvents extends AllEvents
{
    /**
     * This is a list of all current events. Uncomment the ones you wish to listen to.
     * Every event that is uncommented - should then have a function below.
     * @var array
     */
    public $activeEvents = array(
//        'onClose',
//        'onCodeRegister',
//        'onCodeRegisterFailed',
//        'onCodeRequest',
//        'onCodeRequestFailed',
//        'onCodeRequestFailedTooRecent',
        'onConnect',
//        'onConnectError',
//        'onCredentialsBad',
//        'onCredentialsGood',
        'onDisconnect',
//        'onDissectPhone',
//        'onDissectPhoneFailed',
        'onGetAudio',
//        'onGetBroadcastLists',
//        'onGetError',
//        'onGetExtendAccount',
        'onGetGroupMessage',
//        'onGetGroupParticipants',
//        'onGetGroups',
	'onGetGroupV2Info',
//        'onGetGroupsInfo',
//        'onGetGroupsSubject',
        'onGetImage',
//        'onGetLocation',
        'onGetMessage',
//        'onGetNormalizedJid',
//        'onGetPrivacyBlockedList',
//        'onGetProfilePicture',
//        'onGetReceipt',
        'onGetRequestLastSeen',
//        'onGetServerProperties',
//        'onGetServicePricing',
//        'onGetStatus',
//        'onGetSyncResult',
        'onGetVideo',
//        'onGetvCard',
//        'onGroupCreate',
//        'onGroupisCreated',
//        'onGroupsChatCreate',
//        'onGroupsChatEnd',
//        'onGroupsParticipantsAdd',
//        'onGroupsParticipantsPromote',
//        'onGroupsParticipantsRemove',
//        'onLogin',
//        'onLoginFailed',
//        'onAccountExpired',
//        'onMediaMessageSent',
//        'onMediaUploadFailed',
//        'onMessageComposing',
//        'onMessagePaused',
//        'onMessageReceivedClient',
//        'onMessageReceivedServer',
//        'onPaidAccount',
//        'onPing',
        'onPresenceAvailable',
        'onPresenceUnavailable',
//        'onProfilePictureChanged',
//        'onProfilePictureDeleted',
//        'onSendMessage',
//        'onSendMessageReceived',
//        'onSendPong',
//        'onSendPresence',
//        'onSendStatusUpdate',
//        'onStreamError',
//        'onUploadFile',
//        'onUploadFileFailed',
    );

    public function onConnect($mynumber, $socket)
    {
        echo "Phone number $mynumber connected successfully!\n";
    }

    public function onDisconnect($mynumber, $socket)
    {
        echo "Phone number $mynumber is disconnected!\n";
    }

	public function onGetMessage($mynumber, $from, $id, $type, $time, $name, $body)
	{
		echo " < New message from $name ($number) >";
		$number = ExtractNumber($from);
		echo $body;
		mysql_query("INSERT INTO `messages` VALUES (NULL, NOW(), '$number (WA)', 'MODEM', '$body')");
		mysql_query("INSERT INTO `IncomingWA` VALUES (NULL, NOW(), '$time', '$number (WA)', 'MODEM', '$body')");
	}

	public function onGetGroupMessage($mynumber, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $body)
	{
		$number = ExtractNumber($from_user_jid);
		echo "New group message from $name: $body";
		$result = mysql_fetch_array(mysql_query("SELECT group_names FROM `group_details` WHERE group_code='".ExtractNumber($from_group_jid)."'"));
		mysql_query("INSERT INTO `messages` VALUES (NULL, NOW(), '$name ($number)', '".$result['group_names']." (GroupChat)', '$body')");
		$GLOBALS["wa"]->sendMessage(getDutyNumber(),$body);
		echo 'Sent to '.getDutyNumber();
	}

public function onGetGroupV2Info ( $mynumber, $group_id, $creator, $creation, $subject, $participants, $admins, $fromGetGroup ) {
	$select = "SELECT group_names FROM `group_details` WHERE group_code='$group_id'";
	$row = mysql_fetch_array(mysql_query($select));
	if ($row) {
		mysql_query("UPDATE group_details SET group_names='$subject' WHERE group_code='$group_id'");
	} else {
		$select = "INSERT INTO `group_details` VALUES('', '$subject','$group_id','disabled')";
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

public function onGetRequestLastSeen( $mynumber, $from, $id, $seconds )
{
  if (($seconds != "") || ($seconds != null))
      echo "$from last seen: " . gmdate('l jS \of F Y h:i:s A', intval($seconds)). "\n";
}

public function onPresenceAvailable($mynumber, $from)
{
    $number = ExtractNumber($from);
    echo " < $number is now online >\n";
}

public function onPresenceUnavailable($mynumber, $from, $last)
{
    $number = ExtractNumber($from);
    echo " < $number is now offline >\n";
}

public function onGetImage($mynumber, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $width, $height, $preview, $caption)
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

public function onGetVideo($mynumber, $from, $id, $type, $time, $name, $url, $file, $size, $mimeType, $fileHash, $duration, $vcodec, $acodec, $preview, $caption)
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

public function onGetAudio($mynumber, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $duration, $acodec, $fromJID_ifGroup = null)
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
} //end of class
