<?php
	$result = "select * from acc_wkcd where 1=1 ";
	
	if (isset($query)) 
	{
		$result .= " AND (wk_code like '%$query%' OR wk_desc like '%$query%') ";
	}
	$sql = "select count(wk_code) as n_count from ($result) a ";
	
	if (isset($order)) 
	{
		$result .= " ORDER BY $order ";
	}
	if (isset($start)) 
	{
		$result .= " LIMIT $start,$limit ";
	}
	
?>