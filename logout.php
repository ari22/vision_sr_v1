<?php

include_once "services/globalFunctions.php";
session_start();
$user = $_SESSION['C_USER'];

$query = "select curr_login, id from usr where username ='$user'";
//echo $query;
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$curr_login = $row['curr_login'] - 1;
$id_user = $row['id'];
$sql = "update usr set lout_dtime=now(),curr_login='$curr_login' where id ='$id_user'";
mysql_query($sql);
mysql_close($conn);
session_destroy();
header("location:index.php");
exit();
?>
