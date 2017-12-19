<?php
//////////////////
// SPK Available //
//////////////////
//untuk fungsi read saja

$defaultfields = "*";
if (isset($fields)) 
{
	$defaultfields = $fields;
}
$result = "select $defaultfields from $table where 1=1 ";

if (isset($id)) {
	$result .= " AND id = $id ";
}
if (isset($q)) {
	$result .= " AND (so_no like '%$q%' or srep_code like '%$q%' or srep_name like '%$q%' )";
}
if (isset($srep_code)) {
	$result .= " AND srep_code = '$srep_code' ";
}
if (isset($where1)) {
	if($where1=='1'){
		$result .= " and use_date like '0000-00-00 00:00:00' ";
	}
}
if (isset($where2)) {
	if($where2=='2'){
		$result .= " and length(srep_code)<>0 ";
	}
}
if (isset($where3)) {
	if($where3=='3'){
		$result .= " and length(srep_code)=0 ";
	}
}
/* Remark dulu karena gak tau fungsinya dipakai dimana
if (isset($contain)) {
	$result .= " AND so_no like '%$contain%' or so_regdate like '%$contain%' or srep_code like '%$contain%' or ";
	$result .= "  srep_name like '%$contain%' or so_note like '%$contain%' or so_reg_by like '%$contain%' ";
}	
*/
if (isset($date_from) and isset($date_to))
{
	$result .= " AND so_regdate BETWEEN('$date_from')AND('$date_to') ";
}
if (isset($order)) {
	if(isset($sort)){
		$result .= " ORDER BY $sort $order ";
	}else{
		$result .= " order by $order";
	}
}			
$sql = "select count(so_no) as n_count from ($result) a ";
if (isset($page)) {
	$start = ($rows*($page-1));
	$result .= " LIMIT $start,$rows ";
}
//echo $result;

$result = mysql_query($result);    

$table=array();
while($row=mysql_fetch_object($result)){
  $table[]=$row;
  unset($row);
}
//echo $sql;
$result = mysql_query($sql);
$row=mysql_fetch_array($result);	
echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';


?>