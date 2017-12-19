<?php
session_start();
$sql="select * from veh_prh where $field1='".$$field1."' ";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
	{
		$prn_cnt=$row['prn_cnt'];
		$ispd=$row['is_paid'];
		$id = $row['id'];
		$pur_date=$row['pur_date'];
	}
	if($pur_date!=0000-00-00){
		echo '{"success":false,"message":"Vehicle purchase invoice as been closed. Please unclose it first.","id":"'.$id.'"}';
		exit;	
	}
	if($prn_cnt>0)
	{
		echo '{"success":false,"message":"Sorry, this invoice has been printed","id":"'.$id.'"}';
		exit;
	}
	if($ispd==1)
	{
		echo '{"success":false,"message":"Sorry, this invoice has been paid<br/>Please delete that payment first","id":"'.$id.'"}';
		exit;
	}

	$qry_dlt="delete from veh_stk where pur_inv_no='".$pur_inv_no."' AND chassis='".$chassis."' ";
	$hsl_qry_dlt=mysql_query($qry_dlt);
	if(mysql_affected_rows()==0)
	{
		echo '{"success":false,"message":"cannot delete from stock","id":"'.$id.'"}';
		exit;
	}


	$qry_upd="update veh_prh set cls_by='".$_SESSION['C_USER']."', cls_date='0000-00-00', stk_date='0000-00-00', is_paid=0, stk_date='0000-00-00' where pur_inv_no='".$pur_inv_no."'";
	$hsl_qry_upd=mysql_query($qry_upd);
	if(mysql_affected_rows()>0)
	{
		echo '{"success":true,"message":"Invoice has been unclosed successfully","id":"'.$id.'"}';
		exit;
	}else
	{
		echo '{"success":false,"message":"cannot update table(s)","id":"'.$id.'"}';
		exit;
	}

?>