<?php
	$result = "select * from veh_wrhs where 1=1 ";
	
	if (isset($query)) {
		$result .= " AND (wrhs_name like '%$query%' or wrhs_code like '%$query%' )";
	}
	if (isset($order)) {
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) {
		$result .= " LIMIT $start,$limit ";
	}
	$sql = "select count(wrhs_code) as n_count from ($result) a ";
?>