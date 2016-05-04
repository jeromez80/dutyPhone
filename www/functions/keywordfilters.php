<?php
require_once(__DIR__."/initialise.php");

function getFilterKeyword($id) {
	$query = mysql_query('SELECT Keyword FROM `Keywords` WHERE Keyword_ID="'.$id.'"');
	if ($row=mysql_fetch_array($query)) {
		return($row['Keyword']);
	}
	else  {
		return '';
	}
}

function getFilterNumber($id) {
	$query = mysql_query('SELECT * FROM `KeywordsActions` WHERE Keyword_ID="'.$id.'"');
	$nos = '';
	while ($row=mysql_fetch_array($query)) {
		$nos = $nos . $row["Dest_CtyCode"] .$row['Dest_Number']. ',';
	}
	return substr($nos,0,-1);
}

function saveFilters($f0num, $f1kw, $f1num) {
	mysql_query('TRUNCATE `Keywords`');
	mysql_query("INSERT INTO `smartMessage`.`Keywords` (`Keyword_ID`, `Source_Type`, `Source_ID`, `Keyword`) VALUES ('1', 'Email', '', '*all*')");
	if ($f1kw!='') {	mysql_query("INSERT INTO `smartMessage`.`Keywords` (`Keyword_ID`, `Source_Type`, `Source_ID`, `Keyword`) VALUES ('2', 'Email', '', '$f1kw')"); }

	mysql_query('TRUNCATE `KeywordsActions`');
	if ($f0num!=""){
		$f0nums = explode(",", $f0num);
		foreach ($f0nums as $mobile) {
			if ($mobile[0]=='+') { $mobile = substr($mobile,1); }
			if (strlen($mobile)==8) {
				$cty='65';
			} else {
				$cty=substr($mobile,0,2);
				$mobile = substr($mobile,2);
			}
			mysql_query("INSERT INTO `smartMessage`.`KeywordsActions` (`Keyword_ID`, `Action_Type`, `Dest_CtyCode`, `Dest_Number`, `Dest_Message`, `Dest_AppendRaw`, `Dest_Parameters`) VALUES ('1', 'SMS', '$cty', '$mobile', '', '1', '')");
		}
	}

	if ($f1num!="") {
		$f1nums = explode(",", $f1num);
		foreach ($f1nums as $mobile) {
			if ($mobile[0]=='+') { $mobile = substr($mobile,1); }
			if (strlen($mobile)==8) {
				$cty='65';
			} else {
				$cty=substr($mobile,0,2);
				$mobile = substr($mobile,2);
			}
			mysql_query("INSERT INTO `smartMessage`.`KeywordsActions` (`Keyword_ID`, `Action_Type`, `Dest_CtyCode`, `Dest_Number`, `Dest_Message`, `Dest_AppendRaw`, `Dest_Parameters`) VALUES ('2', 'SMS', '$cty', '$mobile', '', '1', '')");
		}
	}
	return;
}

if ($_POST['btnSaveFilters']!='') {
	saveFilters($_POST['filter0number'], $_POST['filter1keyword'], $_POST['filter1number']);
}

?>
