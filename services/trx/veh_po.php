<?php
/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
Antara lain :
$table 	=> Nama Table MySQL
$field1 => Field Primary (bukan id autoincrement)
$field1 => Field Description
Issue date [20140901]
*/
//table yang terlibat veh_spk dan veh_spkreg
session_start();
if (isset($func))
{
	if ($func=='reccount')
	{
		$result = "select * from $table where 1=1 ";
		$sql = "select count($field1) as n_count,max(id) as max_id from ($result) ";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo json_encode($row);//$row['n_count'];
	}
	if ($func=='read')
	{
		include "/mst/navigation.php";
		$defaultfields = "*";
		if (isset($fields)) {
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table where 1=1 ";
		
		if (isset($query)) {
			$result .= " AND ($field1 like '%$query%' or $field2 like '%$query%' )";
		}
		if (isset($filter)) {
			$result .= " AND $filter ";
		}
		if (isset($order)) {
			$result .= " ORDER BY $order ";
		}
		if (isset($id)) {
			$result .= " AND id = $id ";
		}
		if (isset($start)) {
			$result .= " LIMIT $start,$limit ";
		}
		$sql = "select count($field1) as n_count from ($result) a ";
		//echo $result;
		if (isset($page)) {
			$start = 1+($rows*($page-1));
			$result .= " LIMIT $start,$rows ";
		}
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}
	if ($func=='create')
	{	

		if (isset($field1) && isset($field2))
		{
			//$lnfield1 = strlen(trim($$field1));
			$lnfield2= strlen(trim($$field2));
			if (/*$lnfield1==0 || */$lnfield2==0)
			{
				msgFailed($id,$field1,$$field1,'Data cannot be empty');
				return;
			}
			//IsiGakBolehKosong($po_no,"Masukkan No. PO (Purchase Order)");
			IsiGakBolehKosong($wrhs_code,"Please input Warehouse");
			IsiGakBolehKosong($loc_code,"Please input Location");
			IsiGakBolehKosong($supp_code,"Please input Supplier Code");
			IsiGakBolehKosong($supp_name,"Please input Supplier Name");
			IsiGakBolehKosong($due_day,"Please input TOP Date");
			IsiGakBolehKosong($color_code,"Please input Color Type and Name");
			$sql = "select count(id) as n_count from $table where $field1 = '".$$field1."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count>>0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field1,$$field1,'Data already exist');
				return;
			}else
			{
				/* ============== CHECK & UPDATE INV_SEQ Table for Invoice Number ==========*/
				$slc_seq=mysql_query("SELECT inv_type,inv_year,inv_mth,inv_no from inv_seq where inv_type='".$invtyp."' ");
				$row=mysql_fetch_assoc($slc_seq);
				$month=$row['inv_mth'];
				$runingno=($row['inv_no']+1);
				$month2=date("m");
				if($month!=$month2)
				{
					$slc_inv="SELECT max(po_no) as hasil FROM veh_po WHERE SUBSTR(po_no,7,2)=$month2 ";
					$result=mysql_query($slc_inv);
					$row2=mysql_fetch_assoc($result);
					$hsl=$row2['hasil'];
					if($hsl==null){
						$mth_val=date("m");
						$old_mth_no=1;

					}else{
						$mth_val=substr($row2['hasil'], 6,2);
						$old_mth_no=substr($row2['hasil'], 8,4)+1;

					}
					$newinv=$row['inv_type']."-".substr($row['inv_year'], 2).str_pad($mth_val, 2,"0",STR_PAD_LEFT).str_pad($old_mth_no, 4,"0",STR_PAD_LEFT);

					//=============  ===================//

					$query_cek=mysql_query("SELECT count(po_no) as count from veh_po where po_no='".$newinv."' "); 
					$row_cek=mysql_fetch_assoc($query_cek);
					$count=$row_cek['count'];
					if($count>0)
						{
							msgFailed($id,$field1,$newinv,'Invoice no. has been used a');
							exit;
						}
					$newruningno=$old_mth_no;
					$ins_seq=mysql_query("UPDATE inv_seq set inv_year=YEAR(now()), inv_mth=MONTH(now()), inv_no='".$newruningno."' where inv_type='".$invtyp."' ");
					if(mysql_affected_rows()==0)
						{
							msgFailed($id,$field1,$$field1,'Failed to update invoice no.');
							exit;
						}
				}else
				{
					
					$newinv=$row['inv_type']."-".substr($row['inv_year'], 2).str_pad($month, 2,"0",STR_PAD_LEFT).str_pad($runingno, 4,"0",STR_PAD_LEFT);
					$query_cek=mysql_query("SELECT count(po_no) as count from veh_po where po_no='".$newinv."' "); 
					$row_cek=mysql_fetch_assoc($query_cek);
					$count=$row_cek['count'];
					if($count>0)
						{
							msgFailed($id,$field1,$newinv,'Invoice no. has been used a');
							exit;
						}

					$newruningno=(($month2-$month) == 0) ?$runingno : 1;
					$ins_seq=mysql_query("UPDATE inv_seq set inv_year=YEAR(now()), inv_mth=MONTH(now()), inv_no='".$newruningno."' where inv_type='".$invtyp."' ");
					if(mysql_affected_rows()==0)
						{
							msgFailed($id,$field1,$$field1,'Failed to update invoice no.');
							exit;
						}
				}
				
				/* ============= end of check & update ========================*/

				$due_date=(empty($due_date))? '0000-00-00':date("Ymd", strtotime($due_date));
				$query_insert="INSERT into ".$table."(
								po_no,				due_day,			due_date,			supp_code,			supp_name,
								wrhs_code,			loc_code,			note,				veh_code,			veh_name,
								chassis,			engine,				veh_type,			veh_model,			color_code,
								color_name,			stdoptcode,			qty,				unit,				unit_price,
								tot_price,			veh_brand,			veh_transm,			veh_year,			color_type,
								po_made_by,			po_appr_by, 		beg_qty,			rcv_qty,			end_qty,
								is_paid,			po_date
							) VALUES (
								'".$newinv."',		'".$due_day."',		'".$due_date."',	'".$supp_code."',	'".$supp_name."',
								'".$wrhs_code."',	'".$loc_code."',	'".$note."',		'".$veh_code."',	'".$veh_name."',
								'".$chassis."',		'".$engine."',		'".$veh_type."',	'".$veh_model."',	'".$color_code."',
								'".$color_name."',	'".$stdoptcode."',	'".$qty."',			'".$unit."',		'".$unit_price."',
								'".$tot_price."',	'".$veh_brand."',	'".$veh_transm."',	'".$veh_year."',	'".$color_type."',
								'".$po_made_by."',	'".$po_appr_by."',	1,					0,					1,
								0,					0000-00-00
							)";

				$result=mysql_query($query_insert);
				$sql="SELECT count(id) as n_count,id from $table where po_no='".$newinv."'";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				$count=$row['id'];
				if ($count>>0){
					msgSuccess($id,$newinv,$newinv,'Record saved');
					return;
				}else{
					msgFailed($id,$newinv,$newinv,'Insert failed');
					return;
				}


			}
			
		}
	}

	if ($func=='update')
	{
		/* Hanya field "$field2" yang boleh diupdate */

		if (isset($field1) && isset($field2))
		{

			$lnfield1 = strlen(trim($field1));
			$lnfield2= strlen(trim($field2));
			if ($lnfield1==0 || $lnfield2==0)
			{
				msgFailed($id,$field1,$$field1,'Data cannot be empty');
				return;
			}
			IsiGakBolehKosong($wrhs_code,"Please input Warehouse");
			IsiGakBolehKosong($loc_code,"Please input Location");
			IsiGakBolehKosong($supp_code,"Please input Supplier Code");
			IsiGakBolehKosong($supp_name,"Please input Supplier Name");
			IsiGakBolehKosong($due_day,"Please input TOP Date");
			IsiGakBolehKosong($color_code,"Please input Color Type and Name");
			$sql = "select count(id) as n_count from $table where $field1 = '".$$field1."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count==0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field1,$$field1,'Record not found');
				return;
			}else
			{
				$due_date=(empty($due_date))? '0000-00-00':date("Ymd", strtotime($due_date));
				$query_update="UPDATE veh_po SET 
						po_date=0000-00-00,			due_day='".$due_day."'	,		due_date='".$due_date."',
						cls_date=0000-00-00,		supp_code='".$supp_code."',		supp_name='".$supp_name."',
						wrhs_code='".$wrhs_code."',	loc_code='".$loc_code."',		note='".$note."',
						cls_by='".$cls_by."',		veh_code='".$veh_code."',		veh_name='".$veh_name."',
						chassis='".$chassis."',		engine='".$engine."',			veh_type='".$veh_type."',
						veh_model='".$veh_model."',	color_code='".$color_code."',	color_name='".$color_name."',
						stdoptcode='".$stdoptcode."',qty='".$qty."',				unit='".$unit."',
						unit_price='".$unit_price."',tot_price='".$tot_price."',	veh_brand='".$veh_brand."',
						veh_transm='".$veh_transm."',veh_year='".$veh_year."',		color_type='".$color_type."',
						po_made_by='".$po_made_by."',po_appr_by='".$po_appr_by."'
						WHERE po_no='".$po_no."' ";
				$result1 = mysql_query($query_update);
				if(mysql_affected_rows()==1){
				msgSuccess($id,$field1,$$field1,'Record updated');
				return;
				}else{
				msgFailed($id,$field1,$$field1,'Update Failed');
				return;
				}	
			}
			
		}
	}
	if ($func=='delete')
	{
		if (isset($field1) && isset($field2))
		{
			$sql = "select count(id) as n_count from $table where $field1 = '".$$field1."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count==0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field1,$$field1,'Record not found');
				return;
			}else
			{
				$query_delete = "delete from $table where id=$id" ;
				//echo $sql;
				$result = mysql_query($query_delete);
				$sql = "select count(id) as n_count,id from $table where id=$id" ;
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				$count = $row['n_count'];
				if ($count==0){
					msgSuccess($id,$field1,$$field1,'Record deleted');
					return;
				}else{
					msgFailed($id,$field1,$$field1,'Delete failed');
					return;
				}
			}
		}
	}
	if ($func=='datasource')
	{	
		$defaultfields = "*";
		if (isset($fields)) {
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table where 1=1 ";
		
		if (isset($q)) {
			$result .= " AND ($field1 like '%$q%' or $field2 like '%$q%' )";
		}
		if (isset($order)) {
			$result .= " ORDER BY $order ";
		}
		if (isset($id)) {
			$result .= " AND id = $id ";
		}
		if (isset($start)) {
			$result .= " LIMIT $start,$limit ";
		}
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		
		echo json_encode($table);
	}
	/*		if($func=='counter')
{
	$dateString = "20150924-03"; // get Last entry's date from database. ( date("Ymd"). Ex. 20150424-03
		$m1 = (int)substr($dateString,4,2); // $dtData[0] = date part, $dtData[1] = Prefix part
		
		//$month1 = date("m",strtotime($dtData[0]))

		$lenprefix = 3;
	    $lenrunning = 4;
	    //$today = date("ym");
	    $y = date("y");
	    //$m1=date("m");
	    $sql = "select ifnull(a.new,0) as new from (select max($field1) as new from $table where left($field1,$lenprefix)=left('".$keyword."',$lenprefix))a";
	    $result = mysql_query($sql);
	    $row=mysql_fetch_array($result);
	    //echo json_encode($row);//$row['n_count']; //AD017 >> VPO-15070126
	    $m1=substr($row['new'],6,2);
	    $m1=sprintf("%02d", $m1);
	    $m2=date("m");
	    $sql = "select upper(left('$keyword',3)) as prefix,right('".$row['new']."',$lenrunning)+1 as new";
	    $result = mysql_query($sql);
	    $row=mysql_fetch_array($result);
	    //echo json_encode($row);
	    $suffix=(($m2-$m1) == 0) ?str_pad($row['new'],$lenrunning,"0",STR_PAD_LEFT) : str_pad(1,$lenrunning,"0",STR_PAD_LEFT);
	    $new = $row['prefix']."-".$y.$m2.$suffix;
	    echo $new; 
	}*/
	if ($func=='price')
	{
		$ctyp=$_GET["ctyp"];
		$vcode=$_GET["vcode"];
		
		$sql="SELECT * FROM veh_prc WHERE veh_code ='".$vcode."' AND col_type ='".$ctyp."'";
		$result = mysql_query($sql);
		
	    $row=mysql_fetch_array($result);
	    $data=array(
	    	'unit' => $row["pr2_price"],
	    	'total' =>$row["pr2_vat"] );
	    echo json_encode($data);
	}
}
?>