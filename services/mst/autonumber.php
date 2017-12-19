<?php
//URL test = ../services/runCRUD.php?lookup=mst/autonumber&func=new&table=veh_cust&field1=cust_code&keyword=AD0
function getFieldProp($result,$fieldname){
      /* get column metadata */
      $i = 0;
      while ($i < mysql_num_fields($result)) {
	  //echo "Information for column $i:<br />\n";
	  $meta = mysql_fetch_field($result, $i);
	  if (!$meta) {
	      echo "No information available<br />\n";
	  }
      /*echo "<pre>
      blob:         $meta->blob
      max_length:   $meta->max_length
      multiple_key: $meta->multiple_key
      name:         $meta->name
      not_null:     $meta->not_null
      numeric:      $meta->numeric
      primary_key:  $meta->primary_key
      table:        $meta->table
      type:         $meta->type
      unique_key:   $meta->unique_key
      unsigned:     $meta->unsigned
      zerofill:     $meta->zerofill
      </pre>";*/
	
	  if ($meta->name==$fieldname){return $meta->max_length;}
	  $i++;
      }
      
}
  
if (isset($func))
{
	if ($func=='new')
	{
	  if (isset($table) && isset($keyword) && isset($field1))
	  {
	    $lenprefix = 3;
	    $lenrunning = 3;
	    $sql = "select ifnull(a.new,0) as new from (select max($field1) as new from $table where left($field1,$lenprefix)=left('".$keyword."',$lenprefix))a";
	    $result = mysql_query($sql);
	    $row=mysql_fetch_array($result);
	    echo json_encode($row);//$row['n_count']; //AD017
	    
	    $sql = "select upper(left('$keyword',3)) as prefix,right('".$row['new']."',$lenrunning)+1 as new";
	    $result = mysql_query($sql);
	    $row=mysql_fetch_array($result);
	    echo json_encode($row);
	    $new = $row['prefix'].str_pad($row['new'], $lenrunning, "0", STR_PAD_LEFT);
	    echo $new;
	   }
	}
}	

function autonumber($table,$field2,$field1,$valfield1){
	
	if($table=="veh_cust" || $table=="veh_pcus" || $table=="acc_cust" ){
		$today = date("ym");
		$trimmed=str_replace(' ', '', $field2);
		$name = substr($trimmed,0,3);
		$query = "SELECT max($field1) AS maxID FROM $table WHERE $field1 LIKE '$name%' order by id desc";
		$result = mysql_query($query) or die("Query failed with error: ".mysql_error());;
		$data  = mysql_fetch_array($result);
		$idMax = $data['maxID'];
		$noUrut = (int) substr($idMax, 6, 3);
		$noUrut++;
		$newID = strtoupper($name.'-'.sprintf('%03s', $noUrut));
	}else{
	$newID=$valfield1;
	}
		return $newID;
}

?>