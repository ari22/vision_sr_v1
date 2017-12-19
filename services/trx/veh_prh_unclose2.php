<?php
session_start();
$sql="select * from veh_prh where $field1='".$$field1."' ";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
	{
		$prn2_cnt=$row['prn2_cnt'];
		$ispd=$row['is_paid'];
		$id = $row['id'];
		$pur_date=$row['pur_date'];
	}	
	if($prn2_cnt>0)
	{
		echo '{"success":false,"message":"Sorry, this invoice has been printed","id":"'.$id.'"}';
		exit;
	}
	if($ispd==1)
	{
		echo '{"success":false,"message":"Sorry, this invoice has been paid<br/>Please delete that payment first","id":"'.$id.'"}';
		exit;
	}
	
	$sji_date=(empty($sji_date))? '0000-00-00':date("Ymd", strtotime($sji_date));
	$kwiti_date=(empty($kwiti_date))? '0000-00-00':date("Ymd", strtotime($kwiti_date));
	$fpi_date=(empty($fpi_date))? '0000-00-00':date("Ymd", strtotime($fpi_date));
	$dni_date=(empty($dni_date))? '0000-00-00':date("Ymd", strtotime($dni_date));
	$do_date=(empty($do_date))? '0000-00-00':date("Ymd", strtotime($do_date));
	$pdi_date=(empty($pdi_date))? '0000-00-00':date("Ymd", strtotime($pdi_date));

	$del_aph=mysql_query("DELETE FROM veh_aph where pur_inv_no='".$pur_inv_no."'");
	if(mysql_affected_rows()==0)
	{
		echo '{"success":false,"message":"cannot find invoice no","id":"'.$id.'"}';
		exit;
	}

	$upd_prh=mysql_query("UPDATE veh_prh set cls2_by='".$_SESSION['C_USER']."', pur_date=0000-00-00, cls2_date=0000-00-00, is_paid=0
		WHERE pur_inv_no='".$pur_inv_no."' ");
	if(mysql_affected_rows()==0)
	{
		echo '{"success":false,"message":"cannot update prh","id":"'.$id.'"}';
		exit;
	}

	$upd_stk=mysql_query("UPDATE veh_stk set
	pur_date=0000-00-00,				cls2_date=0000-00-00, 				cls2_by='".$_SESSION['C_USER']."',	sji_no='".$sji_no."',				sji_date='".$sji_date."',			kwiti_no='".$kwiti_no."',
	kwiti_date='".$kwiti_date."',		fpi_no='".$fpi_no."',				fpi_date='".$fpi_date."',			dni_no='".$dni_no."',
	dni_date='".$dni_date."',			do_no='".$do_no."',					do_date='".$do_date."',				pdi_no='".$pdi_no."',
	pdi_date='".$pdi_date."',			pur_base='".$pur_base."' ,			pur_opt='".$pur_opt."',				alarm='".$alarm."',
	pur_bt='".$pur_bt."',				pur_pbm='".$pur_pbm."',				pur_vat='".$pur_vat."',				xkey_no='".$key_no."',
	pur_pph='".$pur_pph."',				pur_misc='".$pur_misc."',			pur_price='".$pur_price."',			serv_book='".$serv_book."'
	WHERE pur_inv_no='".$pur_inv_no."' ");
	if(mysql_affected_rows()==1)
	{
		echo '{"success":true,"message":"Invoice has been unclosed successfully","id":"'.$id.'"}';
		exit;
	}else
	{
		echo '{"success":false,"message":"cannot update table(s)","id":"'.$id.'"}';
		exit;
	}

?>