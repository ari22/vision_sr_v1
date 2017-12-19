<?php
/*
	Fungsi				:	Mengambil data customer yang memiliki kendaraan model tertentu
	Cara pakai 			:	
	Required Parameter 	:	model	->	model kendaraan
							year   	->  tahun
							(boleh diisi salah satu atau keduanya)
*/
	mysql_select_db('hnd_template');
	$result = "select id,cust_code,cust_name,hphone,hp from srv_cust WHERE 1=1 ";
	if (isset($model))
	{
		$result .= " AND veh_model like '%$model%' ";
	}
	if (isset($year))
	{
		$result .= " AND veh_year = $year ";
	}
	
	echo $result;
	$sql = "select count(id) as n_count from ($result) a ";
	$result = mysql_query($result);    
	
	$table=array();
	while($row=mysql_fetch_object($result)){
	  $table[]=$row;
	  unset($row);
	}
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
?>