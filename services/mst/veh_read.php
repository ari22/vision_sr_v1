<?php
	$result = "select * from veh_vtyp where 1=1 ";
	
	if (isset($query)) {
		$result .= " AND (veh_name like '%$query%' or veh_code like '%$query%' )";
	}
	if (isset($order)) {
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) {
		$result .= " LIMIT $start,$limit ";
	}
	$sql = "select count(veh_code) as n_count from ($result) a ";
?>