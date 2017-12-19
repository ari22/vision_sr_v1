<?php
/*
Modul			:	Pelunasan Piutang Kendaraan
Cara pakai  	:	http://localhost:88/ver2/services/runCRUD.php?lookup=trx/veh_ar&func=select
Keterangan		: 	func -> Function
			
*/
$table='veh_aph';
$msg='';
$success='false';
if (isset($func))
{
	if ($func=='reccount')
	{
		$result = "select * from $table where 1=1 ";
		$sql = "select count(pur_inv_no) as n_count,max(id) as max_id from ($result) ";
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
			$result .= " AND (pur_inv_no like '%$query%' or chassis like '%$query%' or supp_name like '%$query%' or po_no like '%$query%')";
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
	
		$sql = "select count(pur_inv_no) as n_count from ($result) a ";
		if (isset($page) && isset($rows)) {
			$count = 1 + $page * ($rows-1); // BUG
			$result .= " LIMIT $count,$rows ";
		}
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
}
	
	
?>