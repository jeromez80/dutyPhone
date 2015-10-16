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


?>
