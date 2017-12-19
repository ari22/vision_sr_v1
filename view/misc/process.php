<?php
$db = array(
	'host' => 'localhost',
	'login' => 'root',
	'password' => '',
	'database' => 'ajax',
);
$link = @new mysqli($db['host'], $db['login'], $db['password'], $db['database']);
if (!$link) {
	echo "save_failed";
	return;	
}

// Perform insert
$sql = "INSERT INTO tes VALUES ('$_POST[keyword]', '$_POST[en]')";

 if($stmt = $link->prepare($sql) ){

	$stmt->bind_param
	(
		$_POST['keyword'],
		$_POST['en']
	);

	// execute the insert query
	if($stmt->execute()){
		echo "User was saved.";
		$stmt->close();
	}else{
		die("Unable to save.");
	}

}
else
{
	die("Unable to prepare statement.");
}

// close the database
$mysqli->close();

?>