<?php
$table = "mvrep_code";

if (isset($func))
{
	if ($func=='reccount')
	{
		$result = "select * from $table where 1=1 ";
		$sql = "select count(mvrep_code) as n_count,max(id) as max_id from ($result) a ";
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
			$result .= " AND (mvrep_code like '%$query%' or mvrep_name like '%$query%' )";
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
		$sql = "select count(mvrep_code) as n_count from ($result) a ";
		//echo $result;
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
		
		if (isset($mvrep_code) && isset($mvrep_name))
		{
			$lnmvrep_code = strlen(trim($mvrep_code));
			$lnmvrep_name= strlen(trim($mvrep_name));
			if ($lnmvrep_code==0 || $lnmvrep_name==0)
			{
				echo '{"success":false,"message":"Cannot be empty.","mvrep_code":"'.$mvrep_code.'"}';
				return;
			}
			$sql = "select count(id) as n_count from $table where mvrep_code = '$mvrep_code' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count>>0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				echo '{"success":false,"message":"mvrep_code already exists.","mvrep_code":"'.$mvrep_code.'"}';
				return;
			}else
			{
				$sql = "insert into $table (mvrep_code,mvrep_name) values('$mvrep_code','$mvrep_name')";
				$result = mysql_query($sql);
				$sql = "select count(id) as n_count,id from $table where mvrep_code = '$mvrep_code' ";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				$count = $row['n_count'];
				if ($count>>0){
					echo '{"success":true,"message":"Data saved.","mvrep_code":"'.$mvrep_code.'","id":"'.$row['id'].'"}';
					return;
				}else{
					echo '{"success":false,"message":"Data write failed","mvrep_code":"'.$mvrep_code.'"}';
					return;
				}
			}
			
		}
	}
	if ($func=='update')
	{
		/* Hanya field "mvrep_name" yang boleh diupdate */
		
		if (isset($mvrep_code) && isset($mvrep_name))
		{
			$lnmvrep_code = strlen(trim($mvrep_code));
			$lnmvrep_name= strlen(trim($mvrep_name));
			if ($lnmvrep_code==0 || $lnmvrep_name==0)
			{
				echo '{"success":false,"message":"Cannot be empty.","mvrep_code":"'.$mvrep_code.'"}';
				return;
			}
			$sql = "select count(id) as n_count from $table where mvrep_code = '$mvrep_code' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count==0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				echo '{"success":false,"message":"mvrep_code not exists.","mvrep_code":"'.$mvrep_code.'"}';
				return;
			}else
			{
				$sql = "update $table set mvrep_name='$mvrep_name' where id=$id" ;
				$result = mysql_query($sql);
				$sql = "select mvrep_code,mvrep_name from $table where id =$id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				if ($mvrep_name== $row['mvrep_name']){
					echo '{"success":true,"message":"Data saved.","mvrep_code":"'.$mvrep_code.'"}';
					return;
				}else{
					echo '{"success":false,"message":"Data write failed","mvrep_code":"'.$mvrep_code.'"}';
					return;
				}
			}
			
		}
	}
	if ($func=='delete')
	{
		if (isset($mvrep_code) && isset($mvrep_name))
		{
			$sql = "select count(id) as n_count from $table where mvrep_code = '$mvrep_code' ";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$count = $row['n_count'];
			if ($count==0)
			{
				//echo json_encode(array("success"=>"John","time"=>"2pm")); 
				echo '{"success":false,"message":"mvrep_code not exists.","mvrep_code":"'.$mvrep_code.'"}';
				return;
			}else
			{
				$sql = "delete from $table where id=$id" ;
				//echo $sql;
				$result = mysql_query($sql);
				$sql = "select count(id) as n_count,id from $table where id=$id" ;
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
				$count = $row['n_count'];
				
				if ($count==0){
					echo '{"success":true,"message":"Data saved.","mvrep_code":"'.$mvrep_code.'","id":"'.$id.'"}';
					return;
				}else{
					echo '{"success":false,"message":"Data write failed","mvrep_code":"'.$mvrep_code.'"}';
					return;
				}
			}
		}
	}
}	
?>