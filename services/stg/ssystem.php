<?php
/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
Antara lain :
$table 	=> Nama Table MySQL
$field1 => Field Primary (bukan id autoincrement)
$field1 => Field Description
Issue date [20140901]
*/
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
		include "navigation.php";
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
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field1,$$field1,'Record not found');
				return;
			}else
			{
                            $post = $_POST;
                            $id = $_POST['id'];
                            unset($post['lookup']);
                            unset($post['func']);
                            unset($post['id']);
                            unset($post['pk']);
                            unset($post['sk']);
                            
                            $comp_pkpdt=(empty($comp_pkpdt))? '0000-00-00':date("Ymd", strtotime($comp_pkpdt));
                            
                            $post['comp_pkpdt'] = $comp_pkpdt;
                            
                            $a='';
                            foreach ($post as $key=>$value){ 
                                $a = $a .$key ."='".$value."', ";
                            }
                            $a=substr($a,0,-2);

                           $query_update = "update ssystem set $a where id='$id' ";
                           
			/*	$comp_pkpdt=(empty($comp_pkpdt))? '0000-00-00':date("Ymd", strtotime($comp_pkpdt));
				$query_update="UPDATE ssystem SET 
						comp_name='".$comp_name."',		comp_name2='".$comp_name2."',	comp_add1='".$comp_add1."',
						comp_add2='".$comp_add2."',		comp_add3='".$comp_add3."',		comp_city='".$comp_city."',
						comp_phone='".$comp_city."',	comp_fax='".$comp_fax."',		comp_npwp='".$comp_npwp."',
						comp_pkpdt='".$comp_pkpdt."',	comp_id='".$comp_id."',			bulan='".$bulan."',
						tahun='".$tahun."',				ppn='".$ppn."',					pph='".$pph."',
						po_source='".$po_source."',		wo_source='".$wo_source."',		bbn_set='".$bbn_set."',
						optpur_set='".$optpur_set."',	optprc_set='".$optprc_set."',	vpg_source='".$vpg_source."',
						spk_length='".$spk_length."',	spk_prefix='".$spk_prefix."' ";

				/*	$query_update="UPDATE ssystem SET 
						comp_code='".$comp_code."',	comp_name='".$comp_name."',		comp_name2='".$comp_name2."',
						comp_add1='".$comp_add1."',	comp_add2='".$comp_ad2."',		comp_add3='".$comp_add3."',
						comp_city='".$comp_city."',	comp_phone='".$comp_city."',	comp_fax='".$comp_fax."',
						comp_npwp='".$comp_npwp."',	comp_pkpdt='".$comp_pkpdt."',	comp_stmp='".$comp_stmp."',
						comp_id='".$comp_id."',		bulan='".$bulan."',				tahun='".$tahun."',
						ppn='".$ppn."',				pph='".$pph."',					po_source='".$po_source."',
						so_source='".$so_source."',	wo_source='".$wo_source."',		sl_source='".$sl_source."',
						sq_prn_det='".$sq_prn_det."',so_prn_det='".$so_prn_det."',	sl_prn_det='".$sl_prn_det."',
						pict_dir='".$pict_dir."',	comp_curr='".$comp_curr."',		bbn_set='".$bbn_set."',
						mdlrw_code='".$mdlrw_code."',dlrw_code='".$dlrw_code."',	optpur_set='".$optpur_set."',
						optprc_set='".$optprc_set."',prt_use2ar='".$prt_use2ar."',	vpg_source='".$vpg_source."',
						comp_stamp='".$comp_stamp."',comp_stmpp='".$comp_stmpp."',	comp_zipc='".$comp_zipc."',
						spk_length='".$spk_length."',spk_prefix='".$spk_prefix."',	cotx_name='".$cotx_name."',
						cotx_name2='".$cotx_name2."',cotx_add1='".$cotx_add1."',	cotx_add2='".$cotx_add2."',
						cotx_add3='".$cotx_add3."',	cotx_city='".$cotx_city."',		cotx_phone='".$cotx_phone."',
						cotx_fax='".$cotx_fax."',	cotx_npwp='".$cotx_npwp."',		cotx_toiv='".$cotx_toiv."',
						cotx_zip='".$cotx_zip."' ";*/

				$result1 = mysql_query($query_update);
				if(mysql_affected_rows()==1){
				msgSuccess($id,$field1,$$field1,'Record updated');
				return;
				}else{
				msgSuccess($id,$field1,$$field1,'No Record Change');
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