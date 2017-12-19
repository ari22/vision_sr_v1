<?php
/*
	Fungsi				:	Mengambil data telepon customer showroom yang berulang tahun di tanggal dan bulan tertentu
	Cara pakai 			:	http://localhost:88/ver2/services/runCRUD.php?lookup=crm/sms&func=GetData&reminder=sr_birthday&month=2&day=4
	Required Parameter 	:	day		->	tanggal
							month   ->  bulan lahir
							(boleh diisi salah satu atau keduanya)
*/
	mysql_select_db('hnd_template');
	$result = "select id,cust_code,cust_name,hphone,hp from veh_cust WHERE 1=1 ";
	if (isset($day))
	{
		$result .= " AND day(dob) = $day ";
	}
	if (isset($month))
	{
		$result .= " AND month(dob) = $month ";
	}
	
	//echo $result;
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