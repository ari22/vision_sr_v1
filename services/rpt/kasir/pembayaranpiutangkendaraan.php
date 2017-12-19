<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "ACCOUNT RECEIVABLE PAYMENT REPORT";

$rptFile = "veh_arpp.php";
$order = " ";

$cust_type = '';
$title='';
$filterdesc = '';

$pay_date1 = dateFormat($pay_date1);
$pay_date2 = dateFormat($pay_date2);

$where =" WHERE 1=1 ";
if (!empty($_REQUEST['group_by']))
{
	$group_by = $_REQUEST['group_by'];
	switch ($group_by)
	{
		case '1' :
			$rptFile = "veh_arpc.php"; 
			$title = '(By Customer)';
			$order = " ORDER BY cust_code,pay_date,sal_inv_no";
			break;
		case '2' :
			$rptFile = "veh_arpi.php"; 
			$title = '(By Invoice Type)';
			$order = " ORDER BY sinv_code,pay_date,sal_inv_no ";
			break;
		case '3' :
			$rptFile = "veh_arpp.php"; 
			$title = '(By Payment Type)';
			$order = " ORDER BY  pay_type,pay_date,sal_inv_no ";
			break;
		
	}
}

//$where = " where 1=1 " ;

if (!empty($_REQUEST['pay_date1']) && !empty($_REQUEST['pay_date2']) )
{
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " b.pay_date  <= '".dateFormat($_REQUEST['pay_date2'])."' and b.pay_date >= '" .dateFormat($_REQUEST['pay_date1']). "' ";	
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
	$where .= " pay_type  = '".$pay_type."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Pay Type ";
}

//$statsql = "create temporary table temp_ard select * from veh_ard ".$where ;
//echo $statsql;

//$where = " where sal_inv_no in (select distinct sal_inv_no from temp_ard) " ;
//mysql_query($statsql) or die(mysql_error());

if (!empty($_REQUEST['cust_code']))
{
	$cust_code = $_REQUEST['cust_code'];
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " cust_code  = '".$cust_code."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Customer ";
}
if (!empty($_REQUEST['l_sinv_code']))
{
	$sinv_code = $_REQUEST['l_sinv_code'];
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " sinv_code  = '".$sinv_code."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Invoice Type ";
}

if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

//$where .= " AND b.dp_inv_no NOT IN('')";//Jika dp_inv_no kosong maka data tidak ditampilkan

$statsql = "select b.*,a.lease_code,a.lease_name,a.sinv_code,a.chassis,a.engine,a.veh_code,a.veh_name,
a.cust_code,a.cust_name,a.srep_code,a.srep_name,a.sal_date from " . $db1 . ".veh_arh a left join " . $db1 . ".veh_ard b on a.sal_inv_no = b.sal_inv_no ";
//$statsql .= $where . " " . $order ;

$statsql .= $where;
//echo $statsql;exit;
$mounth = rangeMounth($pay_date1, $pay_date2);
//print_r($mounth);exit;
$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';



$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Data not found";
	return ;
}

//$dtlrow = mysql_fetch_array($dtl);
//echo '<pre>';print_r($dtlrow);echo '</pre>';exit;
include "pembayaranpiutangkendaraan/".$rptFile; 	

$filename = 'VehicleAccountReceivablePayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_arh';
$keys = array(
    'key1' => 'payment'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
