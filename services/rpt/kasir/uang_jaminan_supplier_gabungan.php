<?php
//========CHANGE LOG=============
//buang footer

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "BOOKING FEE SUPPLIER COMBINED REPORT";

$rptFile = "veh_apgc.php";
$order = " ORDER BY dp_date,pay_type,check_no,dp_inv_no";

$supp_type = '';
$title='(By Date)';
$filterdesc = '';

$where =" WHERE 1=1 ";
if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

$dp_date1 = dateFormat($dp_date1);
$dp_date2 = dateFormat($dp_date2);

if (!empty($_REQUEST['dp_date1']) && !empty($_REQUEST['dp_date2']) )
{
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.dp_date  <= '".dateFormat($_REQUEST['dp_date2'])."' and a.dp_date >= '" .dateFormat($_REQUEST['dp_date1']). "' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Payment Date ";
}

if (!empty($_REQUEST['pay_type']))
{
	$pay_type = $_REQUEST['pay_type'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.pay_type  = '".$pay_type."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Pay Type ";
}

if (!empty($_REQUEST['supp_code']))
{
	$supp_code = $_REQUEST['supp_code'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.supp_code  = '".$supp_code."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Supplier ";
}


$statsql ="select a.*,
b.pur_inv_no,b.pur_date,b.chassis,b.engine,
b.dp_begin,b.dp_paid,b.dp_used,b.dp_end,b.use_date,b.po_no,b.po_date,b.color_code,b.color_name,b.veh_code,b.veh_name,b.veh_price,
b.add_by,b.add_date
from " . $db1 . ".veh_dpsgh a left join " . $db1 . ".veh_dpsgd b on a.dp_inv_no = b.dp_inv_no
";

//$statsql .= $where . " " . $order ;
$statsql .= $where;

$mounth = rangeMounth($dp_date1, $dp_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}


include "uangjaminansuppliergabungan/".$rptFile;

$filename = 'downpayment_supplierGroup_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_apgh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

?>