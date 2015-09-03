<?php
$PATH = '/var/www/jobs/';
echo "OK\n";
//echo $_POST["timestamp"] . " : " . $_POST["temp"] . " : " . $_POST["humidity"] . " : " . $_POST["destnumber"] . " ->" . $_POST["destMsg"];
file_put_contents($PATH.md5(microtime()).'.msg', $_POST["destnumber"] . "\n" . $_POST["destMsg"]);
?>
