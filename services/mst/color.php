<?php
/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
Antara lain :
$table 	=> Nama Table MySQL
$field1 => Field Primary (bukan id autoincrement)
$field1 => Field Description
Issue date [20140901]
*/

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
                $filter = " and DATE(exp_date) >= NOW() OR DATE(exp_date) = '0000-00-00' ";
		$defaultfields = "*";
		if (isset($fields)) 
		{
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table where 1=1 ".$filter;
		
		if (isset($id)) {
			$result .= " AND id = $id ";
		}
		if (isset($q)) {
			$result .= " AND ($field1 like '%$q%' or $field2 like '%$q%')";
		}
		if (isset($query)) {
			$result .= " AND ($pk like '%$query%' or $sk like '%$query%')";
		}
		if (isset($order)) {
			if(isset($sort)){
				$result .= " ORDER BY $sort $order ";
			}else{
				$result .= " order by $order";
			}
		}		
		$sql = "select count($field1) as n_count from ($result) a where 1=1 $filter";
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
		if (/*isset($field1) && */isset($field2))
		{
			//$lnfield1 = strlen(trim($$field1));
			$lnfield2= strlen(trim($$field2));
			if (/*$lnfield1==0 || */$lnfield2==0)
			{
				msgFailed($id,$field2,$$field2,'Data cannot be empty');
				return;
			}
			$sql = "select count(id) as n_count from $table where $field2 = '".$$field2."' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count>>0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				msgFailed($id,$field2,$$field2,'Data already exist');
				return;
			}else
			{
				//mau dicoba versi sendiri
				$query_insert="insert into ".$table." (".$attr_insert.") values (".$val_insert.")";
				$result = mysql_query($query_insert);
				//update pk dan sk jadi kapital
				$sql="update $table set $field1='".strtoupper($$field1)."', $field2='".strtoupper($$field2)."' where $field1='".$$field1."'";
				$result=mysql_query($sql);
			/*	$sql = "insert into $table ($field1,$field2) values('".$$field1."','".$$field2."')";
				$result = mysql_query($sql);*/
				//$count = mysql_affected_rows();
				$sql = "select count(id) as n_count,id from $table where $field2 = '".$$field2."' ";
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
				if($act_date==""){
					$act_date="0000-00-00";
				}else{
					$act_date=date('Y-m-d',strtotime($act_date));	
				}
				if($exp_date==""){
					$exp_date="0000-00-00";
				}else{
					$exp_date=date('Y-m-d',strtotime($exp_date));	
				}
				//mau dicoba versi sendiri
				$query_update="update $table set $field2='".strtoupper($$field2)."',type='$type',act_date='$act_date',exp_date='$exp_date',note='$note' where id=$id";
				$result = mysql_query($query_update);
			/*	$sql = "update $table set $field2='".$$field2."' where id=$id" ;
				$result = mysql_query($sql);*/
				$sql = "select $field1,$field2 from $table where id =$id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				
				msgSuccess($id,$field2,$$field2,'Record updated');
				return;
				
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