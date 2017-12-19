<?php
//========CHANGE LOG=============
//Saldo Awal Per Awal Periode Group By Tanggal => Beginnning Balance By Period Start Grouped By Date
//Saldo Awal Per Awal Periode Group By Cara Bayar => Beginnning Balance By Period Start Grouped By Payment Type
//ada query yg ditambah
//footer dibuang

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "BOOKING FEE PAYMENT SUPPLIER REPORT";

$rptFile = "veh_dpcpi.php";
$order = " ORDER BY a.po_no";

$cust_type = '';
$title='';
$filterdesc = '';

$pay_date1 =dateFormat($pay_date1);
$pay_date2 =dateFormat($pay_date2);


if (!empty($_REQUEST['group_by']))
{
	$group_by = $_REQUEST['group_by'];
	switch ($group_by)
	{
		case '1' :
			$rptFile = "veh_dpcpi.php";
			$title = '(Beginnning Balance By Period Start Grouped By Date)';
			$order = " ORDER BY a.pay_date,a.pay_type";
			break;
		case '2' :
			$rptFile = "veh_dpcpp.php";
			$title = '(Beginnning Balance By Period Start Grouped By Payment Type)';
			$order = " ORDER BY a.pay_type,a.pay_date,a.po_no,a.po_date";
			break;

	}
}

$statsql ="select a.*,c.chassis,c.engine,c.veh_code,c.veh_name,c.color_code,c.unit_price
from (
select a.po_no,a.po_date,a.supp_code,a.supp_name, b.bank_code,b.pay_date,b.pay_type,b.check_no,b.check_date,b.due_date,b.pay_bt,b.used_val,b.pay_desc,b.posted,b.dp_date,b.dp_inv_no,b.pur_inv_no,b.pur_date
from " . $db1 . ".veh_dpsh a left join " . $db1 . ".veh_dpsd b on  a.po_no = b.po_no
";
$where =" WHERE 1=1 ";

if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

if (!empty($_REQUEST['pay_date1']) && !empty($_REQUEST['pay_date2']))
{
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " b.pay_date  <= '".dateFormat($_REQUEST['pay_date2'])."' and b.pay_date >= '".dateFormat($_REQUEST['pay_date1'])."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Tanggal Bayar ";
}

if (!empty($_REQUEST['pay_type']))
{
	$pay_type = $_REQUEST['pay_type'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " b.pay_type  = '".$pay_type."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Payment Type ";
}

if (!empty($_REQUEST['po_no']))
{
	$po_no = $_REQUEST['po_no'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.po_no  = '".$po_no."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "No. PO ";
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

$statsql .= $where .") a left join " . $db1 . ".veh_po c on a.po_no = c.po_no ";


$mounth = rangeMounth($pay_date1, $pay_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';


$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}


include "uangjaminansupplier/".$rptFile;
$filename = 'downpayment_supplier' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>