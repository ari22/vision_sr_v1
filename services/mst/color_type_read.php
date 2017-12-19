<?php
	$result = "select * from col_type where 1=1 ";
	
	if (isset($query)) {
		$result .= " AND (coltp_name like '%$query%' or coltp_code like '%$query%' )";
	}
	if (isset($order)) {
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) {
		$result .= " LIMIT $start,$limit ";
	}
	$sql = "select count(coltp_code) as n_count from ($result) a ";
?>