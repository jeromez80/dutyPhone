<?php
die("sdf");
get_table_data($table)
{
	$select = "select * from `$table`";
	$query = mysql_query($select);
	while($row=mysql_fetch_array($query))
	{
		$data[] = $row;		
	}
	return $data;
} 

//############# functions for ulogin #############

function appLogout(){
  // When a user explicitly logs out you'll definetely want to disable
  // autologin for the same user. For demonstration purposes,
  // we don't do that here so that the autologin function remains
  // easy to test.
  //$ulogin->SetAutologin($_SESSION['username'], false);

        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        unset($_SESSION['loggedIn']);
	header("Location:login.php");
}

?>
