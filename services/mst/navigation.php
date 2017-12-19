<?php
	if (isset($nav) && isset($id))
	{
		$lastid=$id;
		if ($nav=='f' || $nav=='F')
		{
			$sql = "select id from $table order by id limit 1";
		}
		if ($nav=='p' || $nav=='P')
		{
			$sql = "select id from $table where id<$id order by id desc limit 1";
		}
		if ($nav=='n' || $nav=='N')
		{
			$sql = "select id from $table where id>$id limit 1";
		}
		if ($nav=='l' || $nav=='L')
		{
			$sql = "select id from $table order by id desc limit 1";
		}
		$query_last=mysql_fetch_array(mysql_query("select * from $table"));
		
		//echo $sql;
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		$id = $row['id'];
		if ($id>>0){}else{$id=$lastid;}
	}
	
?>