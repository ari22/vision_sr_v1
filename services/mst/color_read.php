<?php
	$defaultfields = "*";
	if (isset($fields)) {
		$defaultfields = $fields;
	}
	$result = "select $defaultfields from color where 1=1 ";
	$sql = "select count(color_code) as n_count from ($result) a ";
	if (isset($query)) {
		$result .= " AND color_name like '%$query%' ";
	}
	if (isset($order)) {
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) {
		$result .= " LIMIT $start,$limit ";
	}
?>