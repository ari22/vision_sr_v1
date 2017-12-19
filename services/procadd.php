<?php 
	function getFieldList($table,$mode)
	{
	$sql = "show columns from $table";
			$result = mysql_query($sql);
			$table=array();
			$lcSyntax = '';
			while($row=mysql_fetch_object($result)){
			  //$table[]=$row;
			  //unset($row);
				if ($row->Field=='id')
				{}else
				{
					$lenSyntax = strlen($lcSyntax);
					switch ($mode)
					{
						case 'getData' :
							if ($lenSyntax>>0)
							{$lcSyntax.=',';}
							$lcField = "data.rows[0]['".$row->Field."']";
							if ($row->Type=='date')
							{
								$lcField = " (($lcField=='0000-00-00')? '':$lcField )";
							}
							$lcSyntax .= $row->Field.":".$lcField;
							break;
						case 'condAdd' :
							$lcSyntax .= "$('#".$row->Field."').val('');";
							break;
					}
				}
			}
			echo $lcSyntax;
	}
?>
