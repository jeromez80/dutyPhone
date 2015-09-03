<?php

/*************************************
 * Autor: mgp25                      *
 * Github: https://github.com/mgp25  *
 *************************************/

 // ################ CONFIG PATHS #####################
 require_once('../../src/whatsprot.class.php');
 require 'MyEvents.php';
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

$fileName = __DIR__ . DIRECTORY_SEPARATOR . 'data.db';
$contactsDB = __DIR__ . DIRECTORY_SEPARATOR . 'contacts.db';
if ($argv[1] != null) {
  if (!file_exists($fileName))
  {
    $db = new \PDO("sqlite:" . $fileName, null, null, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db->exec('CREATE TABLE data (`username` TEXT, `password` TEXT, `nickname` TEXT, `login` TEXT)');
    $sql = 'INSERT INTO data (`username`, `password`, `nickname`, `login`) VALUES (:username, :password, :nickname, :login)';
    $query = $db->prepare($sql);

    $query->execute(
        array(
            ':username' => $argv[1],
            ':password' => $argv[2],
            ':nickname' => $argv[3],
            ':login'    => '1'
        )
    );
  }
}

if ((!file_exists($fileName)))
{

    echo "Welcome to CLI WA Client\n";
    echo "========================\n\n\n";
    echo "Your number > ";
    $number = trim(fgets(STDIN));
    $w = new WhatsProt($number, $nickname, $debug);

    try
    {
        $result = $w->codeRequest('sms');
    } catch (Exception $e)
    {
       echo "there is an error" . $e;
    }
    echo "\nEnter sms code you have received > ";
    $code = trim(str_replace("-", "", fgets(STDIN)));
    try
    {
        $result = $w->codeRegister($code);
    } catch (Exception $e)
    {
       echo "there is an error";
    }

    echo "\nYour nickname > ";
    $nickname = trim(fgets(STDIN));
    do
    {
       echo "Is '$nickname' right?\n";
       echo "yes/no > ";
       $right = trim(fgets(STDIN));
       if ($right != 'yes')
       {
         echo "\nYour nickname > ";
         $nickname = trim(fgets(STDIN));
       }

    } while ($right != 'yes');

    $db = new \PDO("sqlite:" . $fileName, null, null, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db->exec('CREATE TABLE data (`username` TEXT, `password` TEXT, `nickname` TEXT, `login` TEXT)');

    $sql = 'INSERT INTO data (`username`, `password`, `nickname`, `login`) VALUES (:username, :password, :nickname, :login)';
    $query = $db->prepare($sql);

    $query->execute(
        array(
            ':username' => $number,
            ':password' => $result->pw,
            ':nickname' => $nickname,
            ':login'    => '1'
        )
    );
}

$db = new \PDO("sqlite:" . $fileName, null, null, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$sql = 'SELECT username, password, nickname, login FROM data';
$row = $db->query($sql);
$result = $row->fetchAll();
$username = $result[0]['username'];
$password = $result[0]['password'];
$nickname = $result[0]['nickname'];
$login    = $result[0]['login'];

$w = new WhatsProt($username, $nickname, $debug);
$GLOBALS["wa"] = $w;
$w->setMessageStore(new SqliteMessageStore($username));
$events = new MyEvents($w);
$w->eventManager()->bind('onGetMessage', 'onGetMessage');
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
  echo $password;
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
$w->sendGetPrivacyBlockedList();
$w->sendAvailableForChat($nickname);
$show = true;
global $onlineContacts;
$GLOBALS["online_contacts"] = array();
$GLOBALS["current_contact"];

    $poll_dir = '/var/www/jobs';

    $pn = new ProcessNode($w, $contact);
    $w->setNewMessageBind($pn);
    $w->pollMessage();
    $msgs = $w->getMessages();
    foreach ($msgs as $m) {
      # process inbound messages
      #print($m->NodeString("") . "\n");
    }

$poll_dir = '/var/www/jobs/';
$dir = new DirectoryIterator(dirname($poll_dir.'*'));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $dmsg=file_get_contents($poll_dir.$fileinfo->getFilename());
        $dnum = strtok($dmsg, "\n");
        if ($dnum[0]=='+') { $dnum=ltrim ($dnum, '+'); }
        $dmsg=substr(strstr($dmsg,"\n"), 1);
        if (($dnum!='') && ($dmsg!='')) {
                echo $dnum . '#'. $dmsg;
                $w->sendMessage($dnum, $dmsg);
        }
    }
}

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
    if ($body=='status') {
        $GLOBALS["wa"]->sendMessage('6593822131' , "takeover=Takeover now.\nstatus=Check status\nhelp=Get help");
    }
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
