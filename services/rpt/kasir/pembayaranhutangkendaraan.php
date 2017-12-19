<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "VEHICLE ACCOUNT PAYABLE PAYMENT REPORT";

$rptFile = "veh_appp.php";
$order = " ";

$supp_type = '';
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
			$rptFile = "veh_apps.php"; 
			$title = '(By Supplier)';
			$order = " ORDER BY supp_code,pay_date,pur_inv_no";
			break;
		case '2' :
			$rptFile = "veh_appp.php"; 
			$title = '(By Payment Type)';
			$order = " ORDER BY  pay_type,pay_date,pur_inv_no ";
			break;
		
	}
}

$where = " where 1=1 " ;

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
	$where .= " b.pay_type  = '".$pay_type."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Pay Type ";
}



/*$statsql = "create temporary table temp_apd 
select * from veh_apd ".$where ;
//echo $statsql;

$where = " where pur_inv_no in (select distinct pur_inv_no from temp_apd) " ;
mysql_query($statsql) or die(mysql_error());*/

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
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Customer ";
}

if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}
/*
$statsql = "create temporary table temp_aph 
select * from veh_aph  ".$where ;
//echo $statsql;
mysql_query($statsql) or die(mysql_error());*/


$statsql ="select a.chassis,a.engine,a.veh_code,a.veh_name,a.supp_code,a.supp_name,
b.* from " . $db1 . ".veh_aph a left join " . $db1 . ".veh_apd b on a.pur_inv_no = b.pur_inv_no";

//$statsql .= $where . " " . $order ;
$statsql .= $where;

$mounth = rangeMounth($pay_date1, $pay_date2);
//print_r($mounth);exit;
$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}

include "pembayaranhutangkendaraan/".$rptFile; 	

$filename = 'VehicleAccountPayablePayment_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_aph';

$keys = array(
    'key1' => 'payment'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);

?>