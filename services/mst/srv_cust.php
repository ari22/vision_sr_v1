<?php
/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
Antara lain :
$table 	=> Nama Table MySQL
$field1 => Field Primary (bukan id autoincrement)
$field1 => Field Description
Issue date [20140901]
*/
$table="srv_cust";
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
		
                if (!empty($where)) {
			$result .= " AND $where ";
		}
                
		if (isset($query)) {
			$result .= " AND ($field1 like '%$query%' or $field2 like '%$query%' )";
		}
		if (isset($q)) {
			$result .= " AND ($field1 like '%$q%' or $field2 like '%$q%' )";
		}
		if (isset($filter)) {
			$result .= " AND $filter ";
		}
		if (isset($order)) {
			$result .= " ORDER BY $sort $order ";
		}
		if (isset($id)) {
			$result .= " AND id = $id ";
		}
		$sql = "select count($field1) as n_count from ($result) a ";
		if (isset($start)) {
			$result .= " LIMIT $start,$limit ";
		}
		
		if (isset($page)) {
			$start = ($rows*($page-1));
			$result .= " LIMIT $start,$rows ";
		}
		
		//echo $result;
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		//echo $sql;
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}
	if ($func=='create')
	{		
		if (isset($field2))
		{
			$lnfield2= strlen(trim($$field2));
			if ($lnfield2==0)
			{
				msgFailed($id,$field2,$$field2,'Data cannot be empty');
				return;
			}
			//cek kalau ada yang kembar pembanding hp atau alamat atau 
			
			//require_once("autonumber.php");
			$query_insert="insert into ".$table." (".$attr_insert.") values (".$val_insert.")";
			$result = mysql_query($query_insert);
			$sql="select id from $table where $field2='".$$field2."' order by id desc limit 0,1";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$query_update="update $table set $field1='".autonumber($table,$$field2,$field1,$$field1)."', $field2='".strtoupper($$field2)."' where id='".$row['id']."'";
			$result=mysql_query($query_update);
			$sql = "select count(id) as n_count,max(id) as id from $table where $field2 = '".$$field2."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			$id = $row['id'];
			if ($count>>0){
				msgSuccess($id,$field2,$$field2,'Record saved');
				return;
			}else{
				msgFailed($id,$field2,$$field2,'Insert failed');
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
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field1,$$field1,'Record not found');
				return;
			}else
			{
				if($dob==""){
					$dob="0000-00-00";
				}else{
					$dob=date('Y-m-d',strtotime($dob));	
				}
				if($wed_anniv==""){
					$wed_anniv="0000-00-00";
				}else{
					$wed_anniv=date('Y-m-d',strtotime($wed_anniv));	
				}
				if($spouse_dob==""){
					$spouse_dob="0000-00-00";
				}else{
					$spouse_dob=date('Y-m-d',strtotime($spouse_dob));	
				}
				if($child1_dob==""){
					$child1_dob="0000-00-00";
				}else{
					$child1_dob=date('Y-m-d',strtotime($child1_dob));	
				}
				if($child2_dob==""){
					$child2_dob="0000-00-00";
				}else{
					$child2_dob=date('Y-m-d',strtotime($child2_dob));	
				}
				if($oest_date==""){
					$oest_date="0000-00-00";
				}else{
					$oest_date=date('Y-m-d',strtotime($oest_date));	
				}
				//mau dicoba versi sendiri
				$query_update="update $table set $field2='".strtoupper($$field2)."',cust_alias='$cust_alias',sex='$sex',cust_type='$cust_type',postaddr='$postaddr',oaddr='$oaddr',oarea='$oarea',ocity='$ocity',ozipcode='$ozipcode',ocountry='$ocountry',ophone='$ophone',ofax='$ofax',oemail='$oemail',ocp1_name='$ocp1_name',ocp1_title='$ocp1_title',ocp2_name='$ocp2_name',ocp2_title='$ocp2_title',bus_fld='$bus_fld',bus_item='$bus_item',haddr='$haddr',harea='$harea',hcity='$hcity',hcountry='$hcountry',hzipcode='$hzipcode',hphone='$hphone',hfax='$hfax',hp='$hp',hemail='$hemail',pob='$pob',dob='$dob',relig_code='$relig_code',job_code='$job_code',ktp_no='$ktp_no',drv_lic_no='$drv_lic_no',spousename='$spousename',wed_anniv='$wed_anniv',child1name='$child1name',child2name='$child2name',spouse_dob='$spouse_dob',child1_dob='$child1_dob',child2_dob='$child2_dob',onpwp='$onpwp',opkp='$opkp',oest_date='$oest_date',ovat='$ovat' where id=$id";
				$result = mysql_query($query_update);
			/*	$sql = "update $table set $field2='".$$field2."' where id=$id" ;
				$result = mysql_query($sql);*/
				$sql = "select $field1,$field2 from $table where id =$id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				
				if ($$field2== $row[$field2]){
					msgSuccess($id,$field2,$$field2,'Record updated');
					return;
				}else{
					msgFailed($id,$field2,$$field2,'Update failed');
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
}
?>