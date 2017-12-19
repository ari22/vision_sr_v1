<?php 
session_start();

$sql="select * from veh_po where $field1='".$$field1."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cnt=$row['cls_cnt'];
if($cnt<99){
	$newcnt=$cnt+1;
	$query_ins="update veh_po set po_date=now(), cls_by='".$_SESSION['C_USER']."', cls_date=now(), cls_cnt='".$newcnt."' where  $field1='".$$field1."' ";
	$result =mysql_query($query_ins);
	$query_close="insert into veh_poo select * from veh_po where $field1='".$$field1."'";
	$result = mysql_query($query_close);
	$sql = "select count(id) as n_count,id from veh_poo where $field1 = '".$$field1."' ";
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	$count = $row['n_count'];
	$id = $row['id'];
	if ($count>>0){
		echo '{"success":true,"total":"'.$count.'","message":"'.$$field1.' successfully closed","id":"'.$id.'"}';
		return;
	}else{
		echo '{"success":false,"message":"'.$$field1.' close cancelled","id":"'.$id.'"}';
		return;
	}

}else{
	echo '{"success":false,"message":"'.$$field1.' exceeds closing time limit"}';
	return;
}



?>

