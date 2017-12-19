<?php 
/*
NOTES!!
belum ada validasi yang menyangkut ke comp_periode
belum ada validasi lock jika di pakai user lain
belum ada validasi user akses
*/
$stock_code='OH';
session_start();
	if($po_date>date("m/j/Y"))
		{
		echo '{"success":false,"message":"Sorry, unable to close invoice<br/>before PO date."}';
		exit;	
		};
	//IsiGakBolehKosong($pur_inv_no,"Masukkan No. Faktur (Invoice)");
	IsiGakBolehKosong($po_no,"Please input PO No.");
	IsiGakBolehKosong($wrhs_code,"Please input Warehouse");
	IsiGakBolehKosong($loc_code,"Please input Location");
	IsiGakBolehKosong($supp_code,"Please input Supplier Code");
	IsiGakBolehKosong($supp_name,"Please input Supplier Name");
	IsiGakBolehKosong($chassis,"Please input Chassis Code");
	IsiGakBolehKosong($engine,"Please input Engine Code");
	SudahTerisi($cls_date, "Invoice has been closed by other user");
	$sql="select * from veh_stk where chassis = '".$chassis."' ";
	$hasil_sql=mysql_query($sql);
	$row=mysql_fetch_assoc($hasil_sql);
	$cnt=$row['cls_cnt'];
	$chs=$row['chassis'];
	$pinv=$row['pur_inv_no'];
	$pono=$row['po_no'];
	if($cnt>0){
	echo '{"success":false,"message":"Chassis <b>'.$chs.'</b> is USED in <br/> Purchase invoice: <b>'.$pinv.'</b> <br/>PO No : <b>'.$pono.' " }';
									  exit;
	}
	$slc_old="select * from veh_prh where pur_inv_no='".$pur_inv_no."' ";
	$hsl_slc=mysql_query($slc_old);
	$row=mysql_fetch_array($hsl_slc);
	$cls_cnt=$row['cls_cnt'];
	$newcnt=$cls_cnt+1;
	$upd_qry="update veh_prh set stk_date='".date("Y-m-d")."', cls_cnt='".$newcnt."', cls_by='".$_SESSION['C_USER']."', cls_date='".date("Y-m-d")."', is_paid=0 where pur_inv_no='".$pur_inv_no."'";
	//echo $upd_qry;
	$hsl_upd=mysql_query($upd_qry);

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

	/*--- Insert VEH_STK begin----- */
	$qry_ins="insert into veh_stk (pur_inv_no, stk_date, opn_date, cls_date, cls_by, cls_cnt, prn_cnt, po_no, 
		  	po_date, po_desc, po_made_by, po_appr_by, color_code, color_name, color_type, 
		  	supp_code, supp_name, supp_invno, supp_invdt, chassis, engine, pred_stk_d, 
		  	beg_qty, pur_qty, rpur_qty, pick_qty, sal_qty, rsal_qty, opn_qty, end_qty, 
		  	unit, veh_code,	veh_name, veh_brand, veh_type, veh_model, veh_year, veh_transm, 
		  	veh_reg_no, stk_code, alarm, xkey_no, serv_book, do_no, do_date, pdi_no, 
		  	pdi_date, sji_no, sji_date, kwiti_no, kwiti_date, fpi_no, fpi_date, dni_no, 
		  	dni_date, pur_base, pur_opt, pur_bt, pur_pbm, pur_vat, pur_pph, pur_misc, 
		  	pur_price, note, wrhs_code, wrhs_orig, loc_code, loc_orig, stdoptcode, stdoptname)
	VALUES ('".$pur_inv_no."', '".date("Y-m-d")."', '".$opn_date."', '".$cls_date."', '".$cls_by."', '".$cls_cnt."', '".$prn_cnt."', '".$po_no."',
			'".$po_date."', '".$po_desc."', '".$po_made_by."', '".$po_appr_by."', '".$color_code."', '".$color_name."', '".$color_type."', 
			'".$supp_code."', '".$supp_name."', '".$supp_invno."', '".$supp_invdt."', '".$chassis."', '".$engine."', '".$pred_stk_d."', 
			0, 1, 0, 0, 0, 0, 0, 1, 
			'".$unit."', '".$veh_code."', '".$veh_name."', '".$veh_brand."', '".$veh_type."', '".$veh_model."', '".$veh_year."', '".$veh_transm."', 
			'".$veh_reg_no."', '".$stock_code."', '".$alarm."', '".$key_no."', '".$serv_book."', '".$do_no."', '".$do_date."', '".$pdi_no."', 
		  	'".$pdi_date."', '".$sji_no."', '".$sji_date."', '".$kwiti_no."', '".$kwiti_date."', '".$fpi_no."', '".$fpi_date."', '".$dni_no."', 
		  	'".$dni_date."', '".$pur_base."', '".$pur_opt."', '".$pur_bt."', '".$pur_pbm."', '".$pur_vat."', '".$pur_pph."', '".$pur_misc."', 
		  	'".$pur_price."', '".$note."', '".$wrhs_code."', '".$wrhs_code."', '".$loc_code."', '".$loc_code."', '".$stdoptcode."', '".$stdoptname."')";
	$hsl_qry_ins=mysql_query($qry_ins);
	if (mysql_affected_rows()==1){
	echo '{"success":true,"message":"Vehicle receiving has been closed successfully", "id":"'.$id.'" }';
	exit;
	}else{
	echo '{"success":false,"message":"Unable to close vehicle receiving", "id":"'.$id.'" }';
	exit;
	}
?>