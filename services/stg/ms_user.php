<?php
/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
Antara lain :
$table 	=> Nama Table MySQL
$field1 => Field Primary (bukan id autoincrement)
$field1 => Field Description
Issue date [20140901]
*/

if (isset($func))
{

	if ($func=='read')
	{
		$defaultfields = "*";
		if (isset($fields)) {
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table where 1=1 ";
		
		if (isset($password1) && isset($username)) {
			$result .= " AND (password = ('$password1') and username = '$username' )";
		}
		
		$sql = "select count(id) as n_count from ($result) a ";
		//echo $result;
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		$result = mysql_query($sql);
		//echo $sql;
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'"}';
	}

	if ($func=='update')
	{
		$sql="update $table set password='$password2'  where 1=1 ";
		if (isset($password2) && isset($username)) {
			$sql .= " AND (password = '$password2' and username = '$username' )";
		}
		$result = mysql_query($sql);
		$count = mysql_affected_rows;
		if ($count>>0)
		{
			msgSuccess('','','','Password Berhasil di ganti');	
		}else{
			msgFailed('','','','Password gagal di ganti');
		}
	}
}
?>