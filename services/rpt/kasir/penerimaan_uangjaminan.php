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
$rptTitle = "BOOKING FEE PAYMENT REPORT";

$rptFile = "veh_dpcpd.php";
$order = " ORDER BY a.so_no";

$cust_type = '';
$title='';
$filterdesc = '';

$pay_date1 =dateFormat($pay_date1);
$pay_date2 =dateFormat($pay_date2);



$statsql ="select a.*,c.chassis,c.engine,c.veh_code,c.veh_name,c.color_code,c.unit_price
from (
select a.dp_inv_no,a.dp_date,a.so_no,a.so_date,a.cust_code,a.cust_name,a.srep_name,a.srep_code,
b.tts_no,b.tts_date,b.bank_code,b.pay_date,b.pay_type,b.check_no,b.check_date,b.due_date,b.pay_val,b.used_val,b.pay_desc,b.posted,b.sal_date,b.sal_inv_no,b.coll_code
from " . $db1 . ".veh_dpch a left join " . $db1 . ".veh_dpcd b on a.dp_inv_no = b.dp_inv_no and a.so_no = b.so_no
";
$where =" WHERE 1=1 ";

if (!empty($_REQUEST['group_by']))
{
	$group_by = $_REQUEST['group_by'];
	switch ($group_by)
	{
		case '1' :
			$rptFile = "veh_dpcpd.php";
			$title = '(Beginnning Balance By Period Start Grouped By Date)';
			$order = " ORDER BY a.pay_date";
			break;
                case '2' :
			$rptFile = "veh_dpcpc.php";
			$title = '(Beginnning Balance By Period Start Grouped By Customer)';
			$order = " ORDER BY a.cust_code,a.cust_name";
			break;
                case '3' :
			$rptFile = "veh_dpcpi.php";
			$title = '(Beginnning Balance By Period Start Grouped By Sales Person)';
			$order = " ORDER BY a.srep_code,a.srep_name";
			break;
                    
		case '4' :
			$rptFile = "veh_dpcpp.php";
			$title = '(Beginnning Balance By Period Start Grouped By Payment Type)';
			$order = " ORDER BY a.pay_type,a.pay_date,a.so_no,a.so_date";
			break;
                
                case '5' :
			$rptFile = "veh_dpcpiv.php";
			$title = '(Beginnning Balance By Period Start Grouped By Print Invoice)';
			 
                        $where .= " AND b.tts_no NOT IN('') ";
			break;

	}
}


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

if (!empty($_REQUEST['so_no']))
{
	$so_no = $_REQUEST['so_no'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.so_no  = '".$so_no."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "No. SPK ";
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
if (!empty($_REQUEST['cust_code']))
{
	$cust_code = $_REQUEST['cust_code'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.cust_code  = '".$cust_code."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Customer ";
}

$statsql .= $where .") a left join " . $db1 . ".veh_spk c on a.so_no = c.so_no ";


$mounth = rangeMounth($pay_date1, $pay_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}


include "uangjaminan/".$rptFile;
$filename = 'uangjaminan_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
?>