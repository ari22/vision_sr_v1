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
		if (/*isset($field1) && */isset($field2))
		{
			//$lnfield1 = strlen(trim($$field1));
			$lnfield2= strlen(trim($$field2));
			if (/*$lnfield1==0 || */$lnfield2==0)
			{
				msgFailed($id,$field2,$$field2,'Data cannot be empty');
				return;
			}
				//so_no tarik data dari table veh_spkreg
				$select_so_no=mysql_query("select srep_code, srep_name from veh_spkreg where so_no='$so_no'");
				$row_so_no=mysql_fetch_assoc($select_so_no);
				//cust_code tarik data dari table veh_cust
				$select_cust=mysql_query("select * from veh_cust where cust_code='$cust_code'");
				$row_cust=mysql_fetch_assoc($select_cust);
				//srep_code tarik data dari table veh_srep
				$select_srep=mysql_query("select srep_code, srep_name, sex from veh_srep where srep_code='".$row_so_no['srep_code']."'");
				$row_srep=mysql_fetch_assoc($select_srep);
				//veh_code tarik data dari table veh_vtyp
				$select_veh=mysql_query("select * from veh_vtyp where veh_code='$veh_code'");
				$row_veh=mysql_fetch_assoc($select_veh);
				//color_code ditarik dari table color
				$select_col=mysql_query("select * from color where color_code='$color_code'");
				$row_col=mysql_fetch_assoc($select_col);
				//lease_code ditarik dari table lease
				$select_lease=mysql_query("select * from lease where lease_code='$lease_code'");
				$row_lease=mysql_fetch_assoc($select_lease);
				//update use_date table veh_spkreg
			
				$query_insert="insert into ".$table." (so_no) values ('$so_no')";
				$result_insert=mysql_query($query_insert);
				$query_update_for_insert="update ".$table." set so_date='$so_date', soseq_date=now(), cust_code='".$row_cust['cust_code']."',cust_name='".$row_cust['cust_name']."',srep_code='".$row_srep['srep_code']."',srep_name='".$row_srep['srep_name']."',srep_sex='".$row_srep['sex']."',sosrc_name='$sosrc_name',veh_code='".$row_veh['veh_code']."',veh_name='".$row_veh['veh_name']."',veh_brand='".$row_veh['veh_brand']."',veh_type='".$row_veh['veh_type']."',veh_model='".$row_veh['veh_model']."',veh_year='".$row_veh['veh_year']."',veh_transm='".$row_veh['veh_transm']."',color_code='".$row_col['color_code']."',color_name='".$row_col['color_name']."',color_type='".$row_col['type']."',qty=1,unit='Unit',unit_price='$unit_price',tot_price='$unit_price',pred_stk_d='$pred_stk_d',cust_addr='".$row_cust['haddr']."',cust_area='".$row_cust['harea']."',cust_city='".$row_cust['hcity']."',cust_cntry='".$row_cust['hcountry']."',cust_zipc='".$row_cust['hzipcode']."',cust_phone='".$row_cust['hphone']."',cust_sex='".$row_cust['sex']."',cust_fax='".$row_cust['hfax']."',cust_hp='".$row_cust['hp']."',cust_npwp='".$row_cust['onpwp']."',cust_nppkp='".$row_cust['opkp']."',cust_rname='$cust_rname',cust_raddr='$cust_raddr',cust_rarea='$cust_rarea',cust_rcity='$cust_rcity',cust_rcntr='$cust_rcntr',cust_rzipc='$cust_rzipc',cust_rphon='$cust_rphon',cust_rsex='$cust_rsex',add_item1='$add_item1',add_item2='$add_item2',add_item3='$add_item3',add_item4='$add_item4',add_item5='$add_item5',add_item6='$add_item6',add_item7='$add_item7',add_item8='$add_item8',crd_via='$crd_via',lease_code='".$row_lease['lease_code']."',lease_name='".$row_lease['lease_name']."',lease_addr='".$row_lease['oaddr']."',lease_city='".$row_lease['ocity']."',lease_zipc='".$row_lease['ozipcode']."',lcp1_name='".$row_lease['ocp1_name']."',lcp2_title='".$row_lease['ocp1_title']."',crd_term='$crd_term',crd_irate='$crd_irate',prc_type='$prc_type',salpaytype='$salpaytype',pay_val='$pay_val',pay_date='$pay_date',pay_type='$pay_type',check_no='$check_no',check_date='$check_date',comm_val='$comm_val',medtr_name='$medtr_name',medtr_addr='$medtr_addr',so_made_by='".$_SESSION['C_USER']."',so_appr_by='$so_appr_by',so_desc='$so_desc' where so_no='$so_no'";
				
				if(mysql_query($query_update_for_insert)){
					$query_update_spkreg="update veh_spkreg set use_date='".date('Y-m-d h:i:s')."' where so_no='$so_no'";
					if(mysql_query($query_update_spkreg)){
					}else{
						//query delete yang sudah disimpan
						$query_delete_failed_insert="delete from $table where so_no=$so_no";
						mysql_query($query_delete_failed_insert);
						msgFailed($id,$field2,$$field2,'Insert Failed');
						return;
					}
				}else{
					msgFailed($id,$field2,$$field2,'Insert Failed');
					return;
				}
				
				$sql = "select count(id) as n_count,id from $table where $field1 = '".$$field1."' ";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				$count = $row['n_count'];
				$id = $row['id'];
				if ($count>>0){
					msgSuccess($id,$field2,$$field2,$query_update_for_insert);
					return;
				}else{
					msgFailed($id,$field2,$$field2,$query_update_for_insert);
					return;
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
			$sql = "select count(id) as n_count from $table where $field1 = '".$$field1."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count==0)
			{
				msgFailed($id,$field1,$$field1,'Record not found');
				return;
			}else
			{
				//so_no tarik data dari table veh_spkreg
				$select_so_no=mysql_query("select srep_code, srep_name from veh_spkreg where so_no='$so_no'");
				$row_so_no=mysql_fetch_assoc($select_so_no);
				//cust_code tarik data dari table veh_cust
				$select_cust=mysql_query("select * from veh_cust where cust_code='$cust_code'");
				$row_cust=mysql_fetch_assoc($select_cust);
				//srep_code tarik data dari table veh_srep
				$select_srep=mysql_query("select srep_code, srep_name, sex from veh_srep where srep_code='".$row_so_no['srep_code']."'");
				$row_srep=mysql_fetch_assoc($select_srep);
				//veh_code tarik data dari table veh_vtyp
				$select_veh=mysql_query("select * from veh_vtyp where veh_code='$veh_code'");
				$row_veh=mysql_fetch_assoc($select_veh);
				//color_code ditarik dari table color
				$select_col=mysql_query("select * from color where color_code='$color_code'");
				$row_col=mysql_fetch_assoc($select_col);
				//lease_code ditarik dari table lease
				$select_lease=mysql_query("select * from lease where lease_code='$lease_code'");
				$row_lease=mysql_fetch_assoc($select_lease);
				
				$query_update="update $table set so_date='$so_date', soseq_date=now(), cust_code='".$row_cust['cust_code']."',cust_name='".$row_cust['cust_name']."',srep_code='".$row_srep['srep_code']."',srep_name='".$row_srep['srep_name']."',srep_sex='".$row_srep['sex']."',sosrc_name='$sosrc_name',veh_code='".$row_veh['veh_code']."',veh_name='".$row_veh['veh_name']."',veh_brand='".$row_veh['veh_brand']."',veh_type='".$row_veh['veh_type']."',veh_model='".$row_veh['veh_model']."',veh_year='".$row_veh['veh_year']."',veh_transm='".$row_veh['veh_transm']."',color_code='".$row_col['color_code']."',color_name='".$row_col['color_name']."',color_type='".$row_col['type']."',qty=1,unit='Unit',unit_price='$unit_price',tot_price='$unit_price',pred_stk_d='$pred_stk_d',cust_addr='".$row_cust['haddr']."',cust_area='".$row_cust['harea']."',cust_city='".$row_cust['hcity']."',cust_cntry='".$row_cust['hcountry']."',cust_zipc='".$row_cust['hzipcode']."',cust_phone='".$row_cust['hphone']."',cust_sex='".$row_cust['sex']."',cust_fax='".$row_cust['hfax']."',cust_hp='".$row_cust['hp']."',cust_npwp='".$row_cust['onpwp']."',cust_nppkp='".$row_cust['opkp']."',cust_rname='$cust_rname',cust_raddr='$cust_raddr',cust_rarea='$cust_rarea',cust_rcity='$cust_rcity',cust_rcntr='$cust_rcntr',cust_rzipc='$cust_rzipc',cust_rphon='$cust_rphon',cust_rsex='$cust_rsex',add_item1='$add_item1',add_item2='$add_item2',add_item3='$add_item3',add_item4='$add_item4',add_item5='$add_item5',add_item6='$add_item6',add_item7='$add_item7',add_item8='$add_item8',crd_via='$crd_via',lease_code='".$row_lease['lease_code']."',lease_name='".$row_lease['lease_name']."',lease_addr='".$row_lease['oaddr']."',lease_city='".$row_lease['ocity']."',lease_zipc='".$row_lease['ozipcode']."',lcp1_name='".$row_lease['ocp1_name']."',lcp2_title='".$row_lease['ocp1_title']."',crd_term='$crd_term',crd_irate='$crd_irate',prc_type='$prc_type',salpaytype='$salpaytype',pay_val='$pay_val',pay_date='$pay_date',pay_type='$pay_type',check_no='$check_no',check_date='$check_date',comm_val='$comm_val',medtr_name='$medtr_name',medtr_addr='$medtr_addr',so_made_by='".$_SESSION['C_USER']."',so_appr_by='$so_appr_by',so_desc='$so_desc' where so_no='$so_no'";
				//$query_update="update $table set ".$attrval_update." where id=$id";
				$result = mysql_query($query_update);
				$sql = "select $field1,$field2 from $table where id =$id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				
				if ($$field2== $row[$field2]){
					msgSuccess($id,$field2,$$field2,$query_update);
					return;
				}else{
					msgFailed($id,$field2,$$field2,$query_update);
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
				//cek ke veh_spkd apakah ada optional
				$query_cek_optional="select count(*) as n_count, id from veh_spkd where so_no='$so_no'";
				$query_delete = "delete from $table where so_no='$so_no'";
				if(mysql_query($query_delete)){
					$query_update_spkreg=mysql_query("update veh_spkreg set use_date='".date('0000-00-00 00:00:00')."' where so_no='$so_no'");
				}else{
					msgFailed($id,$field1,$$field1,'Delete failed');
					return;
				}
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
}
?>