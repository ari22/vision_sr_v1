<?php
	$result = "select * from veh_srep where 1=1 ";
	$sql = "select count(srep_code) as n_count from ($result) a ";
	if (isset($query)) {
		$result .= " AND srep_name like '%$query%' ";
	}
	if (isset($order)) {
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) {
		$result .= " LIMIT $start,$limit ";
	}
?>