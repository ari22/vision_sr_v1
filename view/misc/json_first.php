<?php

$mysql_db_hostname = "localhost";
$mysql_db_user = "root";
$mysql_db_password = "";
$mysql_db_database = "ajax";

$con = @mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password, $mysql_db_database);
 
if (!$con) 
{
	trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
else
{	
	$query = "SELECT * FROM tes  ";
	$result = mysqli_query($con, $query);
	$array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))	
	{		
		//$array[] = array
		$array = array
		(			
			'keyword' => $row['keyword'],
			'en' => $row['en']
		);
	}			
	echo preg_replace('[]','',html_entity_decode(json_encode($array)));	
}

?>