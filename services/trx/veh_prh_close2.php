<?php 
/*
NOTES!!
belum ada validasi yang menyangkut ke comp_periode
belum ada validasi lock jika di pakai user lain
belum ada validasi user akses
*/

session_start();
	if($tot_price!=$pur_price)
	{
		echo '{"success":false,"message":"Sale price total is inequal with price detail."}';
		exit;	
	}
	if($pur_date>date("m/j/Y"))
		{
		echo '{"success":false,"message":"Sorry, unable to close invoice<br/>before PO date."}';
		exit;	
		};
	$cek_prh=mysql_fetch_assoc(mysql_query("SELECT cls_date from veh_prh where pur_inv_no='".$pur_inv_no."'"));
	if($cek_prh['cls_date']==0000-00-00){
		echo '{"success":false,"message":"Sorry, unable to close invoice<br/>Please close this vehicle’s receiving invoice first."}';
		exit;	
	}
	SudahTerisi($cls_date, "Invoice has been closed by other user");

	/*---- DECLARE FIELD FIRST------ */
	$slc_prh="select * from veh_prh where pur_inv_no='".$pur_inv_no."'";
	$hsl_slc_prh=mysql_query($slc_prh);
	$numfields=mysql_num_fields($hsl_slc_prh);
	for($i=0; $i<$numfields; $i++){
		$fieldname[$i]=mysql_field_name($hsl_slc_prh, $i);
	}
	while($row=mysql_fetch_assoc($hsl_slc_prh)){
		for($i=0;$i<$numfields;$i++){
			$$fieldname[$i]=$row[$fieldname[$i]];
		}
	}

	//============== INSERT VEH_APH =============//
	$ins_aph="INSERT INTO veh_aph (
		pur_inv_no,			pur_date,			stk_date,			cls_date,			due_date,
		supp_code,			supp_name,			supp_invno,			supp_invdt,			chassis,
		engine,				veh_code,			veh_name,			color_code,			color_name,
		po_no,				po_date,			inv_vat,			inv_total,			hd_begin,
		hd_paid,			hd_disc,			hd_end,				pinv_code,			wrhs_code,
		note,				apv_inv_no,			apv_date,			apg_inv_no,			apg_date,
		dni_no,				dni_date,			fpi_no,				fpi_date
		)VALUES(	
		'".$pur_inv_no."',	'".date("Y-m-d")."',	'".$stk_date."',	'".date("Y-m-d")."',	'".$due_date."',
		'".$supp_code."',	'".$supp_name."',	null,				null,				'".$chassis."',
		'".$engine."',		'".$veh_code."',	'".$veh_name."',	'".$color_code."',	'".$color_name."',
		'".$po_no."',		'".$po_date."',		null,				'".$unit_price."',	'".$tot_price."',
		0,					0,					'VPR',	'".$wrhs_code."',				null,
		null,				null,				null,				null,				null,
		null,				null,				null,				null
		)";
	$hsl_aph=mysql_query($ins_aph);
	if (mysql_affected_rows()==0){
	echo '{"success":false,"message":"Unable to close vehicle receiving, Cannot update aph", "id":"'.$id.'" }';
	exit;
	}

	$slc_old="select * from veh_prh where pur_inv_no='".$pur_inv_no."' ";
	$hsl_slc=mysql_query($slc_old);
	$row=mysql_fetch_assoc($hsl_slc);
	$cls2_cnt=$row['cls2_cnt'];
	$newcnt=$cls2_cnt+1;
	$upd_qry="UPDATE veh_prh set 
			pur_date='".date("Y-m-d")."', 	cls2_cnt='".$newcnt."',	 	cls2_by='".$_SESSION['C_USER']."', 	cls2_date='".date("Y-m-d")."' 
			where pur_inv_no='".$pur_inv_no."'";
	$hsl_upd=mysql_query($upd_qry);
	if (mysql_affected_rows()==0){
	echo '{"success":false,"message":"Error Found While updating prh", "id":"'.$id.'" }';
	exit;
	}
	// =========== UPDATE STK ========= //
	$sji_date=(empty($sji_date))? '0000-00-00':date("Ymd", strtotime($sji_date));
	$kwiti_date=(empty($kwiti_date))? '0000-00-00':date("Ymd", strtotime($kwiti_date));
	$fpi_date=(empty($fpi_date))? '0000-00-00':date("Ymd", strtotime($fpi_date));
	$dni_date=(empty($dni_date))? '0000-00-00':date("Ymd", strtotime($dni_date));
	$do_date=(empty($do_date))? '0000-00-00':date("Ymd", strtotime($do_date));
	$pdi_date=(empty($pdi_date))? '0000-00-00':date("Ymd", strtotime($pdi_date));

	$upd_stk="UPDATE veh_stk set
	pur_date='".date("Y-m-d")."',		cls2_date='".date("Y-m-d")."', 		cls2_cnt='".$newcnt."',
	cls2_by='".$_SESSION['C_USER']."',	sji_no='".$sji_no."',				sji_date='".$sji_date."',			kwiti_no='".$kwiti_no."',
	kwiti_date='".$kwiti_date."',		fpi_no='".$fpi_no."',				fpi_date='".$fpi_date."',			dni_no='".$dni_no."',
	dni_date='".$dni_date."',			do_no='".$do_no."',					do_date='".$do_date."',				pdi_no='".$pdi_no."',
	pdi_date='".$pdi_date."',			pur_base='".$pur_base."' ,			pur_opt='".$pur_opt."',				alarm='".$alarm."',
	pur_bt='".$pur_bt."',				pur_pbm='".$pur_pbm."',				pur_vat='".$pur_vat."',				xkey_no='".$key_no."',
	pur_pph='".$pur_pph."',				pur_misc='".$pur_misc."',			pur_price='".$pur_price."',			serv_book='".$serv_book."'
	WHERE pur_inv_no='".$pur_inv_no."' ";

	$hsl_qry_upd=mysql_query($upd_stk);
	if (mysql_affected_rows()==1){
	echo '{"success":true,"message":"Vehicle receiving has been closed successfully", "id":"'.$id.'" }';
	exit;
	}else{
	echo '{"success":false,"message":"Unable to close vehicle receiving", "id":"'.$id.'" }';
	exit;
	}
?>