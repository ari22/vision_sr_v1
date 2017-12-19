<?php
session_start();
$sql="select * from veh_po where $field1='".$$field1."' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$vpr=$row['pur_inv_no'];
$id = $row['id'];
if(!empty($vpr)){
	echo '{"success":false,"message":"Sorry, this PO is used in vehicle receiving no. : '.$vpr.' "}';
	mysql_close();
	return;
}
$row=mysql_fetch_assoc($result);
$prnt=$row['prn_cnt'];
if(empty($prnt)){
	$query_ins="update veh_po set po_date=null, cls_by='".$_SESSION['C_USER']."', cls_date=null where  $field1='".$$field1."' ";
	$result =mysql_query($query_ins);
	$query_del="delete from veh_poo where id='$id'";
	$result = mysql_query($query_del);
	$query = "select count(id) as n_count,id from veh_poo where $field1 = '".$$field1."' ";
	$result = mysql_query($query);
	$row=mysql_fetch_array($result);
	$count = $row['n_count'];
	if ($count==0){
		echo '{"success":true,"total":"'.$count.'","message":"'.$$field1.' Unclosed successfully","id":"'.$id.'"}';
		return;
	}else{
			echo '{"success":false,"message":"'.$$field1.' close cancelled.","id":"'.$id.'"}';
		return;
	}
}else{
	echo '{"success":false,"message":"'.$$field1.' invoice has been printed"}';
	return;
}


?>
